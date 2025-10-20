<?php
session_start();
require_once 'includes/config/path.php';
require_once ROOT_PATH . 'includes/header.php';
require_once ROOT_PATH . 'includes/function.php';
$db = new Database();


//Display random 4 states from USA (country_id = 231)
$country = "SELECT name FROM countries ORDER BY RAND() LIMIT 4";
$result_country = $db->fetchAll($country);

//Display random 4 states from USA (country_id = 231)
$state_sql = "SELECT name FROM states WHERE country_id = 231 ORDER BY RAND() LIMIT 4";
$result_state = $db->fetchAll($state_sql);


//Display random 8 foster homes from USA (country_id = 231)
$foster_homes = "SELECT * FROM foster_homes WHERE country_id = 231 ORDER BY RAND() LIMIT 4";
$result_foster_homes = $db->fetchAll($foster_homes);


$random_fosters = "SELECT * FROM fosters ORDER BY RAND() LIMIT 6";
$result_fosters = $db->fetchAll($random_fosters);

//search feature
$merge_search_result = [];
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    //search fosters
    $search_fosters = "SELECT * FROM fosters WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone_number LIKE '%$search%' OR address LIKE '%$search%'";
    $search_result_fosters = $db->fetchAll($search_fosters);
    $merge_search_result = array_merge($search_result_fosters);
}

//Foster search name
if (isset($_GET['foster_name']) && !empty($_GET['foster_name'])) {
    $search = $_GET['foster_name'];
    //search fosters
    $search_fosters = "SELECT * FROM fosters WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone_number LIKE '%$search%' OR address LIKE '%$search%'";
    $search_result_fosters = $db->fetchAll($search_fosters);
    $merge_search_result = array_merge($search_result_fosters);
}

?>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php
        require_once ROOT_PATH . 'includes/nav.php';
        ?>
        <!-- /Header -->

        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8 col-12">
                        <nav aria-label="breadcrumb" class="page-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Search</li>
                            </ol>
                        </nav>
                        <h2 class="breadcrumb-title"><?= count($merge_search_result) ?> matches found </h2>
                    </div>

                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Page Content -->
        <div class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12 col-lg-4 col-xl-3 theiaStickySidebar">

                        <!-- Search Filter -->
                        <form method="get" action="search.php">
                            <div class="card search-filter">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Search Filter</h4>
                                </div>
                                <div class="card-body">
                                    <div class="filter-widget">
                                        <div class="cal-search">
                                            <input type="text" name="foster_name" value="<?= isset($_GET['foster_name']) ? $_GET['foster_name'] : "" ?>" class="form-control" placeholder="Enter foster name, city, state">
                                        </div>
                                    </div>
                                    <div class="filter-widget">
                                        <h4>State</h4>
                                        <?php
                                        foreach ($result_state as $state) { ?>
                                            <div>
                                                <label class="custom_check">
                                                    <input type="checkbox" name="state_name" value="<?= $state['name'] ?>">
                                                    <span class="checkmark"></span> <?= $state['name'] ?>
                                                </label>
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                    <div class="filter-widget">
                                        <h4>Homes</h4>
                                        <?php
                                        foreach ($result_foster_homes as $home) { ?>
                                            <div>
                                                <label class="custom_check">
                                                    <input type="checkbox" name="home_name" value="<?= $home['foster_name'] ?? "" ?>">
                                                    <span class="checkmark"></span> <?= $home['foster_name'] ?>
                                                </label>
                                            </div>
                                        <?php }
                                        ?>

                                    </div>
                                    <div class="btn-search">
                                        <button type="submit" name="search" class="btn btn-block">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- /Search Filter -->

                    </div>
                    <?php if (!isset($_GET['search'])) { ?>
                        <div class="col-md-12 col-lg-8 col-xl-9">
                            <?php
                            if (empty($result_fosters)) { ?>
                                <h6>No Data available 1</h6>
                            <?php }
                            foreach ($result_fosters as $foster) { ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="doctor-widget">
                                            <div class="doc-info-left">
                                                <div class="doctor-img">
                                                    <a href="my-profile.php?uid=<?= $foster['verification_token'] ?>">
                                                        <img class="img-fluid" alt="User Image" src="<?= $foster['profile_image'] == "" ? "assets/img/foster/foster-3.png" :  $foster['profile_image'] ?>">

                                                    </a>
                                                </div>
                                                <div class="doc-info-cont">
                                                    <h4 class="doc-name"><a href="">
                                                            <?= $foster['name'] ?>
                                                        </a></h4>
                                                    <!-- <h5 class="doc-department"><img src="assets/img/specialities/specialities-05.png" class="img-fluid" alt="Speciality">Dentist</h5> -->

                                                    <div class="clinic-details">
                                                        <p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?= $foster['address'] ?></p>

                                                    </div>
                                                    <div class="clinic-services">
                                                        <?php
                                                        $foster_experiences = "SELECT * FROM foster_experiences WHERE foster_id = :foster_id";
                                                        $result_foster_experiences = $db->fetch($foster_experiences, ['foster_id' => $foster['id']]);

                                                        if (empty($result_foster_experiences)) {
                                                            echo "No Data available";
                                                        } else {
                                                            $memories = $result_foster_experiences['favourite_activities'];
                                                            if ($memories != null) {
                                                                //Explode the memory into an array
                                                                $exploded_memories = explode(",", $memories);
                                                                foreach ($exploded_memories as $memory) {
                                                                    echo '<span>' . $memory . '</span>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <!-- <span>Dental Fillings</span>
                                                        <span> Whitneing</span> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="doc-info-right">

                                                <div class="clinic-booking">
                                                    <a class="view-pro-btn" href="my-profile.php?uid=<?= $foster['verification_token'] ?>">View Profile</a>

                                                    <?php
                                                    $current_year = date('Y');
                                                    // echo explode("-", $foster['dob'])[0];
                                                    $age = $current_year - explode("-", $foster['dob'])[0];

                                                    if ($age < 18) { ?>
                                                        <!-- <div class="col-6"> -->
                                                        <a class="apt-btn" href="backend/contact.php?uid=<?= $foster['verification_token'] ?>">Contact Social</a>
                                                        <!-- </div> -->
                                                    <?php } else { ?>
                                                        <!-- <div class="col-6"> -->
                                                        <a class="apt-btn" href="backend/add-connect.php?uid=<?= $foster['verification_token'] ?>">Add Connect</a>
                                                        <!-- </div> -->
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="load-more text-center">
                                <!-- <a class="btn btn-primary btn-sm" href="javascript:void(0);">Load More</a> -->
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-12 col-lg-8 col-xl-9">
                            <?php
                            if (empty($merge_search_result)) { ?>
                                <h1>No Data available 2</h1>
                            <?php }
                            foreach ($merge_search_result as $foster) { ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="doctor-widget">
                                            <div class="doc-info-left">
                                                <div class="doctor-img">
                                                    <a href="my-profile.php?uid=<?= $foster['verification_token'] ?>">
                                                        <img class="img-fluid" alt="User Image" src="<?= $foster['profile_image'] == "" ? "assets/img/foster/foster-3.png" :  $foster['profile_image'] ?>">

                                                    </a>
                                                </div>
                                                <div class="doc-info-cont">
                                                    <h4 class="doc-name"><a href="">
                                                            <?= $foster['name'] ?>
                                                        </a></h4>
                                                    <!-- <h5 class="doc-department"><img src="assets/img/specialities/specialities-05.png" class="img-fluid" alt="Speciality">Dentist</h5> -->

                                                    <div class="clinic-details">
                                                        <p class="doc-location"><i class="fas fa-map-marker-alt"></i> <?= $foster['address'] ?></p>

                                                    </div>
                                                    <div class="clinic-services">
                                                        <?php
                                                        $foster_experiences = "SELECT * FROM foster_experiences WHERE foster_id = :foster_id";
                                                        $result_foster_experiences = $db->fetch($foster_experiences, ['foster_id' => $foster['id']]);

                                                        if (empty($result_foster_experiences)) {
                                                            echo "No Data available";
                                                        } else {
                                                            $memories = $result_foster_experiences['favourite_activities'];
                                                            if ($memories != null) {
                                                                //Explode the memory into an array
                                                                $exploded_memories = explode(",", $memories);
                                                                foreach ($exploded_memories as $memory) {
                                                                    echo '<span>' . $memory . '</span>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <!-- <span>Dental Fillings</span>
                                                        <span> Whitneing</span> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="doc-info-right">

                                                <div class="clinic-booking">
                                                    <a class="view-pro-btn" href="my-profile.php?uid=<?= $foster['verification_token'] ?>">View Profile</a>

                                                    <?php
                                                    $current_year = date('Y');
                                                    // echo explode("-", $foster['dob'])[0];
                                                    $age = $current_year - explode("-", $foster['dob'])[0];

                                                    if ($age < 18) { ?>
                                                        <!-- <div class="col-6"> -->
                                                        <a class="apt-btn" href="backend/contact.php?uid=<?= $foster['verification_token'] ?>">Contact Social</a>
                                                        <!-- </div> -->
                                                    <?php } else { ?>
                                                        <!-- <div class="col-6"> -->
                                                        <a class="apt-btn" href="backend/add-connect.php?uid=<?= $foster['verification_token'] ?>">Add Connect</a>
                                                        <!-- </div> -->
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- Doctor Widget -->

                            <!-- /Doctor Widget -->

                            <div class="load-more text-center">
                                <!-- <a class="btn btn-primary btn-sm" href="javascript:void(0);">Load More</a> -->
                            </div>
                        </div>
                    <?php   } ?>
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

    <!-- jQuery -->

    <?php
    require_once ROOT_PATH . 'includes/script.php';
    ?>
</body>

<!-- doccure/search.html  30 Nov 2019 04:12:16 GMT -->

</html>