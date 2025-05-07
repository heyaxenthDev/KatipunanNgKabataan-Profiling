<?php
// decision_process.php
header('Content-Type: application/json');
include 'includes/conn.php'; // your DB connection

// Get POST data
$brgyCode = $_POST['brgyCode'];
$youthClass = $_POST['youthClassification'];
$gender = $_POST['dominantGender'];
$ageGroup = $_POST['ageCategory'];
$suggestedProgram = $_POST['suggestedProgram'];
$venue = $_POST['venue'];
$budget = $_POST['budget'];
$needs = $_POST['needs'];
$dateSubmitted = date("Y-m-d");

// INSERT into your table (replace 'decision_data' with your actual table name)
$stmt = $conn->prepare("INSERT INTO decision_data 
    (brgy_code, youth_classification, gender, age_group, suggested_program, venue, budget, needs, date_submitted) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssssss", $brgyCode, $youthClass, $gender, $ageGroup, $suggestedProgram, $venue, $budget, $needs, $dateSubmitted);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$stmt->close();
$conn->close();
?>