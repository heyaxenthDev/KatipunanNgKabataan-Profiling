<?php 
    include 'authentication.php';
    checkLogin(); // Call the function to check if the user is logged in
    include "includes/conn.php";
    include "includes/header.php";
    include "includes/sidebar.php";
    include "alert.php";


?>
<main id="main" class="main">

    <?php 
        $getName = $_GET['Name'];
        $getCode = $_GET['Code'];
    ?>

    <div class="pagetitle d-flex justify-content-between align-content-center">
        <div>
            <h1>Barangay <?=$getName?></h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="homepage">Home</a></li>
                    <li class="breadcrumb-item">Barangay</li>
                    <li class="breadcrumb-item active"><?=$getName?></li>
                </ol>
            </nav>
        </div>

        <!-- Pills Tabs -->
        <ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-registered-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-registered" type="button" role="tab" aria-controls="pills-registered"
                    aria-selected="true">Registered</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-unregistered-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-unregistered" type="button" role="tab" aria-controls="pills-unregistered"
                    aria-selected="false">Unregistered</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-sk-official-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-sk-official" type="button" role="tab" aria-controls="pills-sk-official"
                    aria-selected="false">SK Official</button>
            </li>
        </ul>
    </div><!-- End Page Title -->

    <script>
    // Check if there's a saved active tab in localStorage and activate it
    window.onload = function() {
        let activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            let tabElement = document.querySelector(`[data-bs-target="${activeTab}"]`);
            let tabInstance = new bootstrap.Tab(tabElement);
            tabInstance.show();
        }
    }

    // Add event listener to each tab button to store the active tab in localStorage
    document.querySelectorAll('#pills-tab button').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(event) {
            let activeTab = event.target.getAttribute('data-bs-target');
            localStorage.setItem('activeTab', activeTab);
        });
    });
    </script>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="pills-registered" role="tabpanel"
                                aria-labelledby="registered-tab">

                                <h5 class="card-title">Youth Registered</h5>

                                <!-- Registered Youth -->
                                <?php

                                // Query to fetch all registered youth
                                $sql = "SELECT * FROM registered WHERE brgyCode = $getCode AND acc_type = 'registered'";
                                $result = mysqli_query($conn, $sql);

                                ?>

                                <!-- Youth Registered Table -->
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
                                <!-- End Youth Registered Table -->

                            </div>
                            <div class="tab-pane fade" id="pills-unregistered" role="tabpanel"
                                aria-labelledby="unregistered-tab">
                                <h5 class="card-title">Youth Unregistered</h5>

                                <!-- Registered Youth -->
                                <?php

                                // Query to fetch all registered youth
                                $sql = "SELECT * FROM registered WHERE brgyCode = $getCode AND acc_type = 'unregistered'";
                                $result = mysqli_query($conn, $sql);

                                ?>

                                <!-- Youth Registered Table -->
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
                                <!-- End Youth Registered Table -->

                            </div>
                            <div class="tab-pane fade" id="pills-sk-official" role="tabpanel"
                                aria-labelledby="sk-official-tab">
                                <section class="team" id="team">
                                    <div data-aos="fade-up">

                                        <div class="d-flex justify-content-end mt-3">
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#AddSKOfficial"><i class="bi bi-person-plus"></i>
                                                Add
                                                New SK
                                                Official</button>
                                        </div>
                                        <!-- <div class="section-title">
                                            <h2>Team</h2>
                                            <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex
                                                aliquid
                                                fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam
                                                cupiditate. Et nemo qui impedit suscipit alias ea.</p>
                                        </div> -->

                                        <!-- Modal -->
                                        <div class="modal fade" id="AddSKOfficial" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Register
                                                            SK
                                                            Official</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="admin-code.php" method="POST"
                                                        enctype="multipart/form-data">
                                                        <div class="modal-body row g-3">
                                                            <h5 class="card-title mx-2">Personal Information</h5>

                                                            <div class="col-md-3 text-center">
                                                                <label for="skPicture" class="form-label">Profile
                                                                    Picture</label> <br>
                                                                <img id="registerSKPreview"
                                                                    src="assets/img/user-profile.png"
                                                                    alt="Profile Preview"
                                                                    class="mb-2 img-fluid img-thumbnail mt-2">
                                                                <input type="file" class="form-control form-control-sm"
                                                                    id="skPicture" name="skPicture" accept="image/*"
                                                                    onchange="previewSKImage(event, 'registerSKPreview')">
                                                            </div>

                                                            <div class="col-md-9">
                                                                <div class="row g-3">
                                                                    <div class="col-md-4">
                                                                        <label for="lastname" class="form-label">Last
                                                                            Name</label>
                                                                        <input type="text" class="form-control"
                                                                            id="lastname" name="lastname">
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="firstname" class="form-label">First
                                                                            Name</label>
                                                                        <input type="text" class="form-control"
                                                                            id="firstname" name="firstname">
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="middlename"
                                                                            class="form-label">Middle
                                                                            Name</label>
                                                                        <input type="text" class="form-control"
                                                                            id="middlename" name="middlename">
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="position"
                                                                            class="form-label">Position</label>
                                                                        <select class="form-control" id="position"
                                                                            name="position">
                                                                            <option value="">Select Position</option>
                                                                            <option value="SK Chairman">SK Chairman
                                                                            </option>
                                                                            <option value="SK Kagawad">SK Kagawad
                                                                            </option>
                                                                            <option value="SK Secretary">SK Secretary
                                                                            </option>
                                                                            <option value="SK Treasurer">SK Treasurer
                                                                            </option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="sex" class="form-label">Sex</label>
                                                                        <select class="form-control" id="sex"
                                                                            name="sex">
                                                                            <option value="">Select Sex</option>
                                                                            <option value="1">Male</option>
                                                                            <option value="0">Female</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <label for="age" class="form-label">Age</label>
                                                                        <input type="number" class="form-control"
                                                                            id="age" name="age">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="dob" class="form-label">Date of
                                                                            Birth</label>
                                                                        <input type="date" class="form-control" id="dob"
                                                                            name="dob">
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <label for="mobileNumber"
                                                                            class="form-label">Mobile
                                                                            Number</label>
                                                                        <input type="tel" class="form-control"
                                                                            id="mobileNumber" name="mobileNumber">
                                                                    </div>

                                                                    <div class="col-md-2">
                                                                        <label for="streetNumber"
                                                                            class="form-label">Street
                                                                            Number</label>
                                                                        <input type="text" class="form-control"
                                                                            id="streetNumber" name="streetNumber">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="inputAddress"
                                                                            class="form-label">Address</label>
                                                                        <input type="text" class="form-control"
                                                                            id="inputAddress" name="address">
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="brgyAddressName"
                                                                            class="form-label">Barangay</label>
                                                                        <input type="text" class="form-control"
                                                                            id="brgyAddressName"
                                                                            value="<?= $_GET['Name']?>" readonly>
                                                                        <input type="hidden" class="form-control"
                                                                            id="brgyAddressCode" name="barangay"
                                                                            value="<?= $_GET['Code']?>" readonly>
                                                                    </div>

                                                                    <h5 class="card-title mx-2">Login Access</h5>

                                                                    <div class="col-md-6">
                                                                        <label for="username"
                                                                            class="form-label">Username</label>
                                                                        <input type="text" class="form-control"
                                                                            id="username" name="username">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="password"
                                                                            class="form-label">Password</label>
                                                                        <div class="input-group">
                                                                            <input type="password" class="form-control"
                                                                                id="password" name="password">
                                                                            <button class="btn btn-outline-secondary"
                                                                                type="button" id="togglePassword">
                                                                                <i class="bi bi-eye"
                                                                                    id="toggleIcon"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                    <script>
                                                                    document.getElementById('togglePassword')
                                                                        .addEventListener('click', function() {
                                                                            const passwordField = document
                                                                                .getElementById('password');
                                                                            const icon = document.getElementById(
                                                                                'toggleIcon');
                                                                            const type = passwordField.getAttribute(
                                                                                    'type') === 'password' ?
                                                                                'text' : 'password';
                                                                            passwordField.setAttribute('type',
                                                                            type);
                                                                            icon.classList.toggle('bi-eye');
                                                                            icon.classList.toggle('bi-eye-slash');
                                                                        });
                                                                    </script>


                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary"
                                                                name="createAcc">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">

                                            <?php 

                                            $activeBrgy = $_GET['Name'];
                                            $activeCode = $_GET['Code'];
                                            $src = '\KatipunanNgKabataan-Profiling/app/client/';
                                            
                                            // Fetch all officials from the database
                                            $result = $conn->query("SELECT * FROM `accounts` WHERE `brgy_code` = $activeCode AND `term_until` > NOW()");

                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    // Assuming the fields in the database include: 'firstname', 'lastname', 'role', and 'picture'
                                                    $fullname = htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); // Escape output for security
                                                    $role = htmlspecialchars($row['role']);

                                                    // Set default image if the database value is empty or null
                                                    $imageUrl = !empty($row['picture']) ? $src. htmlspecialchars($row['picture']) : 'assets/img/user-profile.png';

                                                    // Output the HTML structure for each member
                                                    echo '
                                                    <div class="col-lg-2 col-md-6 col-6 d-flex align-items-stretch">
                                                        <div class="member" data-aos="fade-up" data-aos-delay="100">
                                                            <div class="member-img">
                                                                <img src="' . $imageUrl . '" class="img-fluid" alt="' . $fullname . '">
                                                                <div class="social">
                                                                    <button class="view-sk-details" data-viewSK-id="'.$row['id'].'"><i class="bi bi-eye"></i></button>
                                                                    <button class="edit-sk-details" data-editSK-id="'.$row['id'].'"><i class="bi bi-pencil-square"></i></button>
                                                                </div>
                                                            </div>
                                                            <div class="member-info">
                                                                <h4>' . $fullname . '</h4>
                                                                <span>' . $role . '</span>
                                                            </div>
                                                        </div>
                                                    </div>';
                                                }
                                            } else {
                                                echo '<p>No officials found.</p>';
                                            }

                                            // Close the connection
                                            $conn->close();
                                            ?>


                                        </div>

                                    </div>
                                </section>
                            </div>
                        </div><!-- End Pills Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php 
    include "modal/viewModal.php";
    include "modal/editModal.php";
    ?>

    <script src="assets/js/details.js"></script>
    <script src="assets/js/edit.js"></script>
    <script>
    function previewSKImage(event, previewId) {
        const input = event.target;
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = "assets/img/user-profile.png";
        }
    }
    </script>

</main><!-- End #main -->
<?php 
include "includes/footer.php";
?>