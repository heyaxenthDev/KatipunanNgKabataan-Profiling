<?php
include "includes/conn.php";

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    
    // Query to fetch youth details
    $sql = "SELECT a.*, s.id AS SK_id, s.lastname AS SK_lastname, s.firstname AS SK_firstname, s.middlename AS SK_middlename, s.age AS SK_age, s.dob AS SK_dob, s.mobile_num AS SK_mobile_num, s.address AS SK_address, s.street_num AS SK_street_num, s.sex AS SK_sex FROM accounts a LEFT JOIN sk_officials s ON s.id = a.account_id WHERE a.account_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        
        // Format the data for JSON response
        $response = array(
            'id' => $data['SK_id'],
            'account_id' => $data['account_id'],
            'brgy_code' => $data['brgy_code'],
            'lastname' => $data['SK_lastname'],
            'firstname' => $data['SK_firstname'],
            'middlename' => $data['SK_middlename'],
            'street_num' => $data['SK_street_num'],
            'role' => $data['role'],
            'sex' => $data['SK_sex'],
            'age' => $data['SK_age'],
            'dob' => $data['SK_dob'],
            'mobile_num' => $data['SK_mobile_num'],
            'address' => $data['SK_address'],
            'username' => $data['username'],
            'password' => $data['password'],
            'email' => $data['email'],
            'picture' => $data['picture']
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