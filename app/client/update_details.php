<?php 
session_start();
include "includes/conn.php";


if (isset($_POST['updateDetails']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
     // Sanitize inputs (or use prepared statements)
    $id = mysqli_real_escape_string ($conn, $_POST['id']); // Assuming you're passing the ID to identify which record to update
    $brgyCode = mysqli_real_escape_string($conn, $_POST['brgyCode']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $middleName = mysqli_real_escape_string($conn, $_POST['middleName']);
    $street = mysqli_real_escape_string($conn, $_POST['street'] ?? '');
    $region = mysqli_real_escape_string($conn, $_POST['Region'] ?? '');
    $province = mysqli_real_escape_string($conn, $_POST['Province'] ?? '');
    $municipality = mysqli_real_escape_string($conn, $_POST['Municipality'] ?? '');
    $barangay = mysqli_real_escape_string($conn, $_POST['Barangay'] ?? '');

// Handle Image Upload
$userImage = null;
if (isset($_FILES['userImage']) && $_FILES['userImage']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['userImage']['tmp_name'];
    $fileName = uniqid() . '_' . $_FILES['userImage']['name'];
    $filePath = 'uploads/' . basename($fileName);
    if (move_uploaded_file($fileTmpPath, $filePath)) {
        $userImage = $filePath;
    }
}

    // Get other form fields
    $zip = mysqli_real_escape_string($conn, $_POST['inputZip'] ?? '');
    $civilStatus = mysqli_real_escape_string($conn, $_POST['inputCivilStatus'] ?? '');
    $gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');
    $age = (int) $_POST['inputAge'] ?? 0;
    $birthdate = mysqli_real_escape_string($conn, $_POST['inputBirthdate'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['inputEmail'] ?? '');
    $contact = mysqli_real_escape_string($conn, $_POST['inputContact'] ?? '');
    $youthAgeGroup = mysqli_real_escape_string($conn, $_POST['inputYouthAgeGroup'] ?? '');
    $youthClassification = mysqli_real_escape_string($conn, $_POST['inputYouthClassification'] ?? '');
    $educationLevel = mysqli_real_escape_string($conn, $_POST['educationalBackground'] ?? '');
    $workStatus = mysqli_real_escape_string($conn, $_POST['workStatus'] ?? '');
    $skVoter = mysqli_real_escape_string($conn, $_POST['skVoter'] ?? '');
    $nationalVoter = mysqli_real_escape_string($conn, $_POST['nationalVoter'] ?? '');
    $kkAssembly = mysqli_real_escape_string($conn, $_POST['kkAssembly'] ?? '');
    $kkAssemblyTimes = mysqli_real_escape_string($conn, $_POST['kkAssemblyTimes'] ?? '');
    $kkAssemblyWhy = mysqli_real_escape_string($conn, $_POST['kkAssemblyWhy'] ?? '');
    $vote = mysqli_real_escape_string($conn, $_POST['vote'] ?? '');

    $acc_type = $age < 15 ? "unregistered" : "registered";

// UPDATE query
if ($userImage) {
    // If image is updated
    $sql = "UPDATE registered SET 
        acc_type=?, last_name=?, first_name=?, middle_name=?, street=?, region=?, province=?, municipality=?, barangay=?, zip=?, civil_status=?, 
        user_image=?, gender=?, age=?, birthdate=?, email=?, contact=?, youth_age_group=?, youth_classification=?, educational_background=?, 
        work_status=?, sk_voter=?, national_voter=?, kk_assembly=?, kk_assembly_times=?, kk_assembly_why=?, vote=?, brgyCode=? 
        WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssssssssssssssssi", $acc_type, $lastName, $firstName, $middleName, $street, $region, $province, $municipality, $barangay, $zip, $civilStatus, $userImage, $gender, $age, $birthdate, $email, $contact, $youthAgeGroup, $youthClassification, $educationLevel, $workStatus, $skVoter, $nationalVoter, $kkAssembly, $kkAssemblyTimes, $kkAssemblyWhy, $vote, $brgyCode, $id);
} else {
    // If image is not updated
    $sql = "UPDATE registered SET 
        acc_type=?, last_name=?, first_name=?, middle_name=?, street=?, region=?, province=?, municipality=?, barangay=?, zip=?, civil_status=?, 
        gender=?, age=?, birthdate=?, email=?, contact=?, youth_age_group=?, youth_classification=?, educational_background=?, 
        work_status=?, sk_voter=?, national_voter=?, kk_assembly=?, kk_assembly_times=?, kk_assembly_why=?, vote=?, brgyCode=? 
        WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssssssssssssssi", $acc_type, $lastName, $firstName, $middleName, $street, $region, $province, $municipality, $barangay, $zip, $civilStatus, $gender, $age, $birthdate, $email, $contact, $youthAgeGroup, $youthClassification, $educationLevel, $workStatus, $skVoter, $nationalVoter, $kkAssembly, $kkAssemblyTimes, $kkAssemblyWhy, $vote, $brgyCode, $id);
}

if ($stmt->execute()) {
    $_SESSION['status'] = "Success!";
    $_SESSION['status_text'] = "Youth Information Updated!";
    $_SESSION['status_code'] = "success";
    $_SESSION['status_btn'] = "Done";
} else {
    $_SESSION['status'] = "Error!";
    $_SESSION['status_text'] = "Error: " . $stmt->error;
    $_SESSION['status_code'] = "error";
    $_SESSION['status_btn'] = "Okay";
}

$stmt->close();
$conn->close();

// Redirect
header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
}
?>