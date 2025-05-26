<?php
header('Content-Type: application/json');
include "includes/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // SK Official and Account IDs
    $sk_id = $conn->real_escape_string($_POST['editSKId']);
    $account_id = $conn->real_escape_string($_POST['editAccountId']); // You need to pass this from frontend!

    // Shared data
    $lastname = $conn->real_escape_string($_POST['editLastname']);
    $firstname = $conn->real_escape_string($_POST['editFirstname']);
    $middlename = $conn->real_escape_string($_POST['editMiddlename']);
    $street_num = $conn->real_escape_string($_POST['editStreetNumber']);
    $position = $conn->real_escape_string($_POST['editPosition']);
    $sex = $conn->real_escape_string($_POST['editSex']);
    $age = $conn->real_escape_string($_POST['editSKAge']);
    $dob = $conn->real_escape_string($_POST['editDOB']);
    $mobile_num = $conn->real_escape_string($_POST['editMobileNumber']);
    $address = $conn->real_escape_string($_POST['editAddress']);
    $username = $conn->real_escape_string($_POST['editUsername']);
    $email = $conn->real_escape_string($_POST['editSKEmail']);

    // Picture upload handling
    $picture = null;
    if (isset($_FILES['editSKPicture']) && $_FILES['editSKPicture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../app/client/uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $ext = strtolower(pathinfo($_FILES['editSKPicture']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid('sk_', true) . '.' . $ext;
        $upload_path = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES['editSKPicture']['tmp_name'], $upload_path)) {
            $picture = 'uploads/' . $new_filename;
        }
    }

    $conn->begin_transaction();

    try {
        // Update `accounts`
        if ($picture) {
            $sql_accounts = "UPDATE accounts SET 
                username = ?, firstname = ?, lastname = ?, email = ?, role = ?, picture = ? 
                WHERE account_id = ?";
            $stmt = $conn->prepare($sql_accounts);
            $stmt->bind_param("ssssssi", $username, $firstname, $lastname, $email, $position, $picture, $account_id);
        } else {
            $sql_accounts = "UPDATE accounts SET 
                username = ?, firstname = ?, lastname = ?, email = ?, role = ? 
                WHERE account_id = ?";
            $stmt = $conn->prepare($sql_accounts);
            $stmt->bind_param("sssssi", $username, $firstname, $lastname, $email, $position, $account_id);
        }
        $stmt->execute();

        // Update `sk_officials`
        $sql_sk = "UPDATE sk_officials SET 
            firstname = ?, lastname = ?, middlename = ?, street_num = ?, sex = ?, age = ?, dob = ?, 
            mobile_num = ?, address = ? 
            WHERE id = ?";
        $stmt = $conn->prepare($sql_sk);
        $stmt->bind_param("ssssissssi", $firstname, $lastname, $middlename, $street_num, $sex, $age, $dob, $mobile_num, $address, $sk_id);
        $stmt->execute();

        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'SK Official updated successfully']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error updating: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>