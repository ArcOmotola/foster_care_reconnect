<?php
session_start();
$title = "Chat";
require_once 'includes/config/path.php';
require_once ROOT_PATH . 'includes/header.php';
require_once ROOT_PATH . 'includes/function.php';
$db = new Database();


//Check if user is logged In
if (!$db->CheckLogin()) {
    header("Location: login.php");
}

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
$chat_id = "";
if (isset($_GET['chat_id'])) {
    $chat_id = $_GET['chat_id'];
}


if (isset($_GET['uid'])) {
    $receiver_uid = $_GET['uid'];
    $foster = "SELECT * FROM fosters WHERE verification_token = :verification_token LIMIT 1";
    $foster_result = $db->fetch($foster, ['verification_token' => $receiver_uid]);
    // var_dump($foster_result);
    if (!empty($foster_result)) {
        $receiver_id = $foster_result['id'];
    } else {
        header("Location: chat.php?error=" . "No user found with ID: " . $receiver_id);
        exit;
    }
}

//Get User chat
$user_id = $_SESSION['id'];
$sender_sql = "SELECT fosters.*, chat.* FROM chat 
JOIN fosters on fosters.id = chat.receiver_id
WHERE (sender_id = :foster_id)
ORDER BY chat.created_at DESC";
$send_chat = $db->fetchAll($sender_sql, ['foster_id' => $user_id]);

$receiver_sql = "SELECT fosters.*, chat.* FROM chat 
JOIN fosters on fosters.id = chat.receiver_id
WHERE (receiver_id = :foster_id)
ORDER BY chat.created_at DESC";
$receive_chat = $db->fetchAll($receiver_sql, ['foster_id' => $user_id]);
$merge_chat = array_merge($send_chat, $receive_chat);
$send_chat = $merge_chat;
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
                                                <a href="chat.php?chat_id=<?= $chat['id'] ?>" class="media" id="chat_box">
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
                                                            <div class="user-last-chat">...</div>
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
                            <?php if (!empty($chat_id)) {

                                $chat_sql = "SELECT fosters.*, chat.* FROM chat 
                                    JOIN fosters on fosters.id = chat.receiver_id
                                    WHERE  chat.id = :id LIMIT 1";
                                $result_chat = $db->fetch($chat_sql, ['id' => $chat_id]);
                                // var_dump($result_chat);
                                $messages_sql = "SELECT fosters.*, chat_messages.* FROM chat_messages
                                    JOIN fosters on fosters.id = chat_messages.sender_id
                                     WHERE chat_id = :chat_id ORDER BY chat_messages.created_at ASC";
                                $messages = $db->fetchAll($messages_sql, ['chat_id' => $chat_id]);
                                // 
                            ?>
                                <div class="chat-cont-right ">
                                    <div class="chat-header">
                                        <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                                            <i class="material-icons">chevron_left</i>
                                        </a>
                                        <div class="media">
                                            <div class="media-img-wrap">
                                                <div class="avatar avatar-online">
                                                    <img src="<?= $result_chat['profile_image'] == ""  ? "assets/img/foster/foster-3.png" :  $result_chat['profile_image'] ?>" alt=" User Image" class="avatar-img rounded-circle">
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="user-name">
                                                    <?= $result_chat['name'] ?>
                                                </div>
                                                <div class="user-status">
                                                    <?= $result_chat['status'] == 1 ? "online" : "offline" ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="chat-options">
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#voice_call">
                                                <i class="material-icons">local_phone</i>
                                            </a>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#video_call">
                                                <i class="material-icons">videocam</i>
                                            </a>
                                            <a href="javascript:void(0)">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                        </div> -->
                                    </div>

                                    <?php
                                    foreach ($messages as $message) { ?>
                                        <div class="chat-body">
                                            <div class="chat-scroll">
                                                <ul class="list-unstyled">
                                                    <?php if ($message['sender_id'] == $user_id) { ?>
                                                        <li class="media sent">
                                                            <div class="media-body">
                                                                <div class="msg-box">
                                                                    <div>
                                                                        <p><?= $message['message'] ?></p>
                                                                        <ul class="chat-msg-info">
                                                                            <li>
                                                                                <div class="chat-time">
                                                                                    <span>
                                                                                        <?= $message['created_at'] ?>
                                                                                    </span>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php } else { ?>
                                                        <li class="media received">
                                                            <div class="avatar">
                                                                <img src="<?= $message['profile_image'] == ""  ? "assets/img/foster/foster-3.png" :  $message['profile_image'] ?>" alt=" User Image" class="avatar-img rounded-circle">
                                                            </div>
                                                            <div class="media-body">
                                                                <div class="msg-box">
                                                                    <div>
                                                                        <p><?= $message['message'] ?></p>
                                                                        <ul class="chat-msg-info">
                                                                            <li>
                                                                                <div class="chat-time">
                                                                                    <span><?= $message['created_at'] ?></span>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php  } ?>
                                    <div class="chat-footer">
                                        <!-- <form action="#" id="sendMessage"> -->
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <!-- <div class="btn-file btn">
                                                    <i class="fa fa-paperclip"></i>
                                                    <input type="file">
                                                </div> -->
                                            </div>
                                            <input type="hidden" name="receiver_id" id="receiver_id" value="<?= $result_chat['sender_id'] == $user_id ? $result_chat['receiver_id'] : $result_chat['sender_id']  ?>">
                                            <input type="hidden" name="chat_id" id="chat_id" value="<?= $chat_id ?>">
                                            <input type="text" class="input-msg-send form-control" name="messageInput" placeholder="Type something" id="messageInput">
                                            <div class="input-group-append">
                                                <button type="button" class="btn msg-send-btn" id="sendBtn"><i class="fab fa-telegram-plane"></i></button>
                                            </div>
                                        </div>
                                        <!-- </form> -->
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="chat-cont-right ">
                                    <div class="chat-header">
                                        <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                                            <i class="material-icons">chevron_left</i>
                                        </a>
                                        <div class="media">
                                            <div class="media-img-wrap">
                                                <div class="avatar avatar-online">
                                                    <img src="<?= $foster_result['profile_image'] == ""  ? "assets/img/foster/foster-3.png" :  $foster_result['profile_image'] ?>" alt=" User Image" class="avatar-img rounded-circle">
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="user-name"><?= $foster_result['name'] ?></div>
                                                <?= $foster_result['status'] == 1 ? "online" : "offline" ?>
                                            </div>
                                        </div>
                                        <!-- <div class="chat-options">
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#voice_call">
                                                <i class="material-icons">local_phone</i>
                                            </a>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#video_call">
                                                <i class="material-icons">videocam</i>
                                            </a>
                                            <a href="javascript:void(0)">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                        </div> -->
                                    </div>
                                    <div class="chat-body">
                                        <div class="chat-scroll">
                                        </div>
                                    </div>
                                    <div class="chat-footer">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="btn-file btn">
                                                    <!-- <i class="fa fa-paperclip"></i>
                                                    <input type="file"> -->
                                                </div>
                                            </div>
                                            <input type="hidden" name="receiver_id" id="receiver_id" value="<?= $foster_result['id']  ?>">
                                            <input type="text" class="input-msg-send form-control" name="messageInput" placeholder="Type something" id="messageInput">
                                            <div class="input-group-append">
                                                <button type="button" class="btn msg-send-btn" id="sendBtn"><i class="fab fa-telegram-plane"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
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