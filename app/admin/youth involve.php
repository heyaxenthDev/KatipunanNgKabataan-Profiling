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
        <!-- New Card -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Youth Programs List</h5>

                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Program</th>
                                <th>Gender</th>
                                <th>Age Category</th>
                                <th>Youth Classification</th>
                                <th>Committee</th>
                                <th>Venue</th>
                                <th>Budget</th>
                                <th>Needs</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch youth programs for this barangay
                            $query = "SELECT * FROM youth_programs ORDER BY id DESC";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['programs']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['for_gender']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['age_category']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['youth_classification']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['committee_assigned']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['venue']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['budget']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['needs']) . "</td>";
                                echo "<td>
                                        <button class='btn btn-primary btn-sm view-details' data-id='" . $row['id'] . "'>
                                            <i class='bi bi-eye'></i>
                                        </button>
                                        <button class='btn btn-info btn-sm feedback-program' data-id='" . $row['id'] . "'>
                                            <i class='bi bi-chat-dots'></i>
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
    <div class="modal fade" id="viewProgramModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
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
                                    <select class="form-select" id="feedbackType" name="feedbackType" required>
                                        <option value="">Select feedback type...</option>
                                        <option value="suggestion">Suggestion</option>
                                        <option value="improvement">Area for Improvement</option>
                                        <option value="praise">Praise</option>
                                        <option value="concern">Concern</option>
                                    </select>
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

    // Handle feedback button clicks
    document.querySelectorAll('.feedback-program').forEach(button => {
        button.addEventListener('click', function() {
            const programId = this.getAttribute('data-id');
            document.getElementById('programId').value = programId;

            // Fetch feedback history
            fetch('get_feedback_history.php?id=' + programId)
                .then(response => response.json())
                .then(data => {
                    const feedbackHistory = document.querySelector('.feedback-history');
                    feedbackHistory.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(feedback => {
                            const date = new Date(feedback.created_at)
                                .toLocaleString('en-US', {
                                    month: 'short',
                                    day: 'numeric',
                                    year: 'numeric',
                                    hour: 'numeric',
                                    minute: 'numeric',
                                    hour12: true
                                });

                            const feedbackItem = document.createElement('div');
                            feedbackItem.className =
                                'feedback-item mb-3 p-2 border-bottom';
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
                        feedbackHistory.innerHTML =
                            '<p class="text-muted">No feedback history available.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            new bootstrap.Modal(document.getElementById('feedbackProgramModal')).show();
        });
    });

});
</script>