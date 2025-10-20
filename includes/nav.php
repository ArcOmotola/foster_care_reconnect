<header class="header">
    <nav class="navbar navbar-expand-lg header-nav">
        <div class="navbar-header">
            <a id="mobile_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <a href="/" class="navbar-brand logo">
                <img src="assets/img/logo.png" class="img-fluid" alt="Logo">
            </a>
        </div>
        <div class="main-menu-wrapper">
            <div class="menu-header">
                <a href="/" class="menu-logo">
                    <img src="assets/img/logo.png" class="img-fluid" alt="Logo">
                </a>
                <a id="menu_close" class="menu-close" href="javascript:void(0);">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <ul class="main-nav">
                <li class="active">
                    <a href="search.php">Fosters</a>
                </li>
                <?php if (isset($_SESSION['last_login_time'])) { ?>
                    <li class="login-link">
                        <a href="profile.php">Profile</a>
                    </li>
                    <li class="login-link">
                        <a href="logout.php">Logout</a>
                    </li>
                <?php } else { ?>
                    <li class="login-link">
                        <a href="login.php">Login / Signup</a>
                    </li>
            </ul>
        <?php } ?>
        </div>
        <ul class="nav header-navbar-rht">
            <li class="nav-item contact-item">
                <div class="header-contact-img">
                </div>
                <div class="header-contact-detail">

                </div>
            </li>
            <?php
            $auth_login = $_SESSION['last_login_time'] ?? false;
            if ($auth_login) { ?>
                <li class="nav-item contact-item">
                    <div class="header-contact-img">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="header-contact-detail">
                        <p class="contact-header">Welcome Back</p>
                        <p class="contact-info-header">
                            <?= $_SESSION['name'] ?? 'User' ?>
                        </p>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link header-login" href="profile.php">Profile </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link header-login" href="logout.php">Logout </a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link header-login" href="login.php">login/ Signup </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</header>