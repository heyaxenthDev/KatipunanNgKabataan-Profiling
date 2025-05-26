<?php 
session_start();
include "includes/conn.php";

if (isset($_POST['createAcc'])) {
    // Get form data and escape inputs
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $middlename = $conn->real_escape_string($_POST['middlename']);
    $position = $conn->real_escape_string($_POST['position']);
    $sex = $_POST['sex'];
    $age = $_POST['age'];
    $dob = $conn->real_escape_string($_POST['dob']);
    $mobileNumber = $conn->real_escape_string($_POST['mobileNumber']);
    $streetNumber = $conn->real_escape_string($_POST['streetNumber']);
    $address = $conn->real_escape_string($_POST['address']);
    $barangayCode = $conn->real_escape_string($_POST['barangay']);

    // Handle profile picture upload
    $picture = '';
    if (isset($_FILES['skPicture']) && $_FILES['skPicture']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['skPicture']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array(strtolower($filetype), $allowed)) {
            // Create unique filename
            $new_filename = uniqid() . '.' . $filetype;
            $upload_path = '../../app/client/uploads/' . $new_filename;

            // Create directory if it doesn't exist
            if (!file_exists('../../app/client/uploads')) {
                mkdir('../../app/client/uploads', 0777, true);
            }

            if (move_uploaded_file($_FILES['skPicture']['tmp_name'], $upload_path)) {
                // Store only the relative path in the database
                $picture = 'uploads/' . $new_filename;
            } else {
                $_SESSION['status'] = "Error";
                $_SESSION['status_text'] = "Error uploading profile picture";
                $_SESSION['status_code'] = "error";
                $_SESSION['status_btn'] = "Try Again";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
        } else {
            $_SESSION['status'] = "Error";
            $_SESSION['status_text'] = "Invalid file type. Only JPG, JPEG, PNG & GIF files are allowed.";
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "Try Again";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
    }

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
        createAccount($conn, $barangayCode, $account_id, $username, $password, $firstname, $lastname, $position, $picture);
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
    exit();
}

function createAccount($conn, $barangayCode, $account_id, $username, $password, $firstname, $lastname, $position, $picture) {
    // Hash the password before inserting into `accounts` table
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Prepare statement for `accounts` table
    $stmt2 = $conn->prepare("INSERT INTO accounts (account_id, brgy_code, username, password, firstname, lastname, role, picture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Bind parameters for `accounts`
    $stmt2->bind_param("ssssssss", $account_id, $barangayCode, $username, $hashedPassword, $firstname, $lastname, $position, $picture);

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