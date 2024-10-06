<?php 
session_start();
include "includes/conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Log in - Katipunan ng Kabataan Profiling System</title>
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
</head>


<?php 
  include "includes/alert.php";
?>

<body class="index-page">
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <a href="index" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="assets/img/SK Logo-white.png" alt="" />
                <!-- <h1 class="sitename">Nova</h1> -->
            </a>

            <nav id="navmenu" class="navmenu">
                <a href="admin-login"><i class="bi bi-person"></i></a>

                <i class="mobile-nav-toggle d-xl-none d-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <img src="assets/img/tibiao-sk.jpg" alt="" data-aos="fade-in" />

            <div class="container">
                <div class="row">
                    <div class="col-xl-4">
                        <h1 data-aos="fade-up">Katipunan ng Kabataan Profiling System</h1>
                        <blockquote data-aos="fade-up" data-aos-delay="100">
                            <p>
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                                Perspiciatis cum recusandae eum laboriosam voluptatem
                                repudiandae odio, vel exercitationem officiis provident
                                minima.
                            </p>
                        </blockquote>
                        <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                            <a href="#sk-login" class="btn-get-started">Get Started</a>
                            <!-- <a href="#" class="glightbox btn-watch-video d-flex align-items-center"><i
                                    class="bi bi-play-circle"></i><span>Watch Video</span></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Hero Section -->

        <!-- Why Us Section -->
        <section id="sk-login" class="sk-login section">

            <div class="container">

                <div class="row g-0">

                    <div class="col-xl-5 img-bg" data-aos="fade-up" data-aos-delay="100">
                        <img src="assets/img/why-us-bg.jpg" alt="">
                    </div>

                    <div class="col-xl-7 p-5">
                        <div class="m-5">
                            <h3 class="mb-3">Welcome Back!</h3>
                            <p>Please enter your credentials to log in.</p>
                            <form action="reg-code.php" method="POST">

                                <div class="mb-3">
                                    <?php 
                                    // Fetch Available Barangays from the database
                                    $sql = "SELECT * FROM barangay";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->execute();
                                    $results = $stmt->get_result(); // Use get_result to fetch multiple rows

                                    // Check if any barangays are available
                                    if ($results->num_rows > 0) {
                                        echo '<select class="form-select form-select-lg" id="barangayCode" name="barangayCode" required>';
                                        echo '<option value="" selected>Select your Barangay</option>';

                                        // Loop through the results and add each barangay to the dropdown
                                        while ($row = $results->fetch_assoc()) {
                                            $barangayCode = $row['barangay_code']; // Assuming you have a column named 'barangay_code'
                                            $barangayName = $row['barangay_name']; // Assuming you have a column named 'barangay_name'
                                            echo "<option value='$barangayCode'>$barangayName</option>";
                                        }

                                        echo '</select>';
                                    } else {
                                        // If no barangays found, display a message or handle as necessary
                                        echo '<p>No barangays available</p>';
                                    }

                                    // Close the statement
                                    $stmt->close();

                                    ?>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Your Username"
                                        value="<?php echo isset($_SESSION['entered_username']) ? $_SESSION['entered_username'] : ''; ?>"
                                        required>
                                    <label for="username"><i class="bi bi-at"></i> Username</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Your Password" required>
                                    <label for="password"><i class="bi bi-lock"></i> Password</label>
                                </div>

                                <div class="mt-3 text-end mb-3">
                                    <a href="forgot_password.php" class="link-primary">Forgot Password?</a>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary" name="sk-login">Login</button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>

            </div>

        </section><!-- /Why Us Section -->
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