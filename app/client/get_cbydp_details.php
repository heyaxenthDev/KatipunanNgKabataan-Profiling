<?php
header('Content-Type: application/json');

// Database connection
include "includes/conn.php";

$id = intval($_GET['id']); // Get the youth ID from the request

$query = "SELECT * FROM `cbydp` WHERE `id` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(['error' => 'No data found']);
}

$conn->close();
?>