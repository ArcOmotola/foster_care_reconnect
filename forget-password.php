<?php
$title = "Reset Password";
require_once 'includes/config/path.php';
require_once ROOT_PATH . 'includes/header.php';
require_once ROOT_PATH . 'includes/function.php';
$db = new Database();

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
        <?php
        require_once ROOT_PATH . 'includes/header.php';
        ?>
        <!-- /Header -->
        <?php
        require_once ROOT_PATH . 'includes/nav.php';
        ?>
        <!-- Page Content -->
        <div class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-8 offset-md-2">

                        <!-- Login Tab Content -->
                        <div class="account-content">
                            <div class="row align-items-center justify-content-center">
                                <!-- <div class="col-md-7 col-lg-6 login-left">
									<img src="assets/img/login-banner.png" class="img-fluid" alt="Doccure Login">
								</div> -->
                                <div class="col-md-12 col-lg-6 login-right">
                                    <div class="login-header">
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

                                            <h4>Reset Password !</h4>

                                        <?php } ?>

                                    </div>

                                    <form method="post" action="backend/reset-password.php">
                                        <div class="form-group form-focus">
                                            <input type="email" name="email" required class="form-control floating" placeholder="Enter your email" value="<?php if (isset($email)) {
                                                                                                                                                                echo $email;
                                                                                                                                                            } ?>">
                                            <label class="focus-label">Email</label>
                                        </div>
                                        <button name="submit" type="submit" class="btn btn-primary btn-block btn-lg login-btn">Reset Password</button>
                                        <div class="text-center dont-have">Login <a href="login.php">Login</a></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /Login Tab Content -->

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

</html>