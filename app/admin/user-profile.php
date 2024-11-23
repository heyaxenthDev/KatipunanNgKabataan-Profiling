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
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="homepage">Home</a></li>
                <li class="breadcrumb-item">User Profile</li>
                <li class="breadcrumb-item active"><?= $fullname?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <?php
                        // Check if $user_picture is empty
                        $profilePicture = empty($user_picture) ? 'assets/img/user-profile.png' : $user_picture;
                        ?>

                        <img src="<?= htmlspecialchars($profilePicture); ?>" alt="Profile" class="rounded-circle">

                        <h2><?= $fullname?></h2>
                        <h3><?= $role?></h3>
                        <!-- <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div> -->
                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered" id="profile-tabs">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Profile</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">Change Password</button>
                            </li>
                        </ul>

                        <script>
                        // Check if there's a saved active tab in localStorage and activate it
                        window.onload = function() {
                            let activeTab = localStorage.getItem('activeTab');
                            if (activeTab) {
                                let tabElement = document.querySelector(`[data-bs-target="${activeTab}"]`);
                                if (tabElement) {
                                    let tabInstance = new bootstrap.Tab(tabElement);
                                    tabInstance.show();
                                }
                            }
                        };

                        // Add event listener to each tab button to store the active tab in localStorage
                        document.querySelectorAll('#profile-tabs button').forEach(tab => {
                            tab.addEventListener('shown.bs.tab', function(event) {
                                let activeTab = event.target.getAttribute('data-bs-target');
                                localStorage.setItem('activeTab', activeTab);
                            });
                        });
                        </script>


                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Username</div>
                                    <div class="col-lg-9 col-md-8"><?= $username?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Last Name</div>
                                    <div class="col-lg-9 col-md-8"><?= $lastname?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">First Name</div>
                                    <div class="col-lg-9 col-md-8"><?= $firstname?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Position</div>
                                    <div class="col-lg-9 col-md-8"><?= $role?></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Date Account Created</div>
                                    <div class="col-lg-9 col-md-8"><?= $dc?></div>
                                </div>

                                <!-- <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">A108 Adam Street, New York, NY 535022</div>
                                </div> -->

                                <!-- <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8">(436) 486-3538 x29071</div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">k.anderson@example.com</div>
                                </div> -->

                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <!-- Profile Edit Form -->
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                            Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <?php
                                            // Check if $user_picture is empty
                                            $profilePicture = empty($user_picture) ? 'assets/img/user-profile.png' : $user_picture;
                                            ?>

                                            <img id="profilePreview" src="<?= htmlspecialchars($profilePicture); ?>"
                                                alt="Profile" class="rounded-circle"
                                                style="width: 100px; height: 100px; object-fit: cover;">

                                            <div class="pt-2">
                                                <label for="profileImageUpload"
                                                    class="btn btn-primary text-white btn-sm"
                                                    title="Upload new profile image">
                                                    <i class="bi bi-upload"></i> Upload
                                                </label>
                                                <input type="file" name="profileImage" id="profileImageUpload"
                                                    accept="image/*" style="display: none;">
                                            </div>

                                            <script>
                                            document.getElementById('profileImageUpload').addEventListener('change',
                                                function(event) {
                                                    const file = event.target.files[0]; // Get the selected file
                                                    if (file) {
                                                        const reader =
                                                            new FileReader(); // Create a FileReader to read the file
                                                        reader.onload = function(e) {
                                                            const preview = document.getElementById(
                                                                'profilePreview'); // Get the img element
                                                            preview.src = e.target
                                                                .result; // Set the src to the file content
                                                        };
                                                        reader.readAsDataURL(file); // Read the file as a data URL
                                                    }
                                                });
                                            </script>

                                        </div>
                                    </div>

                                    <input type="hidden" name="id" id="id" value="<?= $id?>">

                                    <div class="row mb-3">
                                        <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="username" type="text" class="form-control" id="username"
                                                value="<?=$username?>" disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="lastName" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="lastName" type="text" class="form-control" id="lastName"
                                                value="<?=$lastname?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="firstName" class="col-md-4 col-lg-3 col-form-label">First
                                            Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="firstName" type="text" class="form-control" id="firstName"
                                                value="<?=$firstname?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Position" class="col-md-4 col-lg-3 col-form-label">Position</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="role" type="text" class="form-control" id="Position"
                                                value="<?= $role?>" disabled>
                                        </div>
                                    </div>

                                    <!-- <div class="row mb-3">
                                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="address" type="text" class="form-control" id="Address"
                                                value="A108 Adam Street, New York, NY 535022">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="Phone"
                                                value="(436) 486-3538 x29071">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control" id="Email"
                                                value="k.anderson@example.com">
                                        </div>
                                    </div> -->

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary" name="updateAcc">Save
                                            Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>

                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form action="code.php" method="POST">

                                    <input type="hidden" name="id" id="id" value="<?= $id?>">

                                    <!-- Current Password -->
                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control"
                                                id="currentPassword" required>
                                        </div>
                                    </div>

                                    <!-- New Password -->
                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="newpassword" type="password" class="form-control"
                                                id="newPassword" required>
                                        </div>
                                    </div>

                                    <!-- Re-enter New Password -->
                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="renewpassword" type="password" class="form-control"
                                                id="renewPassword" required>
                                        </div>
                                    </div>

                                    <!-- Checkbox to show/hide all passwords -->
                                    <div class="row mb-3">
                                        <div class="col-md-8 col-lg-9 offset-md-4 offset-lg-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="showPasswordsCheckbox">
                                                <label class="form-check-label" for="showPasswordsCheckbox">
                                                    Show all passwords
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary" name="passwordChange">Change
                                            Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                                <script>
                                $(document).ready(function() {
                                    // Listen for the checkbox change event
                                    $('#showPasswordsCheckbox').on('change', function() {
                                        // Check if the checkbox is checked
                                        if ($(this).prop('checked')) {
                                            // Change all password input fields to text to show passwords
                                            $('input[type="password"]').attr('type', 'text');
                                        } else {
                                            // Change all password input fields back to password to hide passwords
                                            $('input[type="text"]').attr('type', 'password');
                                        }
                                    });
                                });
                                </script>

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>