<?php 
session_start();
include "includes/conn.php";
include_once "includes/functions.php";

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
            $sent_by = $_SESSION['user']['id'];
            $sent_to = 1;
            $message = "CBYDP report updated";
            $type = "info";
            $link = "view_cbydp.php?id=$id";
            add_notification($conn, $sent_by, $sent_to, $message, $type, $link);
            $_SESSION['status'] = "Success";
            $_SESSION['status_text'] = "CBYDP updated successfully!";
            $_SESSION['status_code'] = "success";
            $_SESSION['status_btn'] = "Ok";
            header("Location: {$_SERVER['HTTP_REFERER']}");
        } else {
            $_SESSION['status'] = "Error";
            $_SESSION['status_text'] = "Failed to update CBYDP";
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "Back";
            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
        
    $stmt->close();
    $conn->close();
}
?>