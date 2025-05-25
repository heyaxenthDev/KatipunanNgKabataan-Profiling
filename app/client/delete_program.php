<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
session_start();
include "includes/conn.php";

// Accept id from GET or POST
$id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : 0);

if ($id > 0) {
    // First, delete feedback for this program
    $query_feedback = "DELETE FROM program_feedback WHERE program_id = ?";
    $stmt_feedback = $conn->prepare($query_feedback);
    $stmt_feedback->bind_param("i", $id);
    $stmt_feedback->execute();
    $stmt_feedback->close();

    // Now, delete the program
    $query = "DELETE FROM youth_programs WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Program deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'No program found with that ID']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting program: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid or missing program ID.']);
}
$conn->close();
?>