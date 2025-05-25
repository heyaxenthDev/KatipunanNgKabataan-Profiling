<?php
header('Content-Type: application/json');
include "includes/conn.php";

// Use POST and FILES, not JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $conn->real_escape_string($_POST['editSKId']);
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
    // $password = $conn->real_escape_string($_POST['editPassword']);
    $email = $conn->real_escape_string($_POST['editSKEmail']);

    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle image upload
    $picture = null;
    if (isset($_FILES['editSKPicture']) && $_FILES['editSKPicture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../app/client/uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_extension = strtolower(pathinfo($_FILES['editSKPicture']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid('sk_', true) . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;
        if (move_uploaded_file($_FILES['editSKPicture']['tmp_name'], $upload_path)) {
            // Save relative path for DB
            $picture = 'uploads/' . $new_filename;
        }
    }

    $conn->begin_transaction();

    try {
        // Update accounts table
        if ($picture) {
            $sql_accounts = "UPDATE accounts SET 
                username = ?,
                firstname = ?,
                lastname = ?,
                email = ?,
                role = ?,
                picture = ?
                WHERE id = ?";
            $stmt_accounts = $conn->prepare($sql_accounts);
            $stmt_accounts->bind_param("ssssssi", $username, $firstname, $lastname, $email, $position, $picture, $id);
        } else {
            $sql_accounts = "UPDATE accounts SET 
                username = ?,
                firstname = ?,
                lastname = ?,
                email = ?,
                role = ?
                WHERE id = ?";
            $stmt_accounts = $conn->prepare($sql_accounts);
            $stmt_accounts->bind_param("sssssi", $username, $firstname, $lastname, $email, $position, $id);
        }
        $stmt_accounts->execute();

        // Update sk_officials table
        $sql_sk = "UPDATE sk_officials SET 
            firstname = ?,
            lastname = ?,
            middlename = ?,
            street_num = ?,
            sex = ?,
            age = ?,
            dob = ?,
            mobile_num = ?,
            address = ?
            WHERE id = ?";
        $stmt_sk = $conn->prepare($sql_sk);
        $stmt_sk->bind_param("ssssissssi", $firstname, $lastname, $middlename, $street_num, $sex, $age, $dob, $mobile_num, $address, $id);
        $stmt_sk->execute();

        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'SK Official updated successfully']);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error updating SK Official: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>