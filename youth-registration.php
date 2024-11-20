<?php 
 include 'includes/conn.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Youth Registration - Katipunan ng Kabataan Profiling Syste</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="assets/img/favicon.ico" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="about-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <a href="index" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="assets/img/SK Logo-white.png" alt="" />
                <!-- <h1 class="sitename">Nova</h1> -->
            </a>

            <nav id="navmenu" class="navmenu">

                <i class="mobile-nav-toggle d-xl-none d-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade"
            style="background-image: url(assets/img/about-page-title-bg.jpg);">
            <div class="container">
                <h1>Youth Registration Form</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index">Home</a></li>
                        <li class="current">Youth Registration Form</li>
                    </ol>
                </nav>

                <div class="d-grid gap-2 col-3 mx-auto mt-4">
                    <?php 
                        // Fetch Available Barangays from the database
                        $sql = "SELECT * FROM barangay";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $results = $stmt->get_result(); // Use get_result to fetch multiple rows

                        // Check if any barangays are available
                        if ($results->num_rows > 0) {
                            echo '<select class="form-select" id="barangayCode" name="barangayCode" required>';
                            echo '<option value="" selected>Select your Barangay</option>';

                            // Loop through the results and add each barangay to the dropdown
                            while ($row = $results->fetch_assoc()) {
                                $barangayCode = $row['barangay_code']; // Assuming you have a column named 'barangay_code'
                                $barangayName = $row['barangay_name']; // Assuming you have a column named 'barangay_name'
                                echo "<option value='$barangayCode'>$barangayName</option>";
                            }

                            echo '</select>';
                        } else {
                            // If no barangays found, display a message or handle as necessary
                            echo '<p>No barangays available</p>';
                        }

                        // Close the statement
                        $stmt->close();

                    ?>
                </div>
            </div>
        </div><!-- End Page Title -->


        <!-- About Section -->
        <section id="about" class="about section">

            <div class="container">

                <div class="card p-3">
                    <form id="registrationForm" class="card-body" action="submit-form.php" method="POST"
                        enctype="multipart/form-data">

                        <input type="hidden" name="brgyCode" id="brgyCode">

                        <div class="container-fluid">
                            <div class="row align-items-center pt-5">
                                <!-- Logo Section -->
                                <div class="col-4 col-md-4 d-none d-md-block text-center text-md-start sebaste-logo">
                                    <img class="img-fluid " src="assets/img/sebaste-logo-1x1.png" alt="">
                                </div>

                                <!-- Text Section -->
                                <div class="col-md-4 text-center pt-5">
                                    <h5>Republic of the Philippines</h5>
                                    <h5>Province of Antique</h5>
                                    <h5 class="fw-bold">MUNICIPALITY OF SEBASTE</h5>
                                </div>

                                <!-- User Profile Section -->
                                <div class="col-md-4 text-center text-md-end">
                                    <div class="p-5 mx-5">
                                        <img src="assets/img/user-profile.png" id="userImage"
                                            class="img-fluid rounded img-thumbnail mb-3" alt="User Image">
                                        <input type="file" class="form-control" id="userImageInput" name="userImage"
                                            accept="image/*" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <script src="assets/js/load-img.js"></script>

                        <!-- Multi Columns Form -->
                        <div class="row g-3">
                            <label for="YourName" class="form-label fw-semibold">Name of Respondent</label>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingLastName" name="lastName"
                                        placeholder="Last Name" required>
                                    <label for="floatingLastName">Last Name</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingFirstName" name="firstName"
                                        placeholder="First Name" required>
                                    <label for="floatingFirstName">First Name</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="floatingMiddleName" name="middleName"
                                        placeholder="Middle Name" required>
                                    <label for="floatingMiddleName">Middle Name</label>
                                </div>
                            </div>

                            <label for="Location" class="form-label fw-semibold">Location</label>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="Street" name="street"
                                        placeholder="Street" required>
                                    <label for="Street">Street</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <?php
                                    $sql = "SELECT * FROM `refregion`";
                                    $result = mysqli_query($conn, $sql);
                                    
                                    // Check if there are any rows returned
                                    if(mysqli_num_rows($result) > 0 ){
                                        echo '<select class="form-select" id="regionSelect" name="Region" aria-label="Region Select" required>';
                                        echo '<option selected>Select Region</option>';
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="'.$row['regCode'].'">'.$row['regDesc'].'</option>';
                                        }
                                        echo '</select>';
                                    }else {
                                        echo 'No regions found.';
                                    }
                                    ?>
                                    <label for="regionSelect">Region</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" id="provinceSelect" name="Province"
                                        aria-label="Province Select" required>
                                        <option selected>Select Province</option>
                                    </select>
                                    <label for="provinceSelect">Province</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" id="municipalitySelect" name="Municipality"
                                        aria-label="City Select" required>
                                        <option selected>Select City/Municipality</option>
                                    </select>
                                    <label for="municipalitySelect">City/Municipality</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select" id="barangaySelect" name="Barangay"
                                        aria-label="Barangay Select" required>
                                        <option selected>Select Barangay</option>
                                    </select>
                                    <label for="barangaySelect">Barangay</label>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="inputZip" name="inputZip"
                                        placeholder=" " required>
                                    <label for="inputZip">Zip</label>
                                </div>
                            </div>

                            <label for="PersonalInformation" class="form-label fw-semibold">Personal Information</label>

                            <div class="col-md-4">
                                <label class="form-label d-block mb-2">Gender <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="genderMale" value="0"
                                        required>
                                    <label class="form-check-label" for="genderMale">Male</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="genderFemale"
                                        value="1">
                                    <label class="form-check-label" for="genderFemale">Female</label>
                                </div>
                                <!-- Optional: Uncomment the third option if needed -->
                                <!--
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="genderOther" value="Other">
                            <label class="form-check-label" for="genderOther">Other</label>
                        </div>
                        -->
                            </div>


                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" class="form-control" id="inputAge" name="inputAge"
                                        placeholder="Age" required>
                                    <label for="inputAge">Age</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="date" class="form-control" id="inputBirthdate" name="inputBirthdate"
                                        placeholder="Birthdate" required>
                                    <label for="inputBirthdate">Birthdate</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select id="inputCivilStatus" class="form-select" name="inputCivilStatus"
                                        aria-label="Civil Status" required>
                                        <option selected value="">Choose Civil Status...</option>
                                        <option value="single">Single</option>
                                        <option value="married">Married</option>
                                        <option value="divorced">Divorced</option>
                                        <option value="widowed">Widowed</option>
                                    </select>
                                    <label for="inputCivilStatus">Civil Status</label>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="inputEmail" name="inputEmail"
                                        placeholder="name@example.com" required>
                                    <label for="inputEmail">Email Address</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="tel" class="form-control" id="inputContact" name="inputContact"
                                        placeholder="09123456789" required>
                                    <label for="inputContact">Contact Number</label>
                                </div>
                            </div>

                            <label for="Classification" class="form-label fw-semibold">Classification</label>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="inputYouthAgeGroup" name="inputYouthAgeGroup" class="form-select"
                                        aria-label="Youth Age Group" required>
                                        <option selected value="">Choose Youth Age Group...</option>
                                        <option value="unregistered">Unregistered Youth <small>(below 15 years
                                                old)</small>
                                        </option>
                                        <option value="child">Child Youth <small>(15-17 years old)</small></option>
                                        <option value="core">Core Youth <small>(18-24 years old)</small></option>
                                        <option value="young_adult">Young Adult <small>(25-30 years old)</small>
                                        </option>
                                    </select>
                                    <label for="inputYouthAgeGroup">Youth Age Group</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select id="inputYouthClassification" name="inputYouthClassification"
                                        class="form-select" aria-label="Youth Classification" required>
                                        <option selected>Choose Youth Classification...</option>
                                        <option value="In School">In School</option>
                                        <option value="Out of School Youth">Out of School Youth</option>
                                        <option value="Working Youth">Working Youth</option>
                                        <option value="Youth with Special Needs">Youth with Special Needs</option>
                                        <option value="Person with Disability">Person with Disability</option>
                                        <option value="Children in conflict with Law">Children in conflict with Law
                                        </option>
                                        <option value="Indigenous People">Indigenous People</option>
                                    </select>
                                    <label for="inputYouthClassification">Youth Classification</label>
                                </div>
                            </div>

                            <label for="EducationalBackground" class="form-label fw-semibold">Educational
                                Background</label>

                            <!-- Educational Background Section -->
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="educationalBackground"
                                                id="elementaryLevel" value="Elementary Level" required>
                                            <label class="form-check-label" for="elementaryLevel">Elementary
                                                Level</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="educationalBackground"
                                                id="elementaryGraduate" value="Elementary Graduate">
                                            <label class="form-check-label" for="elementaryGraduate">Elementary
                                                Graduate</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="educationalBackground"
                                                id="highSchoolLevel" value="High School Level">
                                            <label class="form-check-label" for="highSchoolLevel">High School
                                                Level</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="educationalBackground"
                                                id="highSchoolGraduate" value="High School Graduate">
                                            <label class="form-check-label" for="highSchoolGraduate">High School
                                                Graduate</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="educationalBackground"
                                                id="vocationalGraduate" value="Vocational Graduate">
                                            <label class="form-check-label" for="vocationalGraduate">Vocational
                                                Graduate</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="educationalBackground"
                                                id="collegeLevel" value="College Level">
                                            <label class="form-check-label" for="collegeLevel">College Level</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="educationalBackground"
                                                id="collegeGraduate" value="College Graduate">
                                            <label class="form-check-label" for="collegeGraduate">College
                                                Graduate</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="educationalBackground"
                                                id="masterLevel" value="Master Level">
                                            <label class="form-check-label" for="masterLevel">Master Level</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="educationalBackground"
                                                id="masterGraduate" value="Master Graduate">
                                            <label class="form-check-label" for="masterGraduate">Master Graduate</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="educationalBackground"
                                                id="doctorateLevel" value="Doctorate Level">
                                            <label class="form-check-label" for="doctorateLevel">Doctorate Level</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="educationalBackground"
                                                id="doctorateGraduate" value="Doctorate Graduate">
                                            <label class="form-check-label" for="doctorateGraduate">Doctorate
                                                Graduate</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Work Status Section -->
                            <div class="mb-4">
                                <label for="WorkStatus" class="form-label fw-semibold">Work Status</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="workStatus" id="employed"
                                                value="Employed" required>
                                            <label class="form-check-label" for="employed">Employed</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="workStatus"
                                                id="unemployed" value="Unemployed">
                                            <label class="form-check-label" for="unemployed">Unemployed</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="workStatus"
                                                id="selfEmployed" value="Self-Employed">
                                            <label class="form-check-label" for="selfEmployed">Self-Employed</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="workStatus"
                                                id="currentlyLooking" value="Currently looking for a job">
                                            <label class="form-check-label" for="currentlyLooking">Currently looking for
                                                a
                                                job</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="workStatus"
                                                id="notInterested" value="Not interested in looking for a job">
                                            <label class="form-check-label" for="notInterested">Not interested in
                                                looking for a
                                                job</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="workStatus"
                                                id="stillStudying" value="Still Studying">
                                            <label class="form-check-label" for="stillStudying">Still Studying</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Voter Registration Section -->
                            <div class="mb-4">
                                <label for="VotersRegistration" class="form-label fw-semibold">Voter's
                                    Registration</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Registered SK Voter?</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="skVoter" id="skVoterYes"
                                                value="Yes" required>
                                            <label class="form-check-label" for="skVoterYes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="skVoter" id="skVoterNo"
                                                value="No">
                                            <label class="form-check-label" for="skVoterNo">No</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Registered National Voter?</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="nationalVoter"
                                                id="nationalVoterYes" value="Yes" required>
                                            <label class="form-check-label" for="nationalVoterYes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="nationalVoter"
                                                id="nationalVoterNo" value="No">
                                            <label class="form-check-label" for="nationalVoterNo">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Assembly Participation Section -->
                            <div class="mb-4">
                                <label for="AssemblyParticipation" class=" form-label fw-semibold">Assembly
                                    Participation</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Have you already attended a KK Assembly?</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kkAssembly"
                                                id="kkAssemblyYes" value="Yes" required>
                                            <label class="form-check-label" for="kkAssemblyYes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kkAssembly"
                                                id="kkAssemblyNo" value="No">
                                            <label class="form-check-label" for="kkAssemblyNo">No</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="ifYes" style="display: none;">
                                        <label>If Yes, how many times?</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kkAssemblyTimes"
                                                id="times1to2" value="1-2">
                                            <label class="form-check-label" for="times1to2">1-2 times</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kkAssemblyTimes"
                                                id="times3to4" value="3-4">
                                            <label class="form-check-label" for="times3to4">3-4 times</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kkAssemblyTimes"
                                                id="times5plus" value="5 and above">
                                            <label class="form-check-label" for="times5plus">5 and above</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="ifNo" style="display: none;">
                                        <label>If No, Why?</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kkAssemblyWhy"
                                                id="NoAssembly" value="There was no KK Assembly Meeting">
                                            <label class="form-check-label" for="NoAssembly">There was no KK Assembly
                                                Meeting</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kkAssemblyWhy"
                                                id="NotInterested" value="Not interested to attend">
                                            <label class="form-check-label" for="NotInterested">Not interested to attend
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                            $(document).ready(function() {
                                $('input[name="kkAssembly"]').change(function() {
                                    if ($(this).val() == "Yes") {
                                        $("#ifYes").show();
                                        $("#ifNo").hide(); // Hide 'No' section if 'Yes' is selected
                                    } else if ($(this).val() == "No") {
                                        $("#ifNo").show();
                                        $("#ifYes").hide(); // Hide 'Yes' section if 'No' is selected
                                    }
                                });
                            });
                            </script>


                            <!-- Vote History Section -->
                            <div class="mb-4">
                                <label for="VoteHistory" class=" form-label fw-semibold">Did you vote last SK
                                    Election?</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="vote" id="voteYes"
                                                value="Yes" required>
                                            <label class="form-check-label" for="voteYes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="vote" id="voteNo"
                                                value="No">
                                            <label class="form-check-label" for="voteNo">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center pt-5">
                                <button type="submit" class="btn btn-primary" name="RegYouth">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </div><!-- End Multi Columns Form -->

                    </form>
                </div>
            </div>

        </section><!-- /About Section -->

        <!-- JavaScript to Populate Barangay Code -->
        <script>
        // Get references to the select and input elements
        const barangaySelect = document.getElementById('barangayCode');
        const barangayCodeInput = document.getElementById('brgyCode');
        const form = document.getElementById('registrationForm');

        // Update the input when a barangay is selected
        barangaySelect.addEventListener('change', function() {
            barangayCodeInput.value = this.value; // Set the input value to the selected barangay code
        });

        // Validate the form before submission
        form.addEventListener('submit', function(event) {
            if (barangaySelect.value === "") {
                // If no barangay is selected, show an alert and prevent form submission
                alert("Please select your Barangay before submitting the form.");
                event.preventDefault(); // Stop form submission
            }
        });
        </script>

    </main>

    <footer id="footer" class="footer light-background">

        <div class="container copyright text-center">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Katipunan ng Kabataan Profiling System</strong>
                <span>All Rights Reserved. 2024</span>
            </p>
            <div class="credits">
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>