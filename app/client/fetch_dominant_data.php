<?php
header('Content-Type: application/json');
include 'includes/conn.php'; // your DB connection
// Fetch data from the `registered` table
$sql = "SELECT youth_classification, gender, age FROM registered";
$result = mysqli_query($conn, $sql);

// Initialize counters
$classifications = [];
$genders = ['male' => 0, 'female' => 0];
$age_groups = ['15-20' => 0, '21-25' => 0, '26-30' => 0];

// Process data
while ($row = mysqli_fetch_assoc($result)) {
    // Count classifications
    $class = $row['youth_classification'];
    $classifications[$class] = ($classifications[$class] ?? 0) + 1;

    // Count gender
    $gender = strtolower($row['gender']);
    if (isset($genders[$gender])) {
        $genders[$gender]++;
    }

    // Categorize age groups
    $age = intval($row['age']);
    if ($age >= 15 && $age <= 20) {
        $age_groups['15-20']++;
    } elseif ($age >= 21 && $age <= 25) {
        $age_groups['21-25']++;
    } elseif ($age >= 26 && $age <= 30) {
        $age_groups['26-30']++;
    }
}

// Get the dominant values
$dominant_classification = array_search(max($classifications), $classifications);
$dominant_gender = array_search(max($genders), $genders);
$dominant_age_group = array_search(max($age_groups), $age_groups);

// Mapping rules
$programs = [
    "In School" => ["education" => ["Free Printing", "Library Hub", "School Supplies Distribution"]],
    "Out of School Youth" => ["education" => ["ALS", "Vocational Training"]],
    "Working Youth" => ["employment" => ["Job Fairs", "Skills Training"]],
    "Youth with Special Needs" => ["special" => ["Inclusive Workshops", "Assistive Programs"]],
    "Person with Disability" => ["special" => ["Disability Support Programs"]],
    "Children in conflict with Law" => ["justice" => ["Rehabilitation Programs"]],
    "Indigenous People" => ["cultural" => ["Cultural Heritage Programs", "Indigenous Skills Training"]],
];

// Sports-based gender influence
$sports = [
    "male" => ["Basketball Tournament"],
    "female" => ["Volleyball Tournament"]
];

// Determine the suggested program
$suggested_program = "General Youth Development"; // Default if nothing matches

if (isset($programs[$dominant_classification])) {
    // Choose the first program under the classification
    $program_category = array_key_first($programs[$dominant_classification]);
    $program_options = $programs[$dominant_classification][$program_category];

    // Use sports specialization if it's a sports-related program
    if ($program_category === "sports" && isset($sports[$dominant_gender])) {
        $suggested_program = $sports[$dominant_gender][0];
    } else {
        $suggested_program = $program_options[0]; // Take the first option
    }
}

// Return data as JSON
echo json_encode([
    "classification" => $dominant_classification,
    "gender" => $dominant_gender,
    "age_group" => $dominant_age_group,
    "suggested_program" => $suggested_program
]);
?>