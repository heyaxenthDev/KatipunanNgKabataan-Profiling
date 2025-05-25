<?php
include "includes/conn.php";

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    
    // Query to fetch youth details
    $sql = "SELECT * FROM registered WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        // Format the data for JSON response
        $response = array(
            'id' => $data['id'],
            'brgy_code' => $data['brgyCode'],
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'street' => $data['street'],
            'barangay' => $data['barangay'],
            'municipality' => $data['municipality'],
            'province' => $data['province'],
            'region' => $data['region'],
            'zip' => $data['zip'],
            'gender' => $data['gender'],
            'birthdate' => $data['birthdate'],
            'civil_status' => $data['civil_status'],
            'email' => $data['email'],
            'contact' => $data['contact'],
            'youth_age_group' => $data['youth_age_group'],
            'youth_classification' => $data['youth_classification'],
            'educational_background' => $data['educational_background'],
            'work_status' => $data['work_status'],
            'sk_voter' => $data['sk_voter'],
            'national_voter' => $data['national_voter'],
            'kk_assembly' => $data['kk_assembly'],
            'kk_assembly_why' => $data['kk_assembly_why'],
            'kk_assembly_times' => $data['kk_assembly_times'],
            'vote' => $data['vote'],
            'user_image' => "../client/" . $data['user_image']
        );
        
        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // No data found
        header('HTTP/1.1 404 Not Found');
        echo json_encode(array('error' => 'Youth record not found'));
    }
} else {
    // No ID provided
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(array('error' => 'No ID provided'));
}

$stmt->close();
$conn->close();
?>