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

                                <!-- Youth Registered Table -->
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>
                                                <b>N</b>ame
                                            </th>
                                            <th>Ext.</th>
                                            <th>City</th>
                                            <th data-type="date" data-format="YYYY/DD/MM">Start Date</th>
                                            <th>Completion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Unity Pugh</td>
                                            <td>9958</td>
                                            <td>Curicó</td>
                                            <td>2005/02/11</td>
                                            <td>37%</td>
                                        </tr>

                                    </tbody>
                                </table>
                                <!-- End Youth Registered Table -->
                            </div>
                            <div class="tab-pane fade" id="pills-unregistered" role="tabpanel"
                                aria-labelledby="unregistered-tab">
                                <h5 class="card-title">Youth Unregistered</h5>

                                <!-- Youth Registered Table -->
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>
                                                <b>N</b>ame
                                            </th>
                                            <th>Ext.</th>
                                            <th>City</th>
                                            <th data-type="date" data-format="YYYY/DD/MM">Start Date</th>
                                            <th>Completion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Unity Pugh</td>
                                            <td>9958</td>
                                            <td>Curicó</td>
                                            <td>2005/02/11</td>
                                            <td>37%</td>
                                        </tr>

                                    </tbody>
                                </table>
                                <!-- End Youth Registered Table -->
                            </div>
                            <div class="tab-pane fade" id="pills-sk-official" role="tabpanel"
                                aria-labelledby="sk-official-tab">
                                <section class="team" id="team">
                                    <div class="container" data-aos="fade-up">

                                        <div class="d-flex justify-content-end mt-3">
                                            <button class="btn btn-secondary btn-sm"><i class="bi bi-person-plus"></i>
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

                                        <div class="row mt-3">

                                            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                                                <div class="member" data-aos="fade-up" data-aos-delay="100">
                                                    <div class="member-img">
                                                        <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
                                                        <div class="social">
                                                            <a href=""><i class="bi bi-twitter"></i></a>
                                                            <a href=""><i class="bi bi-facebook"></i></a>
                                                            <a href=""><i class="bi bi-instagram"></i></a>
                                                            <a href=""><i class="bi bi-linkedin"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="member-info">
                                                        <h4>Walter White</h4>
                                                        <span>Chief Executive Officer</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                                                <div class="member" data-aos="fade-up" data-aos-delay="200">
                                                    <div class="member-img">
                                                        <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                                                        <div class="social">
                                                            <a href=""><i class="bi bi-twitter"></i></a>
                                                            <a href=""><i class="bi bi-facebook"></i></a>
                                                            <a href=""><i class="bi bi-instagram"></i></a>
                                                            <a href=""><i class="bi bi-linkedin"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="member-info">
                                                        <h4>Sarah Jhonson</h4>
                                                        <span>Product Manager</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                                                <div class="member" data-aos="fade-up" data-aos-delay="300">
                                                    <div class="member-img">
                                                        <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                                                        <div class="social">
                                                            <a href=""><i class="bi bi-twitter"></i></a>
                                                            <a href=""><i class="bi bi-facebook"></i></a>
                                                            <a href=""><i class="bi bi-instagram"></i></a>
                                                            <a href=""><i class="bi bi-linkedin"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="member-info">
                                                        <h4>William Anderson</h4>
                                                        <span>CTO</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                                                <div class="member" data-aos="fade-up" data-aos-delay="400">
                                                    <div class="member-img">
                                                        <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="">
                                                        <div class="social">
                                                            <a href=""><i class="bi bi-twitter"></i></a>
                                                            <a href=""><i class="bi bi-facebook"></i></a>
                                                            <a href=""><i class="bi bi-instagram"></i></a>
                                                            <a href=""><i class="bi bi-linkedin"></i></a>
                                                        </div>
                                                    </div>
                                                    <div class="member-info">
                                                        <h4>Amanda Jepson</h4>
                                                        <span>Accountant</span>
                                                    </div>
                                                </div>
                                            </div>

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

</main><!-- End #main -->
<?php 
include "includes/footer.php";
?>