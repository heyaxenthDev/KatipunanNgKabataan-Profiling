<?php
include "includes/conn.php";

// Get JSON data from request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data) {
    $id = $conn->real_escape_string($data['editSKId']);
    $lastname = $conn->real_escape_string($data['editLastname']);
    $firstname = $conn->real_escape_string($data['editFirstname']);
    $middlename = $conn->real_escape_string($data['editMiddlename']);
    $street_num = $conn->real_escape_string($data['editStreetNumber']);
    $position = $conn->real_escape_string($data['editPosition']);
    $sex = $conn->real_escape_string($data['editSex']);
    $age = $conn->real_escape_string($data['editSKAge']);
    $dob = $conn->real_escape_string($data['editDOB']);
    $mobile_num = $conn->real_escape_string($data['editMobileNumber']);
    $address = $conn->real_escape_string($data['editAddress']);
    $username = $conn->real_escape_string($data['editUsername']);
    $password = $conn->real_escape_string($data['editPassword']);
    $email = $conn->real_escape_string($data['editSKEmail']);

    // Start transaction
    $conn->begin_transaction();

    try {
        // Update accounts table
        $sql_accounts = "UPDATE accounts SET 
            username = ?,
            password = ?,
            firstname = ?,
            lastname = ?,
            email = ?,
            role = ?
            WHERE id = ?";
        
        $stmt_accounts = $conn->prepare($sql_accounts);
        $stmt_accounts->bind_param("ssssssi", $username, $password, $firstname, $lastname, $email, $position, $id);
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

        // Commit transaction
        $conn->commit();

        // Send success response
        echo json_encode(['success' => true, 'message' => 'SK Official updated successfully']);
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error updating SK Official: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No data received']);
}

$conn->close();
?>