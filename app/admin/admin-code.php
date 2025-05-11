<?php 
session_start();
include "includes/conn.php";

if (isset($_POST['createAcc'])) {
    // Get form data and escape inputs
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $firstname = $conn->real_escape_string($_POST['firstname']); // Fix typo from 'fistname'
    $middlename = $conn->real_escape_string($_POST['middlename']);
    $position = $conn->real_escape_string($_POST['position']);
    $sex = $_POST['sex'];
    $age = $_POST['age'];
    $dob = $conn->real_escape_string($_POST['dob']);
    $mobileNumber = $conn->real_escape_string($_POST['mobileNumber']);
    $streetNumber = $conn->real_escape_string($_POST['streetNumber']);
    $address = $conn->real_escape_string($_POST['address']);
    $barangayCode = $conn->real_escape_string($_POST['barangay']);

    // Log in Information
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Prepare SQL statement for insertion into `sk_officials`
    $stmt = $conn->prepare("INSERT INTO `sk_officials` (`brgy_code`, `firstname`, `lastname`, `middlename`, `position`, `sex`, `age`, `dob`, `mobile_num`, `address`, `street_num`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("ssssssissss", $barangayCode, $firstname, $lastname, $middlename, $position, $sex, $age, $dob, $mobileNumber, $address, $streetNumber);

    // Execute the statement for SK officials
    if ($stmt->execute()) {
        $account_id = $stmt->insert_id;
        createAccount($conn, $barangayCode, $account_id, $username, $password, $firstname, $lastname, $position);
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "SK Official account created successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Ok";
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error creating SK Official account: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Try Again";
    }

    // Close the first statement
    $stmt->close();

    // Redirect to the referring page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit(); // Make sure to exit after redirecting
}

function createAccount($conn, $barangayCode, $account_id, $username, $password, $firstname, $lastname, $position) {
    // Hash the password before inserting into `accounts` table
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare statement for `accounts` table
    $stmt2 = $conn->prepare("INSERT INTO accounts (account_id, brgy_code, username, password, firstname, lastname, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    // Bind parameters for `accounts`
    $stmt2->bind_param("sssssss", $account_id, $barangayCode, $username, $hashedPassword, $firstname, $lastname, $position);

    // Execute the statement for accounts
    if ($stmt2->execute()) {
        echo "Success";
    } else {
       echo $stmt2->error;
    }

 // Close second statement and connection
 $stmt2->close();
}

?>