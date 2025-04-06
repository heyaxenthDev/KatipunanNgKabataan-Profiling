<?php
session_start();
include 'includes/conn.php';

// Check if ID is provided in the AJAX request
if (isset($_POST['query'])) {
    $id = $_POST['query'];

    // SQL query to fetch youth data
    $sql = "SELECT * FROM `registered` WHERE `regCode` = ?";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("s", $id);  // 's' denotes string type for regCode
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a youth was found
        if ($result->num_rows > 0) {
            $youth = $result->fetch_assoc();
            // Return the youth data as JSON
            echo json_encode($youth);
        } else {
            echo json_encode(["error" => "No record found"]);
            // $_SESSION['status'] = "Test";
        }
        $stmt->close();
    }
}

$conn->close();
?>