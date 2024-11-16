<?php 
include 'authentication.php';
checkLogin();
include "includes/conn.php";
include "includes/header.php";
include "includes/sidebar.php";
include "alert.php";
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Registered Youth</h1>
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
                            $stmt = $conn->prepare("SELECT * FROM registered WHERE brgyCode = ?");
                            $stmt->bind_param("s", $code);
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
                                        <button class='btn btn-success btn-sm' type='button'><i
                                                class='bi bi-eye'></i></button>
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
    </section>

    <?php // include "print-form.php" ?>

    <script>
    function printForm() {
        window.print();
    }
    </script>
</main><!-- End #main -->

<?php include "includes/footer.php"; ?>