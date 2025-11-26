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

	//Foster
	$fosters_count = "SELECT * FROM fosters";
	$result_foster_count = $db->fetchAll($fosters_count);

	$foster_home_count = "SELECT * FROM foster_homes";
	$result_foster_home_count = $db->fetchAll($foster_home_count);
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

					<div class="row">
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-primary border-primary">
											<i class="fe fe-users"></i>
										</span>
										<div class="dash-count">
											<h3><?= count($result_foster_home_count) ?></h3>
										</div>
									</div>
									<div class="dash-widget-info">
										<h6 class="text-muted">Social Care</h6>
										<div class="progress progress-sm">
											<div class="progress-bar bg-primary w-50"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-success">
											<i class="fe fe-user"></i>
										</span>
										<div class="dash-count">
											<h3><?= count($result_foster_count) ?></h3>
										</div>
									</div>
									<div class="dash-widget-info">

										<h6 class="text-muted">Foster child</h6>
										<div class="progress progress-sm">
											<div class="progress-bar bg-success w-50"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- <div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-danger border-danger">
											<i class="fe fe-user"></i>
										</span>
										<div class="dash-count">
											<h3>5</h3>
										</div>
									</div>
									<div class="dash-widget-info">

										<h6 class="text-muted">Minor</h6>
										<div class="progress progress-sm">
											<div class="progress-bar bg-danger w-50"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-warning border-warning">
											<i class="fe fe-user"></i>
										</span>
										<div class="dash-count">
											<h3>5</h3>
										</div>
									</div>
									<div class="dash-widget-info">

										<h6 class="text-muted">Adult</h6>
										<div class="progress progress-sm">
											<div class="progress-bar bg-warning w-50"></div>
										</div>
									</div>
								</div>
							</div>
						</div> -->
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-6">

							<!-- Sales Chart -->

							<!-- /Sales Chart -->

						</div>

					</div>
					<div class="row">
						<div class="col-md-6 d-flex">

							<!-- Recent Orders -->
							<div class="card card-table flex-fill">
								<div class="card-header">
									<h4 class="card-title">Recent foster Child</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>SN</th>
													<th>Doctor Name</th>
													<th>Email</th>
													<th>Phone</th>
													<th>SSN</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$num = 0;
												foreach ($result_fosters as $foster) {
													$num++;
												?>
													<tr>
														<td><?= $num ?></td>
														<td>
															<h2 class="table-avatar">
																<a href="#" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-01.jpeg" alt="User Image"></a>
																<a href="profile.html"><?= $foster['name'] ?></a>
															</h2>
														</td>
														<td><?= $foster['email'] ?></td>
														<td><?= $foster['phone_number'] ?></td>
														<td><?= $foster['ssn'] ?></td>

													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /Recent Orders -->

						</div>
						<div class="col-md-6 d-flex">

							<!-- Feed Activity -->
							<div class="card  card-table flex-fill">
								<div class="card-header">
									<h4 class="card-title">Recent Social Care</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>S/N</th>
													<th>Care Name</th>
													<th>Address</th>
													<th>Email</th>
													<th>Phone</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$num = 0;
												foreach ($result_foster_homes as $home) {
													$num++;
												?>
													<tr>
														<td><?= $num ?></td>
														<td>
															<h2 class="table-avatar">
																<a href="#"><?= $home['foster_name'] ?></a>
															</h2>
														</td>
														<td><?= $home['home_address'] ?></td>
														<td class="text-right"><?= $home['email'] ?></td>
														<td><?= $home['contact_number'] ?></td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /Feed Activity -->

						</div>
					</div>


				</div>
			</div>
			<!-- /Page Wrapper -->

		</div>
		<!-- /Main Wrapper -->

		<?php require_once('includes/script.php') ?>
	</body>

	<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:34 GMT -->

	</html>