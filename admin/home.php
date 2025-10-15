<?php
session_start();
require_once('../includes/config/path.php');
require_once('includes/head.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

//Foster
$foster_homes = "SELECT * FROM foster_homes order by created_at";
$result_foster_homes = $db->fetchAll($foster_homes);
?>

<body>

	<!-- Main Wrapper -->
	<div class="main-wrapper">


		<?php require_once('includes/header.php') ?>

		<!-- /Header -->

		<!-- Sidebar -->
		<?php require_once('includes/sidebar.php') ?>
		<!-- /Sidebar -->
		<!-- /Sidebar -->

		<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content container-fluid">

				<!-- Page Header -->
				<div class="page-header">
					<div class="row">
						<div class="col-sm-7 col-auto">
							<h3 class="page-title">Social Worker</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item active">List</li>
							</ul>
						</div>
						<div class="col-sm-5 col">
							<a href="add-home.php" class="btn btn-primary float-right mt-2">Add</a>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table class="datatable table table-hover table-center mb-0">
										<thead>
											<tr>
												<th>S/N</th>
												<th>Name</th>
												<th>Email</th>
												<th>Address</th>
												<th>Phone</th>
												<th>Date joined</th>
												<!-- <th class="text-right">Actions</th> -->
											</tr>
										</thead>
										<tbody>
											<?php
											$num = 0;
											foreach ($result_foster_homes as $home) {
												$num++; ?>
												<tr>
													<td><?= $num ?></td>
													<td><?= $home['foster_name'] ?></td>
													<td><?= $home['email'] ?></td>
													<td><?= $home['home_address'] ?></td>
													<td><?= $home['contact_number'] ?></td>
													<td><?= $home['created_at'] ?></td>

													<!-- <td class="text-right">
														<div class="actions">
															<a class="btn btn-sm bg-success-light" href="#">
																<i class="fe fe-pencil"></i> Edit
															</a>
															<a class="btn btn-sm bg-danger-light">
																<i class="fe fe-trash"></i> Delete
															</a>
														</div>
													</td> -->
												</tr>
											<?php } ?>


										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Page Wrapper -->


		<!-- Add Modal -->
		<div class="modal fade" id="Add_Specialities_details" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add Specialities</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="row form-row">
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Specialities</label>
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Image</label>
										<input type="file" class="form-control">
									</div>
								</div>

							</div>
							<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /ADD Modal -->

		<!-- Edit Details Modal -->
		<div class="modal fade" id="edit_specialities_details" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit Specialities</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="row form-row">
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Specialities</label>
										<input type="text" class="form-control" value="Cardiology">
									</div>
								</div>
								<div class="col-12 col-sm-6">
									<div class="form-group">
										<label>Image</label>
										<input type="file" class="form-control">
									</div>
								</div>

							</div>
							<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /Edit Details Modal -->

		<!-- Delete Modal -->
		<div class="modal fade" id="delete_modal" aria-hidden="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<!--	<div class="modal-header">
							<h5 class="modal-title">Delete</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>-->
					<div class="modal-body">
						<div class="form-content p-2">
							<h4 class="modal-title">Delete</h4>
							<p class="mb-4">Are you sure want to delete?</p>
							<button type="button" class="btn btn-primary">Save </button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Delete Modal -->
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

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/specialities.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:51 GMT -->

</html>