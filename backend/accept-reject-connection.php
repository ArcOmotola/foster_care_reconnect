<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
require_once('email/index.php');
$db = new Database();


if (isset($_GET['action']) && !empty($_GET['action']) && isset($_GET['connection_id'])) {
    $connection_id = $_GET['connection_id'];
    $action = $_GET['action'];
    $check_connection = "SELECT * FROM foster_connects WHERE id = :connection_id";
    $result_connect = $db->fetch($check_connection, ['connection_id' => $connection_id]);
    if (empty($result_connect)) {
        $error_message = 'No conection found';
        header("Location: ../connection-requests.php?error=$error_message");
        exit;
    } else {
        //check if connection is already accepted or rejected
        if ($result_connect['status'] == 'accepted' || $result_connect['status'] == 'rejected') {
            $error_message = 'Connection already ' . $result_connect['status'];
            header("Location: ../connection-requests.php?error=$error_message");
            exit;
        }

        //update connection status
        $update_sql = "UPDATE foster_connects SET status = :status WHERE id = :connection_id";
        $db->execute($update_sql, ['status' => $action, 'connection_id' => $connection_id]);
        $foster_sql = "SELECT * FROM fosters WHERE id = :foster_id";
        $foster_result = $db->fetch($foster_sql, [
            'foster_id' => $result_connect['foster_id']
        ]);
        if ($action == 'accepted') {

            //Send Email Notification
            $to = $foster_result['email'];
            $subject = "You have a new connect request!";
            $verificationLink = $_SERVER['HTTP_ORIGIN'] . "/login.php";
            $body = "
                    <p>Hello $foster_result[name],</p>
                    <p>We're pleased to notify you that $foster_result[name]  has $action to connect with you on Foster Care Reconnect.</p>
                    <p>If you'd like to accept this request, please log into your account and start chat. You can manage your connections in your account profile.:</p>
                    <p><a href='$verificationLink'>Login to Foster Care Reconnect</a></p>
                    <p>Best regards,</p>
                    <p>Foster Care Reconnect Team</p>
                    ";
            generalEmailSender($subject, $to, $body, $name);

            //App Notification
            $notification_sql = "INSERT INTO app_notifications (foster_id, message) VALUES (:foster_id, :message)";
            $notification_result = $db->execute(
                $notification_sql,
                [
                    'foster_id' => $foster_result['id'],
                    'message' => "We're pleased to notify you that $foster_result[name]  has $action to connect with you on Foster Care Reconnect."
                ]
            );
            $success_message = 'Connection accepted successfully';
            header("Location: ../connection-requests.php?success=$success_message");
            exit;
        } elseif ($action == 'rejected') {
            $to = $foster_result['email'];
            $subject = "You have a new connect request!";
            $verificationLink = $_SERVER['HTTP_ORIGIN'] . "/login.php";
            $body = "
                    <p>Hello $foster_result[name],</p>
                    <p>We're pleased to notify you that $foster_result[name]  has $action to connect with you on Foster Care Reconnect.</p>
                    <p>If you'd like to accept this request, please log into your account.</p>
                    <p><a href='$verificationLink'>Login to Foster Care Reconnect</a></p>
                    <p>Best regards,</p>
                    <p>Foster Care Reconnect Team</p>
                    ";
            generalEmailSender($subject, $to, $body, $name);

            $notification_sql = "INSERT INTO app_notifications (foster_id, message) VALUES (:foster_id, :message)";
            $notification_result = $db->execute(
                $notification_sql,
                [
                    'foster_id' => $foster_result['id'],
                    'message' => "We're pleased to notify you that $foster_result[name]  has $action to connect with you on Foster Care Reconnect."
                ]
            );
            $error_message = 'Connection rejected successfully';
            header("Location: ../connection-requests.php?error=$error_message");
            exit;
        } else {
            $error_message = 'Invalid action Request';
            header("Location: ../connection-requests.php?error=$error_message");
            exit;
        }
    }
} else {
    $error_message = 'Invalid Request';
    header("Location: ../connection-requests.php?error=$error_message");
}
