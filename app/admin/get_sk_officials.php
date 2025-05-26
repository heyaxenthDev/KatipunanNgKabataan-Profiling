<?php
include 'includes/conn.php';

$query = "SELECT id, firstname, middlename, lastname, position FROM sk_officials";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo '<option value="" disabled selected>Select official</option>';
    while ($row = $result->fetch_assoc()) {
        $full_name = $row['firstname'] . ' ' . strtoupper(substr($row['middlename'], 0, 1)) . '. ' . $row['lastname'];
        $position = $row['position'];
        $display = $full_name . ' - ' . $position;
        echo '<option value="' . htmlspecialchars($display) . '">' . htmlspecialchars($display) . '</option>';
    }
} else {
    echo '<option value="" disabled>No officials found</option>';
}
?>