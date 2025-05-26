<?php
session_start();
include "includes/conn.php";
include "includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['newCbydp'])) {
    $user_id = $_SESSION['user']['id'];
    $message = "New CBYDP report submitted";
    $type = "info";
   // Retrieve form data
    $brgyCode = $conn->real_escape_string($_POST['brgyCode']);
    $brgyName = $conn->real_escape_string($_POST['brgyName']);
    $programArea = $conn->real_escape_string($_POST['programArea']);
    $referenceCode = $conn->real_escape_string($_POST['referenceCode']);
    $ppa = $conn->real_escape_string($_POST['ppa']);
    $objectiveDescription = $conn->real_escape_string($_POST['objectiveDescription']);
    $expectedResult = $conn->real_escape_string($_POST['expectedResult']);
    $performanceIndicator = $conn->real_escape_string($_POST['performanceIndicator']);
    $implementationPeriod = $conn->real_escape_string($_POST['implementationPeriod']);
    $mooeAllocated = $conn->real_escape_string($_POST['mooeAllocated']);
    $mooeSpent = $conn->real_escape_string($_POST['mooeSpent']);

    // Prepare SQL
    $sql = "INSERT INTO cbydp (
        user_id, brgyCode, brgyName, programArea, referenceCode, ppa,
        objectiveDescription, expectedResult, performanceIndicator,
        implementationPeriod, mooeAllocated, mooeSpent
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isssssssssss",
        $user_id, $brgyCode, $brgyName, $programArea, $referenceCode, $ppa,
        $objectiveDescription, $expectedResult, $performanceIndicator,
        $implementationPeriod, $mooeAllocated, $mooeSpent
    );

    if ($stmt->execute()) {
        $sent_by = $_SESSION['user']['id'];
        $sent_to = 1;
        $message = "New CBYDP report submitted";
        $type = "info";
        $link = "view_cbydp.php?id=" . $conn->insert_id;
        add_notification($conn, $sent_by, $sent_to, $message, $type, $link);
        $_SESSION['status'] = "Success!";
        $_SESSION['status_text'] = "Report submitted successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
        
    } else {
        $_SESSION['status'] = "Error!";
        $_SESSION['status_text'] = "Error: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Okay";
    }

    $stmt->close();
    $conn->close();

    // Redirect
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

?>