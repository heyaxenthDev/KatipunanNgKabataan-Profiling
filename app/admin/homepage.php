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
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="row">

            <?php
                include 'includes/conn.php';

                try {
                    $stmt = $conn->query("
                        SELECT 
                            b.barangay_name,
                            COALESCE(r.registered_count, 0) AS registered_count,
                            COALESCE(u.unregistered_count, 0) AS unregistered_count
                        FROM barangay b
                        LEFT JOIN (
                            SELECT brgyCode, COUNT(*) AS registered_count
                            FROM registered
                            GROUP BY brgyCode
                        ) r ON b.barangay_code = r.brgyCode
                        LEFT JOIN (
                            SELECT brgyCode, COUNT(*) AS unregistered_count
                            FROM unregistered
                            GROUP BY brgyCode
                        ) u ON b.barangay_code = u.brgyCode
                    ");
                
                    $data = [];
                    while ($row = $stmt->fetch_assoc()) {
                        $data[] = [
                            'name' => $row['barangay_name'],
                            'registered' => (int)$row['registered_count'],
                            'unregistered' => (int)$row['unregistered_count']
                        ];
                    }
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>

            <?php
                // Define an array of color palettes to cycle through for each barangay
                $colorPalettes = [
                    ['#4caf50', '#ffeb3b'], // Green and Yellow
                    ['#2196f3', '#f44336'], // Blue and Red
                    ['#9c27b0', '#ffc107'], // Purple and Amber
                    ['#ff5722', '#03a9f4'], // Orange and Light Blue
                    ['#673ab7', '#8bc34a'], // Deep Purple and Light Green
                ];
                $paletteIndex = 0; // To iterate over color palettes
                ?>
            <?php foreach ($data as $barangay): ?>
            <!-- Center columns -->
            <div class="col-md-4">
                <!-- Website Traffic Card for Each Barangay -->
                <div class="card">
                    <div class="card-body pb-0">
                        <h5 class="card-title"><?= htmlspecialchars($barangay['name']) ?></h5>
                        <div id="<?= htmlspecialchars($barangay['name']) ?>-Chart" style="min-height: 400px;"
                            class="echart"></div>

                        <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const chart = echarts.init(document.querySelector(
                                "#<?= htmlspecialchars($barangay['name']) ?>-Chart"));

                            const chartData = [{
                                    value: <?= $barangay['registered'] ?>,
                                    name: 'Registered'
                                },
                                {
                                    value: <?= $barangay['unregistered'] ?>,
                                    name: 'Unregistered'
                                }
                            ];

                            chart.setOption({
                                color: <?= json_encode($colorPalettes[$paletteIndex % count($colorPalettes)]) ?>,
                                tooltip: {
                                    trigger: 'item',
                                    formatter: '{a} <br/>{b}: {c} ({d}%)'
                                },
                                legend: {
                                    top: '5%',
                                    left: 'center'
                                },
                                series: [{
                                    name: 'Population Status',
                                    type: 'pie',
                                    radius: ['40%', '70%'],
                                    label: {
                                        show: true,
                                        position: 'outside',
                                        formatter: '{b}: {c} ({d}%)'
                                    },
                                    data: chartData
                                }]
                            });
                        });
                        </script>
                    </div>
                </div><!-- End Website Traffic -->
                <?php $paletteIndex++; ?>

            </div><!-- End Center columns -->

            <!-- Increment color palette index -->
            <?php endforeach; ?>




        </div>
    </section>

</main><!-- End #main -->

<?php 
include "includes/footer.php";
?>