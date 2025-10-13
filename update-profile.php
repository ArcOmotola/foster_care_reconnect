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

                    <div class="col-md-7 col-lg-8 col-xl-9">
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
                                <!-- Profile Settings Form -->
                                <form action="backend/update-profile.php" method="post">
                                    <div class="row form-row">
                                        <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <div class="change-avatar">
                                                    <div class="profile-img">
                                                        <img src="assets/img/patients/patient.jpg" alt="User Image" id="uploadedImage">
                                                    </div>
                                                    <div class="upload-img">
                                                        <div class="change-photo-btn">
                                                            <span><i class="fa fa-upload"></i> Upload Photo</span>
                                                            <input type="file" name="profile-image" class="upload" id="uploadImage">
                                                        </div>
                                                        <input type="hidden" name="user_id" id="user_id" value="<?= $result_user['id'] ?>">
                                                        <small class="form-text text-muted">Allowed JPG, GIF or PNG. Max size of 2MB</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input type="text" name="name" class="form-control" value="<?= $result_user['name'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" disabled name="name" class="form-control" value="<?= $result_user['email'] ?>">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <div class="cal-icon">
                                                    <input type="text" name="dob" class="form-control datetimepicker" value="<?= $result_user['dob'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label>Home Address</label>
                                                <input type="text" name="address" class="form-control" value="<?= $result_user['address'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label>SSN Number</label>
                                                <input type="text" name="ssn" class="form-control" value="<?= $result_user['ssn'] ?>">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input type="text" name="phone_number" class="form-control" value="<?= $result_user['phone_number'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button type="submit" name="submit" class="btn btn-primary submit-btn">Save Changes</button>
                                    </div>
                                </form>

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