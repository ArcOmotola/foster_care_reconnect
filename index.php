<?php
session_start();
require_once 'includes/config/path.php';
require_once ROOT_PATH . 'includes/header.php';
require_once ROOT_PATH . 'includes/function.php';
$db = new Database();

//Check if foster home has data in the using country_id for USA which is 231
$foster_home_sql = "SELECT * FROM foster_homes";
$result_foster_home = $db->fetchAll($foster_home_sql);

//Display random 4 states from USA (country_id = 231)
$state_sql = "SELECT name FROM states WHERE country_id = 231 ORDER BY RAND() LIMIT 4";
$result = $db->fetchAll($state_sql);


//Admin
$admin_sql = "SELECT * FROM admins";
$admins = $db->fetchAll($admin_sql);
if (empty($admins)) {
  //Insert dummy data into foster_homes table
  $insert_sql = "INSERT INTO admins (email, password) VALUES
    ('admin@test.com', md5('1234567890'))";
  $db->execute($insert_sql);
}


//Display random 8 foster homes from USA (country_id = 231)
$foster_homes = "SELECT * FROM foster_homes WHERE country_id = 231 ORDER BY RAND() LIMIT 4";
$result_foster_homes = $db->fetchAll($foster_homes);


//foster mock generate
$foster = "SELECT * FROM fosters";
$result_fosters = $db->fetchAll($foster);
// if (empty($result_fosters)) {
//   //Insert dummy data into foster_homes table
//   $insert_sql = "INSERT INTO fosters (name, foster_home_id, email, password, address, ssn, phone_number ) VALUES
//     ('Omotola Jolade', 2, 'demo@test.com', md5('1234567890'), '123 Main St, Los Angeles, CA', '123-45-6789', '555-1234')";
//   $db->execute($insert_sql);
// }

$random_fosters = "SELECT * FROM fosters ORDER BY RAND() LIMIT 6";
$result_fosters = $db->fetchAll($random_fosters);



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

    <?php if (isset($_SESSION['last_login_time'])) { ?>
      <!-- Home Banner -->

      <section class="section section-search">
        <div class="container-fluid">
          <div class="banner-wrapper">
            <div class="banner-header text-center">
              <h4>Welcome <b class="text-primary"><?= $_SESSION['name'] ?></b>
              </h4>
              <h1>Search Foster, Connect with friends</h1>
            </div>

            <!-- Search -->
            <div class="search-box">
              <form action="search.php" method="get">
                <div class="form-group search-info">
                  <input type="text" class="form-control" placeholder="Search name" name="search">
                  <span class="form-text">Ex : City, State or Name for Check up etc</span>
                </div>
                <button type="submit" class="btn btn-primary search-btn"><i class="fas fa-search"></i> <span>Search</span></button>
              </form>
            </div>
          </div>
        </div>
      </section>
      <!-- /Home Banner -->
    <?php } else { ?>
      <!-- Clinic and Specialities -->
      <section class="section section-specialities">
        <div class="container-fluid">
          <div class="section-header text-center">
            <h2>Find your long lost loved ones</h2>
            <p class="sub-title">Reconnect Coverage.</p>
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
    <?php } ?>


    <!-- Clinic and Specialities -->

    <!-- Popular Section -->
    <section class="section section-doctor">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4">
            <div class="section-header ">
              <h2>People you may know</h2>
              <p>When loved ones drift apart, we map a way back. Search, verify, and reconnect with the people who matter most safely and simply.</p>
            </div>
            <div class="about-content">
              <!-- <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum.</p>
              <p>web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes</p>
              <a href="javascript:;">Read More..</a> -->
            </div>
          </div>
          <div class="col-lg-8">
            <div class="doctor-slider slider">


              <!-- Doctor Widget -->
              <?php foreach ($result_fosters as $foster) { ?>
                <div class="profile-widget">
                  <div class="doc-img">
                    <a href="#">
                      <img class="img-fluid" alt="User Image" src="<?= $foster['profile_image'] == "" ? "assets/img/foster/foster-3.png" :  $foster['profile_image'] ?>">
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
                    <p class="speciality"> <?= $foster['ssn'] ?></p>

                    <ul class="available-info">
                      <li>
                        <i class="fas fa-map-marker-alt"></i> <?= $foster['phone_number'] ?>
                      </li>
                      <li>
                        <?php
                        $current_year = date('Y');
                        // echo explode("-", $foster['dob'])[0];
                        $age = $current_year - explode("-", $foster['dob'])[0];
                        ?>
                        <i class="fas fa-map-marker-alt"></i> Age: <b><?= $age ?> </b> years old
                      </li>

                    </ul>
                    <div class="row row-sm">
                      <div class="col-6">
                        <a href="my-profile.php?uid=<?= $foster['verification_token'] ?>" class="btn view-btn">View Profile</a>
                      </div>
                      <?php
                      $current_year = date('Y');
                      // echo explode("-", $foster['dob'])[0];
                      $age = $current_year - explode("-", $foster['dob'])[0];

                      if ($age < 18) { ?>
                        <div class="col-6">
                          <a href="backend/contact.php?uid=<?= $foster['verification_token'] ?>" disabled class=" btn btn-danger">Minor</a>
                        </div>
                      <?php } else { ?>
                        <div class="col-6">
                          <a href="backend/add-connect.php?uid=<?= $foster['verification_token'] ?>" class="btn book-btn">Add Connect</a>
                        </div>
                      <?php } ?>
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
              <h2 class="mt-2">Foster Homes near you</h2>
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