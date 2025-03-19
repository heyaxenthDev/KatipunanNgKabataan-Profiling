<?php
include "includes/conn.php";

$code = $_GET['Code'] ?? "";

// Query to get the count for each youth classification
$sql = "
    SELECT 
        SUM(CASE WHEN youth_classification = 'In School' THEN 1 ELSE 0 END) AS in_school,
        SUM(CASE WHEN youth_classification = 'Out of School' THEN 1 ELSE 0 END) AS out_of_school,
        SUM(CASE WHEN youth_classification = 'Working Youth' THEN 1 ELSE 0 END) AS working_youth,
        SUM(CASE WHEN youth_classification = 'Youth w/ Special Needs' THEN 1 ELSE 0 END) AS youth_special_needs,
        SUM(CASE WHEN youth_classification = 'Person w/ Disability' THEN 1 ELSE 0 END) AS person_disability,
        SUM(CASE WHEN youth_classification = 'Children in conflict w/ Law' THEN 1 ELSE 0 END) AS conflict_law,
        SUM(CASE WHEN youth_classification = 'Indigenous People' THEN 1 ELSE 0 END) AS indigenous_people
    FROM registered WHERE brgyCode = '$code' AND acc_type = 'registered'
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