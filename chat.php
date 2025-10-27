<?php
session_start();
$title = "Chat";
require_once 'includes/config/path.php';
require_once ROOT_PATH . 'includes/header.php';
require_once ROOT_PATH . 'includes/function.php';
$db = new Database();

if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
}
if (isset($_GET['success'])) {
    $success_message = $_GET['success'];
}

if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
}

if (isset($_GET['success'])) {
    $success_message = $_GET['success'];
}

//Get User chat
$user_id = $_SESSION['id'];
$sender_sql = "SELECT fosters.*, chat.* FROM chat 
JOIN fosters on fosters.id = chat.receiver_id
WHERE (sender_id = :foster_id)
ORDER BY chat.created_at DESC";
$send_chat = $db->fetchAll($sender_sql, ['foster_id' => $user_id]);
// var_dump($send_chat);
?>

<body class="chat-page">

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <?php
        require_once ROOT_PATH . 'includes/nav.php';
        ?>
        <!-- /Header -->

        <!-- Page Content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="chat-window">

                            <!-- Chat Left -->
                            <div class="chat-cont-left">
                                <div class="chat-header">
                                    <span>Chats</span>
                                    <!-- <a href="javascript:void(0)" class="chat-compose">
                                        <i class="material-icons">control_point</i>
                                    </a> -->
                                </div>
                                <form class="chat-search">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <i class="fas fa-search"></i>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Search">
                                    </div>
                                </form>
                                <div class="chat-users-list">
                                    <div class="chat-scroll">
                                        <?php if (!empty($send_chat)) { ?>
                                            <?php
                                            foreach ($send_chat as $chat) { ?>
                                                <a href="/" class="media" id="chat_box">
                                                    <div class="media-img-wrap">
                                                        <div class="avatar avatar-away">
                                                            <img src="<?= $chat['profile_image'] == ""  ? "assets/img/foster/foster-3.png" :  $chat['profile_image'] ?>" alt=" User Image" class="avatar-img rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <div>
                                                            <div class="user-name">
                                                                <?= $chat['name'] ?>
                                                            </div>
                                                            <div class="user-last-chat">Hey, How are you?</div>
                                                        </div>
                                                        <div>
                                                            <?php
                                                            $split_date_time = explode(" ", $chat['created_at']);
                                                            $date = $split_date_time[0];
                                                            $time = $split_date_time[1];
                                                            ?>
                                                            <div class="last-chat-time block"><?= $time ?></div>
                                                            <div class="badge badge-success badge-pill"><?= $date ?></div>
                                                        </div>
                                                    </div>
                                                </a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <h6>No chat available</h6>
                                        <?php  } ?>

                                    </div>
                                </div>
                            </div>
                            <!-- /Chat Left -->

                            <!-- Chat Right -->
                            <div class="chat-cont-right ">
                                <div class="chat-header">
                                    <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                                        <i class="material-icons">chevron_left</i>
                                    </a>
                                    <div class="media">
                                        <div class="media-img-wrap">
                                            <div class="avatar avatar-online">
                                                <img src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image" class="avatar-img rounded-circle">
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <div class="user-name">Dr. Darren Elder</div>
                                            <div class="user-status">online</div>
                                        </div>
                                    </div>
                                    <div class="chat-options">
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#voice_call">
                                            <i class="material-icons">local_phone</i>
                                        </a>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#video_call">
                                            <i class="material-icons">videocam</i>
                                        </a>
                                        <a href="javascript:void(0)">
                                            <i class="material-icons">more_vert</i>
                                        </a>
                                    </div>
                                </div>
                                <div class="chat-body">
                                    <div class="chat-scroll">
                                        <ul class="list-unstyled">
                                            <li class="media sent">
                                                <div class="media-body">
                                                    <div class="msg-box">
                                                        <div>
                                                            <p>Hello. What can I do for you?</p>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>8:30 AM</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="media received">
                                                <div class="avatar">
                                                    <img src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image" class="avatar-img rounded-circle">
                                                </div>
                                                <div class="media-body">
                                                    <div class="msg-box">
                                                        <div>
                                                            <p>I'm just looking around.</p>
                                                            <p>Will you tell me something about yourself?</p>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>8:35 AM</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="msg-box">
                                                        <div>
                                                            <p>Are you there? That time!</p>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>8:40 AM</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="msg-box">
                                                        <div>
                                                            <div class="chat-msg-attachments">
                                                                <div class="chat-attachment">
                                                                    <img src="assets/img/img-02.jpg" alt="Attachment">
                                                                    <div class="chat-attach-caption">placeholder.jpg</div>
                                                                    <a href="#" class="chat-attach-download">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="chat-attachment">
                                                                    <img src="assets/img/img-03.jpg" alt="Attachment">
                                                                    <div class="chat-attach-caption">placeholder.jpg</div>
                                                                    <a href="#" class="chat-attach-download">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>8:41 AM</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="media sent">
                                                <div class="media-body">
                                                    <div class="msg-box">
                                                        <div>
                                                            <p>Where?</p>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>8:42 AM</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="msg-box">
                                                        <div>
                                                            <p>OK, my name is Limingqiang. I like singing, playing basketballand so on.</p>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>8:42 AM</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="msg-box">
                                                        <div>
                                                            <div class="chat-msg-attachments">
                                                                <div class="chat-attachment">
                                                                    <img src="assets/img/img-04.jpg" alt="Attachment">
                                                                    <div class="chat-attach-caption">placeholder.jpg</div>
                                                                    <a href="#" class="chat-attach-download">
                                                                        <i class="fas fa-download"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>8:50 AM</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="media received">
                                                <div class="avatar">
                                                    <img src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image" class="avatar-img rounded-circle">
                                                </div>
                                                <div class="media-body">
                                                    <div class="msg-box">
                                                        <div>
                                                            <p>You wait for notice.</p>
                                                            <p>Consectetuorem ipsum dolor sit?</p>
                                                            <p>Ok?</p>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>8:55 PM</span>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="chat-date">Today</li>
                                            <li class="media received">
                                                <div class="avatar">
                                                    <img src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image" class="avatar-img rounded-circle">
                                                </div>
                                                <div class="media-body">
                                                    <div class="msg-box">
                                                        <div>
                                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>10:17 AM</span>
                                                                    </div>
                                                                </li>
                                                                <li><a href="#">Edit</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="media sent">
                                                <div class="media-body">
                                                    <div class="msg-box">
                                                        <div>
                                                            <p>Lorem ipsum dollar sit</p>
                                                            <div class="chat-msg-actions dropdown">
                                                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fe fe-elipsis-v"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="#">Delete</a>
                                                                </div>
                                                            </div>
                                                            <ul class="chat-msg-info">
                                                                <li>
                                                                    <div class="chat-time">
                                                                        <span>10:19 AM</span>
                                                                    </div>
                                                                </li>
                                                                <li><a href="#">Edit</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="media received">
                                                <div class="avatar">
                                                    <img src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image" class="avatar-img rounded-circle">
                                                </div>
                                                <div class="media-body">
                                                    <div class="msg-box">
                                                        <div>
                                                            <div class="msg-typing">
                                                                <span></span>
                                                                <span></span>
                                                                <span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="chat-footer">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="btn-file btn">
                                                <i class="fa fa-paperclip"></i>
                                                <input type="file">
                                            </div>
                                        </div>
                                        <input type="text" class="input-msg-send form-control" placeholder="Type something">
                                        <div class="input-group-append">
                                            <button type="button" class="btn msg-send-btn"><i class="fab fa-telegram-plane"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Chat Right -->

                        </div>
                    </div>
                </div>
                <!-- /Row -->

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

    <!-- Voice Call Modal -->
    <div class="modal fade call-modal" id="voice_call">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Outgoing Call -->
                    <div class="call-box incoming-box">
                        <div class="call-wrapper">
                            <div class="call-inner">
                                <div class="call-user">
                                    <img alt="User Image" src="assets/img/doctors/doctor-thumb-02.jpg" class="call-avatar">
                                    <h4>Darren Elder</h4>
                                    <span>Connecting...</span>
                                </div>
                                <div class="call-items">
                                    <a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
                                    <a href="voice-call.html" class="btn call-item call-start"><i class="material-icons">call</i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Outgoing Call -->

                </div>
            </div>
        </div>
    </div>
    <!-- /Voice Call Modal -->

    <!-- Video Call Modal -->
    <div class="modal fade call-modal" id="video_call">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <!-- Incoming Call -->
                    <div class="call-box incoming-box">
                        <div class="call-wrapper">
                            <div class="call-inner">
                                <div class="call-user">
                                    <img class="call-avatar" src="assets/img/doctors/doctor-thumb-02.jpg" alt="User Image">
                                    <h4>Darren Elder</h4>
                                    <span>Calling ...</span>
                                </div>
                                <div class="call-items">
                                    <a href="javascript:void(0);" class="btn call-item call-end" data-dismiss="modal" aria-label="Close"><i class="material-icons">call_end</i></a>
                                    <a href="video-call.html" class="btn call-item call-start"><i class="material-icons">videocam</i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Incoming Call -->

                </div>
            </div>
        </div>
    </div>
    <!-- Video Call Modal -->

    <?php
    require_once ROOT_PATH . 'includes/script.php';
    ?>

    <script src="assets/js/chat.js"></script>
</body>

<!-- doccure/chat.html  30 Nov 2019 04:12:18 GMT -->

</html>