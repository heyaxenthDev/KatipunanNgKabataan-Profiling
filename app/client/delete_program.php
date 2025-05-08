<?php
session_start();
include "includes/conn.php";

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'No ID provided'
    ]);
    exit;
}

$id = $conn->real_escape_string($_GET['id']);

// Prepare and execute delete query
$query = "DELETE FROM youth_programs WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Program deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No program found with that ID'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error deleting program: ' . $conn->error
    ]);
}

$stmt->close();
$conn->close();
?>