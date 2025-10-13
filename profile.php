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

                        <!-- Profile Widget -->

                        <!-- /Profile Widget -->

                        <?php require_once  ROOT_PATH . 'profile-menu.php'; ?>
                        <!-- Last Booking -->

                        <!-- /Last Booking -->

                    </div>

                    <div class="col-md-7 col-lg-8 col-xl-9 dct-appoinment">
                        <div class="card">
                            <div class="card-body pt-0">
                                <div class="user-tabs">
                                    <ul class="nav nav-tabs nav-tabs-bottom nav-justified flex-wrap">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#pat_appointments" data-toggle="tab">Fosters friends</a>
                                        </li>

                                    </ul>
                                </div>
                                <div class="tab-content">

                                    <!-- Appointment Tab -->
                                    <div id="pat_appointments" class="tab-pane fade show active">
                                        <div class="card card-table mb-0">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-center mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th>Connected Date</th>
                                                                <th>Last chat</th>
                                                                <th>Status</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <h2 class="table-avatar">
                                                                        <a href="doctor-profile.html" class="avatar avatar-sm mr-2">
                                                                            <img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
                                                                        </a>
                                                                        <a href="doctor-profile.html">Filter Elder </a>
                                                                    </h2>
                                                                </td>
                                                                <td>14 Nov 2019 <span class="d-block text-info">10.00 AM</span></td>
                                                                <td>16 Nov 2019</td>
                                                                <td><span class="badge badge-pill bg-success-light">Confirm</span></td>
                                                                <td class="text-right">
                                                                    <div class="table-action">
                                                                        <a href="javascript:void(0);" class="btn btn-sm bg-success-light">
                                                                            <i class="far fa-edit"></i> Edit
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
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

    <!-- Add Medical Records Modal -->
    <div class="modal fade custom-modal" id="add_medical_records">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Medical Records</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="text" class="form-control datetimepicker" value="31-10-2019">
                        </div>
                        <div class="form-group">
                            <label>Description ( Optional )</label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Upload File</label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="submit-section text-center">
                            <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                            <button type="button" class="btn btn-secondary submit-btn" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Medical Records Modal -->

    <?php
    require_once ROOT_PATH . 'includes/script.php';
    ?>

</body>

<!-- doccure/patient-profile.html  30 Nov 2019 04:12:13 GMT -->

</html>