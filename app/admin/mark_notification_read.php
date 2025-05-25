<?php
session_start();
include "includes/conn.php";
$id = intval($_POST['id']);
$user_id = $_SESSION['user']['id'];
mysqli_query($conn, "UPDATE notifications SET status='read' WHERE id='$id' AND user_id='$user_id'");
echo json_encode(['success' => true]); 