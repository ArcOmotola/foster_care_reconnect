<div class="card widget-profile pat-widget-profile">
    <div class="card-body">
        <div class="pro-widget-content">
            <div class="profile-info-widget">
                <a href="#" class="booking-doc-img">
                    <?php
                    if (empty($result_user['profile_image'])) { ?>
                        <img src="assets/img/patients/patient.jpg" alt="User Image">
                    <?php } else { ?>
                        <img src="assets/img/patients/" <?= $result_user['profile_image'] ?>alt="User Image">
                    <?php } ?>
                </a>
                <div class="profile-det-info">
                    <h3>
                        <?= ucfirst($result_user['name']) ?>
                    </h3>

                    <div class="patient-details">
                        <h5><b>Email :</b> <?= $result_user['email'] ?></h5>
                        <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?= $result_user['address'] ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="patient-info">
            <ul>
                <li>Phone <span><?= $result_user['phone_number'] ?></span></li>
                <li>Age <span><?= $result_user['dob'] ?></span></li>
                <li>SSN <span><?= $result_user['ssn'] ?></span></li>
            </ul>
        </div>
    </div>
    <a href="update-profile.php" class="btn btn-sm bg-info-light">
        <i class="far fa-edit"></i> Update Profile
    </a>
</div>
<div class="dashboard-widget">
    <nav class="dashboard-menu">
        <ul>
            <li>
                <a href="profile.php">
                    <i class="fas fa-columns"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <!-- <li>
                                            <a href="favourites.html">
                                                <i class="fas fa-bookmark"></i>
                                                <span>Favourites</span>
                                            </a>
                                        </li> -->
            <!-- <li>
                                            <a href="#">
                                                <i class="fas fa-comments"></i>
                                                <span>Message</span>
                                                <small class="unread-msg">23</small>
                                            </a>
                                        </li> -->
            <li class="active">
                <a href="update-profile.php">
                    <i class="fas fa-user-cog"></i>
                    <span>Profile Settings</span>
                </a>
            </li>
            <li>
                <a href="profile-change-password.php">
                    <i class="fas fa-lock"></i>
                    <span>Change Password</span>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Logs history</h4>
    </div>


    <ul class="list-group list-group-flush">
        <?php if (!empty($result_logged)) { ?>
            <li class="list-group-item">
                <div class="media align-items-center">
                    <div class="mr-3">
                        <img alt="Image placeholder" src="assets/img/doctors/doctor-thumb-02.jpg" class="avatar  rounded-circle">
                    </div>
                    <div class="media-body">
                        <h5 class="d-block mb-0">Type: <?= ucfirst($result_logged['log_type']) ?></h5>
                        <span class="d-block text-sm text-muted"><?= ucfirst($result_logged['message']) ?></span>
                        <span class="d-block text-sm text-muted"><?= date($result_logged['created_at']) ?></span>
                    </div>
                </div>
            </li>
        <?php } ?>

    </ul>
</div>