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


$connect_sql = "SELECT fosters.*, foster_connects.* FROM foster_connects 
JOIN fosters on fosters.id = foster_connects.connect_id
WHERE (foster_id = :foster_id)
ORDER BY foster_connects.created_at DESC";
$connect_users = $db->fetchAll($connect_sql, ['foster_id' => $user_id]);

$connect_sql_2 = "SELECT fosters.*, foster_connects.* FROM foster_connects 
JOIN fosters on fosters.id = foster_connects.foster_id
WHERE (connect_id = :foster_id)
ORDER BY foster_connects.created_at DESC";
$connect_users_2 = $db->fetchAll($connect_sql_2, ['foster_id' => $user_id]);
$merge_result = array_merge($connect_users, $connect_users_2);



//App notifications
$app_sql = "SELECT * FROM app_notifications WHERE foster_id = :foster_id";
$app_notifications = $db->fetch($app_sql, ['foster_id' => $user_id]);
if (empty($app_notifications)) {
    $count_notification = 0;
} else {
    $count_notification = count($app_notifications);
}
// var_dump($app_notifications);
?>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php
        require_once ROOT_PATH . 'includes/header.php';
        ?>
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
                                <li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile</li>
                            </ol>
                        </nav>
                        <h2 class="breadcrumb-title">Profile</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Page Content -->
        <div class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar dct-dashbd-lft">

                        <?php require_once  ROOT_PATH . 'profile-menu.php'; ?>


                    </div>

                    <div class="col-md-7 col-lg-8 col-xl-9">
                        <center>
                            <h2 class="center text-info mb-4">Foster friends</h2>
                        </center>
                        <div class="row row-grid">
                            <?php
                            if (!empty($merge_result)) {
                                foreach ($merge_result as $connect) { ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="card widget-profile pat-widget-profile">
                                            <div class="card-body">
                                                <div class="pro-widget-content">
                                                    <div class="profile-info-widget">
                                                        <a href="my-profile.php?uid=<?= $connect['verification_token'] ?>" class="booking-doc-img">
                                                            <img class="img-fluid" alt="User Image" src="<?= $connect['profile_image'] == "" ? "assets/img/foster/foster-3.png" :  $connect['profile_image'] ?>">
                                                        </a>
                                                        <div class="profile-det-info">
                                                            <h3><a href="my-profile.php?uid=<?= $connect['verification_token'] ?>"><?= $connect['name'] ?></a></h3>

                                                            <div class="patient-details">
                                                                <h5><b>Phone Number :</b> <?= $connect['phone_number'] ?></h5>
                                                                <!-- <h5 class="mb-0"><i class="fas fa-map-marker-alt">Address :</i> <?= $connect['address'] ?></h5> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="patient-info">
                                                    <ul>
                                                        <li>Phone <span><?= $connect['phone_number'] ?></span></li>
                                                        <li>Date of Birth <span><?= $connect['dob'] ?></span></li>
                                                        <?php if ($connect['status'] == "pending") {
                                                            echo "<li><button type=\"button\" class=\"btn btn-warning\">Pending</button></li>";
                                                        } elseif ($connect['status'] == "accepted") {
                                                            echo "<li><button type=\"button\" class=\"btn btn-success\">Accepted</button></li>";
                                                        } else {
                                                            echo "<li><button type=\"button\" class=\"btn btn-danger\">Rejected</button></li>";
                                                        } ?>
                                                        <!-- <li><button type="button" class="btn btn-rounded btn-warning">Warning</button></li> -->

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } else {
                                echo "<h1>No foster friends</h1>";
                            } ?>
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

<!-- doccure/patient-profile.html  30 Nov 2019 04:12:13 GMT -->

</html>