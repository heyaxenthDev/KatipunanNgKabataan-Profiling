<?php 
// Get Barangay Code value
$BrgyCode = $_GET['Code'];

// Fetch the specific barangay details from the database
$getBrgy = "SELECT * FROM barangay WHERE barangay_code = '$BrgyCode'";
$run_query = mysqli_query($conn, $getBrgy);

// Check if the query returned any results
if (mysqli_num_rows($run_query) > 0) {
    // Fetch the barangay data
    $barangay = mysqli_fetch_assoc($run_query);

    // Assuming you have columns like 'barangay_name', 'barangay_captain', etc.
    $barangayName = $barangay['barangay_name'];

} else {
    // If no results were found, display a message or handle the error
    echo "<p>No details found for the selected barangay.</p>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= $barangayName?> SK Official - Katipunan ng Kabataan Profiling System</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/address.js"></script>

</head>

<body>

    <?php
    // Get session user details
    $id = $_SESSION['user']['id'];
    $user_username = $_SESSION['user']['user_username'];

    $query = "SELECT * FROM `accounts` WHERE `id` = '$id' AND `username` = '$user_username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $user = substr($row['firstname'], 0, 1) . ". " . $row['lastname'];
            $fullname = $row['firstname'] . " " . $row['lastname'];
            $firstname = $row['firstname'];
            $email = $row['email'];
            $email_verify_status = $row['email_verify'];
            $role = $row['role'];
            $lastname = $row['lastname'];
            $username = $row['username'];
            $email = $row['email'];
            $brgy_code = $row['brgy_code'];
            $user_picture = $row['picture'];
            $dc = date("M d, Y", strtotime($row['date_created']));

        }
    }

    $getBrgyName = "SELECT * FROM barangay WHERE barangay_code = $brgy_code";
    $brgy_name = mysqli_query($conn, $getBrgyName);

    if ($brgy_name && mysqli_num_rows($brgy_name) > 0) {
        while ($row = mysqli_fetch_assoc($brgy_name)) {
            $BrgyName = $row['barangay_name'];
        }
    }
    ?>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="homepage?Code=<?=$BrgyCode?>" class="logo d-flex align-items-center">
                <img src="assets/img/SK Logo-white.png" alt="">
                <span class="d-none d-lg-block">KKPS</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <?php
                        // Check if $user_picture is empty
                        $profilePicture = empty($user_picture) ? 'assets/img/user-profile.png' : $user_picture;
                        ?>

                        <img src="<?= htmlspecialchars($profilePicture); ?>" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $user?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $fullname?></h6>
                            <span><?= $role?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="user-profile?Code=<?=$BrgyCode?>">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <!-- <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="bi bi-question-circle"></i>
                                <span>Need Help?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li> -->

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="\KatipunanNgKabataan-Profiling/client-logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->