<?php 
    // Get the current script name
    $current_page = basename($_SERVER['PHP_SELF'], ".php");

?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'homepage') ? '' : 'collapsed' ?>"
                href="homepage?Code=<?=$BrgyCode?>">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'registered youth') ? '' : 'collapsed' ?>"
                href="registered youth?Code=<?=$BrgyCode?>">
                <i class="bi bi-person-check"></i>
                <span>Registered</span>
            </a>
        </li><!-- End Register Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'unregistered youth') ? '' : 'collapsed' ?>"
                href="unregistered youth?Code=<?=$BrgyCode?>">
                <i class="bi bi-person-dash"></i>
                <span>Unregistered</span>
            </a>
        </li><!-- End Unregister Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'registration form') ? '' : 'collapsed' ?>"
                href="registration form?Code=<?=$BrgyCode?>">
                <i class="bi bi-card-list"></i>
                <span>Registration Form</span>
            </a>
        </li><!-- End Registration Form Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'youth involve') ? '' : 'collapsed' ?>"
                href="youth involve?Code=<?=$BrgyCode?>">
                <i class="bi bi-people"></i>
                <span>Youth Involve</span>
            </a>
        </li><!-- End Youth Involve Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'cbydp') ? '' : 'collapsed' ?>" href="cbydp?Code=<?=$BrgyCode?>">
                <i class="bi bi-file-earmark-text"></i>
                <span>CBYDP</span>
            </a>
        </li><!-- End CBYDP Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'abyip') ? '' : 'collapsed' ?>" href="abyip?Code=<?=$BrgyCode?>">
                <i class="bi bi-file-earmark-text"></i>
                <span>ABYIP</span>
            </a>
        </li><!-- End ABYIP Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'documents') ? '' : 'collapsed' ?>"
                href="documents?Code=<?=$BrgyCode?>">
                <i class="bi bi-folder2-open"></i>
                <span>Documents</span>
            </a>
        </li><!-- End Documents Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'reports') ? '' : 'collapsed' ?>"
                href="reports?Code=<?=$BrgyCode?>">
                <i class="bi bi-bar-chart-line"></i>
                <span>Reports</span>
            </a>
        </li><!-- End Reports Page Nav -->

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'calendar') ? '' : 'collapsed' ?>"
                href="calendar?Code=<?=$BrgyCode?>">
                <i class="bi bi-calendar-week"></i>
                <span>Calendar</span>
            </a>
        </li><!-- End Calendar Page Nav -->

        <li class="nav-heading">User</li>

        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'user-profile') ? '' : 'collapsed' ?>"
                href="user-profile?Code=<?=$BrgyCode?>">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->

    </ul>

</aside><!-- End Sidebar-->