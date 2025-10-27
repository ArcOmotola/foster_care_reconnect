	<?php
    session_start();
    require_once('../includes/config/path.php');
    require_once('includes/head.php');
    require_once(ROOT_PATH . 'includes/function.php');
    $db = new Database();

    //get foster info
    //Display random 8 foster homes from USA (country_id = 231)
    $foster_homes = "SELECT * FROM foster_homes order by created_at LIMIT 6";
    $result_foster_homes = $db->fetchAll($foster_homes);

    //Foster
    $fosters = "SELECT * FROM fosters order by created_at LIMIT 5";
    $result_fosters = $db->fetchAll($fosters);

    //Countries
    $countries = "SELECT * FROM countries";
    $result_countries = $db->fetchAll($countries);

    ?>



	<body>

	    <!-- Main Wrapper -->
	    <div class="main-wrapper">

	        <?php require_once('includes/header.php') ?>

	        <!-- /Header -->

	        <!-- Sidebar -->
	        <?php require_once('includes/sidebar.php') ?>
	        <!-- /Sidebar -->

	        <!-- Page Wrapper -->
	        <div class="page-wrapper">

	            <div class="content container-fluid">

	                <!-- Page Header -->
	                <div class="page-header">
	                    <div class="row">
	                        <div class="col-sm-12">
	                            <h3 class="page-title">Welcome Admin!</h3>
	                            <ul class="breadcrumb">
	                                <li class="breadcrumb-item active">Dashboard</li>
	                            </ul>
	                        </div>
	                    </div>
	                </div>
	                <!-- /Page Header -->

	                <div class="content">
	                    <div class="container">

	                        <div class="row">
	                            <div class="col-md-7 col-lg-8">
	                                <div class="card">
	                                    <div class="card-body">

	                                        <!-- Checkout Form -->
	                                        <form action="../backend/admin/add-social-worker-process.php" method="post" enctype="multipart/form-data">

	                                            <!-- Personal Information -->
	                                            <div class="info-widget">
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

	                                                    <h4 class="card-title">Personal Information</h4>
	                                                <?php } ?>
	                                                <div class="row">
	                                                    <div class="col-md-6 col-sm-12">
	                                                        <div class="form-group card-label">
	                                                            <label>Country</label>
	                                                            <select name="country" id="country" class="form-control" required>
	                                                                <option value="">Select Country</option>
	                                                                <?php foreach ($result_countries as $countries) {
                                                                        echo '<option value="' . $countries['id'] . '">' . $countries['name'] . '</option>';
                                                                    } ?>
	                                                            </select>
	                                                        </div>
	                                                    </div>
	                                                    <div class="col-md-6 col-sm-12">
	                                                        <div class="form-group card-label">
	                                                            <label>State</label>
	                                                            <select name="state" id="state" class="form-control">
	                                                                <option value="">Select State</option>
	                                                            </select>
	                                                        </div>
	                                                    </div>

	                                                    <div class="col-md-6 col-sm-12">
	                                                        <div class="form-group card-label">
	                                                            <label>Name</label>
	                                                            <input class="form-control" name="foster_name" type="text" required>
	                                                        </div>
	                                                    </div>
	                                                    <div class="col-md-6 col-sm-12">
	                                                        <div class="form-group card-label">
	                                                            <label>Home Address</label>
	                                                            <input class="form-control" type="email" name="home_address" required>
	                                                        </div>
	                                                    </div>
	                                                    <div class="col-md-6 col-sm-12">
	                                                        <div class="form-group card-label">
	                                                            <label>Phone Number</label>
	                                                            <input class="form-control" type="text" required name="phone_number">
	                                                        </div>
	                                                    </div>
	                                                    <div class="col-md-6 col-sm-12">
	                                                        <div class="form-group card-label">
	                                                            <label>Email</label>
	                                                            <input class="form-control" type="email" required name="email">
	                                                        </div>
	                                                    </div>
	                                                    <div class="col-md-6 col-sm-12">
	                                                        <div class="form-group card-label">
	                                                            <label>Password</label>
	                                                            <input class="form-control" type="password" required name="password">
	                                                        </div>
	                                                    </div>
	                                                    <div class="col-md-6 col-sm-12">
	                                                        <div class="form-group card-label">
	                                                            <label>Picture</label>
	                                                            <input class="form-control" type="file" required name="cover_image">
	                                                        </div>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                            <!-- /Personal Information -->

	                                            <div class="payment-widget">

	                                                <!-- Terms Accept -->
	                                                <div class="terms-accept">
	                                                    <div class="custom-checkbox">
	                                                        <input type="checkbox" id="terms_accept" required>
	                                                        <label for="terms_accept">I have read and accept <a href="#">Terms &amp; Conditions</a></label>
	                                                    </div>
	                                                </div>
	                                                <!-- /Terms Accept -->

	                                                <!-- Submit Section -->
	                                                <div class="submit-section mt-4">
	                                                    <button type="submit" class="btn btn-primary submit-btn" name="submit">Submit</button>
	                                                </div>
	                                                <!-- /Submit Section -->

	                                            </div>
	                                        </form>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>

	                    </div>

	                </div>


	            </div>
	        </div>
	        <!-- /Page Wrapper -->

	    </div>
	    <!-- /Main Wrapper -->

	    <?php require_once('includes/script.php') ?>
	    <script>
	        $(function() {
	            // alert("hello")
	            $('#country').on('change', function() {
	                // alert('hello')
	                let country = $(this).find(":selected").val();
	                // console.log(country);
	                if (country == "") {
	                    alert('Please select a country')
	                } else {
	                    let State = $("#state").html(
	                        "<option disabled selected> Select a State </option>"
	                    );
	                    $.ajax({
	                        type: "GET",
	                        url: "../backend/state.php?country_id=" + country,
	                        dataType: "JSON",
	                        success: function(data) {
	                            // console.log(data.data);
	                            let states = data.data;
	                            let state = states.map((items) => {
	                                // console.log(items);
	                                return $("<option></option>")
	                                    .val(items.id)
	                                    .html(items.name);
	                            });
	                            State.append(state);
	                        },
	                        error: function(err) {
	                            console.log(err.message);
	                        }
	                    });
	                }

	            })
	        })
	    </script>
	</body>

	<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:34 GMT -->

	</html>