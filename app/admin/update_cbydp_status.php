<?php
session_start();
include "includes/conn.php";
include_once "includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'] ?? '';

    $sql = "UPDATE cbydp SET status = ?, remarks = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $status, $remarks, $id);

    if ($stmt->execute()) {
        $user_id = $_SESSION['user']['id'];
        $message = $status === 'approved' ? 'CBYDP Plan approved' : 'CBYDP Plan rejected';
        $type = "info";
        post_notification($user_id, $conn, $message, $type);
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Plan has been " . ($status === 'approved' ? 'approved' : 'rejected') . " successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Ok";

        $plan_id = $_POST['id'];
        $link = "view_cbydp.php?id=$plan_id";

        // Get the user_id of the plan owner
        $result = mysqli_query($conn, "SELECT user_id FROM cbydp WHERE id = '$plan_id'");
        $row = mysqli_fetch_assoc($result);
        $sent_to = $row['user_id'];
        $sent_by = $_SESSION['user']['id'];

        switch ($status) {
            case 'approved':
                $message = "Your CBYDP plan was approved!";
                $type = "approval";
                break;
            case 'rejected':
                $message = "Your CBYDP plan was rejected. Remarks: $remarks";
                $type = "rejection";
                break;
            case 'revision':
                $message = "Your CBYDP plan needs revision. Remarks: $remarks";
                $type = "revision";
                break;
            case 'improvement':
                $message = "Your CBYDP plan was improved. Remarks: $remarks";
                $type = "info";
                break;
            default:
                $message = "Your CBYDP plan was updated.";
                $type = "info";
                break;
        }
        add_notification($conn, $sent_by, $sent_to, $message, $type, $link);
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
}
?>