<?php
include 'authentication.php';
checkLogin();
include "includes/conn.php";

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['editId'] ?? null;
    
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'No ID provided']);
        exit;
    }
    
    // Get all form data
    $last_name = $_POST['editLastName'] ?? '';
    $first_name = $_POST['editFirstName'] ?? '';
    $middle_name = $_POST['editMiddleName'] ?? '';
    $street = $_POST['editStreet'] ?? '';
    $barangay = $_POST['editBarangay'] ?? '';
    $municipality = $_POST['editMunicipality'] ?? '';
    $province = $_POST['editProvince'] ?? '';
    $region = $_POST['editRegion'] ?? '';
    $zip = $_POST['editZip'] ?? '';
    $gender = $_POST['editGender'] ?? 0;
    $birthdate = $_POST['editBirthdate'] ?? '';
    $civil_status = $_POST['editCivilStatus'] ?? '';
    $email = $_POST['editEmail'] ?? '';
    $contact = $_POST['editContact'] ?? '';
    $youth_age_group = $_POST['editYouthAgeGroup'] ?? '';
    $youth_classification = $_POST['editYouthClassification'] ?? '';
    $educational_background = $_POST['editEducationalBackground'] ?? '';
    $work_status = $_POST['editWorkStatus'] ?? '';
    $sk_voter = $_POST['editSkVoter'] ?? 'No';
    $national_voter = $_POST['editNationalVoter'] ?? 'No';
    $kk_assembly = $_POST['editKkAssembly'] ?? 'No';
    $kk_assembly_times = $_POST['editKkAssemblyTimes'] ?? '';
    $kk_assembly_why = $_POST['editKkAssemblyWhy'] ?? '';
    $vote = $_POST['editVote'] ?? 'No';
    
    // Handle file upload if a new image is provided
    $user_image = '';
    if (isset($_FILES['editUserImage']) && $_FILES['editUserImage']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES['editUserImage']['name'], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $upload_path = $upload_dir . $new_filename;
        
        if (move_uploaded_file($_FILES['editUserImage']['tmp_name'], $upload_path)) {
            $user_image = $upload_path;
        }
    }
    
    // Prepare the update query
    $query = "UPDATE registered SET 
        last_name = ?, first_name = ?, middle_name = ?, 
        street = ?, barangay = ?, municipality = ?, 
        province = ?, region = ?, zip = ?, gender = ?, 
        birthdate = ?, civil_status = ?, email = ?, 
        contact = ?, youth_age_group = ?, youth_classification = ?, 
        educational_background = ?, work_status = ?, 
        sk_voter = ?, national_voter = ?, kk_assembly = ?, 
        kk_assembly_times = ?, kk_assembly_why = ?, vote = ?";
    
    $params = [
        $last_name, $first_name, $middle_name,
        $street, $barangay, $municipality,
        $province, $region, $zip, $gender,
        $birthdate, $civil_status, $email,
        $contact, $youth_age_group, $youth_classification,
        $educational_background, $work_status,
        $sk_voter, $national_voter, $kk_assembly,
        $kk_assembly_times, $kk_assembly_why, $vote
    ];
    
    // Add user_image to query if a new image was uploaded
    if ($user_image) {
        $query .= ", user_image = ?";
        $params[] = $user_image;
    }
    
    $query .= " WHERE id = ?";
    $params[] = $id;
    
    // Execute the update
    $stmt = $conn->prepare($query);
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Youth record updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating youth record: ' . $conn->error]);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?>