<?php
include "includes/conn.php";

header('Content-Type: application/json');

try {
    // Get and validate input parameters
    $type = $_POST['type'] ?? '';
    $category = $_POST['category'] ?? '';
    $purok = $_POST['purok'] ?? '';
    $brgyCode = $_POST['brgyCode'] ?? '';

    if ($category == "female") {
        $category = 1;
    } else if ($category == "male") {
        $category = 0;
    }

    if (!$type || !$category || !$purok || !$brgyCode) {
        throw new Exception('Missing required parameters');
    }

    $data = [];
    
    // Prepare base query conditions
    $conditions = [];
    $params = [];
    $types = '';

    // Add brgyCode condition
    $conditions[] = "brgyCode = ?";
    $params[] = $brgyCode;
    $types .= 's';

    // Add category condition based on report type
    if ($type === 'activities_program') {
        $conditions[] = "category = ?";
    } else {
        $conditions[] = "gender = ?";
    }
    $params[] = $category;
    $types .= 's';

    // Add purok/street condition
    if ($type === 'activities_program') {
        $conditions[] = "venue LIKE ?";
        $params[] = "%$purok%";
    } else {
        $conditions[] = "street = ?";
        $params[] = $purok;
    }
    $types .= 's';

    // Build the WHERE clause
    $whereClause = implode(' AND ', $conditions);

    // Prepare and execute query based on report type
    switch ($type) {
        case 'registered':
            $query = "SELECT 
                        CONCAT(first_name, ' ', last_name) as name,
                        age,
                        gender,
                        civil_status as status,
                        CONCAT(street, ', ', barangay) as address,
                        work_status as employment
                    FROM registered 
                    WHERE acc_type = 'registered' AND $whereClause
                    ORDER BY last_name, first_name";
            break;

        case 'unregistered':
            $query = "SELECT 
                        CONCAT(first_name, ' ', last_name) as name,
                        age,
                        gender,
                        civil_status as status,
                        CONCAT(street, ', ', barangay) as address,
                        work_status as employment
                    FROM registered 
                    WHERE acc_type = 'unregistered' AND $whereClause
                    ORDER BY last_name, first_name";
            break;

        case 'activities_program':
            $query = "SELECT 
                        programs as program_name,
                        DATE_FORMAT(date_created, '%M %d, %Y') as date,
                        venue,
                        committee,
                        budget,
                        status
                    FROM youth_programs 
                    WHERE $whereClause
                    ORDER BY date_created DESC";
            break;

        default:
            throw new Exception('Invalid report type');
    }

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->error);
    }

    // Bind parameters dynamically
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    if (!$stmt->execute()) {
        throw new Exception('Failed to execute query: ' . $stmt->error);
    }

    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        // Format budget if present
        if (isset($row['budget'])) {
            $row['budget'] = '₱' . number_format((float)$row['budget'], 2);
        }

        // Handle optional fields like contact number
        if (isset($row['contact_number'])) {
            $row['contact_number'] = $row['contact_number'] ?: 'N/A';
        }

        $data[] = $row;
    }

    // Fetch barangay name based on brgyCode
    $brgyName = '';
    $brgyStmt = $conn->prepare("SELECT barangay_name FROM barangay WHERE barangay_code = ?");
    if ($brgyStmt) {
        $brgyStmt->bind_param("s", $brgyCode);
        $brgyStmt->execute();
        $brgyResult = $brgyStmt->get_result();
        if ($row = $brgyResult->fetch_assoc()) {
            $brgyName = $row['barangay_name'];
        }
        $brgyStmt->close();
    }

    echo json_encode([
        'success' => true,
        'data' => $data,
        'brgyName' => $brgyName,
        'message' => empty($data) ? 'No data found for the selected criteria' : ''
    ]);

} catch (Exception $e) {
    error_log('Report Generation Error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while generating the report: ' . $e->getMessage()
    ]);
}

// Close statement and database connection
if (isset($stmt) && $stmt instanceof mysqli_stmt) {
    $stmt->close();
}
$conn->close();
?>