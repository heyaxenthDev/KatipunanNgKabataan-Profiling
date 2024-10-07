<?php
session_start();

include_once('includes/conn.php');

// Check if user is authenticated as an client
if (isset($_SESSION['client_auth']) || $_SESSION['client_auth'] == true) {
    // Set session variables for status message
    $_SESSION['status_text'] = "You have been logged out.";
    $_SESSION['status_code'] = "info";

     // Unset session variables
    //  session_destroy();

    // Redirect to index page
    header("Location: index");
    exit; // Exit script to prevent further execution
}