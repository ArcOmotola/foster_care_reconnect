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


$connect_sql_2 = "SELECT fosters.*, foster_connects.* FROM foster_connects 
JOIN fosters on fosters.id = foster_connects.foster_id
WHERE (connect_id = :foster_id AND foster_connects.status = 'pending')
ORDER BY foster_connects.created_at DESC";
$connect_users_2 = $db->fetchAll($connect_sql_2, ['foster_id' => $user_id]);
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
                                <li class="breadcrumb-item active" aria-current="page">Reconnection Requests</li>
                            </ol>
                        </nav>
                        <h2 class="breadcrumb-title">Request</h2>
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

                            <h4 class="mb-4">Reconnection Requests</h4>

                        <?php } ?>
                        <div class="appointment-tab">

                            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#upcoming-appointments" data-toggle="tab">New requests</a>
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
                                                            <th>Foster Name</th>
                                                            <th>Date</th>
                                                            <th>Adress</th>
                                                            <th>Phone Number</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($connect_users_2 as $connect_user) { ?>
                                                            <tr>
                                                                <td>
                                                                    <h2 class="table-avatar">
                                                                        <a href="my-profile.php?uid=<?= $connect_user['verification_token'] ?>" class="avatar avatar-sm mr-2">
                                                                            <img class="avatar-img rounded-circle" alt="User Image" src="<?= $connect_user['profile_image'] == "" ? "assets/img/foster/foster-3.png" :  $connect_user['profile_image'] ?>">
                                                                        </a>
                                                                        <a href="my-profile.php?uid=<?= $connect_user['verification_token'] ?>">
                                                                            <?= $connect_user['name'] ?> <span>#<?= md5($connect_user['id']) ?></span>
                                                                        </a>
                                                                    </h2>
                                                                </td>
                                                                <td><?= $connect_user['created_at'] ?></span></td>
                                                                <td><?= $connect_user['address'] ?></td>
                                                                <td><?= $connect_user['phone_number'] ?></td>
                                                                <td class="text-right">
                                                                    <div class="table-action">
                                                                        <a href="backend/accept-reject-connection.php?connection_id=<?= $connect_user['id'] . "&action=accepted" ?>" class="btn btn-sm bg-success-light">
                                                                            <i class="fas fa-check"></i> Accept
                                                                        </a>
                                                                        <a href="backend/accept-reject-connection.php?connection_id=<?= $connect_user['id'] . "&action=rejected" ?>" class="btn btn-sm bg-danger-light">
                                                                            <i class="fas fa-times"></i> Reject
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