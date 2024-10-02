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
?>