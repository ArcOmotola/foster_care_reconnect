
<?php
require_once 'includes/config/path.php';
require_once ROOT_PATH.'includes/header.php';
require_once ROOT_PATH.'includes/function.php';
$db = new Database();
?>

<body>

  <!-- Main Wrapper -->
  <div class="main-wrapper">
    <!-- Header -->
    <?php
    require_once ROOT_PATH.'includes/header.php';
?>
    <!-- /Header -->
<?php
require_once ROOT_PATH.'includes/nav.php';
?>	
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					
					<div class="row">
						<div class="col-md-8 offset-md-2">
								
							<!-- Register Content -->
							<div class="account-content">
								<div class="row align-items-center justify-content-center">
									<div class="col-md-7 col-lg-6 login-left">
										<img src="assets/img/login-banner.png" class="img-fluid" alt="Doccure Register">	
									</div>
									<div class="col-md-12 col-lg-6 login-right">
										<div class="login-header">
											<h3>Foster Register</h3>
										</div>
										
										<!-- Register Form -->
										<form action="#" method="post">
											<div class="form-group form-focus">
												<input type="text" class="form-control floating">
												<label class="focus-label">Name</label>
											</div>
											<div class="form-group form-focus">
												<input type="text" class="form-control floating">
												<label class="focus-label">Mobile Number</label>
											</div>
											<div class="form-group form-focus">
												<input type="password" class="form-control floating">
												<label class="focus-label">Create Password</label>
											</div>
											<div class="text-right">
												<a class="forgot-link" href="login.php">Already have an account?</a>
											</div>
											<button class="btn btn-primary btn-block btn-lg login-btn" type="submit">Signup</button>
											
										</form>
										<!-- /Register Form -->
										
									</div>
								</div>
							</div>
							<!-- /Register Content -->
								
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
	    <!-- Footer -->
    <?php
require_once ROOT_PATH.'includes/footer.php';
?>
    <!-- /Footer -->

  </div>
  <!-- /Main Wrapper -->

  <?php
  require_once ROOT_PATH.'includes/script.php';
?>

</body>
</html>	