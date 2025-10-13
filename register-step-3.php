<?php
require_once 'includes/config/path.php';
require_once ROOT_PATH . 'includes/header.php';
require_once ROOT_PATH . 'includes/function.php';
$db = new Database();

$countries = 'SELECT name, id FROM countries';
$result_countries = $db->fetchAll($countries);

$foster_home_sql = "SELECT * FROM foster_homes";
$result_foster_home = $db->fetchAll($foster_home_sql);

if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
}
if (isset($_GET['success'])) {
    $success_message = $_GET['success'];
}
if (isset($_GET['step'])) {
    $step = $_GET['step'];
}
if (isset($_GET['forster_id'])) {
    $foster_id = $_GET['forster_id'];
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
            <div class="container">

                <div class="row">
                    <div class="col-md-10 col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <!-- Checkout Form -->
                                <form action="backend/register.php" method="POST">
                                    <?php
                                    if (isset($error_message)) { ?>
                                        <div class="alert alert-fill-danger" role="alert">
                                            <i class="fa fa-exclamation-triangle"></i>
                                            <?= $error_message ?>
                                        </div>
                                    <?php } elseif (isset($success_message)) { ?>
                                        <div class="alert alert-fill-success" role="alert">
                                            <i class="fa fa-success"></i>
                                            <?= $success_message ?>
                                        </div>
                                    <?php } else { ?>

                                        <h4 class="card-title">Personal Information</h4>
                                    <?php } ?>

                                    <div class="payment-widget" id="step-2">
                                        <h4 class=" card-title">Foster experience and Fun Fact</h4>

                                        <!-- Credit Card Payment -->
                                        <div class="payment-list">

                                            <div class="row">
                                                <input type="text" name="step" id="" value="<?= $step ?>">
                                                <input type="text" name="foster_id" id="" value="<?= $foster_id ?>">
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group card-label">
                                                        <label>School Name</label>
                                                        <input class="form-control" type="text" name="school_name" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group card-label">
                                                        <label>Event Attend so far</label>
                                                        <input class="form-control" type="text" name="event_attend" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group card-label">
                                                        <label>Pet</label>
                                                        <input class="form-control" type="text" name="pet" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group card-label">
                                                        <label>Holiday</label>
                                                        <input class="form-control" type="text" name="holiday" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-sm-12">
                                                    <div class="form-group card-label">
                                                        <label>Favoriate activity Tag</label>
                                                        <input class="form-control" type="text" name="case_worker_name" required>
                                                        <textarea name="fun_fact" id="" class="form-control" placeholder="Fun fact #Mick, #Maggie #Scooby"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="terms-accept">
                                            <div class="custom-checkbox">
                                                <input type="checkbox" id="terms_accept">
                                                <label for="terms_accept">I have read and accept <a href="#">Terms &amp; Conditions</a></label>
                                            </div>
                                        </div>
                                        <!-- /Terms Accept -->

                                        <!-- Submit Section -->

                                        <!-- /Submit Section -->

                                    </div>
                                    <div class="submit-section mt-4">
                                        <button type="submit" name="register" class="btn btn-primary submit-btn" id="nextBtn">Next</button>
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

    <!-- <script src="assets/js/register.js"></script> -->
</body>

</html>