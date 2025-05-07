<?php 
    include 'authentication.php';
    checkLogin(); // Call the function to check if the user is logged in
    include "includes/conn.php";
    include "includes/header.php";
    include "includes/sidebar.php";
    include "alert.php";


?>

<main id="main" class="main">

    <section class="section">
        <div class="card">
            <div class="d-flex justify-content-between">

                <!-- Select for type of data -->
                <select name="type" id="type" class="form-select">
                    <option value="registered">Registered</option>
                    <option value="unregistered">Unregistered</option>
                    <option value="activities_program">Activities Program</option>
                </select>

                <!-- Select for Category -->
                <select name="category" id="category" class="form-select">
                    <option value="female">Female</option>
                    <option value="make">Male</option>
                    <option value="indeginous_people">Indeginous People</option>
                    <option value="pwd">PWD</option>
                </select>

                <!-- Select for purok/street -->
                <select name="purok" id="purok" class="form-select">
                    <?php

                    $brgyCode = $_GET['Code'];

                    // Get the list of available purok/street from the database
                    $stmt = $conn->prepare("SELECT DISTINCT street FROM registered WHERE brgyCode = ?");
                    $stmt->bind_param("s", $brgyCode);
                    $stmt->execute();
                    $getStreet = $stmt->get_result();

                    if ($getStreet->num_rows > 0) {
                        while ($row = $getStreet->fetch_assoc()){
                    ?>

                    <option value="<?= $row['street']?>"><?= $row['street']?></option>

                    <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>