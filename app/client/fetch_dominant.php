<?php
// Prevent any output before headers
ob_start();

// Set proper headers
header('Content-Type: application/json');

// Include database connection
include 'includes/conn.php';

try {
    // Get barangay code from request
    $brgyCode = $_GET['brgyCode'] ?? '';

    if (empty($brgyCode)) {
        throw new Exception('Barangay code is required');
    }

    function getDominant($conn, $column, $brgyCode) {
        try {
            // For gender, we need to handle numeric values
            if ($column === 'gender') {
                $stmt = $conn->prepare("SELECT 
                    CASE 
                        WHEN gender = '1' THEN 'Female'
                        ELSE 'Male'
                    END as gender,
                    COUNT(*) as count 
                    FROM registered 
                    WHERE brgyCode = ? AND acc_type != 'unregistered'
                    GROUP BY gender 
                    ORDER BY count DESC 
                    LIMIT 1");
            } 
            // For age group, we need to map the values
            else if ($column === 'youth_age_group') {
                $stmt = $conn->prepare("SELECT 
                    CASE 
                        WHEN youth_age_group = 'core' THEN '21-25'
                        WHEN youth_age_group = 'child' THEN '15-20'
                        WHEN youth_age_group = 'young_adult' THEN '25-30'
                        ELSE youth_age_group
                    END as youth_age_group,
                    COUNT(*) as count 
                    FROM registered 
                    WHERE brgyCode = ? AND acc_type != 'unregistered'
                    GROUP BY youth_age_group 
                    ORDER BY count DESC 
                    LIMIT 1");
            }
            else {
                $stmt = $conn->prepare("SELECT $column, COUNT(*) as count 
                    FROM registered 
                    WHERE brgyCode = ? AND acc_type != 'unregistered'
                    GROUP BY $column 
                    ORDER BY count DESC 
                    LIMIT 1");
            }
            
            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $conn->error);
            }

            $stmt->bind_param("s", $brgyCode);
            
            if (!$stmt->execute()) {
                throw new Exception("Failed to execute statement: " . $stmt->error);
            }

            $result = $stmt->get_result();
            if (!$result) {
                throw new Exception("Failed to get result: " . $stmt->error);
            }

            $row = $result->fetch_assoc();
            return $row[$column] ?? '';
        } catch (Exception $e) {
            throw new Exception("Error in getDominant: " . $e->getMessage());
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    // Get dominant values
    $response = [
        'success' => true,
        'classification' => getDominant($conn, 'youth_classification', $brgyCode),
        'gender' => getDominant($conn, 'gender', $brgyCode),
        'age' => getDominant($conn, 'youth_age_group', $brgyCode)
    ];

} catch (Exception $e) {
    // Handle any errors
    $response = [
        'success' => false,
        'message' => $e->getMessage()
    ];
} finally {
    // Clear any output buffers
    ob_end_clean();
    
    // Send JSON response
    echo json_encode($response);
}
?>