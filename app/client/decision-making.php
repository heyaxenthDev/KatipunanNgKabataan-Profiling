<?php
include "includes/conn.php";

// Variables to store counts
$maleCount = 0;
$femaleCount = 0;
$ageGroup15To20 = 0;
$ageGroup21To25 = 0;
$ageGroup26To30 = 0;
$educationalBackgroundCount = [
    'highschool' => 0,
    'college' => 0,
    'graduate' => 0
];
$workStatusCount = [
    'employed' => 0,
    'unemployed' => 0,
    'student' => 0
];

// Fetch demographic data from the database
$sql = "SELECT gender, youth_age_group, educational_background, work_status, COUNT(*) as total FROM registered WHERE 1 GROUP BY gender, youth_age_group, educational_background, work_status";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $gender = $row['gender'];
        $ageGroup = $row['youth_age_group'];
        $educationalBackground = $row['educational_background'];
        $workStatus = $row['work_status'];
        $total = $row['total'];

        // Count based on gender
        if ($gender == 'Male') {
            $maleCount += $total;
        } elseif ($gender == 'Female') {
            $femaleCount += $total;
        }

        // Count based on age group
        if ($ageGroup == 'child') {
            $ageGroup15To20 += $total;
        } elseif ($ageGroup == 'core') {
            $ageGroup21To25 += $total;
        } elseif ($ageGroup == 'young_adult') {
            $ageGroup26To30 += $total;
        }

        // Count based on educational background
        if ($educationalBackground == 'highschool') {
            $educationalBackgroundCount['highschool'] += $total;
        } elseif ($educationalBackground == 'college') {
            $educationalBackgroundCount['college'] += $total;
        } elseif ($educationalBackground == 'graduate') {
            $educationalBackgroundCount['graduate'] += $total;
        }

        // Count based on work status
        if ($workStatus == 'employed') {
            $workStatusCount['employed'] += $total;
        } elseif ($workStatus == 'unemployed') {
            $workStatusCount['unemployed'] += $total;
        } elseif ($workStatus == 'student') {
            $workStatusCount['student'] += $total;
        }
    }
}

// Initialize program, type, and category suggestions
$programSuggestion = "";
$typeSuggestion = "";
$forCategory = "";
$ageCategory = "";
$youthClassification = "";

// Suggest programs and types based on demographic data
if ($maleCount > $femaleCount) {
    if ($ageGroup15To20 >= $ageGroup21To25 && $ageGroup15To20 >= $ageGroup26To30) {
        $programSuggestion = "sports";
        $typeSuggestion = "mobile_legend"; // Young males might prefer mobile games
        $ageCategory = "15-20";
    } elseif ($ageGroup21To25 >= $ageGroup15To20 && $ageGroup21To25 >= $ageGroup26To30) {
        $programSuggestion = "sports";
        $typeSuggestion = "volleyball"; // Young adults might prefer volleyball
        $ageCategory = "21-25";
    } else {
        $programSuggestion = "sports";
        $typeSuggestion = "basketball"; // Older males might prefer basketball
        $ageCategory = "26-30";
    }
} else {
    if ($ageGroup15To20 >= $ageGroup21To25 && $ageGroup15To20 >= $ageGroup26To30) {
        $programSuggestion = "education";
        $typeSuggestion = "distribution_school_supplies"; // Younger females might prefer school supplies
        $ageCategory = "15-20";
    } elseif ($ageGroup21To25 >= $ageGroup15To20 && $ageGroup21To25 >= $ageGroup26To30) {
        $programSuggestion = "health_environment";
        $typeSuggestion = "health_environment"; // Females in this range might prefer health programs
        $ageCategory = "21-25";
    } else {
        $programSuggestion = "feeding";
        $typeSuggestion = "malnourish_low_weight"; // Older females might prioritize feeding programs
        $ageCategory = "26-30";
    }
}

// Special cases or tie scenarios
if ($maleCount == $femaleCount) {
    if ($ageGroup15To20 > $ageGroup21To25 && $ageGroup15To20 > $ageGroup26To30) {
        $programSuggestion = "tree_planting";
        $typeSuggestion = "tree_planting"; // Both genders might work well in environmental initiatives
        $ageCategory = "15-20";
    } else {
        $programSuggestion = "sports";
        $typeSuggestion = "volleyball"; // Neutral choice if the tie persists
        $ageCategory = "26-30"; // Default to older age group if tie
    }
}

// Suggest categories based on demographic data
if ($maleCount > $femaleCount) {
    $forCategory = "male";

    if ($ageGroup15To20) {
        $youthClassification = "Child Youth";
    } elseif ($ageGroup21To25) {
        $youthClassification = "Core Youth";
    } else {
        $youthClassification = "Young Adult";
    }
} else {
    $forCategory = "female";

    if ($ageGroup15To20) {
        $youthClassification = "Child Youth";
    } elseif ($ageGroup21To25) {
        $youthClassification = "Core Youth";
    } else {
        $youthClassification = "Young Adult";
    }
}

// Advanced suggestion based on work status and educational background
if ($workStatusCount['student'] > 0) {
    if ($educationalBackgroundCount['highschool'] > 0) {
        $programSuggestion = "education";
        $typeSuggestion = "study_materials"; // Focus on study materials for high school students
    } elseif ($educationalBackgroundCount['college'] > 0) {
        $programSuggestion = "scholarships";
        $typeSuggestion = "college_scholarships"; // Scholarships for college students
    }
}

if ($workStatusCount['unemployed'] > 0) {
    $programSuggestion = "skills_training";
    $typeSuggestion = "skills_courses"; // Unemployed individuals might benefit from skills development programs
}

if ($workStatusCount['employed'] > 0) {
    $programSuggestion = "entrepreneurship";
    $typeSuggestion = "business_training"; // Employed individuals might be interested in entrepreneurship
}

// Output JSON for frontend integration
echo json_encode([
    "program" => $programSuggestion,
    "type" => $typeSuggestion,
    "forCategory" => $forCategory,
    "ageCategory" => $ageCategory,
    "youthClassification" => $youthClassification
]);
?>