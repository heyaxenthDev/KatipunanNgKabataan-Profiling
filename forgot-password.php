<?php 
session_start();
include "includes/conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Forgot Password - Katipunan ng Kabataan Profiling System</title>
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
                <h1>Forgot Password?</h1>
            </div>
        </div><!-- End Page Title -->

        <!-- Forgot Password Section -->
        <section id="forgot-password" class="forgot-password section">
            <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">


                <?php 
                if (isset($_SESSION['codeSent'])) {
                ?>
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-header text-center">
                            <p>Enter Verification code sent to your email</p>
                        </div>

                        <form action="process_forgot_password.php" method="POST" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="form-floating mb-3">
                                <input type="email" id="email" class="form-control" name="email"
                                    placeholder="Email Address" value="<?= $_SESSION['entered_email']?>" readonly>
                                <label for="email">Email Address</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" id="verificationCode" class="form-control" name="verificationCode"
                                    placeholder="Verification Code" required>
                                <label for="verificationCode">Verification Code</label>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" name="confirmCode">Reset
                                    Password</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                }else{
                    ?>
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section-header text-center">
                            <p>Enter your email to reset your password</p>
                        </div>
                        <form action="process_forgot_password.php" method="POST" data-aos="fade-up" data-aos-delay="200"
                            id="resetPasswordForm">
                            <div class="form-floating mb-3">
                                <input type="email" id="email" class="form-control" name="email"
                                    placeholder="Email Address" required>
                                <label for="email">Email Address</label>
                                <small id="email-status" class="text-danger"></small>
                            </div>
                            <div class="text-center">
                                <button type="submit" id="resetRequestCode" class="btn btn-primary"
                                    name="resetRequestCode">Reset
                                    Password <span id="spinner"
                                        class="spinner-border spinner-border-sm d-none"></span></button>
                            </div>
                        </form>

                        <script>
                        $(document).ready(function() {
                            $("#email").keyup(function() {
                                var email = $(this).val().trim();
                                if (email !== "") {
                                    $.ajax({
                                        url: "check_email.php",
                                        method: "POST",
                                        data: {
                                            email: email
                                        },
                                        success: function(response) {
                                            $("#email-status").html(response);
                                        }
                                    });
                                } else {
                                    $("#email-status").html("");
                                }
                            });
                        });

                        document.getElementById("myForm").addEventListener("submit", function(event) {
                            var submitBtn = document.getElementById("resetRequestCode");
                            var spinner = document.getElementById("spinner");

                            // Show spinner and disable button
                            spinner.classList.remove("d-none");
                            submitBtn.disabled = true;
                        });
                        </script>
                    </div>
                </div>
                <?php
                }
                // unset($_SESSION['codeSent']);
                ?>

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