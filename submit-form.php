<?php
session_start();
include "includes/conn.php";

if (isset($_POST['RegYouth'])) {
    // Sanitize inputs (or use prepared statements)
    $brgyCode = mysqli_real_escape_string($conn, $_POST['brgyCode']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $middleName = mysqli_real_escape_string($conn, $_POST['middleName']);
    $street = mysqli_real_escape_string($conn, $_POST['street'] ?? '');

    // Get Region Description using prepared statements
    $regionCode = $_POST['Region'] ?? '';
    $region = null;
    if ($regionCode) {
        $stmt = $conn->prepare("SELECT `regDesc` FROM `refregion` WHERE `regCode` = ?");
        $stmt->bind_param("s", $regionCode);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $regionData = $result->fetch_assoc();
            $region = $regionData['regDesc'];
        }
        $stmt->close();
    }

    // Get Province Description similarly
    $provinceCode = $_POST['Province'] ?? '';
    $province = null;
    if ($provinceCode) {
        $stmt = $conn->prepare("SELECT `provDesc` FROM `refprovince` WHERE `provCode` = ?");
        $stmt->bind_param("s", $provinceCode);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $ProvData = $result->fetch_assoc();
            $province = $ProvData['provDesc'];
        }
        $stmt->close();
    }

    // Get Municipality Description
    $municipalityCode = $_POST['Municipality'] ?? '';
    $municipality = null;
    if ($municipalityCode) {
        $stmt = $conn->prepare("SELECT `citymunDesc` FROM `refcitymun` WHERE `citymunCode` = ?");
        $stmt->bind_param("s", $municipalityCode);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $municipalData = $result->fetch_assoc();
            $municipality = $municipalData['citymunDesc'];
        }
        $stmt->close();
    }

    // Get Barangay Description
    $barangayCode = $_POST['Barangay'] ?? '';
    $barangay = null;
    if ($barangayCode) {
        $stmt = $conn->prepare("SELECT `brgyDesc` FROM `refbrgy` WHERE `brgyCode` = ?");
        $stmt->bind_param("s", $barangayCode);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $BarangayData = $result->fetch_assoc();
            $barangay = $BarangayData['brgyDesc'];
        }
        $stmt->close();
    }

    // Handle Image Upload
    $userImage = null;
    if (isset($_FILES['userImage']) && $_FILES['userImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['userImage']['tmp_name'];
        $fileName = uniqid() . '_' . $_FILES['userImage']['name'];
        $filePath = 'app/client/uploads/' . basename($fileName);
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
    function generateRegistrationCode($conn, $table) {
        $dateRegistered = date('Ymd');
        $randomNumbers = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $lastIdQuery = "SELECT MAX(id) as last_id FROM $table";
        $result = mysqli_query($conn, $lastIdQuery);
        $row = mysqli_fetch_assoc($result);
        $primaryKey = $row['last_id'] + 1;
        return "$dateRegistered - $randomNumbers - $primaryKey";
    }

    $table = $age < 15 ? "unregistered" : "registered";
    $registrationCode = generateRegistrationCode($conn, $table);

    // Insert data
    $sql = $table === "unregistered"
        ? "INSERT INTO unregistered (regCode, last_name, first_name, middle_name, street, region, province, municipality, barangay, zip, civil_status, user_image, gender, age, birthdate, email, contact, youth_age_group, youth_classification, educational_background, work_status, sk_voter, national_voter, kk_assembly, kk_assembly_times, kk_assembly_why, vote, brgyCode)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" // Adjust fields as needed
        : "INSERT INTO registered (regCode, last_name, first_name, middle_name, street, region, province, municipality, barangay, zip, civil_status, user_image, gender, age, birthdate, email, contact, youth_age_group, youth_classification, educational_background, work_status, sk_voter, national_voter, kk_assembly, kk_assembly_times, kk_assembly_why, vote, brgyCode)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssssssssssssssss", $registrationCode, $lastName, $firstName, $middleName, $street, $region, $province, $municipality, $barangay, $zip, $civilStatus, $userImage, $gender, $age, $birthdate, $email, $contact, $youthAgeGroup, $youthClassification, $educationLevel, $workStatus, $skVoter, $nationalVoter, $kkAssembly, $kkAssemblyTimes, $kkAssemblyWhy, $vote, $brgyCode);
    if ($stmt->execute()) {
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