<?php
include 'authentication.php';
checkLogin();
include "includes/conn.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'No ID provided']);
        exit;
    }
    
    // First check if the youth record exists
    $check_stmt = $conn->prepare("SELECT id FROM registered WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Youth record not found']);
        exit;
    }
    
    // Delete the youth record
    $delete_stmt = $conn->prepare("DELETE FROM registered WHERE id = ?");
    $delete_stmt->bind_param("i", $id);
    
    if ($delete_stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Youth record deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting youth record: ' . $conn->error]);
    }
    
    $delete_stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>