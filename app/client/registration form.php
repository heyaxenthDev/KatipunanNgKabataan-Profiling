<?php 
    include 'authentication.php';
    checkLogin(); // Call the function to check if the user is logged in
    include "includes/conn.php";
    include "includes/header.php";
    include "includes/sidebar.php";
    include "alert.php";


?>

<main id="main" class="main">

    <div class="pagetitle pb-3">
        <h1>Registration Form</h1>
    </div><!-- End Page Title -->
    <section class="section">

        <div class="card">
            <form class="card-body" action="submit-form.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="brgyCode" id="brgyCode" value="<?=$_GET['Code']?>">

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
                            <input type="text" class="form-control" id="Street" name="street" placeholder="Street"
                                required>
                            <label for="Street">Street</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="regionInput" name="Region" value="VI" readonly>
                            <label for="regionInput">Region</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="provinceInput" name="Province" value="Antique"
                                readonly>
                            <label for="provinceInput">Province</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="municipalityInput" name="Municipality"
                                value="Sebaste" readonly>
                            <label for="municipalityInput">City/Municipality</label>
                        </div>
                    </div>

                    <!-- <div class="col-md-4">
                        <div class="form-floating">
                            <?php 
                                $provCode = "0606";
                                $citymunCode = "060615";

                                $stmt = $conn->prepare("SELECT * FROM `refbrgy` WHERE provCode = ? AND citymunCode = ?");
                                $stmt->bind_param("ss", $provCode, $citymunCode);
                                $stmt->execute();
                                $result = $stmt->get_result();
                            ?>

                            <select class="form-select" id="barangaySelect" name="Barangay" aria-label="Barangay Select"
                                required>
                                <option selected>Select Barangay</option>
                                <?php 
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='".$row['brgyCode']."'>".$row['brgyDesc']."</option>";
                                    }
                                ?>
                            </select>
                            <label for="barangaySelect">Barangay</label>
                        </div>
                    </div> -->

                    <div class="col-md-4">
                        <div class="form-floating">
                            <?php 
                                $brgyCode = $_GET['Code'] ?? '';

                                $stmt = $conn->prepare("SELECT * FROM `barangay` WHERE barangay_code = ?");
                                $stmt->bind_param("s", $brgyCode);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $getBrgy = $result->fetch_assoc();
                                $brgyName = $getBrgy['barangay_name'];
                            ?>
                            <input type="text" class="form-control" id="barangayInput" name="Barangay"
                                value="<?= $brgyName?>" readonly>
                            <label for="barangayInput">Barangay</label>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputZip" name="inputZip" value="5709" readonly>
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
                        <div class="form-floating">
                            <input type="date" class="form-control" id="inputBirthdate" name="inputBirthdate"
                                placeholder="Birthdate" required>
                            <label for="inputBirthdate">Birthdate</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="inputAge" name="inputAge" placeholder="Age"
                                readonly>
                            <label for="inputAge">Age</label>
                        </div>
                    </div>

                    <script>
                    document.getElementById("inputBirthdate").addEventListener("input", function() {
                        let birthdate = this.value;
                        let ageInput = document.getElementById("inputAge");

                        if (birthdate) {
                            let birthDateObj = new Date(birthdate);
                            let today = new Date();
                            let age = today.getFullYear() - birthDateObj.getFullYear();
                            let monthDiff = today.getMonth() - birthDateObj.getMonth();
                            let dayDiff = today.getDate() - birthDateObj.getDate();

                            // Adjust age if birthday hasn't occurred yet this year
                            if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                                age--;
                            }

                            ageInput.value = age;
                        } else {
                            ageInput.value = "";
                        }
                    });
                    </script>




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
                                <option value="unregistered">Unregistered Youth <small>(below 15 years old)</small>
                                </option>
                                <option value="child">Child Youth <small>(15-17 years old)</small></option>
                                <option value="core">Core Youth <small>(18-24 years old)</small></option>
                                <option value="young_adult">Young Adult <small>(25-30 years old)</small></option>
                            </select>
                            <label for="inputYouthAgeGroup">Youth Age Group</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <select id="inputYouthClassification" name="inputYouthClassification" class="form-select"
                                aria-label="Youth Classification" required>
                                <option selected>Choose Youth Classification...</option>
                                <option value="In School">In School</option>
                                <option value="Out of School Youth">Out of School Youth</option>
                                <option value="Working Youth">Working Youth</option>
                                <option value="Youth with Special Needs">Youth with Special Needs</option>
                                <option value="Person with Disability">Person with Disability</option>
                                <option value="Children in conflict with Law">Children in conflict with Law</option>
                                <option value="Indigenous People">Indigenous People</option>
                            </select>
                            <label for="inputYouthClassification">Youth Classification</label>
                        </div>
                    </div>

                    <label for="EducationalBackground" class="form-label fw-semibold">Educational Background</label>

                    <!-- Educational Background Section -->
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="educationalBackground"
                                        id="elementaryLevel" value="Elementary Level" required>
                                    <label class="form-check-label" for="elementaryLevel">Elementary Level</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="educationalBackground"
                                        id="elementaryGraduate" value="Elementary Graduate">
                                    <label class="form-check-label" for="elementaryGraduate">Elementary Graduate</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="educationalBackground"
                                        id="highSchoolLevel" value="High School Level">
                                    <label class="form-check-label" for="highSchoolLevel">High School Level</label>
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
                                    <label class="form-check-label" for="vocationalGraduate">Vocational Graduate</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="educationalBackground"
                                        id="collegeLevel" value="College Level">
                                    <label class="form-check-label" for="collegeLevel">College Level</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="educationalBackground"
                                        id="collegeGraduate" value="College Graduate">
                                    <label class="form-check-label" for="collegeGraduate">College Graduate</label>
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
                                    <label class="form-check-label" for="doctorateGraduate">Doctorate Graduate</label>
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
                                    <input class="form-check-input" type="radio" name="workStatus" id="unemployed"
                                        value="Unemployed">
                                    <label class="form-check-label" for="unemployed">Unemployed</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="workStatus" id="selfEmployed"
                                        value="Self-Employed">
                                    <label class="form-check-label" for="selfEmployed">Self-Employed</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="workStatus" id="currentlyLooking"
                                        value="Currently looking for a job">
                                    <label class="form-check-label" for="currentlyLooking">Currently looking for a
                                        job</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="workStatus" id="notInterested"
                                        value="Not interested in looking for a job">
                                    <label class="form-check-label" for="notInterested">Not interested in looking for a
                                        job</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="workStatus" id="stillStudying"
                                        value="Still Studying">
                                    <label class="form-check-label" for="stillStudying">Still Studying</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Voter Registration Section -->
                    <div class="mb-4">
                        <label for="VotersRegistration" class="form-label fw-semibold">Voter's Registration</label>
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
                                    <input class="form-check-input" type="radio" name="kkAssembly" id="kkAssemblyYes"
                                        value="Yes" required>
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
                                    <input class="form-check-input" type="radio" name="vote" id="voteYes" value="Yes"
                                        required>
                                    <label class="form-check-label" for="voteYes">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="vote" id="voteNo" value="No">
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
    </section>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>