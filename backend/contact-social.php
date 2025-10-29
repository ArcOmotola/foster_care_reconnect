<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

if (isset($_POST['submit'])) {

    $title =  trim(filter_input(INPUT_POST, "title", FILTER_SANITIZE_SPECIAL_CHARS));
    $message =  trim(htmlspecialchars($_POST['message'], ENT_QUOTES, "UTF-8"));
    $uid =  trim(htmlspecialchars($_POST['uid'], ENT_QUOTES, "UTF-8"));
    // echo $title, $message;

    if ($title == "" || $message == "") {
        $error_message = "Required field can not be empty";
    } else {
        $sql = "SELECT * FROM fosters WHERE verification_token = :uid";
        $query = $db->fetch($sql, ['uid' => $uid]);
        if (empty($query)) {
            $error_message = "foster does not exist";
            header("Location: ../social-contact.php?error=" . $error_message);
        } else {
            $insert_sql = "INSERT INTO social_worker_messages (foster_home_id,foster_id,message) VALUES (:foster_home_id,:foster_id,:message)";
            $params = [
                'foster_id' => $_SESSION['id'],
                'foster_home_id' => $query['foster_home_id'],
                'message' => $message,
            ];
            $register = $db->execute($insert_sql, $params);
            if ($register) {
                $success_message = "Message sent successfully.";
                header("Location: ../search.php?success=" . $success_message);
            } else {
                $error_message = "An error occured, try again later.";
                header("Location: ../social-contact.php?error=" . $error_message);
            }
        }
    }
} else {
    $error_message = "Required field can not be empty f";
    header("Location: ../social-contact.php?error=" . $error_message);
}
