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

            <form class="card-body" action="decision_process.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="brgyCode" id="brgyCode" value="<?= $_GET['Code'] ?>">

                <script src="assets/js/suggested_programs.js"></script>

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
                            <label class="col-sm-4 col-form-label">
                                Dominant Youth Classification:
                                <!-- <span id="labelClassification" class="badge bg-info text-dark ms-2"></span> -->
                            </label>

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
                            <label class="col-sm-4 col-form-label">
                                Dominant Gender:
                                <!-- <span id="labelGender" class="badge bg-info text-dark ms-2"></span> -->
                            </label>

                            <div class="col-sm-8">
                                <select class="form-select" id="dominantGender" name="dominantGender" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">
                                Dominant Age Group:
                                <!-- <span id="labelAge" class="badge bg-info text-dark ms-2"></span> -->
                            </label>

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
                                <select class="form-select" id="suggestedProgram" name="suggestedProgram" required>
                                    <option value="">-- Select Program --</option>
                                    <option value="SPORTS">Sports</option>
                                    <option value="EDUCATION">Education</option>
                                    <option value="HEALTH ENVIRONMENT">Health Environment</option>
                                    <option value="FEEDING">Feeding</option>
                                    <option value="TREE PLANTING">Tree Planting</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Types:</label>
                            <div class="col-sm-8">
                                <select class="form-select" id="types" name="types" required>
                                    <option value="">-- Select Type --</option>
                                </select>
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

                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label">Committee Assigned:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="committee_assigned" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end pt-3">
                    <button type="submit" class="btn btn-primary" name="generateDecision">Generate Decision</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
            </form>


            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
            // Wait for the DOM to be fully loaded before executing any code
            $(document).ready(function() {
                // Get the barangay code from the hidden input field
                const brgyCode = $("#brgyCode").val();

                // Make an AJAX call to fetch dominant information for the selected barangay
                $.ajax({
                    url: "fetch_dominant.php",
                    method: "GET",
                    data: {
                        brgyCode: brgyCode
                    },
                    dataType: 'json', // Explicitly specify that we expect JSON
                    success: function(data) {
                        try {
                            if (data.success) {
                                // If successful, populate the form fields with the fetched data
                                // Using trigger('change') to ensure any dependent fields are updated
                                $("#youthClassification").val(data.classification).trigger(
                                    "change");
                                $("#dominantGender").val(data.gender).trigger("change");
                                $("#ageCategory").val(data.age).trigger("change");

                                // Update the badge labels to show the dominant values
                                $("#labelClassification").text(data.classification);
                                $("#labelGender").text(data.gender);
                                $("#labelAge").text(data.age);

                                // Auto-select suggested program and type
                                autoSelectSuggestedProgramAndType({
                                    classification: data.classification,
                                    gender: data.gender,
                                    age: data.age
                                });
                            } else {
                                // Log server error to console for debugging
                                console.error("Server returned error:", data.message);
                                // Show user-friendly error message
                                alert("Failed to fetch dominant info: " + (data.message ||
                                    "Unknown error"));
                            }
                        } catch (error) {
                            // Handle any JSON parsing or data processing errors
                            console.error("Error processing response:", error);
                            alert("Error processing server response");
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX request failures (network errors, etc.)
                        console.error("AJAX error:", status, error);
                        // Check if the response contains HTML error message
                        if (xhr.responseText && xhr.responseText.includes("<br />")) {
                            alert("Server error occurred. Please check the server logs.");
                        } else {
                            alert("Error fetching data: " + error);
                        }
                    }
                });
            });

            document.addEventListener("DOMContentLoaded", function() {
                const programTypes = {
                    "SPORTS": [
                        "BASKETBALL",
                        "VOLLEYBALL",
                        "TOURNAMENT PLAYING MOBILE LEGEND"
                    ],
                    "EDUCATION": [
                        "FREE PRINTING",
                        "LIBRARY HUB",
                        "DISTRIBUTION OF SCHOOL SUPPLIES"
                    ],
                    "HEALTH ENVIRONMENT": [
                        "HEALTH ENVIRONMENT"
                    ],
                    "FEEDING": [
                        "MALNOURISH/LOW WEIGHT"
                    ],
                    "TREE PLANTING": [
                        "TREE PLANTING"
                    ]
                };
                const suggestedProgram = document.getElementById("suggestedProgram");
                const types = document.getElementById("types");
                suggestedProgram.addEventListener("change", function() {
                    types.innerHTML = '<option value="">-- Select Type --</option>';
                    const selected = this.value;
                    if (programTypes[selected]) {
                        programTypes[selected].forEach(function(type) {
                            const opt = document.createElement("option");
                            opt.value = type;
                            opt.textContent = type;
                            types.appendChild(opt);
                        });
                    }
                });
            });
            </script>


        </div>

        <!-- New Card -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Youth Programs List</h5>

                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Program</th>
                                <th>Type</th>
                                <th>Gender</th>
                                <th>Age Category</th>
                                <th>Youth Classification</th>
                                <th>Committee</th>
                                <!-- <th>Venue</th> -->
                                <th>Budget</th>
                                <!-- <th>Needs</th> -->
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch youth programs for this barangay
                            $brgyCode = $_GET['Code'];
                            $query = "SELECT * FROM youth_programs WHERE brgyCode = ? ORDER BY id DESC";
                            $stmt = $conn->prepare($query);
                            $stmt->bind_param("s", $brgyCode);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['programs']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['types']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['for_gender']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['age_category']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['youth_classification']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['committee_assigned']) . "</td>";
                                // echo "<td>" . htmlspecialchars($row['venue']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['budget']) . "</td>";
                                // echo "<td>" . htmlspecialchars($row['needs']) . "</td>";
                                echo "<td>
                                        <button class='btn btn-primary btn-sm view-details' data-id='" . $row['id'] . "'>
                                            <i class='bi bi-eye'></i>
                                        </button>
                                        <button class='btn btn-info btn-sm feedback-program' data-id='" . $row['id'] . "'>
                                            <i class='bi bi-chat-dots'></i>
                                        </button>
                                        <button class='btn btn-warning btn-sm edit-program' data-id='" . $row['id'] . "'>
                                            <i class='bi bi-pencil'></i>
                                        </button>
                                        <button class='btn btn-danger btn-sm delete-program' data-id='" . $row['id'] . "'>
                                            <i class='bi bi-trash'></i>
                                        </button>
                                    </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- View Modal -->
    <div class="modal fade" id="viewProgramModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Program Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Program:</label>
                                <p id="viewProgram" class="form-control-plaintext"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Type:</label>
                                <p id="viewType" class="form-control-plaintext"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Gender:</label>
                                <p id="viewGender" class="form-control-plaintext"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Age Category:</label>
                                <p id="viewAgeCategory" class="form-control-plaintext"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Youth Classification:</label>
                                <p id="viewYouthClassification" class="form-control-plaintext"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Committee Assigned:</label>
                                <p id="viewCommittee" class="form-control-plaintext"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Venue:</label>
                                <p id="viewVenue" class="form-control-plaintext"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Budget:</label>
                                <p id="viewBudget" class="form-control-plaintext"></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Needs:</label>
                                <p id="viewNeeds" class="form-control-plaintext"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackProgramModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Program Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column - Feedback History -->
                        <div class="col-md-6 border-end">
                            <h6 class="mb-3">Feedback History</h6>
                            <div class="feedback-history" style="max-height: 400px; overflow-y: auto;">
                                <?php
                                // Fetch feedback history for this program
                                $query = "SELECT pf.*, a.firstname, a.lastname 
                                         FROM program_feedback pf 
                                         JOIN accounts a ON pf.user_id = a.id 
                                         WHERE pf.program_id = ? 
                                         ORDER BY pf.created_at DESC";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("i", $row['id']);
                                $stmt->execute();
                                $feedbackResult = $stmt->get_result();

                                if ($feedbackResult->num_rows > 0) {
                                    while ($feedback = $feedbackResult->fetch_assoc()) {
                                        $date = date('M d, Y h:i A', strtotime($feedback['created_at']));
                                        echo '<div class="feedback-item mb-3 p-2 border-bottom">';
                                        echo '<div class="d-flex justify-content-between align-items-start">';
                                        echo '<div>';
                                        echo '<strong>' . htmlspecialchars($feedback['firstname'] . ' ' . $feedback['lastname']) . '</strong>';
                                        echo '<span class="badge bg-info ms-2">' . ucfirst(htmlspecialchars($feedback['feedback_type'])) . '</span>';
                                        echo '</div>';
                                        echo '<small class="text-muted">' . $date . '</small>';
                                        echo '</div>';
                                        echo '<p class="mb-0 mt-2">' . htmlspecialchars($feedback['feedback_message']) . '</p>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo '<p class="text-muted">No feedback history available.</p>';
                                }
                                ?>
                            </div>
                        </div>

                        <!-- Right Column - Feedback Form -->
                        <div class="col-md-6">
                            <h6 class="mb-3">Submit Feedback</h6>
                            <form action="submit_feedback.php" method="POST">
                                <input type="hidden" id="programId" name="programId">
                                <div class="mb-3">
                                    <label for="feedbackType" class="form-label">Feedback Type</label>
                                    <input type="text" class="form-control" id="feedbackType" name="feedbackType"
                                        value="Feedback Response" required>
                                </div>
                                <div class="mb-3">
                                    <label for="feedbackMessage" class="form-label">Feedback Message</label>
                                    <textarea class="form-control" id="feedbackMessage" name="feedbackMessage" rows="4"
                                        required></textarea>
                                </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submitFeedback">Submit Feedback</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editProgramModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Program</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editProgramForm">
                    <div class="modal-body">
                        <input type="hidden" id="editProgramId" name="programId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editProgram" class="form-label">Program</label>
                                    <select class="form-select" id="editProgram" name="program" required>
                                        <option value="">-- Select Program --</option>
                                        <option value="SPORTS">Sports</option>
                                        <option value="EDUCATION">Education</option>
                                        <option value="HEALTH ENVIRONMENT">Health Environment</option>
                                        <option value="FEEDING">Feeding</option>
                                        <option value="TREE PLANTING">Tree Planting</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editType" class="form-label">Type</label>
                                    <select class="form-select" id="editType" name="type" required>
                                        <option value="">-- Select Type --</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editGender" class="form-label">Gender</label>
                                    <select class="form-select" id="editGender" name="gender" required>
                                        <option value="">-- Select Gender --</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editAgeCategory" class="form-label">Age Category</label>
                                    <select class="form-select" id="editAgeCategory" name="ageCategory" required>
                                        <option value="">-- Select Age Group --</option>
                                        <option value="15-20">15-20</option>
                                        <option value="21-25">21-25</option>
                                        <option value="26-30">26-30</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editYouthClassification" class="form-label">Youth Classification</label>
                                    <select class="form-select" id="editYouthClassification" name="youthClassification"
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
                                <div class="mb-3">
                                    <label for="editCommittee" class="form-label">Committee Assigned</label>
                                    <input type="text" class="form-control" id="editCommittee" name="committee"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="editVenue" class="form-label">Venue</label>
                                    <select class="form-select" id="editVenue" name="venue" required>
                                        <option value="">-- Select Venue --</option>
                                        <option value="Poblacion Sebaste Gym">Poblacion Sebaste Gym</option>
                                        <option value="Brgy. Alegre Cover Court">Brgy. Alegre Cover Court</option>
                                        <option value="Brgy. Aras-Asan Cover Court">Brgy. Aras-Asan Cover Court</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editBudget" class="form-label">Budget</label>
                                    <input type="text" class="form-control" id="editBudget" name="budget" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editNeeds" class="form-label">Needs</label>
                                    <input type="text" class="form-control" id="editNeeds" name="needs" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Handle view button clicks
    document.querySelectorAll('.view-details').forEach(button => {
        button.addEventListener('click', function() {
            const programId = this.getAttribute('data-id');

            // Fetch program details
            fetch('get_program_details.php?id=' + programId)
                .then(response => response.json())
                .then(data => {
                    // Populate modal with data
                    document.getElementById('viewProgram').textContent = data.programs;
                    document.getElementById('viewType').textContent = data.types;
                    document.getElementById('viewGender').textContent = data.for_gender;
                    document.getElementById('viewAgeCategory').textContent = data
                        .age_category;
                    document.getElementById('viewYouthClassification').textContent = data
                        .youth_classification;
                    document.getElementById('viewCommittee').textContent = data
                        .committee_assigned;
                    document.getElementById('viewVenue').textContent = data.venue;
                    document.getElementById('viewBudget').textContent = data.budget;
                    document.getElementById('viewNeeds').textContent = data.needs;

                    // Show the modal
                    new bootstrap.Modal(document.getElementById('viewProgramModal')).show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error fetching program details');
                });
        });
    });

    // Feedback loading function
    function loadFeedbackHistory(programId) {
        fetch('get_feedback_history.php?id=' + programId)
            .then(response => response.json())
            .then(data => {
                const feedbackHistory = document.querySelector('.feedback-history');
                feedbackHistory.innerHTML = '';

                if (data.length > 0) {
                    data.forEach(feedback => {
                        const date = new Date(feedback.created_at).toLocaleString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            year: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            hour12: true
                        });

                        const feedbackItem = document.createElement('div');
                        feedbackItem.className = 'feedback-item mb-3 p-2 border-bottom';
                        feedbackItem.innerHTML = `
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>${feedback.firstname} ${feedback.lastname}</strong>
                                    <span class="badge bg-info ms-2">${feedback.feedback_type.charAt(0).toUpperCase() + feedback.feedback_type.slice(1)}</span>
                                </div>
                                <small class="text-muted">${date}</small>
                            </div>
                            <p class="mb-0 mt-2">${feedback.feedback_message}</p>
                        `;
                        feedbackHistory.appendChild(feedbackItem);
                    });
                } else {
                    feedbackHistory.innerHTML = '<p class="text-muted">No feedback history available.</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Handle feedback button clicks
    document.querySelectorAll('.feedback-program').forEach(button => {
        button.addEventListener('click', function() {
            const programId = this.getAttribute('data-id');
            document.getElementById('programId').value = programId;
            loadFeedbackHistory(programId);
            new bootstrap.Modal(document.getElementById('feedbackProgramModal')).show();
        });
    });
    // Handle delete button clicks
    document.querySelectorAll('.delete-program').forEach(button => {
        button.addEventListener('click', function() {
            const programId = this.getAttribute('data-id');

            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, send delete request
                    fetch('delete_program.php?id=' + programId)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Program has been deleted.',
                                    'success'
                                ).then(() => {
                                    // Reload the page to update the table
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message || 'Something went wrong.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'Failed to delete program.',
                                'error'
                            );
                        });
                }
            });
        });
    });

    // Handle edit button clicks
    document.querySelectorAll('.edit-program').forEach(button => {
        button.addEventListener('click', function() {
            const programId = this.getAttribute('data-id');
            document.getElementById('editProgramId').value = programId;

            // Fetch program details
            fetch('get_program_details.php?id=' + programId)
                .then(response => response.json())
                .then(data => {
                    // Populate form with data
                    document.getElementById('editProgram').value = data.programs;

                    // Trigger the change event to populate the types
                    const event = new Event('change');
                    document.getElementById('editProgram').dispatchEvent(event);

                    // After a short delay, set the type value
                    setTimeout(() => {
                        document.getElementById('editType').value = data.types;
                    }, 100);

                    document.getElementById('editGender').value = data.for_gender;
                    document.getElementById('editAgeCategory').value = data.age_category;
                    document.getElementById('editYouthClassification').value = data
                        .youth_classification;
                    document.getElementById('editCommittee').value = data
                        .committee_assigned;
                    document.getElementById('editVenue').value = data.venue;
                    document.getElementById('editBudget').value = data.budget;
                    document.getElementById('editNeeds').value = data.needs;

                    // Show the modal
                    new bootstrap.Modal(document.getElementById('editProgramModal')).show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to fetch program details.',
                    });
                });
        });
    });

    // Handle edit form submission
    document.getElementById('editProgramForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('update_program.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Program updated successfully.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to update program.',
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while updating the program.',
                });
            });
    });

    // Handle program type options based on selected program
    const programTypes = {
        "SPORTS": ["BASKETBALL", "VOLLEYBALL", "TOURNAMENT PLAYING MOBILE LEGEND"],
        "EDUCATION": ["FREE PRINTING", "LIBRARY HUB", "DISTRIBUTION OF SCHOOL SUPPLIES"],
        "HEALTH ENVIRONMENT": ["HEALTH ENVIRONMENT"],
        "FEEDING": ["MALNOURISH/LOW WEIGHT"],
        "TREE PLANTING": ["TREE PLANTING"]
    };

    document.getElementById('editProgram').addEventListener('change', function() {
        const typesSelect = document.getElementById('editType');
        typesSelect.innerHTML = '<option value="">-- Select Type --</option>';

        const selected = this.value;
        if (programTypes[selected]) {
            programTypes[selected].forEach(function(type) {
                const opt = document.createElement('option');
                opt.value = type;
                opt.textContent = type;
                typesSelect.appendChild(opt);
            });
        }
    });
});
</script>