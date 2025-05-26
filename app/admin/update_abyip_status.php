<?php
session_start();
include "includes/conn.php";
include_once "includes/functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];

    // Update the status in the database
    $sql = "UPDATE abyip SET status = ?, remarks = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $status, $remarks, $id);

    if ($stmt->execute()) {
        // Get the user_id of the plan owner
        $result = mysqli_query($conn, "SELECT user_id FROM abyip WHERE id = '$id'");
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        $sent_by = $_SESSION['user']['id'];
        $sent_to = $user_id;
        $link = "view_abyip.php?id=$id";

        switch ($status) {
            case 'approved':
                $message = "Your ABYIP plan was approved!";
                $type = "approval";
                break;
            case 'rejected':
                $message = "Your ABYIP plan was rejected. Remarks: $remarks";
                $type = "rejection";
                break;
            default:
                $message = "Your ABYIP plan status was updated.";
                $type = "info";
                break;
        }

        add_notification($conn, $sent_by, $sent_to, $message, $type, $link);

        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Plan status updated successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Ok";
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Failed to update plan status";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
    }

    $stmt->close();
    $conn->close();

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
} else {
    $_SESSION['status'] = "Error";
    $_SESSION['status_text'] = "Invalid request method";
    $_SESSION['status_code'] = "error";
    $_SESSION['status_btn'] = "Back";
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>