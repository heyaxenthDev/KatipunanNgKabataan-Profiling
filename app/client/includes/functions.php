<?php
function add_notification($conn, $sent_by, $sent_to, $message, $type = 'info', $link = null) {
    $stmt = $conn->prepare("INSERT INTO notifications (sent_by, sent_to, message, type, link) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $sent_by, $sent_to, $message, $type, $link);
    $stmt->execute();
    $stmt->close();
} 