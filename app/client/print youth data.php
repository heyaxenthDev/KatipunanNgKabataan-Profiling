<?php 
    include 'authentication.php';
    checkLogin(); // Call the function to check if the user is logged in
    include "includes/conn.php";
    include "includes/header.php";
    include "includes/sidebar.php";
    include "alert.php";


?>

<link href="assets/css/print-form.css" rel="stylesheet">

<script src="assets/js/sweetalert2.all.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>

<main id="main" class="main">

    <div class="pagetitle pb-3">
        <h1>Print Youth Data</h1>
    </div><!-- End Page Title -->
    <section class="section">


        <!-- <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div> -->
        <!-- End Search Bar -->

        <div class="row">
            <div class="search-bar col-md-4 mb-3">
                <form class="search-form d-flex align-items-center" method="POST" action="#">
                    <label for="searchbar" class="m-2">Search</label>
                    <input type="text" name="query" placeholder="Enter Registration Number" title="Enter " required>
                    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                </form>
            </div><!-- End Search Bar -->

            <div class="col-md-6 align-items-end buttons">
                <button type="button" onclick="printForm()" class="btn btn-info"><i class="bi bi-printer"></i> Print
                    Preview</button>
            </div>
        </div>


        <div class="card" id="printableCard">
            <form class="card-body" action="#" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="brgyCode" id="brgyCode" value="<?=$_GET['Code']?>">

                <div class="container-fluid mb-2">
                    <div class="row align-items-center p-2">
                        <!-- Logo Section -->
                        <div class="col-4 text-center text-md-start sebaste-logo">
                            <img class="img-fluid " src="assets/img/sebaste-logo-1x1.png" alt="">
                        </div>

                        <!-- Text Section -->
                        <div class="col-4 text-center text-header">
                            <h5>Republic of the Philippines</h5>
                            <h5>Province of Antique</h5>
                            <h5 class="fw-bold">MUNICIPALITY OF SEBASTE</h5>
                        </div>

                        <!-- User Profile Section -->
                        <div class="col-4 text-center text-md-end img-prev">
                            <div class="division">
                                <img src="assets/img/user-profile.png" id="userImage"
                                    class="img-fluid rounded img-thumbnail" alt="User Image">
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Multi Columns Form -->
                <div class="row g-3">
                    <label for="YourName" class="form-label fw-semibold">Name of Respondent</label>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-dark border-bottom">
                                <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                    id="LastName" name="lastName" readonly>
                            </div>
                            <label for="LastName">Last Name</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-dark border-bottom">
                                <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                    id="FirstName" name="firstName" readonly>
                            </div>
                            <label for="FirstName">First Name</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-bottom border-dark">
                                <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                    id="MiddleName" name="middleName" readonly>
                            </div>
                            <label for="MiddleName">Middle Name</label>
                        </div>
                    </div>

                    <label for="Location" class="form-label fw-semibold">Location</label>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-bottom border-dark">
                                <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                    id="Street" name="street" readonly>
                            </div>
                            <label for="Street">Street</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-bottom border-dark">
                                <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                    id="Region" name="Region" readonly>
                            </div>
                            <label for="Region">Region</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-bottom border-dark">
                                <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                    id="Province" name="Province" readonly>
                            </div>
                            <label for="Province">Province</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-bottom border-dark">
                                <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                    id="Municipality" name="Municipality" readonly>
                            </div>
                            <label for="Municipality">City/Municipality</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-bottom border-dark">
                                <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                    id="Barangay" name="Barangay" readonly>
                            </div>
                            <label for="Barangay">Barangay</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-bottom border-dark">
                                <input type="text" class="form-control text-value text-center border-0 fw-bold" id="Zip"
                                    name="Zip" readonly>
                            </div>
                            <label for="Zip">Zip</label>
                        </div>
                    </div>


                    <label for="PersonalInformation" class="form-label fw-semibold">Personal Information</label>

                    <div class="col-md-4">
                        <label class="form-label d-block mb-2">Gender <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="0"
                                readonly>
                            <label class="form-check-label" for="genderMale">Male</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="1">
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
                        <div class="text-center">
                            <div class="border-bottom border-dark">
                                <input type="text" class="form-control text-value text-center border-0 fw-bold" id="Age"
                                    name="Age" readonly>
                            </div>
                            <label for="Age">Age</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-bottom border-dark">
                                <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                    id="birthdate" name="birthdate" readonly>
                            </div>
                            <label for="birthdate">Birthdate</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-bottom border-dark">
                                <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                    id="CivilStatus" name="CivilStatus" readonly>
                            </div>
                            <label for="CivilStatus">Civil Status</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-bottom border-dark">
                                <input type="email" class="form-control text-value text-center border-0 fw-bold"
                                    id="Email" name="Email" readonly>
                            </div>
                            <label for="Email">Email Address</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="border-bottom border-dark">
                                <input type="tel" class="form-control text-value text-center border-0 fw-bold"
                                    id="Contact" name="Contact" readonly>
                            </div>
                            <label for="Contact">Contact Number</label>
                        </div>
                    </div>

                    <label for="Classification" class="form-label fw-semibold">Classifications</label>

                    <div class="row mt-2">

                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="border-bottom border-dark">
                                    <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                        id="YouthAgeGroup" name="YouthAgeGroup" readonly>
                                </div>
                                <label for="YouthAgeGroup">Youth Age Group</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="border-bottom border-dark">
                                    <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                        id="YouthClassification" name="YouthClassification" readonly>
                                </div>
                                <label for="YouthClassification">Youth Classification</label>
                            </div>
                        </div>

                        <!-- Educational Background Section -->
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="border-bottom border-dark">
                                    <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                        id="EducationalBackground" name="educationalBackground" readonly>
                                </div>
                                <label for="EducationalBackground" class="form-label">Educational
                                    Background</label>
                            </div>
                        </div>

                        <!-- Work Status Section -->
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="border-bottom border-dark">
                                    <input type="text" class="form-control text-value text-center border-0 fw-bold"
                                        id="WorkStatus" name="workStatus" readonly>
                                </div>
                                <label for="WorkStatus" class="form-label">Work Status</label>
                            </div>
                        </div>
                    </div>



                    <!-- Voter Registration Section -->
                    <div class="mb-1">
                        <label for="VotersRegistration" class="form-label fw-semibold">Voter's Registration</label>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Registered SK Voter?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="skVoter" id="skVoterYes"
                                        value="Yes" readonly>
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
                                        id="nationalVoterYes" value="Yes" readonly>
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
                    <div class="mb-1">
                        <label for="AssemblyParticipation" class=" form-label fw-semibold">Assembly
                            Participation</label>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Have you already attended a KK Assembly?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kkAssembly" id="kkAssemblyYes"
                                        value="Yes" readonly>
                                    <label class="form-check-label" for="kkAssemblyYes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kkAssembly" id="kkAssemblyNo"
                                        value="No">
                                    <label class="form-check-label" for="kkAssemblyNo">No</label>
                                </div>
                            </div>

                            <div class="col-md-6" id="ifYes" style="display: none;">
                                <label>If Yes, how many times?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kkAssemblyTimes" id="times1to2"
                                        value="1-2">
                                    <label class="form-check-label" for="times1to2">1-2 times</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kkAssemblyTimes" id="times3to4"
                                        value="3-4">
                                    <label class="form-check-label" for="times3to4">3-4 times</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kkAssemblyTimes" id="times5plus"
                                        value="5 and above">
                                    <label class="form-check-label" for="times5plus">5 and above</label>
                                </div>
                            </div>

                            <div class="col-md-6" id="ifNo" style="display: none;">
                                <label>If No, Why?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kkAssemblyWhy" id="NoAssembly"
                                        value="There was no KK Assembly Meeting">
                                    <label class="form-check-label" for="NoAssembly">There was no KK Assembly
                                        Meeting</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kkAssemblyWhy" id="NotInterested"
                                        value="Not interested to attend">
                                    <label class="form-check-label" for="NotInterested">Not interested to attend
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Vote History Section -->
                    <div class="mb-1">
                        <label for="VoteHistory" class=" form-label fw-semibold">Did you vote last SK
                            Election?</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="vote" id="voteYes" value="Yes"
                                        readonly>
                                    <label class="form-check-label" for="voteYes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="vote" id="voteNo" value="No">
                                    <label class="form-check-label" for="voteNo">No</label>
                                </div>
                            </div>
                        </div>
                    </div>


                </div><!-- End Multi Columns Form -->

            </form>
        </div>

        <script src="assets/js/search.js"></script>

        <script>
        function printForm() {
            window.print(); // This will apply the CSS print styles
        }
        </script>


    </section>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>