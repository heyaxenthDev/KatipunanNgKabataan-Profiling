<?php 
    // Get the current script name
    $current_page = basename($_SERVER['PHP_SELF'], ".php");

    // Function to check if a file exists, fallback to Page404.html if not
    function get_page_link($page_name, $query) {
        $file_path = $page_name . '.php';
        if (file_exists($file_path)) {
            return $file_path . '?' . $query;
        } else {
            return 'pages-error-404.html';
        }
    }
?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">Main</li>

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'homepage') ? '' : 'collapsed' ?>"
                href="<?= get_page_link('homepage', "Code=$BrgyCode") ?>">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'registered youth') ? '' : 'collapsed' ?>"
                href="<?= get_page_link('registered youth', "Code=$BrgyCode") ?>">
                <i class="bi bi-person-check"></i>
                <span>Registered</span>
            </a>
        </li><!-- End Register Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'unregistered youth') ? '' : 'collapsed' ?>"
                href="<?= get_page_link('unregistered youth', "Code=$BrgyCode") ?>">
                <i class="bi bi-person-dash"></i>
                <span>Unregistered</span>
            </a>
        </li><!-- End Unregister Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'registration form') ? '' : 'collapsed' ?>"
                href="<?= get_page_link('registration form', "Code=$BrgyCode") ?>">
                <i class="bi bi-card-list"></i>
                <span>Registration Form</span>
            </a>
        </li><!-- End Registration Form Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'youth involve') ? '' : 'collapsed' ?>"
                href="<?= get_page_link('youth involve', "Code=$BrgyCode") ?>">
                <i class="bi bi-people"></i>
                <span>Youth Involve</span>
            </a>
        </li><!-- End Youth Involve Page Nav -->

        <li class="nav-heading">Documents</li>

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'cbydp') ? '' : 'collapsed' ?>"
                href="<?= get_page_link('cbydp', "Code=$BrgyCode") ?>">
                <i class="bi bi-file-earmark-text"></i>
                <span>CBYDP</span>
            </a>
        </li><!-- End CBYDP Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'abyip') ? '' : 'collapsed' ?>"
                href="<?= get_page_link('abyip', "Code=$BrgyCode") ?>">
                <i class="bi bi-file-earmark-text"></i>
                <span>ABYIP</span>
            </a>
        </li><!-- End ABYIP Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'notice of the meeting') ? '' : 'collapsed' ?>"
                href="<?= get_page_link('notice of the meeting', "Code=$BrgyCode") ?>">
                <i class="bi bi-bell"></i>
                <span>Notice of the Meeting</span>
            </a>
        </li><!-- End Documents Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'reports') ? '' : 'collapsed' ?>"
                href="<?= get_page_link('reports', "Code=$BrgyCode") ?>">
                <i class="bi bi-bar-chart-line"></i>
                <span>Reports</span>
            </a>
        </li><!-- End Reports Page Nav -->

        <!-- <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'calendar') ? '' : 'collapsed' ?>"
                href="<?= get_page_link('calendar', "Code=$BrgyCode") ?>">
                <i class="bi bi-calendar-week"></i>
                <span>Calendar</span>
            </a>
        </li> -->
        <!-- End Calendar Page Nav -->

        <li class="nav-heading">User</li>

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'user-profile') ? '' : 'collapsed' ?>"
                href="<?= get_page_link('user-profile', "Code=$BrgyCode") ?>">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->

    </ul>

</aside><!-- End Sidebar-->