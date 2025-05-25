<?php
header('Content-Type: application/json');
session_start();
include "includes/conn.php";
include "includes/functions.php";   

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['programId']) && isset($_POST['feedbackMessage']) ) {
    $programId = $conn->real_escape_string($_POST['programId']);
    $feedbackType = $conn->real_escape_string($_POST['feedbackType']);
    $feedbackMessage = $conn->real_escape_string($_POST['feedbackMessage']);
    $userId = $_SESSION['user']['id'] ?? null;

    if (!$userId) {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "User not authenticated";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    $sql = "INSERT INTO program_feedback (program_id, user_id, feedback_type, feedback_message, created_at) 
            VALUES (?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $programId, $userId, $feedbackType, $feedbackMessage);

    if ($stmt->execute()) {
        $sent_by = $_SESSION['user']['id'];
        $sent_to = 1;
        $message = $feedbackType . ': ' . $feedbackMessage;
        $type = "info";
        $link = "view_program.php?id=$programId";
        add_notification($conn, $sent_by, $sent_to, $message, $type, $link);
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
} else {
    $_SESSION['status'] = "Error";
    $_SESSION['status_text'] = "Invalid request method";
    $_SESSION['status_code'] = "error";
    $_SESSION['status_btn'] = "Back";
    header("Location: {$_SERVER['HTTP_REFERER']}");
}
?>