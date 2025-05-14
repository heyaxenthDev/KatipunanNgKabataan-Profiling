<?php
session_start();
include "includes/conn.php";

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $programId = $conn->real_escape_string($_GET['id']);
    
    $query = "SELECT pf.*, a.firstname, a.lastname 
              FROM program_feedback pf 
              JOIN accounts a ON pf.user_id = a.id 
              WHERE pf.program_id = ? 
              ORDER BY pf.created_at DESC";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $programId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $feedback = array();
    while ($row = $result->fetch_assoc()) {
        $feedback[] = array(
            'id' => $row['id'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'feedback_type' => $row['feedback_type'],
            'feedback_message' => $row['feedback_message'],
            'created_at' => $row['created_at']
        );
    }
    
    echo json_encode($feedback);
} else {
    echo json_encode(array('error' => 'No program ID provided'));
}
?>