<?php
session_start();
include "includes/conn.php";
$id = $_SESSION['user']['id'];
mysqli_query($conn, "UPDATE notifications SET status='read' WHERE sent_to='$id'");
echo json_encode(['success' => true]); 