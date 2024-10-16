<?php
// Include database connection
include 'includes/conn.php';

if(isset($_POST['get_option'])) {
    $region = $_POST['get_option'];
    
    // Fetch provinces based on selected region
    $query = "SELECT * FROM refprovince WHERE regCode = '$region'";
    $result = mysqli_query($conn, $query);
    
    $output = '<option value="">Select Province</option>';
    
    while($row = mysqli_fetch_assoc($result)) {
        $output .= '<option value="'.$row['provCode'].'">'.$row['provDesc'].'</option>';
    }
    
    echo $output;
}

if(isset($_POST['get_province'])) {
    $province = $_POST['get_province'];
    
    // Fetch municipalities based on selected province
    $query = "SELECT * FROM refcitymun WHERE provCode = '$province'";
    $result = mysqli_query($conn, $query);
    
    $output = '<option value="">Select Municipality</option>';
    
    while($row = mysqli_fetch_assoc($result)) {
        $output .= '<option value="'.$row['citymunCode'].'">'.$row['citymunDesc'].'</option>';
    }
    
    echo $output;
}

if(isset($_POST['get_municipality'])) {
    $municipality = $_POST['get_municipality'];
    
    // Fetch barangays based on selected municipality
    $query = "SELECT * FROM refbrgy WHERE citymunCode = '$municipality'";
    $result = mysqli_query($conn, $query);
    
    $output = '<option value="">Select Barangay</option>';
    
    while($row = mysqli_fetch_assoc($result)) {
        $output .= '<option value="'.$row['brgyCode'].'">'.$row['brgyDesc'].'</option>';
    }
    
    echo $output;
}
?>