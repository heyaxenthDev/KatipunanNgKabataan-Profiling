<?php
session_start();
include "includes/conn.php";
$id = $_SESSION['user']['id'];
mysqli_query($conn, "UPDATE notifications SET status='read' WHERE user_id='$id'");
echo json_encode(['success' => true]); 