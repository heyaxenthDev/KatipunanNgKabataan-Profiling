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
        <h1>Different Aspect that the Youth Involve</h1>
    </div><!-- End Page Title -->
    <section class="section">

        <div class="card">
            <form class="card-body" action="#" method="POST" enctype="multipart/form-data">

                <h5 class="card-title">Youth Program Form</h5>

                <input type="hidden" name="brgyCode" id="brgyCode" value="<?=$_GET['Code']?>">

                <div class="row">
                    <!-- Left Side Column -->
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Date of Submission: </label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" id="inputText" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="programs" class="col-sm-4 col-form-label">Programs: </label>
                            <div class="col-sm-8">
                                <select class="form-select" id="programs" name="programs" required>
                                    <option selected>-- Select Program --</option>
                                    <option value="sports">Sports</option>
                                    <option value="education">Education</option>
                                    <option value="health_environment">Health Environment</option>
                                    <option value="feeding">Feeding</option>
                                    <option value="tree_planting">Tree Planting</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="types" class="col-sm-4 col-form-label">Types: </label>
                            <div class="col-sm-8">
                                <select class="form-select" id="types" name="types" required>
                                    <option selected>-- Select Type --</option>
                                </select>
                            </div>
                        </div>

                        <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            // Types data mapped by program
                            const typesData = {
                                sports: [{
                                        value: "basketball",
                                        text: "Basketball"
                                    },
                                    {
                                        value: "volleyball",
                                        text: "Volleyball"
                                    },
                                    {
                                        value: "tournament_playing",
                                        text: "Tournament Playing"
                                    },
                                    {
                                        value: "mobile_legend",
                                        text: "Mobile Legend"
                                    }
                                ],
                                education: [{
                                        value: "free_printing",
                                        text: "Free Printing"
                                    },
                                    {
                                        value: "library_hub",
                                        text: "Library Hub"
                                    },
                                    {
                                        value: "distribution_school_supplies",
                                        text: "Distribution of School Supplies"
                                    }
                                ],
                                health_environment: [{
                                    value: "health_environment",
                                    text: "Health Environment"
                                }],
                                feeding: [{
                                    value: "malnourish_low_weight",
                                    text: "Malnourish/Low Weight"
                                }],
                                tree_planting: [{
                                    value: "tree_planting",
                                    text: "Tree Planting"
                                }]
                            };

                            // References to DOM elements
                            const programsSelect = document.getElementById("programs");
                            const typesSelect = document.getElementById("types");

                            // Update types dropdown based on selected program
                            programsSelect.addEventListener("change", function() {
                                const selectedProgram = this.value;

                                // Clear current types options
                                typesSelect.innerHTML = "<option selected>-- Select Type --</option>";

                                // Populate new options based on the selected program
                                if (selectedProgram && typesData[selectedProgram]) {
                                    typesData[selectedProgram].forEach(type => {
                                        const option = document.createElement("option");
                                        option.value = type.value;
                                        option.textContent = type.text;
                                        typesSelect.appendChild(option);
                                    });
                                }
                            });
                        });
                        </script>


                        <div class="row mb-3">
                            <label for="forCategory" class="col-sm-4 col-form-label">For: </label>
                            <div class="col-sm-8">
                                <select class="form-select" id="forCategory" name="forCategory" required>
                                    <option selected>-- Select For --</option>
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>
                                    <option value="intermediate">Intermediate</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="ageCategory" class="col-sm-4 col-form-label">Age: </label>
                            <div class="col-sm-8">
                                <select class="form-select" id="ageCategory" name="ageCategory" required>
                                    <option selected>-- Select Age Category --</option>
                                    <option value="15-30">15-30</option>
                                </select>
                            </div>
                        </div>


                    </div>
                    <!-- End Left Side Column -->

                    <!-- Right Side Column -->
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label for="youthClassification" class="col-sm-4 col-form-label">Youth Classification:
                            </label>
                            <div class="col-sm-8">
                                <select class="form-select" id="youthClassification">
                                    <option selected>-- Select Youth Class --</option>
                                    <option value="Child Youth">Child Youth</option>
                                    <option value="Core Youth">Core Youth</option>
                                    <option value="Young Adult">Young Adult</option>
                                </select>
                            </div>
                        </div>

                        <?php 
                        // Get Available Officials per barangay record
                        $code = $_GET['Code'];

                        // Query to fetch SK officials based on barangay code
                        $sql = "SELECT * FROM sk_officials WHERE brgy_code = '$code'";
                        $sql_run = mysqli_query($conn, $sql);
                        ?>

                        <div class="row mb-3">
                            <label for="committeeAssigned" class="col-sm-4 col-form-label">Committee Assigned: </label>
                            <div class="col-sm-8">
                                <select class="form-select" id="committeeAssigned" name="committeeAssigned" required>
                                    <option selected>-- Select Committee Assigned --</option>
                                    <?php 
                                    // Check if any results were returned
                                    if (mysqli_num_rows($sql_run) > 0) {
                                        // Loop through each official and add as an option
                                        while ($row = mysqli_fetch_assoc($sql_run)) {
                                            echo "<option value='" . $row['firstname'] . " " . $row['lastname'] . "'>" . $row['firstname'] . " " . $row['lastname'] . " <small>(". $row['position'].")</small></option>";
                                        }
                                    } else {
                                        echo "<option disabled>No officials available</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>




                        <div class="row mb-3">
                            <label for="venue" class="col-sm-4 col-form-label">Venue: </label>
                            <div class="col-sm-8">
                                <select class="form-select" id="venue" name="venue" required>
                                    <option selected>-- Select Venue --</option>
                                    <option value="Poblacion Sebaste Gym">Poblacion Sebaste Gym</option>
                                    <option value="Brgy. Alegre Cover Court">Brgy. Alegre Cover Court</option>
                                    <option value="Brgy. Aras-Asan Cover Court">Brgy. Aras-Asan Cover Court</option>
                                    <option value="Brgy. Bacalan Cover Court">Brgy. Bacalan Cover Court</option>
                                    <option value="Brgy. Agela Cover Court">Brgy. Agela Cover Court</option>
                                    <option value="Brgy. Callian Cover Court">Brgy. Callian Cover Court</option>
                                    <option value="Brgy. Idio Cover Court">Brgy. Idio Cover Court</option>
                                    <option value="Brgy. Pjavier Cover Court">Brgy. Pjavier Cover Court</option>
                                    <option value="Brgy. Nauhon Cover Court">Brgy. Nauhon Cover Court</option>
                                    <option value="Brgy. Abiera Cover Court">Brgy. Abiera Cover Court</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Budget:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputText" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Needs:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="inputText" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="attachment" class="col-sm-4 col-form-label">Attachment: </label>
                            <div class="col-sm-8">
                                <select class="form-select" id="attachment" name="attachment" required
                                    onchange="showUploadInput()">
                                    <option selected>-- Select Attachment Type --</option>
                                    <option value="CBYDP">CBYDP</option>
                                    <option value="ABYIP">ABYIP</option>
                                    <option value="Documents">Documents</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3" id="uploadInput" style="display: none;">
                            <label for="fileUpload" class="col-sm-4 col-form-label">Upload Attachment: </label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" id="fileUpload" name="fileUpload" required>
                            </div>
                        </div>

                        <script>
                        function showUploadInput() {
                            const attachmentType = document.getElementById("attachment").value;
                            const uploadInput = document.getElementById("uploadInput");

                            if (attachmentType === "CBYDP" || attachmentType === "ABYIP" || attachmentType ===
                                "Documents") {
                                uploadInput.style.display = "flex";
                            } else {
                                uploadInput.style.display = "none";
                            }
                        }
                        </script>



                    </div>
                    <!-- End Right Side Column -->
                </div>
                <div class="text-end pt-3">
                    <button type="submit" class="btn btn-primary" name="YouthInvolve">Submit</button>
                    <button type="reset" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </section>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>