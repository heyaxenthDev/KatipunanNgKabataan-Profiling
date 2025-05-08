<?php
session_start();
include "includes/conn.php";

// Check if ID is provided
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'No ID provided']);
    exit;
}

$id = $conn->real_escape_string($_GET['id']);

// Prepare and execute query
$query = "SELECT * FROM youth_programs WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Return the program details as JSON
    echo json_encode($row);
} else {
    echo json_encode(['error' => 'Program not found']);
}

$stmt->close();
$conn->close();
?>