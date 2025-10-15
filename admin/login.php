<?php
require_once('includes/head.php');

if (isset($_GET['error'])) {
	$error_message = $_GET['error'];
}
if (isset($_GET['success'])) {
	$success_message = $_GET['success'];
}
?>

<body>

	<!-- Main Wrapper -->
	<div class="main-wrapper login-body">
		<div class="login-wrapper">
			<div class="container">
				<div class="loginbox">
					<div class="login-left">
						<img class="img-fluid" src="../assets/img/logo.png" alt="Logo">
					</div>
					<div class="login-right">
						<div class="login-right-wrap">

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

								<h1>Admin Login</h1>
								<p class="account-subtitle">Access to admin dashboard</p>

							<?php } ?>

							<form action="../backend/admin/login.php" method="post">
								<div class="form-group">
									<input class="form-control" name="email" type="text" placeholder="Email" required>
								</div>
								<div class="form-group">
									<input class="form-control" type="password" name="password" placeholder="Password" required>
								</div>
								<div class="form-group">
									<button class="btn btn-primary btn-block" name="submit" type="submit">Login</button>
								</div>
							</form>
							<!-- /Form -->

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="assets/js/jquery-3.2.1.min.js"></script>

	<!-- Bootstrap Core JS -->
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- Custom JS -->
	<script src="assets/js/script.js"></script>

</body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:46 GMT -->

</html>