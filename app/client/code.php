<?php
session_start();
include "includes/conn.php";

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['YouthInvolve'])) {
    // Sanitize and validate form inputs
    $brgyCode = $conn->real_escape_string($_POST['brgyCode']);
    $programDate = $conn->real_escape_string($_POST['program_date']);
    $programs = $conn->real_escape_string($_POST['programs']);
    $types = $conn->real_escape_string($_POST['types']);
    $forCategory = $conn->real_escape_string($_POST['forCategory']);
    $ageCategory = $conn->real_escape_string($_POST['ageCategory']);
    $youthClassification = $conn->real_escape_string($_POST['youthClassification']);
    $committeeAssigned = $conn->real_escape_string($_POST['committeeAssigned']);
    $venue = $conn->real_escape_string($_POST['venue']);
    $budget = $conn->real_escape_string($_POST['budget']);
    $needs = $conn->real_escape_string($_POST['needs']);
    $attachmentType = $conn->real_escape_string($_POST['attachment']);

    // File upload handling
    $attachmentFile = null;
    if (!empty($_FILES['fileUpload']['name'])) {
        $targetDir = "uploads/";
        $attachmentFile = $targetDir . basename($_FILES["fileUpload"]["name"]);
        
        // Check file type and move to target directory
        if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $attachmentFile)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    }

    // SQL query to insert data
    $stmt = $conn->prepare("INSERT INTO youth_programs (brgyCode, program_date, programs, types, for_category, age_category, youth_classification, committee_assigned, venue, budget, needs, attachment_type, attachment_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss", $brgyCode, $programDate, $programs, $types, $forCategory, $ageCategory, $youthClassification, $committeeAssigned, $venue, $budget, $needs, $attachmentType, $attachmentFile);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Success!";
        $_SESSION['status_text'] = "Youth Program Recorded!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
    } else {
        $_SESSION['status'] = "Error!";
        $_SESSION['status_text'] = "Error: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Okay";
    }
    $stmt->close();

    // Redirect
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

if (isset($_POST['updateAcc'])) {
    $brgy_code = $_POST['brgy_code'];
    $id = $_POST['id'];
    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $uploaded_file_path = null;

    // Check if a file was uploaded
    if (!empty($_FILES['profileImage']['name'])) {
        // Define upload directory
        $upload_dir = 'uploads/';

        // Ensure the upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Create directory if it doesn't exist
        }

        // Extract file info
        $file_name = basename($_FILES['profileImage']['name']);
        $file_tmp = $_FILES['profileImage']['tmp_name'];
        $file_size = $_FILES['profileImage']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif']; // Allowable extensions

        // Generate a unique name to prevent overwriting
        $new_file_name = uniqid('profile_', true) . '.' . $file_ext;
        $uploaded_file_path = $upload_dir . $new_file_name;

        // Validate file type and size (5MB limit)
        if (!in_array($file_ext, $allowed_extensions)) {
            $_SESSION['status'] = "Error!";
            $_SESSION['status_text'] = "Invalid file type. Only JPG, PNG, and GIF are allowed.";
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "Okay";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } elseif ($file_size > 5 * 1024 * 1024) {
            $_SESSION['status'] = "Error!";
            $_SESSION['status_text'] = "File is too large. Maximum allowed size is 5MB.";
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "Okay";
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } else {
            // Move file to the server directory
            if (!move_uploaded_file($file_tmp, $uploaded_file_path)) {
                $_SESSION['status'] = "Error!";
                $_SESSION['status_text'] = "File upload failed.";
                $_SESSION['status_code'] = "error";
                $_SESSION['status_btn'] = "Okay";
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit();
            }
        }
    }

    // Update the database
    $sql = "UPDATE `accounts` 
            SET `firstname` = ?, 
                `lastname` = ?"
            . ($uploaded_file_path ? ", `picture` = ?" : "") . 
            " WHERE `brgy_code` = ? AND `id` = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error); // Debugging in case of preparation failure
    }

    // Bind parameters dynamically based on `$uploaded_file_path`
    if ($uploaded_file_path) {
        $stmt->bind_param("ssssi", $firstname, $lastname, $uploaded_file_path, $brgy_code, $id);
    } else {
        $stmt->bind_param("sssi", $firstname, $lastname, $brgy_code, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['status'] = "Success!";
        $_SESSION['status_text'] = "Profile updated successfully!";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
    } else {
        $_SESSION['status'] = "Error!";
        $_SESSION['status_text'] = "Error updating profile: " . $stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Okay";
    }

    $stmt->close();

    // Redirect back to the referring page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}


if (isset($_POST['passwordChange'])) {
    // Capture POST data
    $user_id = $_POST['id']; // Ensure this ID is passed from the form
    $current_password = $_POST['password'];
    $new_password = $_POST['newpassword'];
    $renew_password = $_POST['renewpassword'];

    // Validate if new passwords match
    if ($new_password !== $renew_password) {
        $_SESSION['status'] = "Warning!";
        $_SESSION['status_text'] = "New passwords do not match.";
        $_SESSION['status_code'] = "warning";
        $_SESSION['status_btn'] = "Okay";
        exit;
    }

    // Fetch the current hashed password from the database
    $sql = "SELECT `password` FROM `accounts` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['status'] = "Warning!";
        $_SESSION['status_text'] = "User not found.";
        $_SESSION['status_code'] = "warning";
        $_SESSION['status_btn'] = "Okay";
        exit;
    }

    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    // Verify the current password
    if (!password_verify($current_password, $hashed_password)) {
        $_SESSION['status'] = "Warning!";
        $_SESSION['status_text'] = "Current password is incorrect.";
        $_SESSION['status_code'] = "warning";
        $_SESSION['status_btn'] = "Okay";
        exit;
    }

    // Hash the new password
    $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $update_sql = "UPDATE `accounts` SET `password` = ? WHERE `id` = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $new_hashed_password, $user_id);

    if ($update_stmt->execute()) {
        $_SESSION['status'] = "Success!";
        $_SESSION['status_text'] = "Password updated successfully.";
        $_SESSION['status_code'] = "success";
        $_SESSION['status_btn'] = "Done";
    } else {
        $_SESSION['status'] = "Error!";
        $_SESSION['status_text'] = "Error updating password: " . $update_stmt->error;
        $_SESSION['status_code'] = "error";
        $_SESSION['status_btn'] = "Okay";
    }

    // Close connections
    $stmt->close();
    $update_stmt->close();
    
    // Redirect
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

$conn->close();
?>