<?php 
include 'authentication.php';
checkLogin();
include "includes/conn.php";
include "includes/header.php";
include "includes/sidebar.php";
include "alert.php";

$brgyCode = $_GET['Code'] ?? '';

$stmt = $conn->prepare("SELECT * FROM `barangay` WHERE barangay_code = ?");
$stmt->bind_param("s", $brgyCode);
$stmt->execute();
$result = $stmt->get_result();
$getBrgy = $result->fetch_assoc();
$brgyName = $getBrgy['barangay_name'];
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
                            $acc_type = "registered";
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
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success btn-sm view-details"
                                                data-id="<?=$row['id']?>">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm edit-details"
                                                data-edit-id="<?=$row['id']?>">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm delete-youth"
                                                data-delete-id="<?=$row['id']?>">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </div>
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

        <?php 
        include "modal/viewModal.php";
        include "modal/editModal.php";
        ?>



        <script src="assets/js/details.js"></script>
        <script src="assets/js/edit.js"></script>
        <!-- <script src="assets/js/print.js"></script> -->

    </section>


</main><!-- End #main -->

<?php include "includes/footer.php"; ?>