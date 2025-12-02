<?php
$title = "A out Us";
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
                                <div class="col-md-7 col-lg-6 login-left">
                                    <img src="assets/img/about-image.jpeg" class="img-fluid" alt="Doccure Login">
                                </div>
                            </div>
                            <br>
                            <br>
                            <h1>
                                <center>About
                            </h1>
                            </center>
                            <br>

                            <p>Foster Care Connect is a compassionate, technology-driven platform designed to reunite siblings separated within the foster care system. Many children enter care at moments of crisis, and too often, brothers and sisters are placed in different homes. This separation can deepen emotional stress and create feelings of disconnection during an already challenging time. Our mission is to bridge that gap.</p>
                            <p>Foster Care Connect uses a secure matching engine that helps caseworkers, caregivers, and agencies identify and reconnect siblings quickly and accurately. Through a combination of verified data, smart search tools, and real-time communication features, we make it easier for families to stay connected, build relationships, and maintain that critical sense of belonging.
                            </p>
                            <p>Our platform is built by a dedicated team of students and professionals who believe every child deserves love, stability, and meaningful family connections. We strive to support foster youth by giving agencies a modern, efficient tool that enhances collaboration, reduces delays, and places children’s well-being at the center of every decision.</p>
                            <p>At Foster Care Connect, we are more than a system. we are a movement for stronger families, better outcomes, and a future where no child feels alone.</p>
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