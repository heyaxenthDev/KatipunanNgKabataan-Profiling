<?php 
session_start();
include "includes/conn.php";

if (isset($_POST['addBarangayForm'])) {
    // Get the submitted barangay name from the form
    $barangayName = mysqli_real_escape_string($conn, $_POST['barangayName']);
    
    // Check if the barangay name is not empty
    if (!empty($barangayName)) {
        // Get the next auto-increment ID for the barangay table
        $query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'sk_db' AND TABLE_NAME = 'barangay'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $next_id = $row['AUTO_INCREMENT'];

        // Generate barangay code with leading zeros (e.g., 001, 002, etc.)
        $barangayCode = sprintf("%03d", $next_id);
        
        // Prepare an SQL query to insert the new barangay
        $sql = "INSERT INTO barangay (barangay_code, barangay_name) VALUES ('$barangayCode', '$barangayName')";
        
        // Execute the query and check if the insertion was successful
        if (mysqli_query($conn, $sql)) {
            $_SESSION['status'] = "Success!";
            $_SESSION['status_text'] = "New barangay '$barangayName' has been added successfully with code: $barangayCode!";
            $_SESSION['status_code'] = "success";
            $_SESSION['status_btn'] = "OK";
        } else {
            $_SESSION['status'] = "Error!";
            $_SESSION['status_text'] = "Error adding barangay: " . mysqli_error($conn);
            $_SESSION['status_code'] = "error";
            $_SESSION['status_btn'] = "Retry";
        }
    } else {
        // Handle the case where barangay name is empty
        $_SESSION['status'] = "Input Error!";
        $_SESSION['status_text'] = "Barangay name cannot be empty.";
        $_SESSION['status_code'] = "warning";
        $_SESSION['status_btn'] = "Back";
    }

    // Redirect back to the previous page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}

if (isset($_POST['updateAcc'])) {
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
            " WHERE `id` = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error); // Debugging in case of preparation failure
    }

    // Bind parameters dynamically based on `$uploaded_file_path`
    if ($uploaded_file_path) {
        $stmt->bind_param("sssi", $firstname, $lastname, $uploaded_file_path, $id);
    } else {
        $stmt->bind_param("ssi", $firstname, $lastname, $id);
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