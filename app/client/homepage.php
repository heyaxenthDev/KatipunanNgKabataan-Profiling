<?php 
    include 'authentication.php';
    checkLogin(); // Call the function to check if the user is logged in
    include "includes/conn.php";
    include "includes/header.php";
    include "includes/sidebar.php";
    include "alert.php";


?>
<script src="assets/js/sweetalert2.all.min.js"></script>
<?php
if (isset($_SESSION['logged'])) {
?>
<script type="text/javascript">
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

Toast.fire({
    background: '#53a653',
    color: '#fff',
    icon: '<?php echo $_SESSION['logged_icon']; ?>',
    title: '<?php echo $_SESSION['logged']; ?>'
});
</script>
<?php
    unset($_SESSION['logged']);
}
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Welcome, <?=$role?>!</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="row">
                <!-- Sales Card -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card registered-card">

                        <div class="card-body">
                            <h5 class="card-title">Youth Registered</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <?php 
                                        // Get current brgyCode
                                        $code = $_GET['Code'];
                                        
                                        // Get data count from registered table
                                        $regCount = "SELECT COUNT(*) AS total_reg FROM `registered` WHERE `brgyCode` = $code AND `acc_type` = 'registered'";
                                        $run = mysqli_query($conn, $regCount);

                                        if ($run) {
                                           $row = mysqli_fetch_assoc($run);
                                           $count_reg = $row['total_reg'];
                                        }else {
                                            $count_reg = 0;
                                        }

                                    ?>
                                    <h6><?=$count_reg?></h6>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card unregistered-card">

                        <div class="card-body">
                            <h5 class="card-title">Youth Unregistered</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <?php 
                                        // Get data count from unregistered table

                                        $regCount = "SELECT COUNT(*) AS total_unreg FROM `registered` WHERE `brgyCode` = $code AND `acc_type` = 'unregistered'";
                                        $run = mysqli_query($conn, $regCount);

                                        if ($run) {
                                           $row = mysqli_fetch_assoc($run);
                                           $count_unreg = $row['total_unreg'];
                                        }else {
                                            $count_unreg = 0;
                                        }

                                    ?>
                                    <h6><?=$count_unreg?></h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-3 col-md-6">
                    <div class="card info-card male-card">

                        <div class="card-body">
                            <h5 class="card-title">Male</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-gender-male"></i>
                                </div>
                                <div class="ps-3">

                                    <?php 
                                        // Get data count from registered table

                                        $regCount = "SELECT COUNT(*) AS total_male FROM `registered` WHERE `gender` = 0 AND `brgyCode` = $code";

                                        $run = mysqli_query($conn, $regCount);

                                        if ($run) {
                                           $row = mysqli_fetch_assoc($run);
                                           $male = $row['total_male'];
                                        }else {
                                            $male = 0;
                                        }

                                    ?>
                                    <h6><?=$male?></h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <!-- Customers Card -->
                <div class="col-xxl-3 col-md-6">

                    <div class="card info-card female-card">

                        <div class="card-body">
                            <h5 class="card-title">Female</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-gender-female"></i>
                                </div>
                                <div class="ps-3">
                                    <?php 
                                        // Get data count from registered table

                                        $regCount = "SELECT COUNT(*) AS total_female FROM `registered` WHERE `gender` = 1 AND `brgyCode` = $code";
                                        $run = mysqli_query($conn, $regCount);

                                        if ($run) {
                                           $row = mysqli_fetch_assoc($run);
                                           $female = $row['total_female'];
                                        }else {
                                            $female = 0;
                                        }

                                    ?>
                                    <h6><?=$female?></h6>

                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- End Customers Card -->
            </div>

            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="row">

                    <!-- Registered Reports -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Youth Classification <span>| Registered</span></h5>

                                <!-- Youth Classification -->
                                <div id="registereBarChart"></div>

                                <script>
                                document.addEventListener("DOMContentLoaded", () => {

                                    const given_code = "<?php echo $code; ?>";

                                    // Fetch the data from the PHP backend
                                    fetch(`get_youth_classification_registered.php?Code=${given_code}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            // Extract values from the JSON response
                                            const youthData = [
                                                data.in_school,
                                                data.out_of_school,
                                                data.working_youth,
                                                data.youth_special_needs,
                                                data.person_disability,
                                                data.conflict_law,
                                                data.indigenous_people
                                            ];

                                            // Create the chart with dynamic data
                                            new ApexCharts(document.querySelector("#registereBarChart"), {
                                                series: [{
                                                    data: youthData
                                                }],
                                                chart: {
                                                    type: 'bar',
                                                    height: 350
                                                },
                                                plotOptions: {
                                                    bar: {
                                                        borderRadius: 4,
                                                        horizontal: true,
                                                    }
                                                },
                                                dataLabels: {
                                                    enabled: false
                                                },
                                                xaxis: {
                                                    categories: [
                                                        'In School',
                                                        'Out of School',
                                                        'Working Youth',
                                                        'Youth w/ Special Needs',
                                                        'Person w/ Disability',
                                                        'Children in conflict w/ Law',
                                                        'Indigenous People'
                                                    ],
                                                }
                                            }).render();
                                        });
                                });
                                </script>
                                <!-- End Youth Classification -->
                            </div>

                        </div>
                    </div><!-- End Registered Reports -->

                    <!-- Unregistered Reports -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Youth Classification <span>| Unregistered</span></h5>

                                <!-- Youth Classification -->
                                <div id="unregistereBarChart"></div>

                                <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    const given_code = "<?php echo $code; ?>";

                                    // Fetch the data from the PHP backend
                                    fetch(`get_youth_classification_unregistered.php?Code=${given_code}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            // Extract values from the JSON response
                                            const youthData = [
                                                data.in_school,
                                                data.out_of_school,
                                                data.working_youth,
                                                data.youth_special_needs,
                                                data.person_disability,
                                                data.conflict_law,
                                                data.indigenous_people
                                            ];

                                            // Create the chart with dynamic data
                                            new ApexCharts(document.querySelector("#unregistereBarChart"), {
                                                series: [{
                                                    data: youthData
                                                }],
                                                chart: {
                                                    type: 'bar',
                                                    height: 350
                                                },
                                                plotOptions: {
                                                    bar: {
                                                        borderRadius: 4,
                                                        horizontal: true,
                                                    }
                                                },
                                                dataLabels: {
                                                    enabled: false
                                                },
                                                xaxis: {
                                                    categories: [
                                                        'In School',
                                                        'Out of School',
                                                        'Working Youth',
                                                        'Youth w/ Special Needs',
                                                        'Person w/ Disability',
                                                        'Children in conflict w/ Law',
                                                        'Indigenous People'
                                                    ],
                                                }
                                            }).render();
                                        });
                                });
                                </script>
                                <!-- End Youth Classification -->
                            </div>

                        </div>
                    </div><!-- End Unregistered Reports -->

                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">

                <!-- Youth Age Group -->
                <div class="card">

                    <div class="card-body pb-0">
                        <h5 class="card-title">Youth Age Groups</h5>

                        <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

                        <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            // Get the PHP variable and pass it to the fetch request
                            const given_code = "<?php echo $code; ?>";

                            // Fetch the data from the PHP backend with the dynamic code
                            fetch(`get_youth_age_groups_data.php?Code=${given_code}`)
                                .then(response => response.json())
                                .then(data => {
                                    // Create the chart with dynamic data
                                    echarts.init(document.querySelector("#trafficChart")).setOption({
                                        tooltip: {
                                            trigger: 'item'
                                        },
                                        legend: {
                                            top: '5%',
                                            left: 'center'
                                        },
                                        series: [{
                                            name: 'Youth Age Groups',
                                            type: 'pie',
                                            radius: ['40%', '70%'],
                                            avoidLabelOverlap: false,
                                            label: {
                                                show: false,
                                                position: 'center'
                                            },
                                            emphasis: {
                                                label: {
                                                    show: true,
                                                    fontSize: '18',
                                                    fontWeight: 'bold'
                                                }
                                            },
                                            labelLine: {
                                                show: false
                                            },
                                            data: [{
                                                    value: data.unregistered,
                                                    name: 'Unregistered Youth'
                                                },
                                                {
                                                    value: data.child_youth,
                                                    name: 'Child Youth'
                                                },
                                                {
                                                    value: data.core_youth,
                                                    name: 'Core Youth'
                                                },
                                                {
                                                    value: data.young_adult,
                                                    name: 'Young Adult'
                                                }
                                            ]
                                        }]
                                    });
                                });
                        });
                        </script>
                    </div>


                </div><!-- End Youth Age Group -->

            </div><!-- End Right side columns -->

        </div>
    </section>

</main><!-- End #main -->
<?php 
include "includes/footer.php";
?>