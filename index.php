<?php
session_start();
require_once 'includes/config/path.php';
require_once ROOT_PATH . 'includes/header.php';
require_once ROOT_PATH . 'includes/function.php';
$db = new Database();

//Check if foster home has data in the using country_id for USA which is 231
$foster_home_sql = "SELECT * FROM foster_homes";
$result_foster_home = $db->fetchAll($foster_home_sql);
if (empty($result_foster_home)) {
  //Insert dummy data into foster_homes table
  $insert_sql = "INSERT INTO foster_homes (foster_name, country_id, state_id, home_address, contact_number, cover_image, email, password) VALUES
    ('Happy Tails Foster Home', 231, 1, '123 Main St, Los Angeles, CA', '555-1234', 'cover1.jpg', 'dH1oX@example.com', md5('password10')),
    ('Safe Haven Foster Care', 231, 2, '456 Oak St, New York, NY', '555-5678', 'cover2.jpg', 'oV9mD@example.com', md5('password10')),
    ('Forever Friends Foster Home', 231, 3, '789 Pine St, Chicago, IL', '555-8765', 'cover3.jpg', 'a6TlO@example.com', md5('password10')),
    ('Loving Arms Foster Care', 231, 4, '321 Maple St, Houston, TX', '555-4321', 'cover4.jpg', 'qH1oX@example.com', md5('password10')),
    ('New Beginnings Foster Home', 231, 1, '654 Cedar St, Phoenix, AZ', '555-6789', 'cover5.jpg', 'lH1oX@example.com', md5('password10')),
    ('Bright Futures Foster Care', 231, 2, '987 Birch St, Philadelphia, PA', '555-9876', 'cover6.jpg', 'kH1oX@example.com', md5('password10')),
    ('Caring Hearts Foster Home', 231, 3, '147 Spruce St, San Antonio, TX', '555-2468', 'cover7.jpg', 'rH1oX@example.com', md5('password10')),
    ('Hopeful Hearts Foster Care', 231, 4, '258 Walnut St, Dallas, TX', '555-1357', 'cover8.jpg', 'wH1oX@example.com', md5('password10')),
    ('Second Chance Foster Home', 231, 1, '369 Chestnut St, San Diego, CA', '555-8642', 'cover9.jpg', 'xH1oX@example.com', md5('password10')),
    ('Healthy Hearts Foster Care', 231, 2, '789 Birch St, Austin, TX', '555-7531', 'cover10.jpg', 'yH1oX@example.com', md5('password10'));";
  $db->execute($insert_sql);
}

//Display random 4 states from USA (country_id = 231)
$state_sql = "SELECT name FROM states WHERE country_id = 231 ORDER BY RAND() LIMIT 4";
$result = $db->fetchAll($state_sql);


//Display random 8 foster homes from USA (country_id = 231)
$foster_homes = "SELECT * FROM foster_homes WHERE country_id = 231 ORDER BY RAND() LIMIT 4";
$result_foster_homes = $db->fetchAll($foster_homes);


//foster mock generate
$foster = "SELECT * FROM fosters";
$result_fosters = $db->fetchAll($foster);
if (empty($result_fosters)) {
  //Insert dummy data into foster_homes table
  $insert_sql = "INSERT INTO fosters (name, foster_home_id, email, password, address, ssn, phone_number ) VALUES
    ('Omotola Jolade', 2, 'demo@test.com', md5('1234567890'), '123 Main St, Los Angeles, CA', '123-45-6789', '555-1234')";
  $db->execute($insert_sql);
}
//morked data for fosters
$data = [
  [
    'name' => 'John Doe',
    'nickname' => 'Johnny',
    'rating' => 4.5,
    'location' => 'New York, USA',
    'image' => 'assets/img/foster/foster-1.png',
  ],
  [
    'name' => 'Jane Smith',
    'nickname' => 'Glory',
    'rating' => 4.0,
    'location' => 'San Francisco, USA',
    'image' => 'assets/img/foster/foster-2.png',

  ],
  [
    'name' => 'Alice Johnson',
    'nickname' => 'Folody',
    'rating' => 4.2,
    'location' => 'Chicago, USA',
    'image' => 'assets/img/foster/foster-3.png',

  ],
  [
    'name' => 'Bob Brown',
    'nickname' => 'Reols',
    'rating' => 3.8,
    'location' => 'Seattle, USA',
    'image' => 'assets/img/foster/foster-1.png',

  ],
  [
    'name' => 'Charlie Davis',
    'nickname' => 'Smart Guy',
    'rating' => 4.6,
    'location' => 'Austin, USA',
    'image' => 'assets/img/foster/foster-3.png',


  ],
  [
    'name' => 'Eve Wilson',
    'nickname' => 'Holde',
    'rating' => 4.3,
    'location' => 'Boston, USA',
    'image' => 'assets/img/foster/foster-2.png',
  ]
]
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
    <!-- Home Banner -->

    <!-- /Home Banner -->

    <!-- Clinic and Specialities -->
    <section class="section section-specialities">
      <div class="container-fluid">
        <div class="section-header text-center">
          <h2>State we cover</h2>
          <p class="sub-title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
        <div class="row justify-content-center">
          <div class="col-md-9">
            <!-- Slider -->
            <div class="specialities-slider slider">

              <!-- Slider Item -->
              <?php
              if (empty($result)) { ?>
                <h1>No Data available</h1>
              <?php }
              foreach ($result as $state) { ?>
                <div class="speicality-item text-center">
                  <div class="speicality-img">
                    <img src="assets/img/specialities/specialities-02.png" class="img-fluid" alt="Speciality">
                    <span><i class="fa fa-circle" aria-hidden="true"></i></span>
                  </div>
                  <p><?= $state['name'] ?></p>
                </div>
              <?php } ?>
              <!-- /Slider Item -->



            </div>
            <!-- /Slider -->

          </div>
        </div>
      </div>
    </section>
    <!-- Clinic and Specialities -->

    <!-- Popular Section -->
    <section class="section section-doctor">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4">
            <div class="section-header ">
              <h2>Fosters you may know</h2>
              <p>Lorem Ipsum is simply dummy text </p>
            </div>
            <div class="about-content">
              <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.</p>
              <p>web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes</p>
              <a href="javascript:;">Read More..</a>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="doctor-slider slider">


              <!-- Doctor Widget -->
              <?php foreach ($data as $foster) { ?>
                <div class="profile-widget">
                  <div class="doc-img">
                    <a href="#">
                      <img class="img-fluid" alt="User Image" src="<?= $foster['image'] ?>">
                    </a>
                    <a href="javascript:void(0)" class="fav-btn">
                      <i class="far fa-bookmark"></i>
                    </a>
                  </div>
                  <div class="pro-content">
                    <h3 class="title">
                      <a href="#">
                        <?= $foster['name'] ?>
                      </a>
                      <i class="fas fa-check-circle verified"></i>
                    </h3>
                    <p class="speciality"> <? $foster['nickname'] ?></p>

                    <ul class="available-info">
                      <li>
                        <i class="fas fa-map-marker-alt"></i> <?= $foster['location'] ?>
                      </li>

                    </ul>
                    <div class="row row-sm">
                      <div class="col-6">
                        <a href="#" class="btn view-btn">View Profile</a>
                      </div>
                      <div class="col-6">
                        <a href="#" class="btn book-btn">Chat Now</a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php } ?>
              <!-- /Doctor Widget -->



            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /Popular Section -->

    <!-- Availabe Features -->
    <section class="section section-features">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-5 features-img">
            <img src="assets/img/features/feature-my.png" width="220px" height="180px" class="img-fluid" alt="Feature">
          </div>
          <div class="col-md-7">
            <div class="section-header">
              <h2 class="mt-2">Foster centers near you..</h2>
              <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p>
            </div>
            <div class="features-slider slider">
              <!-- Slider Item -->

              <?php
              if (empty($result_foster_homes)) { ?>
                <h1>No Data available</h1>
              <?php }
              foreach ($result_foster_homes as $homes) { ?>
                <div class="feature-item text-center">
                  <img src="assets/img/foster_homes/cover1.jpeg" class="img-fluid" alt="Feature">
                  <p><?= $homes['foster_name'] ?></p>
                </div>
              <?php } ?>

              <!-- /Slider Item -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Availabe Features -->

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

<!-- doccure/index.html  30 Nov 2019 04:12:03 GMT -->

</html>