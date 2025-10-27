<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
require_once('email/index.php');

$db = new Database();

//check if user is logged in
if (!$db->CheckLogin()) {
    header("Location: " .  $_SERVER['HTTP_REFERER'] . "?error=" . "Please login to continue");
    exit;
} else {
    if (isset($_GET['uid'])) {
        //get foster with the uid
        $uid = $_GET['uid'];
        $foster_sql = "SELECT * FROM fosters WHERE verification_token = :uid";
        $result_foster = $db->fetch($foster_sql, ['uid' => $uid]);
        if (empty($result_foster)) {
            header("Location: " .  $_SERVER['HTTP_REFERER'] . "?error=" . "No foster found with ID: " . $uid);
            exit;
        } else {
            $connect_id = $result_foster['id'];
            $foster_id = $_SESSION['id'];

            //check if connect request already exists
            $connect_sql = "SELECT * FROM foster_connects WHERE foster_id = :foster_id AND connect_id = :connect_id";
            $result_connect = $db->fetch($connect_sql, ['foster_id' => $foster_id, 'connect_id' => $connect_id]);
            if (!empty($result_connect)) {
                header("Location: " .  $_SERVER['HTTP_REFERER'] . "?error=" . "You have already sent a connect request to this foster");
                exit;
            }
            $sql = "INSERT INTO foster_connects (foster_id, connect_id) VALUES (:foster_id, :connect_id)";
            $result = $db->execute($sql, ['foster_id' => $foster_id, 'connect_id' => $connect_id]);
            if ($result) {
                $notification_sql = "INSERT INTO app_notifications (foster_id, message) VALUES (:foster_id, :message)";
                $notification_result = $db->execute(
                    $notification_sql,
                    [
                        'foster_id' => $connect_id,
                        'message' => "You have a new connect request"
                    ]
                );

                //Send Email Notification
                $to = $result_foster['email'];
                $subject = "You have a new connect request!";
                $verificationLink = $_SERVER['HTTP_ORIGIN'] . "/login.php";
                $body = "
                    <p>Hello $result_foster[name],</p>
                    <p>We're pleased to notify you that $result_foster[name]  has requested to connect with you on Foster Care Reconnect.</p>
                    <p>If you'd like to accept this request, please log into your account and approve it. You can manage your connections in your account settings.:</p>
                    <p><a href='$verificationLink'>Login to Foster Care Reconnect</a></p>
                    <p>Best regards,</p>
                    <p>Foster Care Reconnect Team</p>
                    ";
                generalEmailSender($subject, $to, $body, $name);
                $foster_id = $db->lastInsertId();
                header("Location: " .  $_SERVER['HTTP_REFERER'] . "?success=" . "Connect request sent successfully");
                exit;
            } else {
                header("Location: " .  $_SERVER['HTTP_REFERER'] . "?error=" . "Error sending connect request");
                exit;
            }
        }
    } else {
        header("Location: " .  $_SERVER['HTTP_REFERER'] . "?error=" . "Uid must be set");
        exit;
    }
}
