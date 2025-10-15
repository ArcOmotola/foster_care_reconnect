	<?php
	session_start();
	require_once('../includes/config/path.php');
	require_once('includes/head.php');
	require_once(ROOT_PATH . 'includes/function.php');
	$db = new Database();

	//Foster
	$fosters = "SELECT * FROM fosters order by created_at";
	$result_fosters = $db->fetchAll($fosters);
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
								<h3 class="page-title">Foster Child</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item active">Lists</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<div class="row">
						<div class="col-md-12">

							<!-- Recent Orders -->
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>S/N</th>
													<th>Name</th>
													<th>Email</th>
													<th>SSN</th>
													<th>Phone</th>
													<th class="text-right">Age</th>
													<th>Date Joined</th>
													<th>Action</th>
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
																<a href="profile.html" class="avatar avatar-sm mr-2"><img class="avatar-img rounded-circle" src="assets/img/doctors/doctor-thumb-01.jpeg" alt="User Image"></a>
																<a href="#"><?= $foster['name'] ?></a>
															</h2>
														</td>
														<td><?= $foster['email'] ?></td>
														<td><?= $foster['phone_number'] ?></td>
														<td><?= $foster['ssn'] ?></td>
														<td>
															<?php
															$current_year = date('Y');
															$age = $current_year - explode("-", $foster['dob'])[0];
															echo $age;
															?>
														</td>
														<td class="text-right">
															<?= $foster['created_at'] ?>
														</td>
														<td class="text-right">
															<div class="actions">
																<a class="btn btn-sm bg-success-light" href="#">
																	<i class="fe fe-pencil"></i> Edit
																</a>
																<a href="../backend/admin/delete-foster.php?id=<?= $foster['id'] ?>" class="btn btn-sm bg-danger-light">
																	<i class="fe fe-trash"></i> Delete
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
							<!-- /Recent Orders -->

						</div>
					</div>
				</div>
			</div>
			<!-- /Page Wrapper -->

		</div>
		<!-- /Main Wrapper -->

		<!-- jQuery -->
		<script src="assets/js/jquery-3.2.1.min.js"></script>

		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- Slimscroll JS -->
		<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

		<!-- Datatables JS -->
		<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatables/datatables.min.js"></script>

		<!-- Custom JS -->
		<script src="assets/js/script.js"></script>

	</body>

	<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/appointment-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:49 GMT -->

	</html>