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
            <div class="card-body">

                <div>
                    <div class="d-flex justify-content-between pt-5 px-5">
                        <img class="img-fluid p-5 mx-5" style="height: 240px;" src="assets/img/sebaste-logo-1x1.png"
                            alt="">

                        <div class="text-center pt-5">
                            <h5 class="">Republic of the Philippines</h5>
                            <h5 class="">Province of Antique</h5>
                            <h5 class="fw-bold">MUNICIPALITY OF SEBASTE</h5>
                        </div>

                        <div class="col-md-3 p-5 mx-5">
                            <img src="assets/img/user-profile.png" id="userImage"
                                class="img-fluid rounded float-end img-thumbnail mb-3" alt="User Image">
                            <input type="file" class="form-control" id="userImageInput" name="userImage"
                                accept="image/*">
                        </div>
                    </div>
                </div>

                <script src="assets/js/load-img.js"></script>

                <!-- Multi Columns Form -->
                <form class="row g-3">
                    <label for="YourName" class="form-label fw-semibold">Name of Respondent</label>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingLastName" placeholder="Last Name">
                            <label for="floatingLastName">Last Name</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingFirstName" placeholder="First Name">
                            <label for="floatingFirstName">First Name</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="floatingMiddleName" placeholder="Middle Name">
                            <label for="floatingMiddleName">Middle Name</label>
                        </div>
                    </div>

                    <label for="Location" class="form-label fw-semibold">Location</label>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="Street" placeholder="Street">
                            <label for="Street">Street</label>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-floating">
                            <select id="inputRegion" class="form-select" aria-label="Region">
                                <option selected>Choose Region...</option>
                                <option>Region 1</option>
                                <option>Region 2</option>
                                <option>Region 3</option>
                                <!-- Add more regions as needed -->
                            </select>
                            <label for="inputRegion">Region</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <select id="inputProvince" class="form-select" aria-label="Province">
                                <option selected>Choose Province...</option>
                                <option>Province 1</option>
                                <option>Province 2</option>
                                <option>Province 3</option>
                                <!-- Add more provinces as needed -->
                            </select>
                            <label for="inputProvince">Province</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <select id="inputMunicipality" class="form-select" aria-label="Municipality">
                                <option selected>Choose Municipality...</option>
                                <option>Municipality 1</option>
                                <option>Municipality 2</option>
                                <option>Municipality 3</option>
                                <!-- Add more municipalities as needed -->
                            </select>
                            <label for="inputMunicipality">Municipality</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <select id="inputBarangay" class="form-select" aria-label="Barangay">
                                <option selected>Choose Barangay...</option>
                                <option>Barangay 1</option>
                                <option>Barangay 2</option>
                                <option>Barangay 3</option>
                                <!-- Add more barangays as needed -->
                            </select>
                            <label for="inputBarangay">Barangay</label>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputZip" placeholder=" ">
                            <label for="inputZip">Zip</label>
                        </div>
                    </div>

                    <label for="PersonalInformation" class="form-label fw-semibold">Personal Information</label>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <select id="inputGender" class="form-select" aria-label="Gender">
                                <option selected>Choose Gender...</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                            </select>
                            <label for="inputGender">Gender</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="inputAge" placeholder="Age">
                            <label for="inputAge">Age</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="inputBirthdate" placeholder="Birthdate">
                            <label for="inputBirthdate">Birthdate</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <select id="inputCivilStatus" class="form-select" aria-label="Civil Status">
                                <option selected>Choose Civil Status...</option>
                                <option>Single</option>
                                <option>Married</option>
                                <option>Divorced</option>
                                <option>Widowed</option>
                            </select>
                            <label for="inputCivilStatus">Civil Status</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="inputEmail" placeholder="name@example.com">
                            <label for="inputEmail">Email Address</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating">
                            <input type="tel" class="form-control" id="inputContact" placeholder="09123456789">
                            <label for="inputContact">Contact Number</label>
                        </div>
                    </div>

                    <label for="Classification" class="form-label fw-semibold">Classification</label>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <select id="inputYouthAgeGroup" class="form-select" aria-label="Youth Age Group">
                                <option selected>Choose Youth Age Group...</option>
                                <option>Child Youth <small>(15-17 years old)</small></option>
                                <option>Core Youth <small>(18-24 years old)</small></option>
                                <option>Young Adult <small>(25-30 years old)</small></option>
                            </select>
                            <label for="inputYouthAgeGroup">Youth Age Group</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating">
                            <select id="inputYouthClassification" class="form-select" aria-label="Youth Classification">
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

                    <div class="text-center pt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- End Multi Columns Form -->

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>