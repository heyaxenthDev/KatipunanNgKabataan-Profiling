<?php 
    include 'authentication.php';
    checkLogin(); // Call the function to check if the user is logged in
    include "includes/conn.php";
    include "includes/header.php";
    include "includes/sidebar.php";
    include "alert.php";


?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Unregistered Youth</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card pt-3">
                    <div class="card-body">
                        <!-- Registered Youth -->
                        <?php
                        if (isset($_GET['Code'])) {
                            $code = $_GET['Code'];
                            $acc_type = "unregistered";
                            $stmt = $conn->prepare("SELECT * FROM registered WHERE brgyCode = ? AND acc_type = ?");
                            $stmt->bind_param("ss", $code, $acc_type);
                            $stmt->execute();
                            $result = $stmt->get_result();
                        ?>

                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Registration #</th>
                                    <th><b>Name</b></th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Youth Class</th>
                                    <th>Purok/Street</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?=$row['regCode'] ?></td>
                                    <td><?=htmlspecialchars($row['first_name'] . " " . $row['last_name']) ?></td>
                                    <td><?=htmlspecialchars($row['age']) ?></td>
                                    <td><?=($row['gender'] == 0 ? "Male" : "Female") ?></td>
                                    <td><?=htmlspecialchars($row['youth_classification']) ?></td>
                                    <td><?=htmlspecialchars($row['street']) ?></td>
                                    <td>
                                        <button class="btn btn-success btn-sm view-details" data-id="<?=$row['id']?>"><i
                                                class="bi bi-eye"></i>
                                            View</button>
                                        <button class='btn btn-primary btn-sm' type='button'><i
                                                class='bi bi-pencil-square'></i></button>
                                        <button class='btn btn-secondary btn-sm' onclick="printForm('printableCard')"
                                            type='button'><i class='bi bi-printer'></i></button>
                                    </td>

                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <?php
                            $stmt->close();
                        } else {
                            echo "<p class='text-warning'>No code specified in the URL.</p>";
                        }
                        mysqli_close($conn);
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="viewYouthModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="viewYouthModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewYouthModalLabel">Youth Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <label class="form-label fw-semibold">Name of Respondent</label>

                        <div class="col-md-8">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm" id="viewLastName"
                                    name="lastName" required>
                                <label for="viewLastName">Last Name</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="text" class="form-control form-control-sm" id="viewFirstName"
                                    name="firstName" placeholder="First Name" required>
                                <label for="viewFirstName">First Name</label>
                            </div>

                            <div class="form-floating">
                                <input type="text" class="form-control form-control-sm" id="viewMiddleName"
                                    name="middleName" placeholder="Middle Name" required>
                                <label for="viewMiddleName">Middle Name</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <img src="" id="viewPicture" class="img-fluid" alt="">
                        </div>

                        <label class="form-label fw-semibold">Location</label>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control form-control-sm" id="viewStreet" name="street"
                                    placeholder="Street" required>
                                <label for="viewStreet">Street</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control form-control-sm" id="viewRegion" name="Region"
                                    readonly>
                                <label for="viewRegion">Region</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control form-control-sm" id="viewProvince"
                                    name="Province" readonly>
                                <label for="viewProvince">Province</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control form-control-sm" id="viewMunicipality"
                                    name="Municipality" readonly>
                                <label for="viewMunicipality">City/Municipality</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="viewBarangay" name="Barangay" readonly>
                                <label for="viewBarangay">Barangay</label>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="viewZip" name="inputZip" readonly>
                                <label for="viewZip">Zip</label>
                            </div>
                        </div>

                        <label class="form-label fw-semibold">Personal Information</label>

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
                                <input type="date" class="form-control" id="viewBirthdate" name="inputBirthdate"
                                    placeholder="Birthdate" required>
                                <label for="viewBirthdate">Birthdate</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="viewAge" name="inputAge" placeholder="Age"
                                    readonly>
                                <label for="viewAge">Age</label>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="text" id="viewCivilStatus" name="inputCivilStatus" class="form-control"
                                    placeholder="Enter Civil Status" required>
                                <label for="viewCivilStatus">Civil Status</label>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="viewEmail" name="inputEmail"
                                    placeholder="name@example.com" required>
                                <label for="viewEmail">Email Address</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-floating">
                                <input type="tel" class="form-control" id="viewContact" name="inputContact"
                                    placeholder="09123456789" required>
                                <label for="viewContact">Contact Number</label>
                            </div>
                        </div>

                        <label class="form-label fw-semibold">Classification</label>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" id="viewYouthAgeGroup" name="inputYouthAgeGroup" class="form-control"
                                    list="youthAgeGroupList" placeholder="Enter Youth Age Group" required>
                                <label for="viewYouthAgeGroup">Youth Age Group</label>
                                <datalist id="youthAgeGroupList">
                                    <option value="Unregistered Youth (below 15 years old)">
                                    <option value="Child Youth (15-17 years old)">
                                    <option value="Core Youth (18-24 years old)">
                                    <option value="Young Adult (25-30 years old)">
                                </datalist>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" id="viewYouthClassification" name="inputYouthClassification"
                                    class="form-control" list="youthClassificationList"
                                    placeholder="Enter Youth Classification" required>
                                <label for="viewYouthClassification">Youth Classification</label>
                                <datalist id="youthClassificationList">
                                    <option value="In School">
                                    <option value="Out of School Youth">
                                    <option value="Working Youth">
                                    <option value="Youth with Special Needs">
                                    <option value="Person with Disability">
                                    <option value="Children in conflict with Law">
                                    <option value="Indigenous People">
                                </datalist>
                            </div>
                        </div>



                        <label class="form-label fw-semibold">Educational Background</label>

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
                                        <label class="form-check-label" for="elementaryGraduate">Elementary
                                            Graduate</label>
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
                                        <label class="form-check-label" for="doctorateGraduate">Doctorate
                                            Graduate</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Work Status Section -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Work Status</label>
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
                                        <input class="form-check-input" type="radio" name="workStatus"
                                            id="currentlyLooking" value="Currently looking for a job">
                                        <label class="form-check-label" for="currentlyLooking">Currently looking for a
                                            job</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="workStatus"
                                            id="notInterested" value="Not interested in looking for a job">
                                        <label class="form-check-label" for="notInterested">Not interested in looking
                                            for a
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
                            <label class="form-label fw-semibold">Voter's Registration</label>
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
                            <label class=" form-label fw-semibold">Assembly
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
                                        <input class="form-check-input" type="radio" name="kkAssembly" id="kkAssemblyNo"
                                            value="No">
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
                            <label class=" form-label fw-semibold">Did you vote last SK
                                Election?</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="vote" id="voteYes"
                                            value="Yes" required>
                                        <label class="form-check-label" for="voteYes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="vote" id="voteNo" value="No">
                                        <label class="form-check-label" for="voteNo">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Understood</button>
                    </div>
                </div>
            </div>
        </div>


        <script src="assets/js/details.js"></script>
    </section>

    <?php // include "print-form.php" ?>

    <script>
    function printForm() {
        window.print();
    }
    </script>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>