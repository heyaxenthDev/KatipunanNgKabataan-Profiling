<?php
header('Content-Type: application/json');
session_start();
include "includes/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['programId'])) {
    $id = intval($_POST['programId']);
    $program = $conn->real_escape_string($_POST['program'] ?? '');
    $type = $conn->real_escape_string($_POST['type'] ?? '');
    $gender = $conn->real_escape_string($_POST['gender'] ?? '');
    $ageCategory = $conn->real_escape_string($_POST['ageCategory'] ?? '');
    $youthClassification = $conn->real_escape_string($_POST['youthClassification'] ?? '');
    $committee = $conn->real_escape_string($_POST['committee'] ?? '');
    $venue = $conn->real_escape_string($_POST['venue'] ?? '');
    $budget = $conn->real_escape_string($_POST['budget'] ?? '');
    $needs = $conn->real_escape_string($_POST['needs'] ?? '');

    $sql = "UPDATE youth_programs SET 
                programs = ?, 
                types = ?, 
                for_gender = ?, 
                age_category = ?, 
                youth_classification = ?, 
                committee_assigned = ?, 
                venue = ?, 
                budget = ?, 
                needs = ?
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param(
        "sssssssssi",
        $program,
        $type,
        $gender,
        $ageCategory,
        $youthClassification,
        $committee,
        $venue,
        $budget,
        $needs,
        $id
    );

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Program updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update program: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
$conn->close(); 