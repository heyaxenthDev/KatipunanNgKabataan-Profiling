<?php
session_start();
include "includes/conn.php";
include "includes/functions.php";

if (isset($_POST['RegYouth'])) {
    $user_id = $_SESSION['user']['id'];
    $message = "New youth registered";
    $type = "info";
    // Sanitize inputs (or use prepared statements)
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

    // Generate registration code
    function generateRegistrationCode($conn) {
        $dateRegistered = date('Ymd');
        $randomNumbers = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $lastIdQuery = "SELECT MAX(id) as last_id FROM registered";
        $result = mysqli_query($conn, $lastIdQuery);
        $row = mysqli_fetch_assoc($result);
        $primaryKey = $row['last_id'] + 1;
        return "$dateRegistered - $randomNumbers - $primaryKey";
    }

    $acc_type = $age < 15 ? "unregistered" : "registered";
    $registrationCode = generateRegistrationCode($conn, $acc_type);

    // Insert data
    $sql = "INSERT INTO registered (acc_type, regCode, last_name, first_name, middle_name, street, region, province, municipality, barangay, zip, civil_status, user_image, gender, age, birthdate, email, contact, youth_age_group, youth_classification, educational_background, work_status, sk_voter, national_voter, kk_assembly, kk_assembly_times, kk_assembly_why, vote, brgyCode)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssssssssssssssss", $acc_type, $registrationCode, $lastName, $firstName, $middleName, $street, $region, $province, $municipality, $barangay, $zip, $civilStatus, $userImage, $gender, $age, $birthdate, $email, $contact, $youthAgeGroup, $youthClassification, $educationLevel, $workStatus, $skVoter, $nationalVoter, $kkAssembly, $kkAssemblyTimes, $kkAssemblyWhy, $vote, $brgyCode);
    if ($stmt->execute()) {
        $sent_by = $_SESSION['user']['id'];
        $sent_to = 1;
        $message = "New youth registered";
        $type = "info";
        $link = "view_youth.php?id=" . $conn->insert_id;
        add_notification($conn, $sent_by, $sent_to, $message, $type, $link);
        $_SESSION['status'] = "Success!";
        $_SESSION['status_text'] = "Youth Registered!";
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