<?php
require_once 'includes/config/path.php';
require_once ROOT_PATH . 'includes/header.php';
require_once ROOT_PATH . 'includes/function.php';
$db = new Database();

$countries = 'SELECT name, id FROM countries';
$result_countries = $db->fetchAll($countries);
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
								<form action="https://dreamguys.co.in/demo/doccure/booking-success.html">

									<!-- Personal Information -->
									<div class="info-widget">
										<h4 class="card-title">Personal Information</h4>
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<div class="form-group card-label">
													<label>Full Name</label>
													<input class="form-control" type="text">
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group card-label">
													<label>SSN</label>
													<input class="form-control" type="text" placeholder="Last 4 digit for verificatioon">
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group card-label">
													<label>Email</label>
													<input class="form-control" type="email">
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group card-label">
													<label>Phone</label>
													<input class="form-control" type="text">
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group card-label">
													<label>Country</label>
													<select name="country_id" class="form-control form-control-lg" id="country" required>
														<option value="" disabled selected>Select Country</option>
														<?php
														foreach ($result_countries as $country) { ?>
															<option value="<?php echo $country['id']; ?>"><?php echo $country['name']; ?></option>
														<?php }
														?>
													</select>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group card-label">
													<label>State</label>
													<select name="state" class="form-control form-control-lg" id="state" required>
														<option value="" selected>Select State</option>
													</select>
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group card-label">
													<label>Date of birth</label>
													<input class="form-control" type="date">
												</div>
											</div>
											<div class="col-md-6 col-sm-12">
												<div class="form-group card-label">
													<label>Place of birth</label>
													<input class="form-control" type="text">
												</div>
											</div>
										</div>
										<!-- <div class="exist-customer">Existing Customer? <a href="#">Click here to login</a></div> -->
									</div>
									<!-- /Personal Information -->

									<div class="payment-widget">
										<h4 class="card-title">Foster Care History</h4>

										<!-- Credit Card Payment -->
										<div class="payment-list">

											<div class="row">
												<div class="col-md-6">
													<div class="form-group card-label">
														<label for="card_name">Name on Card</label>
														<input class="form-control" id="card_name" type="text">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group card-label">
														<label for="card_number">Card Number</label>
														<input class="form-control" id="card_number" placeholder="1234  5678  9876  5432" type="text">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group card-label">
														<label for="expiry_month">Expiry Month</label>
														<input class="form-control" id="expiry_month" placeholder="MM" type="text">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group card-label">
														<label for="expiry_year">Expiry Year</label>
														<input class="form-control" id="expiry_year" placeholder="YY" type="text">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group card-label">
														<label for="cvv">CVV</label>
														<input class="form-control" id="cvv" type="text">
													</div>
												</div>
											</div>
										</div>
										<!-- /Credit Card Payment -->

										<!-- Paypal Payment -->
										<h4 class="card-title">Placement History</h4>

										<!-- Credit Card Payment -->
										<div class="payment-list">

											<div class="row">
												<div class="col-md-6">
													<div class="form-group card-label">
														<label for="card_name">Name on Card</label>
														<input class="form-control" id="card_name" type="text">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group card-label">
														<label for="card_number">Card Number</label>
														<input class="form-control" id="card_number" placeholder="1234  5678  9876  5432" type="text">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group card-label">
														<label for="expiry_month">Expiry Month</label>
														<input class="form-control" id="expiry_month" placeholder="MM" type="text">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group card-label">
														<label for="expiry_year">Expiry Year</label>
														<input class="form-control" id="expiry_year" placeholder="YY" type="text">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group card-label">
														<label for="cvv">CVV</label>
														<input class="form-control" id="cvv" type="text">
													</div>
												</div>
											</div>
										</div>
										<!-- /Paypal Payment -->

										<!-- Terms Accept -->
										<div class="terms-accept">
											<div class="custom-checkbox">
												<input type="checkbox" id="terms_accept">
												<label for="terms_accept">I have read and accept <a href="#">Terms &amp; Conditions</a></label>
											</div>
										</div>
										<!-- /Terms Accept -->

										<!-- Submit Section -->
										<div class="submit-section mt-4">
											<button type="submit" class="btn btn-primary submit-btn">Register</button>
										</div>
										<!-- /Submit Section -->

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
						url: "backend/state.php?country_id=" + country,
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

</html>