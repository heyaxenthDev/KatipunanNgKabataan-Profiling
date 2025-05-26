<?php
// decision_process.php
header('Content-Type: application/json');
session_start();
include "includes/conn.php";
include "includes/functions.php";

// Check if the request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['generateDecision'])) {
    $user_id = $_SESSION['user']['id'];
    // Get form data
    $brgyCode = $conn->real_escape_string($_POST['brgyCode']);
    $programs = $conn->real_escape_string($_POST['suggestedProgram']);
    // $types = $conn->real_escape_string($_POST['types']) || '';
    $for_gender = $conn->real_escape_string($_POST['dominantGender']);
    $age_category = $conn->real_escape_string($_POST['ageCategory']);
    $youth_classification = $conn->real_escape_string($_POST['youthClassification']);
    $venue = $conn->real_escape_string($_POST['venue']);
    $budget = $conn->real_escape_string($_POST['budget']);
    $needs = $conn->real_escape_string($_POST['needs']);
    $committee_assigned = $conn->real_escape_string($_POST['committee_assigned']);

    // Set default values for attachment fields
    $attachment_type = NULL;
    $attachment_file = NULL;

    // Prepare the SQL statement
    $sql = "INSERT INTO youth_programs (user_id, brgyCode, programs, for_gender, age_category, 
            youth_classification, committee_assigned, venue, budget, needs, attachment_type, attachment_file) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssss", 
        $user_id,
        $brgyCode, 
        $programs, 
        // $types, 
        $for_gender, 
        $age_category, 
        $youth_classification, 
        $committee_assigned, 
        $venue, 
        $budget, 
        $needs, 
        $attachment_type, 
        $attachment_file
    );

    // Execute the statement
    if ($stmt->execute()) {
        $sent_by = $_SESSION['user']['id'];
        $sent_to = 1;
        $message = "New youth program submitted";
        $type = "info";
        $link = "view_program.php?id=" . $conn->insert_id;
        add_notification($conn, $sent_by, $sent_to, $message, $type, $link);
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Youth program data saved successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Ok";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error: " . $sql . "<br>" . $conn->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }

    // Close statement
    $stmt->close();
} else {
    $_SESSION['status'] = "Error";
    $_SESSION['status_text'] = "Invalid request method";
    $_SESSION['status_code'] = "error";
    $_SESSION['status_btn'] = "Back";
    header("Location: {$_SERVER['HTTP_REFERER']}");
}

// Close connection
$conn->close();
?>