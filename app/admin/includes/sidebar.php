<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <?php 
    // Get the current file name
    $current_page = basename($_SERVER['PHP_SELF'], ".php");
    ?>

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'homepage' ? '' : 'collapsed'; ?>" href="homepage">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'barangayView' ? '' : 'collapsed'; ?>"
                data-bs-toggle="collapse" href="#components-nav">
                <i class="bi bi-pin-map"></i><span>Barangay</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav"
                class="nav-content collapse <?php echo $current_page == 'barangayView' ? 'show' : ''; ?>"
                data-bs-parent="#sidebar-nav">

                <?php
                include "includes/conn.php"; // Include the database connection

                // Query to get all barangays from the database
                $query = "SELECT * FROM barangay";
                $result = mysqli_query($conn, $query);

                // Check if the query returned any rows
                if (mysqli_num_rows($result) > 0) {
                    // Loop through each barangay and generate the HTML
                    while ($row = mysqli_fetch_assoc($result)) {
                        $barangayName = $row['barangay_name'];
                        $barangayCode = $row['barangay_code'];
                        $isActive = ($current_page == 'barangayView' && $_GET['Code'] == $barangayCode) ? 'class="active"' : '';
                        echo '
                        <li>
                            <a href="barangayView?Name='.$barangayName.'&Code='.$barangayCode.'" '.$isActive.'>
                                <i class="bi bi-circle"></i><span>' . htmlspecialchars($barangayName) . '</span>
                            </a>
                        </li>';
                    }
                } else {
                    echo '
                    <li>
                        <a href="#">
                            <i class="bi bi-circle"></i><span>No barangays found</span>
                        </a>
                    </li>';
                }
                ?>

                <li>
                    <a data-bs-toggle="modal" data-bs-target="#AddNewBarangayModal" style="cursor: pointer;">
                        <i class="bi bi-plus-circle"></i><span class="text-secondary">Add New Barangay</span>
                    </a>
                </li>

            </ul>
        </li><!-- End Barangay Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'cbyp' || $current_page == 'abyp' ? '' : 'collapsed'; ?>"
                data-bs-toggle="collapse" href="#forms-nav">
                <i class="bi bi-journal-text"></i><span>Brgy. SK Reports</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav"
                class="nav-content collapse <?php echo $current_page == 'cbyp' || $current_page == 'abyp' ? 'show' : ''; ?>"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="cbyp" <?php echo $current_page == 'cbyp' ? 'class="active"' : ''; ?>>
                        <i class="bi bi-circle"></i><span>CBYP</span>
                    </a>
                </li>
                <li>
                    <a href="abyp" <?php echo $current_page == 'abyp' ? 'class="active"' : ''; ?>>
                        <i class="bi bi-circle"></i><span>ABYP</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'users-profile' ? '' : 'collapsed'; ?>"
                href="users-profile.html">
                <i class="bi bi-people"></i>
                <span>Member List</span>
            </a>
        </li><!-- End Member List Nav -->

        <li class="nav-item">
            <a class="nav-link <?php echo $current_page == 'pages-faq' ? '' : 'collapsed'; ?>" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Documents</span>
            </a>
        </li><!-- End Documents Page Nav -->

    </ul>

</aside><!-- End Sidebar-->

<!-- Modal -->
<div class="modal fade" id="AddNewBarangayModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Barangay</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for entering Barangay name -->
                <form id="addBarangayForm" action="code.php" method="POST">
                    <div class="mb-3">
                        <label for="barangayName" class="form-label">Barangay Name</label>
                        <input type="text" class="form-control" id="barangayName" name="barangayName" required>
                        <div class="invalid-feedback">
                            Please enter a barangay name.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="addBarangayForm" name="addBarangayForm">Save
                    Barangay</button>
            </div>
        </div>
    </div>
</div>