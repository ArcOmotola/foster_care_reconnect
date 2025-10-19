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
if ($_GET['uid']) {
    $user_uid = $_GET['uid'];

    //Get User Info
    $user_sql = "SELECT * FROM fosters WHERE verification_token = :user_id";
    $result_user = $db->fetch($user_sql, ['user_id' => $user_uid]);
    if (empty($result_user)) {
        header("Location: index.php?error=" . "No foster found with ID: " . $_GET['uid']);
    }

    //Foster Experience
    $foster_experiences = "SELECT * FROM foster_experiences WHERE foster_id = :foster_id";
    $result_foster_experiences = $db->fetch($foster_experiences, ['foster_id' => $result_user['id']]);

    //Foster Placement
    $foster_placements = "SELECT * FROM foster_placements WHERE foster_id = :foster_id";
    $result_foster_placements = $db->fetch($foster_placements, ['foster_id' => $result_user['id']]);

    //Foster home
    $foster_home = "SELECT * FROM foster_homes WHERE id = :foster_home_id";
    $result_home = $db->fetch($foster_home, ['foster_home_id' => $result_user['foster_home_id']]);
} else {
    header("Location: index.php?error=" . "No foster found with ID: " . $_GET['uid']);
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
                        <h2 class="breadcrumb-title">Profile</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Page Content -->
        <div class="content">
            <div class="container">

                <!-- Doctor Widget -->
                <div class="card">
                    <div class="card-body">
                        <div class="doctor-widget">
                            <div class="doc-info-left">
                                <div class="doctor-img">
                                    <img src="assets/img/doctors/doctor-thumb-02.jpg" class="img-fluid" alt="User Image">
                                </div>
                                <div class="doc-info-cont">
                                    <h4 class="doc-name"><?= $result_user['name']  ?></h4>
                                    <p class="doc-speciality"><?= $result_user['email']  ?></p>

                                    <div class="clinic-details">
                                        <p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?= $result_user['address'] ?></p>
                                        <p class="doc-location"><i class="fas fa-house"></i> Foster Home: <?= $result_home['foster_name'] ?>- </p>
                                    </div>
                                    <div class="clinic-services">
                                        <h6>Memories </h6>
                                        <br>
                                        <br>

                                        <?php
                                        // var_dump($result_foster_experiences);
                                        $memories = $result_foster_experiences['favourite_activities'];
                                        if ($memories != null) {
                                            //Explode the memory into an array
                                            $exploded_memories = explode(",", $memories);
                                            foreach ($exploded_memories as $memory) {
                                                echo '<span>' . $memory . '</span>';
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="doc-info-right">
                                <div class="clini-infos">
                                </div>
                                <div class="doctor-action">

                                </div>
                                <div class="clinic-booking">
                                    <?php
                                    $current_year = date('Y');
                                    // echo explode("-", $foster['dob'])[0];
                                    $age = $current_year - explode("-", $result_user['dob'])[0];
                                    if ($age < 18) { ?>
                                        <a class="apt-btn" href="backend/contact.php?uid=<?= $result_user['verification_token'] ?>">Contact Home</a>
                                    <?php } else { ?>
                                        <a class="apt-btn" href="backend/add-connect.php?uid=<?= $result_user['verification_token'] ?>">Add Connect</a>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Doctor Widget -->

                <!-- Doctor Details Tab -->
                <div class="card">
                    <div class="card-body pt-0">

                        <!-- Tab Menu -->
                        <nav class="user-tabs mb-4">
                            <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#doc_overview" data-toggle="tab">Overview</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#doc_business_hours" data-toggle="tab">Placements</a>
                                </li>
                            </ul>
                        </nav>
                        <!-- /Tab Menu -->

                        <!-- Tab Content -->
                        <div class="tab-content pt-0">

                            <!-- Overview Content -->
                            <div role="tabpanel" id="doc_overview" class="tab-pane fade show active">
                                <div class="row">
                                    <div class="col-md-12 col-lg-9">

                                        <!-- About Details -->
                                        <div class="widget about-widget">
                                            <h4 class="widget-title">Profile Detail</h4>
                                            <ul>
                                                <li>Name : <?= $result_user['name'] ?></li>
                                                <li>Address : <?= $result_user['address'] ?></li>
                                                <li>Phone : <?= $result_user['phone_number'] ?></li>
                                            </ul>
                                        </div>
                                        <!-- /About Details -->

                                        <!-- Education Details -->
                                        <div class="widget education-widget">
                                            <h4 class="widget-title">Education</h4>
                                            <div class="experience-box">
                                                <ul class="experience-list">
                                                    <li>
                                                        <div class="experience-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="experience-content">
                                                            <div class="timeline-content">
                                                                <a href="#" class="name"><?= $result_foster_experiences['school_name'] ?></a>
                                                                <span class="time"><?= rand(1000, 1999) . ' - ' . rand(2000, 2999) ?></span>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                        <!-- /Education Details -->

                                        <!-- Experience Details -->
                                        <div class="widget experience-widget">
                                            <h4 class="widget-title">Pets</h4>
                                            <div class="experience-box">
                                                <ul class="experience-list">
                                                    <li>
                                                        <div class="experience-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="experience-content">
                                                            <div class="timeline-content">
                                                                <a href="#/" class="name">
                                                                    <?= $result_foster_experiences['pets'] ?>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                        <!-- /Experience Details -->

                                        <!-- Awards Details -->
                                        <div class="widget awards-widget">
                                            <h4 class="widget-title">Holiday</h4>
                                            <div class="experience-box">
                                                <ul class="experience-list">
                                                    <li>
                                                        <div class="experience-user">
                                                            <div class="before-circle"></div>
                                                        </div>
                                                        <div class="experience-content">
                                                            <div class="timeline-content">
                                                                <p class="exp-year"><?= $result_foster_experiences['holidays'] ?></p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- /Awards Details -->

                                        <!-- Services List -->
                                        <div class="service-list">
                                            <h4>Memory Tags</h4>
                                            <ul class="clearfix">
                                                <?php
                                                // var_dump($result_foster_experiences);
                                                $memories = $result_foster_experiences['favourite_activities'];
                                                if ($memories != null) {
                                                    //Explode the memory into an array
                                                    $exploded_memories = explode(",", $memories);
                                                    foreach ($exploded_memories as $memory) {
                                                        echo '<li>' . $memory . '</li>';
                                                    }
                                                }
                                                ?>

                                            </ul>
                                        </div>
                                        <!-- /Services List -->



                                    </div>
                                </div>
                            </div>
                            <!-- /Overview Content -->

                            <!-- Business Hours Content -->
                            <div role="tabpanel" id="doc_business_hours" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-6 offset-md-3">

                                        <!-- Business Hours Widget -->
                                        <div class="widget business-widget">
                                            <div class="widget-content">
                                                <div class="listing-hours">
                                                    <div class="listing-day current">
                                                        <div class="day">Placement Name</span></div>
                                                        <div class="time-items">
                                                            <span class="time"><?= $result_foster_placements['placement_name'] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="listing-day">
                                                        <div class="day">Placement Reason</div>
                                                        <div class="time-items">
                                                            <span class="time"><?= $result_foster_placements['placement_reason'] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="listing-day">
                                                        <div class="day">Pickup Date</div>
                                                        <div class="time-items">
                                                            <span class="time"><?= $result_foster_placements['last_pickup_date'] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="listing-day">
                                                        <div class="day">Final placement outcome</div>
                                                        <div class="time-items">
                                                            <span class="time"><?= $result_foster_placements['final_placement_outcome'] ?></span>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Business Hours Widget -->

                                    </div>
                                </div>
                            </div>
                            <!-- /Business Hours Content -->

                        </div>
                    </div>
                </div>
                <!-- /Doctor Details Tab -->

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

    <!-- Voice Call Modal -->
    <div class="modal fade call-modal" id="voice_call">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Outgoing Call -->
                    <div class="call-box incoming-box">
                        <div class="call-wrapper">
                            <div class="call-inner">
                                <div class="call-user">
                                    <img alt="User Image" src="assets/img/doctors/doctor-thumb-02.jpg" class="call-avatar">
                                    <h4>Dr. Darren Elder</h4>
                                    <span>Connecting...</span>
                                </div>
                                <div class="call-items">
                                    <a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
                                    <a href="voice-call.html" class="btn call-item call-start"><i class="material-icons">call</i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Outgoing Call -->

                </div>
            </div>
        </div>
    </div>
    <!-- /Voice Call Modal -->

    <!-- Video Call Modal -->
    <div class="modal fade call-modal" id="video_call">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <!-- Incoming Call -->
                    <div class="call-box incoming-box">
                        <div class="call-wrapper">
                            <div class="call-inner">
                                <div class="call-user">
                                    <img class="call-avatar" src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
                                    <h4>Dr. Darren Elder</h4>
                                    <span>Calling ...</span>
                                </div>
                                <div class="call-items">
                                    <a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
                                    <a href="video-call.html" class="btn call-item call-start"><i class="material-icons">videocam</i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Incoming Call -->

                </div>
            </div>
        </div>
    </div>
    <!-- Video Call Modal -->

    <?php
    require_once ROOT_PATH . 'includes/script.php';
    ?>


</body>

<!-- doccure/doctor-profile.html  30 Nov 2019 04:12:16 GMT -->

</html>