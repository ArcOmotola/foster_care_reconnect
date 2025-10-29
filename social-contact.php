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

if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
}

//Get foster info
$user_id = $_SESSION['id'];

$user_sql = "SELECT * FROM fosters WHERE id = :user_id";
$result_user = $db->fetch($user_sql, ['user_id' => $user_id]);

$logged_sql = "SELECT * FROM loggers WHERE foster_id = :foster_id ORDER BY id DESC LIMIT 10";
$result_logged = $db->fetch($logged_sql, ['foster_id' => $user_id]);
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
                                <li class="breadcrumb-item"><a href="index-2.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
                            </ol>
                        </nav>
                        <h2 class="breadcrumb-title">Profile Settings</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Page Content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">



                    <!-- Profile Sidebar -->
                    <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">
                        <?php require_once  ROOT_PATH . 'profile-menu.php'; ?>

                    </div>
                    <!-- /Profile Sidebar -->

                    <div class="col-md-7 col-lg-8">
                        <div class="card">
                            <div class="card-body">
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
                                <?php } ?>

                                <!-- Checkout Form -->
                                <form action="backend/contact-social.php" method="post">
                                    <input type="hidden" name="uid" value="<?= $uid ?>">
                                    <!-- Personal Information -->
                                    <div class="info-widget">
                                        <h4 class="card-title">Message</h4>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group card-label">
                                                    <label>Title</label>
                                                    <input class="form-control" type="text" name="title" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group card-label">
                                                    <label>Message</label>
                                                    <textarea class="form-control" rows="4" name="message" required></textarea>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /Personal Information -->

                                    <div class="payment-widget">

                                        <!-- Submit Section -->
                                        <div class="submit-section mt-4">
                                            <button type="submit" name="submit" class="btn btn-primary submit-btn">Send Message</button>
                                        </div>
                                        <!-- /Submit Section -->

                                    </div>
                                </form>
                                <!-- /Checkout Form -->

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
    <script src="assets/js/uploadImage.js"></script>
</body>

</html>