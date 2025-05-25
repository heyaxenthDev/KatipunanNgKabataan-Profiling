<?php 
session_start();
include "includes/conn.php";
include_once "includes/functions.php";

if (isset($_POST['updateAbyip'])) {
    $id = $_POST['id'];
    $brgyName = $_POST['brgyName'];
    $reference_code = $_POST['reference_code'];
    $ppa = $_POST['ppa'];
    $description = $_POST['description'];
    $expected_result = $_POST['expected_result'];
    $performance_indicator = $_POST['performance_indicator'];
    $period_implementation = $_POST['period_implementation'];
    $mooe = floatval($_POST['mooe']);
    $co = floatval($_POST['co']);
    $total = floatval($_POST['total']);
    $person_responsible = $_POST['person_responsible'];
    $prepared_by = $_POST['prepared_by'];
    $approved_by = $_POST['approved_by'];

    $sql = "UPDATE abyip 
            SET brgyName = ?, reference_code = ?, ppa = ?, description = ?, expected_result = ?, performance_indicator = ?, period_implementation = ?, mooe = ?, co = ?, total = ?, person_responsible = ?, prepared_by = ?, approved_by = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssdddsssi", 
        $brgyName, 
        $reference_code, 
        $ppa, 
        $description, 
        $expected_result, 
        $performance_indicator, 
        $period_implementation, 
        $mooe, 
        $co, 
        $total, 
        $person_responsible, 
        $prepared_by, 
        $approved_by, 
        $id
    );

    if ($stmt->execute()) {
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "ABYIP updated successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Ok";

        $plan_id = $_POST['id'];
        $status = $_POST['status']; // 'approved', 'rejected', 'revision', etc.
        $remarks = $_POST['remarks'] ?? '';
        $link = "view_abyip.php?id=$plan_id";

        // Get the user_id of the plan owner
        $result = mysqli_query($conn, "SELECT user_id FROM abyip WHERE id = '$plan_id'");
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        $sent_by = $_SESSION['user']['id'];
        $sent_to = 1;
        switch ($status) {
            case 'approved':
                $message = "Your ABYIP plan was approved!";
                $type = "approval";
                break;
            case 'rejected':
                $message = "Your ABYIP plan was rejected. Remarks: $remarks";
                $type = "rejection";
                break;
            case 'revision':
                $message = "Your ABYIP plan needs revision. Remarks: $remarks";
                $type = "revision";
                break;
            case 'improvement':
                $message = "Your ABYIP plan was improved. Remarks: $remarks";
                $type = "info";
                break;
            default:
                $message = "Your ABYIP plan was updated.";
                $type = "info";
                break;
        }
        add_notification($conn, $sent_by, $sent_to, $message, $type, $link);
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Failed to update ABYIP.";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
    }

    $stmt->close();
    $conn->close();

    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
?>