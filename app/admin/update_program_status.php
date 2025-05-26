<?php
include 'authentication.php';
checkLogin();
include "includes/conn.php";

header('Content-Type: application/json');

try {
    // Get and validate input parameters
    $programId = $_POST['programId'] ?? '';
    $status = $_POST['status'] ?? '';
    $remarks = $_POST['remarks'] ?? '';

    if (!$programId || !$status) {
        throw new Exception('Missing required parameters');
    }

    if (!in_array($status, ['approved', 'rejected'])) {
        throw new Exception('Invalid status value');
    }

    if (empty($remarks)) {
        throw new Exception('Remarks are required');
    }

    // Update the program status and remarks
    $query = "UPDATE youth_programs SET status = ?, remarks = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        throw new Exception('Failed to prepare statement: ' . $conn->error);
    }

    $stmt->bind_param("ssi", $status, $remarks, $programId);

    if (!$stmt->execute()) {
        throw new Exception('Failed to update program status: ' . $stmt->error);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Program status updated successfully'
    ]);

} catch (Exception $e) {
    error_log('Program Status Update Error: ' . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

// Close statement and database connection
if (isset($stmt) && $stmt instanceof mysqli_stmt) {
    $stmt->close();
}
$conn->close();
?>