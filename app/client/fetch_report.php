<?php
include "includes/conn.php";

$type = $_GET['type'] ?? '';
$category = $_GET['category'] ?? '';
$purok = $_GET['purok'] ?? '';
$brgyCode = $_GET['Code'] ?? '';

$where = [];
$params = [];
$types = "";

// Only allow 'registered' or 'unregistered' as acc_type
if ($type === "registered" || $type === "unregistered") {
    $where[] = "acc_type = ?";
    $params[] = $type;
    $types .= "s";
}

// Category filter
if ($category) {
    if ($category == "female" || $category == "male") {
        $where[] = "LOWER(gender) = ?";
        $params[] = strtolower($category);
        $types .= "s";
    } elseif ($category == "indeginous_people") {
        $where[] = "youth_classification = 'Indigenous People'";
    } elseif ($category == "pwd") {
        $where[] = "youth_classification = 'PWD'";
    }
}

// Purok filter
if ($purok) {
    $where[] = "street = ?";
    $params[] = $purok;
    $types .= "s";
}

// Brgy code filter
if ($brgyCode) {
    $where[] = "brgyCode = ?";
    $params[] = $brgyCode;
    $types .= "s";
}

$whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

$sql = "SELECT id, last_name, first_name, middle_name, street, gender, age, civil_status, work_status FROM registered $whereSql";
$stmt = $conn->prepare($sql);

if ($params) {
    $stmt->bind_param($types, ...$params);
}

error_log($sql);
error_log(print_r($params, true));

$stmt->execute();
$result = $stmt->get_result();

$output = '<table class="table table-bordered"><thead><tr>
<th>NO.</th><th>Name</th><th>Age</th><th>Gender</th><th>Civil Status</th><th>Street</th><th>Work Status</th>
</tr></thead><tbody>';

$i = 1;
while ($row = $result->fetch_assoc()) {
    $fullName = htmlspecialchars($row['last_name'] . ', ' . $row['first_name'] . ' ' . $row['middle_name']);
    $output .= "<tr>
        <td>{$i}</td>
        <td>{$fullName}</td>
        <td>" . htmlspecialchars($row['age']) . "</td>
        <td>" . htmlspecialchars($row['gender']) . "</td>
        <td>" . htmlspecialchars($row['civil_status']) . "</td>
        <td>" . htmlspecialchars($row['street']) . "</td>
        <td>" . htmlspecialchars($row['work_status']) . "</td>
    </tr>";
    $i++;
}
$output .= '</tbody></table>';

echo $output;
?>