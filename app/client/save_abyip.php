<?php
session_start();
include 'includes/conn.php';
include_once "includes/functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user']['id'];
    $reference_code = $_POST['reference_code'];
    $ppa = $_POST['ppa'];
    $description = $_POST['description'];
    $expected_result = $_POST['expected_result'];
    $performance_indicator = $_POST['performance_indicator'];
    $period_implementation = $_POST['period_implementation'];
    $mooe = $_POST['mooe'];
    $co = $_POST['co'];
    $total = $_POST['total'];
    $person_responsible = $_POST['person_responsible'];
    $prepared_by = $_POST['prepared_by'] || "";
    $approved_by = $_POST['approved_by'] || "";
    $brgyCode = $_POST['brgyCode'];

    $sql = "INSERT INTO abyip (
        user_id,reference_code, ppa, description, expected_result, performance_indicator,
        period_implementation, mooe, co, total, person_responsible, prepared_by, approved_by, brgyCode
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssdddssss", $user_id, $reference_code, $ppa, $description, $expected_result,
        $performance_indicator, $period_implementation, $mooe, $co, $total, $person_responsible,
        $prepared_by, $approved_by, $brgyCode);

    if ($stmt->execute()) {
        $user_id = $_SESSION['user']['id'];
        $message = "New ABYIP Plan submitted";
        $type = "info";
        $link = "view_abyip.php?id=" . $conn->insert_id;
        add_notification($conn, $user_id, 1, $message, $type, $link);
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "ABYIP Plan submitted successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Ok";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Failed to submit ABYIP Plan";
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Back";
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }

    $stmt->close();
    $conn->close();
}
?>