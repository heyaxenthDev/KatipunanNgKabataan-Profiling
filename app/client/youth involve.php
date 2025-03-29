<?php 
    include 'authentication.php';
    checkLogin(); // Call the function to check if the user is logged in
    include "includes/conn.php";
    include "includes/header.php";
    include "includes/sidebar.php";
    include "alert.php";

// Fetch the dominant classification, gender, and age group from the database
$query = "SELECT 
            (SELECT youth_classification FROM registered GROUP BY youth_classification ORDER BY COUNT(*) DESC LIMIT 1) AS dominant_classification,
            (SELECT gender FROM registered GROUP BY gender ORDER BY COUNT(*) DESC LIMIT 1) AS dominant_gender,
            (SELECT youth_age_group FROM registered GROUP BY youth_age_group ORDER BY COUNT(*) DESC LIMIT 1) AS dominant_age_group";
            
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Assign fetched data to variables
$dominant_classification = $row['dominant_classification'];
$dominant_gender = $row['dominant_gender'];
$dominant_age_group = $row['dominant_age_group'];

// Decision logic for suggested program
$suggested_program = "";

if ($dominant_classification == "In School") {
    $suggested_program = "Library Hub, School Supplies Distribution, Tutorial Programs";
} elseif ($dominant_classification == "Out of School Youth") {
    $suggested_program = "Alternative Learning System (ALS), Vocational Training, Job Assistance";
} elseif ($dominant_classification == "Working Youth") {
    $suggested_program = "Job Fairs, Skills Training, Entrepreneurship Workshops";
} elseif ($dominant_classification == "Youth with Special Needs") {
    $suggested_program = "Inclusive Education, Disability Support Programs";
} elseif ($dominant_classification == "Person with Disability") {
    $suggested_program = "PWD Support Programs, Skills Development";
} elseif ($dominant_classification == "Children in conflict with Law") {
    $suggested_program = "Rehabilitation Programs, Legal Assistance";
} elseif ($dominant_classification == "Indigenous People") {
    $suggested_program = "Cultural Preservation Programs, Livelihood Assistance";
}

// Additional logic based on gender and age
if ($dominant_gender == "Male" && ($dominant_age_group == "15-20" || $dominant_age_group == "21-25" || $dominant_age_group == "26-30")) {
    $suggested_program .= ", Basketball Tournament (Sports)";
} elseif ($dominant_gender == "Female" && ($dominant_age_group == "15-20" || $dominant_age_group == "21-25" || $dominant_age_group == "26-30")) {
    $suggested_program .= ", Volleyball Tournament (Sports)";
}
?>

<main id="main" class="main">
    <div class="pagetitle pb-3">
        <h1>Different Aspect that the Youth Involve</h1>
    </div><!-- End Page Title -->
    <section class="section">

        <div class="card">

            <form class="card-body" action="#" method="POST" enctype="multipart/form-data">

                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    function updateSuggestedProgram() {
                        let youthClass = document.getElementById("youthClassification").value;
                        let gender = document.getElementById("forCategory").value;
                        let age = document.getElementById("ageCategory").value;
                        let suggestedProgram = "";

                        // Decision Logic
                        if (youthClass === "In School") {
                            suggestedProgram = "Library Hub, School Supplies Distribution, Tutorial Programs";
                        } else if (youthClass === "Out of School Youth") {
                            suggestedProgram =
                                "Alternative Learning System (ALS), Vocational Training, Job Assistance";
                        } else if (youthClass === "Working Youth") {
                            suggestedProgram = "Job Fairs, Skills Training, Entrepreneurship Workshops";
                        } else if (youthClass === "Youth with Special Needs") {
                            suggestedProgram = "Inclusive Education, Disability Support Programs";
                        } else if (youthClass === "Person with Disability") {
                            suggestedProgram = "PWD Support Programs, Skills Development";
                        } else if (youthClass === "Children in conflict with Law") {
                            suggestedProgram = "Rehabilitation Programs, Legal Assistance";
                        } else if (youthClass === "Indigenous People") {
                            suggestedProgram = "Cultural Preservation Programs, Livelihood Assistance";
                        }

                        // Additional logic based on gender and age
                        if (gender === "Male" && (age === "15-20" || age === "21-25" || age === "26-30")) {
                            suggestedProgram += ", Basketball Tournament (Sports)";
                        } else if (gender === "Female" && (age === "15-20" || age === "21-25" || age ===
                                "26-30")) {
                            suggestedProgram += ", Volleyball Tournament (Sports)";
                        }

                        document.getElementById("suggestedProgram").value = suggestedProgram;
                    }

                    document.getElementById("youthClassification").addEventListener("change",
                        updateSuggestedProgram);
                    document.getElementById("forCategory").addEventListener("change", updateSuggestedProgram);
                    document.getElementById("ageCategory").addEventListener("change", updateSuggestedProgram);
                });
                </script>

                <h5 class="card-title">Decision-Making Data Form</h5>

                <input type="hidden" name="brgyCode" id="brgyCode" value="<?=$_GET['Code']?>">

                <div class="row">
                    <!-- Left Side Column -->
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Date of Submission:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="<?= date('F d, Y') ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Dominant Youth Classification:</label>
                            <div class="col-sm-8">
                                <select class="form-select" id="youthClassification" name="youthClassification"
                                    required>
                                    <option value="">-- Select Classification --</option>
                                    <option value="In School">In School</option>
                                    <option value="Out of School Youth">Out of School Youth</option>
                                    <option value="Working Youth">Working Youth</option>
                                    <option value="Youth with Special Needs">Youth with Special Needs</option>
                                    <option value="Person with Disability">Person with Disability</option>
                                    <option value="Children in conflict with Law">Children in conflict with Law
                                    </option>
                                    <option value="Indigenous People">Indigenous People</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Dominant Gender:</label>
                            <div class="col-sm-8">
                                <select class="form-select" id="dominantGender" name="dominantGender" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Dominant Age Group:</label>
                            <div class="col-sm-8">
                                <select class="form-select" id="ageCategory" name="ageCategory" required>
                                    <option value="">-- Select Age Group --</option>
                                    <option value="15-20">15-20</option>
                                    <option value="21-25">21-25</option>
                                    <option value="26-30">26-30</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side Column -->
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Suggested Program:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="suggestedProgram" name="suggestedProgram"
                                    readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Venue:</label>
                            <div class="col-sm-8">
                                <select class="form-select" id="venue" name="venue" required>
                                    <option value="">-- Select Venue --</option>
                                    <option value="Poblacion Sebaste Gym">Poblacion Sebaste Gym</option>
                                    <option value="Brgy. Alegre Cover Court">Brgy. Alegre Cover Court</option>
                                    <option value="Brgy. Aras-Asan Cover Court">Brgy. Aras-Asan Cover Court</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Budget:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="budget" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Needs:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="needs" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end pt-3">
                    <button type="submit" class="btn btn-primary" name="generateDecision">Generate Decision</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>

        </div>
    </section>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>