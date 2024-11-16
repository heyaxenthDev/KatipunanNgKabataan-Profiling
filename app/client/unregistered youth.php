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
                        // Get current brgy code
                        $code = $_GET['Code'];

                        // Query to fetch all registered youth
                        $sql = "SELECT * FROM unregistered WHERE brgyCode = $code";
                        $result = mysqli_query($conn, $sql);

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
                                // Check if there are any rows returned
                                if (mysqli_num_rows($result) > 0) {
                                    // Loop through each row and populate the table
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                <tr>
                                    <td><?=$row['regCode'] ?></td>
                                    <td><?=$row['first_name'] . " ". $row['last_name'] ?></td>
                                    <td><?=$row['age'] ?></td>
                                    <td><?=($row['gender']== 0 ? "Male" : "Female") ?></td>
                                    <td><?=$row['youth_classification'] ?></td>
                                    <td><?=$row['street'] ?></td>
                                    <td>
                                        <button class='btn btn-success btn-sm' type='button'><i
                                                class='bi bi-eye'></i></button>
                                        <button class='btn btn-primary btn-sm' type='button'><i
                                                class='bi bi-pencil-square'></i></button>
                                        <button class='btn btn-danger btn-sm' type='button'><i
                                                class='bi bi-trash'></i></button>
                                    </td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                        <?php
                        // Close the database connection
                        mysqli_close($conn);
                        ?>

                        <!-- End Registered Youth -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>