<?php
session_start();
require_once 'includes/config/path.php';
require_once ROOT_PATH . 'includes/header.php';
require_once ROOT_PATH . 'includes/function.php';
$db = new Database();

//Check if user is logged In
if (!$db->CheckLogin()) {
    header("Location: login.php");
}

if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
}

if (isset($_GET['success'])) {
    $success_message = $_GET['success'];
}

//Get foster info
$user_id = $_SESSION['id'];

$user_sql = "SELECT * FROM fosters WHERE id = :user_id";
$result_user = $db->fetch($user_sql, ['user_id' => $user_id]);

$app_sql = "SELECT * FROM app_notifications WHERE foster_id = :foster_id";
$app_notifications = $db->fetch($app_sql, ['foster_id' => $user_id]);

// var_dump($connect_users_2);
?>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->

        <!-- /Header -->
        <?php
        require_once ROOT_PATH . 'includes/nav.php';
        ?>

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-12 col-12">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Notifications</li>
                            </ol>
                        </nav>
                        <h2 class="breadcrumb-title">Notifications</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Page Content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                        <?php require_once  ROOT_PATH . 'profile-menu.php'; ?>
                    </div>

                    <div class="col-md-7 col-lg-8 col-xl-9">
                        <?php
                        if (isset($error_message)) { ?>

                            <div class="alert alert-danger alert-dismissible fade show" role="alert">

                                <strong>Error!</strong> <?= $error_message ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } elseif (isset($success_message)) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">

                                <strong>Success!</strong><?= $success_message ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } else { ?>

                            <h4 class="mb-4">App Notifications</h4>

                        <?php } ?>
                        <div class="appointment-tab">

                            <!-- Appointment Tab -->
                            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#upcoming-appointments" data-toggle="tab">Notifications</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!-- Upcoming Appointment Tab -->
                                <div class="tab-pane show active" id="upcoming-appointments">
                                    <div class="card card-table mb-0">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-center mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>S/N</th>
                                                            <th>Message</th>
                                                            <th>Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (empty($app_notifications)) {
                                                            echo "<tr><td colspan='4'>No notifications found</td></tr>";
                                                            exit;
                                                        }
                                                        $sn = 0;
                                                        foreach ($app_notifications as $app_notification) {
                                                            $sn++;
                                                        ?>
                                                            <tr>
                                                                <td>
                                                                    <?= $sn ?>
                                                                </td>
                                                                <td><?= $app_notifications['message'] ?></span></td>
                                                                <td><?= $app_notifications['created_at'] ?></td>
                                                                <td class="text-right">
                                                                    <div class="table-action">
                                                                        <a href="backend/accept-reject-connection.php?connection_id=<?= $app_notifications['id'] . "&action=delete" ?>" class="btn btn-sm bg-danger-light">
                                                                            <i class="fas fa-times"></i> Delete
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Upcoming Appointment Tab -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /Page Content -->

        <!-- Footer -->
        <?php
        require_once ROOT_PATH . 'includes/footer.php';
        ?>
        <!-- /Footer -->

    </div>
    <!-- /Main Wrapper -->
    <?php
    require_once ROOT_PATH . 'includes/script.php';
    ?>

</body>

<!-- doccure/doctor-profile-settings.html  30 Nov 2019 04:12:15 GMT -->

</html>