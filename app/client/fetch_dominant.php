<?php
// fetch_dominant.php
header('Content-Type: application/json');
include 'includes/conn.php'; // your DB connection

$brgyCode = $_GET['brgyCode'] ?? '';

function getDominant($conn, $column, $brgyCode) {
    $stmt = $conn->prepare("SELECT $column, COUNT(*) as count FROM registered WHERE brgy_code = ? GROUP BY $column ORDER BY count DESC LIMIT 1");
    $stmt->bind_param("s", $brgyCode);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    return $result[$column] ?? '';
}

$response = [
    'classification' => getDominant($conn, 'youth_classification', $brgyCode),
    'gender' => getDominant($conn, 'gender', $brgyCode),
    'age' => getDominant($conn, 'age_group', $brgyCode),
    'success' => true
];

echo json_encode($response);
?>