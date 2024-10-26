<?php
session_start();
include "includes/conn.php";

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['YouthInvolve'])) {
    // Sanitize and validate form inputs
    $brgyCode = $conn->real_escape_string($_POST['brgyCode']);
    $programDate = $conn->real_escape_string($_POST['program_date']);
    $programs = $conn->real_escape_string($_POST['programs']);
    $types = $conn->real_escape_string($_POST['types']);
    $forCategory = $conn->real_escape_string($_POST['forCategory']);
    $ageCategory = $conn->real_escape_string($_POST['ageCategory']);
    $youthClassification = $conn->real_escape_string($_POST['youthClassification']);
    $committeeAssigned = $conn->real_escape_string($_POST['committeeAssigned']);
    $venue = $conn->real_escape_string($_POST['venue']);
    $budget = $conn->real_escape_string($_POST['budget']);
    $needs = $conn->real_escape_string($_POST['needs']);
    $attachmentType = $conn->real_escape_string($_POST['attachment']);

    // File upload handling
    $attachmentFile = null;
    if (!empty($_FILES['fileUpload']['name'])) {
        $targetDir = "uploads/";
        $attachmentFile = $targetDir . basename($_FILES["fileUpload"]["name"]);
        
        // Check file type and move to target directory
        if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $attachmentFile)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    }

    // SQL query to insert data
    $stmt = $conn->prepare("INSERT INTO youth_programs (brgyCode, program_date, programs, types, for_category, age_category, youth_classification, committee_assigned, venue, budget, needs, attachment_type, attachment_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $brgyCode, $programDate, $programs, $types, $forCategory, $ageCategory, $youthClassification, $committeeAssigned, $venue, $budget, $needs, $attachmentType, $attachmentFile);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Success!";
        $_SESSION['status_text'] = "Youth Program Recorded!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
    } else {
        $_SESSION['status'] = "Error!";
        $_SESSION['status_text'] = "Error: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Okay";
    }
    $stmt->close();
}

$conn->close();
?>