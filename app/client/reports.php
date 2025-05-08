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
        <h1>Reports Generation</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Select the type of data you want to generate</h4>

                <div class="d-flex justify-content-between gap-3">

                    <!-- Select for type of data -->
                    <select name="type" id="type" class="form-select">
                        <option value="">Select Type</option>
                        <option value="registered">Registered</option>
                        <option value="unregistered">Unregistered</option>
                        <option value="activities_program">Activities Program</option>
                    </select>

                    <!-- Select for Category -->
                    <select name="category" id="category" class="form-select">
                        <option value="">Select Category</option>
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                        <option value="indeginous_people">Indeginous People</option>
                        <option value="pwd">PWD</option>
                    </select>

                    <!-- Select for purok/street -->
                    <select name="purok" id="purok" class="form-select">
                        <option value="">Select Purok/Street</option>
                        <?php
                            $brgyCode = $_GET['Code'] ?? '';
                            // Get the list of available purok/street from the database
                            $stmt = $conn->prepare("SELECT DISTINCT street FROM registered WHERE brgyCode = ?");
                            $stmt->bind_param("s", $brgyCode);
                            $stmt->execute();
                            $getStreet = $stmt->get_result();

                            if ($getStreet->num_rows > 0) {
                                while ($row = $getStreet->fetch_assoc()){
                                    echo '<option value="' . htmlspecialchars($row['street']) . '">' . htmlspecialchars($row['street']) . '</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <div id="report-table" class="mt-4"></div>
    <button id="print-btn" class="btn btn-primary mt-3" style="display:none;">Print</button>

</main><!-- End #main -->

<!-- Make sure this is included! -->
<script src="assets/js/reports.js"></script>

<?php 
include "includes/footer.php";
?>