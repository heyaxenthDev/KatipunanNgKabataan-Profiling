<?php
include 'includes/conn.php'; // your DB connection

// Step 1: Get dominant youth classification
$class_sql = "SELECT youth_classification, COUNT(*) as total 
              FROM registered 
              GROUP BY youth_classification 
              ORDER BY total DESC LIMIT 1";
$class_result = $conn->query($class_sql);
$dominant_class = $class_result->fetch_assoc()['youth_classification'] ?? '';

// Step 2: Get dominant gender
$gender_sql = "SELECT gender, COUNT(*) as total 
               FROM registered 
               GROUP BY gender 
               ORDER BY total DESC LIMIT 1";
$gender_result = $conn->query($gender_sql);
$dominant_gender = $gender_result->fetch_assoc()['gender'] ?? '';

// Step 3: Get dominant age group
$age_sql = "SELECT 
              CASE 
                WHEN age BETWEEN 15 AND 17 THEN 'Child Youth'
                WHEN age BETWEEN 18 AND 24 THEN 'Core Youth'
                WHEN age BETWEEN 25 AND 30 THEN 'Young Adult'
              END as age_group,
              COUNT(*) as total
            FROM registered 
            GROUP BY age_group 
            ORDER BY total DESC LIMIT 1";
$age_result = $conn->query($age_sql);
$dominant_age_group = $age_result->fetch_assoc()['age_group'] ?? '';

// Step 4: Determine suggested program
$program = '';
$category = '';

switch ($dominant_class) {
    case 'In-school Youth':
        $program = 'Library Hub, School Supplies Distribution, Tutorial Programs';
        $category = 'Educational Support';
        break;
    case 'Out-of-school Youth':
        $program = 'ALS Program, Vocational Training, Job Assistance';
        $category = 'Employment Opportunities';
        break;
    case 'Unemployed Youth':
        $program = 'Job Fairs, Skills Training, Entrepreneurship Workshops';
        $category = 'Employment Opportunities';
        break;
    case 'Self-employed Youth':
        $program = 'Startup Grants, Business Mentorship, SME Support';
        $category = 'Business Development';
        break;
    case 'Still Studying':
        $program = 'Scholarships, Career Guidance, Internships';
        $category = 'Educational Support';
        break;
}

// Add sports-based recommendation for Core/Child Youth
if ($dominant_age_group !== 'Young Adult') {
    if ($dominant_gender == 'Male') {
        $program .= ', Basketball Tournament';
        $category .= ', Sports Program';
    } elseif ($dominant_gender == 'Female') {
        $program .= ', Volleyball Tournament';
        $category .= ', Sports Program';
    }
}

echo json_encode([
    'classification' => $dominant_class,
    'gender' => $dominant_gender,
    'age_group' => $dominant_age_group,
    'category' => $category,
    'suggested_programs' => $program
]);
?>