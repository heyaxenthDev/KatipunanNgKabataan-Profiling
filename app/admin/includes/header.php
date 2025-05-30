<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Administrative - Katipunan ng Kabataan Profiling System</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.ico" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>


</head>

<body>

    <?php
    // Get session user details
    $id = $_SESSION['user']['id'];
    $user_username = $_SESSION['user']['user_username'];

    $query = "SELECT * FROM `accounts` WHERE `id` = '$id' AND `username` = '$user_username' AND `role` = 'Administrative'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $user = substr($row['firstname'], 0, 1) . ". " . $row['lastname'];
            $fullname = $row['firstname'] . " " . $row['lastname'];
            $firstname = $row['firstname'];
            $role = $row['role'];
            $email = $row['email'];
            $email_verify_status = $row['email_verify'];
            $lastname = $row['lastname'];
            $username = $row['username'];
            $user_picture = $row['picture'];
            $dc = date("M d, Y", strtotime($row['date_created']));

        }
    }

    $notif_query = "SELECT * FROM notifications WHERE sent_to = '$id' ORDER BY created_at DESC LIMIT 10";
    $notif_result = mysqli_query($conn, $notif_query);
    $notifications = [];
    $unread_count = 0;
    if ($notif_result && mysqli_num_rows($notif_result) > 0) {
        while ($notif = mysqli_fetch_assoc($notif_result)) {
            $notifications[] = $notif;
            if ($notif['status'] == 'unread') $unread_count++;
        }
    }

    $typeIcons = [
        'approval' => 'bi-check-circle text-success',
        'rejection' => 'bi-x-circle text-danger',
        'revision' => 'bi-pencil-square text-warning',
        'info' => 'bi-info-circle text-primary'
    ];
    ?>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="assets/img/SK Logo-white.png" alt="">
                <span class="d-none d-lg-block">KKPS</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <?php if ($unread_count > 0): ?>
                        <span class="badge bg-primary badge-number"><?= $unread_count ?></span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have <?= $unread_count ?> new notification<?= $unread_count == 1 ? '' : 's' ?>
                            <a href="#" onclick="markAllRead(event)"><span
                                    class="badge rounded-pill bg-primary p-2 ms-2">Mark all as read</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <?php if (count($notifications) > 0): ?>
                        <?php foreach ($notifications as $notif): ?>
                        <li class="notification-item<?= $notif['status'] == 'unread' ? ' bg-light' : '' ?>">
                            <i class="bi <?= $typeIcons[$notif['type']] ?? $typeIcons['info'] ?>"></i>
                            <div>
                                <?php if (!empty($notif['link'])): ?>
                                <a href="<?= htmlspecialchars($notif['link']) ?>" style="text-decoration:none;">
                                    <p><?= htmlspecialchars($notif['message']) ?></p>
                                </a>
                                <?php else: ?>
                                <p><?= htmlspecialchars($notif['message']) ?></p>
                                <?php endif; ?>
                                <small
                                    class="text-muted"><?= date('M d, Y h:i A', strtotime($notif['created_at'])) ?></small>
                                <a href="#" onclick="markNotifRead(<?= $notif['id'] ?>, event)" title="Mark as read"><i
                                        class="bi bi-check2-circle"></i></a>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <li class="notification-item">
                            <div>
                                <p>No notifications.</p>
                            </div>
                        </li>
                        <?php endif; ?>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="<?= $user_picture?>" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $user?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $fullname?></h6>
                            <span><?= $role?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="user-profile.php">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="user-profile.php">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center"
                                href="\KatipunanNgKabataan-Profiling/admin-logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->


            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <script>
    function markAllRead(e) {
        e.preventDefault();
        fetch('mark_notifications_read.php', {
                method: 'POST'
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
            });
    }

    function markNotifRead(id, e) {
        e.preventDefault();
        fetch('mark_notification_read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(id)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) location.reload();
            });
    }
    </script>