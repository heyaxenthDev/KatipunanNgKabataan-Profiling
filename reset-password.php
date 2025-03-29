<?php 
session_start();
include "includes/conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Reset Password - Katipunan ng Kabataan Profiling System</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Favicons -->
    <link href="assets/img/favicon.ico" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/aos/aos.css" rel="stylesheet" />
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet" />
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="index-page">
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <a href="index" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="assets/img/SK Logo-white.png" alt="" />
                <!-- <h1 class="sitename">Nova</h1> -->
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="youth-registration">Youth Registration</a></li>
                    <li>
                        <a href="admin-login"><i class="bi bi-person"></i></a>
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none d-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <?php 
    include "alert.php";
    ?>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade"
            style="background-image: url(assets/img/undraw_forgot-password_odai.jpg);">
            <div class="container">
                <h1>Reset Your Password</h1>
            </div>
        </div><!-- End Page Title -->

        <!-- Forgot Password Section -->
        <section id="forgot-password" class="forgot-password section">
            <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-header text-center">
                            <p>Enter Verification code sent to your email</p>
                        </div>

                        <form action="process_forgot_password.php" method="POST" data-aos="fade-up"
                            data-aos-delay="200">

                            <input type="hidden" id="email" class="form-control" name="email" placeholder="Email"
                                value="<?= $_GET['email']?>" required>

                            <div class="form-floating mb-3">
                                <input type="password" id="newPassword" class="form-control" name="newPassword"
                                    placeholder="New Password" required>
                                <label for="newPassword">New Password</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" id="confirmPassword" class="form-control" name="confirmPassword"
                                    placeholder="Confirm Password" required>
                                <label for="confirmPassword">Confirm Password</label>
                            </div>

                            <small id="password-message" class="text-danger"></small>

                            <!-- Show Password Checkbox -->
                            <div class="form-check mt-2 mb-5">
                                <input class="form-check-input" type="checkbox" id="showPassword">
                                <label class="form-check-label" for="showPassword">Show Password</label>
                            </div>

                            <script>
                            document.getElementById("confirmPassword").addEventListener("keyup", function() {
                                var newPassword = document.getElementById("newPassword").value;
                                var confirmPassword = this.value;
                                var message = document.getElementById("password-message");

                                if (newPassword !== confirmPassword) {
                                    message.textContent = "Passwords do not match!";
                                } else {
                                    message.textContent = "";
                                }
                            });

                            // Toggle Password Visibility
                            document.getElementById("showPassword").addEventListener("change", function() {
                                var newPassword = document.getElementById("newPassword");
                                var confirmPassword = document.getElementById("confirmPassword");
                                var type = this.checked ? "text" : "password";

                                newPassword.type = type;
                                confirmPassword.type = type;
                            });
                            </script>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" name="resetPassword">Reset
                                    Password</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </section><!-- /Forgot Password Section -->

    </main>
    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>