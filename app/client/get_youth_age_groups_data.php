<?php
include "includes/conn.php";

$code = $_GET['Code'] ?? "";

// Query to get the count for each youth age group
$sql = "
    SELECT 
        SUM(CASE WHEN youth_age_group = 'unregistered' THEN 1 ELSE 0 END) AS unregistered,
        SUM(CASE WHEN youth_age_group = 'child' THEN 1 ELSE 0 END) AS child_youth,
        SUM(CASE WHEN youth_age_group = 'core' THEN 1 ELSE 0 END) AS core_youth,
        SUM(CASE WHEN youth_age_group = 'young adult' THEN 1 ELSE 0 END) AS young_adult
     FROM registered WHERE brgyCode = '$code'
";

// Execute the query
$result = mysqli_query($conn, $sql);

// Fetch the result as an associative array
$data = mysqli_fetch_assoc($result);

// Output the data as JSON
echo json_encode($data);

// Close the connection
mysqli_close($conn);
?>