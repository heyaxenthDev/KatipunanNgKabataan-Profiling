<?php 
session_start();
include "includes/conn.php";

if(isset($_POST['editCbydp'])){
    $id = $_POST['id'];
    $brgyName = $_POST['brgyName'];
    $programArea = $_POST['programArea'];
    $referenceCode = $_POST['referenceCode'];
    $ppa = $_POST['ppa'];
    $objectiveDescription = $_POST['objectiveDescription'];
    $expectedResult = $_POST['expectedResult'];
    $performanceIndicator = $_POST['performanceIndicator'];
    $implementationPeriod = $_POST['implementationPeriod'];
    $mooeAllocated = $_POST['mooeAllocated'];
    $mooeSpent = $_POST['mooeSpent'];

    $sql = "UPDATE cbydp SET brgyName = ?, programArea = ?, referenceCode = ?, ppa = ?, objectiveDescription = ?, expectedResult = ?, performanceIndicator = ?, implementationPeriod = ?, mooeAllocated = ?, mooeSpent = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", $brgyName, $programArea, $referenceCode, $ppa, $objectiveDescription, $expectedResult, $performanceIndicator, $implementationPeriod, $mooeAllocated, $mooeSpent, $id);
   
    if ($stmt->execute()) {
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Feedback submitted successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Ok";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Failed to submit feedback";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
    $stmt->close();
    $conn->close();
}
?>