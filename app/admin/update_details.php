<?php
include "includes/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $id = $conn->real_escape_string($_POST['id']);
    $brgy_code = $conn->real_escape_string($_POST['brgyCode']);
    $last_name = $conn->real_escape_string($_POST['lastName']);
    $first_name = $conn->real_escape_string($_POST['firstName']);
    $middle_name = $conn->real_escape_string($_POST['middleName']);
    $street = $conn->real_escape_string($_POST['street']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $birthdate = $conn->real_escape_string($_POST['inputBirthdate']);
    $civil_status = $conn->real_escape_string($_POST['inputCivilStatus']);
    $email = $conn->real_escape_string($_POST['inputEmail']);
    $contact = $conn->real_escape_string($_POST['inputContact']);
    $youth_age_group = $conn->real_escape_string($_POST['inputYouthAgeGroup']);
    $youth_classification = $conn->real_escape_string($_POST['inputYouthClassification']);
    $educational_background = $conn->real_escape_string($_POST['educationalBackground']);

    // Handle file upload if a new image is provided
    $user_image = '';
    if (isset($_FILES['userImage']) && $_FILES['userImage']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES["userImage"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension;
        $target_file = $target_dir . $new_filename;
        
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["userImage"]["tmp_name"]);
        if($check !== false) {
            if (move_uploaded_file($_FILES["userImage"]["tmp_name"], $target_file)) {
                $user_image = $target_file;
            }
        }
    }

    // Prepare update query
    $sql = "UPDATE registered SET 
            last_name = ?, 
            first_name = ?, 
            middle_name = ?, 
            street = ?, 
            gender = ?, 
            birthdate = ?, 
            civil_status = ?, 
            email = ?, 
            contact = ?, 
            youth_age_group = ?, 
            youth_classification = ?, 
            educational_background = ?";
    
    // Add user_image to update if a new image was uploaded
    if ($user_image) {
        $sql .= ", user_image = ?";
    }
    
    $sql .= " WHERE id = ? AND brgyCode = ?";
    
    $stmt = $conn->prepare($sql);
    
    if ($user_image) {
        $stmt->bind_param("ssssisssssssssi", 
            $last_name, $first_name, $middle_name, $street, $gender, 
            $birthdate, $civil_status, $email, $contact, $youth_age_group, 
            $youth_classification, $educational_background, $user_image, 
            $id, $brgy_code);
    } else {
        $stmt->bind_param("ssssisssssssii", 
            $last_name, $first_name, $middle_name, $street, $gender, 
            $birthdate, $civil_status, $email, $contact, $youth_age_group, 
            $youth_classification, $educational_background, 
            $id, $brgy_code);
    }

    if ($stmt->execute()) {
        $_SESSION['status'] = "Success";
        $_SESSION['status_text'] = "Youth details updated successfully!";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "Error";
        $_SESSION['status_text'] = "Error updating youth details: " . $stmt->error;
        $_SESSION['status_code'] = "error";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the previous page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    // If not a POST request, redirect to home
    header("Location: homepage");
    exit();
}
?>