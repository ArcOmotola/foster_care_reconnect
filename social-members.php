<?php
session_start();
require_once 'includes/config/path.php';
require_once ROOT_PATH . 'includes/header.php';
require_once ROOT_PATH . 'includes/function.php';
$db = new Database();
if (!$db->CheckLogin()) {
    header("Location: social-worker-login.php");
}
$logged_id = $_SESSION['id'];
$foster_home_sql = "SELECT * FROM foster_homes where id = :id";
$result_foster_home = $db->fetch($foster_home_sql, ['id' => $logged_id]);

//get foster child realted the house
$child_house_sql =  "SELECT * FROM fosters where foster_home_id = :foster_home_id";
$child_home_result = $db->fetchAll($child_house_sql, [
    'foster_home_id' => $logged_id
]);
if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
}
if (isset($_GET['success'])) {
    $success_message = $_GET['success'];
}


?>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <!-- /Header -->
        <?php
        require_once ROOT_PATH . 'includes/nav.php';
        ?>
        <!-- /Header -->

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-12 col-12">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
                            </ol>
                        </nav>
                        <h2 class="breadcrumb-title">Fosters list</h2>
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

                        <!-- Profile Sidebar -->
                        <div class="profile-sidebar">
                            <div class="widget-profile pro-widget-content">
                                <div class="profile-info-widget">
                                    <a href="#" class="booking-doc-img">
                                        <img src="assets/img/foster/foster-2.png" alt="User Image">
                                    </a>
                                    <div class="profile-det-info">
                                        <h3><?= $result_foster_home['foster_name'] ?></h3>

                                        <div class="patient-details">
                                            <h5 class="mb-0"><?= $result_foster_home['home_address'] ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard-widget">
                                <nav class="dashboard-menu">
                                    <ul>
                                        <li>
                                            <a href="social-members.php">
                                                <i class="fas fa-columns"></i>
                                                <span>Dashboard</span>
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="social-members.php">
                                                <i class="fas fa-calendar-check"></i>
                                                <span>Foster childs</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="logout.php">
                                                <i class="fas fa-sign-out-alt"></i>
                                                <span>Logout</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <!-- /Profile Sidebar -->

                    </div>

                    <div class="col-md-7 col-lg-8 col-xl-9">
                        <div class="appointments">

                            <!-- Appointment List -->
                            <?php if (!empty($child_home_result)) {
                                foreach ($child_home_result as $child) { ?>
                                    <div class="appointment-list">
                                        <div class="profile-info-widget">
                                            <a href="patient-profile.html" class="booking-doc-img">
                                                <img alt="User Image" src="<?= $child['profile_image'] == "" ? "assets/img/foster/foster-3.png" :  $connect['profile_image'] ?>">
                                            </a>
                                            <div class="profile-det-info">
                                                <h3><a href="#"></a></h3>
                                                <div class="patient-details">
                                                    <h5><i class="far fa-user"></i>Name : <?php echo $child['name']; ?></h5>
                                                    <h5><i class="far fa-clock"></i>Date Joined : <?php echo $child['created_at']; ?></h5>
                                                    <h5><i class="fas fa-map-marker-alt"></i> <?php echo $child['address']; ?></h5>
                                                    <h5><i class="fas fa-envelope"></i> <?php echo $child['email']; ?></h5>
                                                    <h5 class="mb-0"><i class="fas fa-phone"></i><?php echo $child['phone_number']; ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="appointment-action">
                                            <a href="" class="btn btn-sm bg-info-light">
                                                <i class="far fa-eye"></i> View
                                            </a>
                                            <?php
                                            $current_year = date('Y');
                                            $age = $current_year - explode("-", $child['dob'])[0];
                                            if ($age < 18) { ?>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-danger-light">
                                                    <i class="fas fa-times"></i> Minor
                                                </a>
                                            <?php } else { ?>
                                                <a href="javascript:void(0);" class="btn btn-sm bg-success-light">
                                                    <i class="fas fa-check"></i> Adult
                                                </a>
                                            <?php } ?>

                                        </div>
                                    </div>
                                <?php } ?>


                            <?php } else { ?>
                                <h4>No result available</h4>
                            <?php } ?>
                            <!-- /Appointment List -->

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

    <!-- Appointment Details Modal -->
    <div class="modal fade custom-modal" id="appt_details">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Appointment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="info-details">
                        <li>
                            <div class="details-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="title">#APT0001</span>
                                        <span class="text">21 Oct 2019 10:00 AM</span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-right">
                                            <button type="button" class="btn bg-success-light btn-sm" id="topup_status">Completed</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="title">Status:</span>
                            <span class="text">Completed</span>
                        </li>
                        <li>
                            <span class="title">Confirm Date:</span>
                            <span class="text">29 Jun 2019</span>
                        </li>
                        <li>
                            <span class="title">Paid Amount</span>
                            <span class="text">$450</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- /Appointment Details Modal -->

    <?php
    require_once ROOT_PATH . 'includes/script.php';
    ?>

</body>

<!-- doccure/appointments.html  30 Nov 2019 04:12:09 GMT -->

</html>