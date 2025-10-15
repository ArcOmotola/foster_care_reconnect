<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');

$db = new Database();

if (isset($_POST['submit'])) {

    $password =  trim(htmlspecialchars($_POST['new-password'], ENT_QUOTES, "UTF-8"));
    $confirm_password =  trim(htmlspecialchars($_POST['confirm_password'], ENT_QUOTES, "UTF-8"));

    if ($password == "" || $confirm_password == "") {
        $error_message = "Required field can not be empty";
        header("Location: ../profile-change-password.php.php?error=" . $error_message);
        exit;
    } else {

        $user_id = $_SESSION['id'];
        $sql = "SELECT  email, id   FROM fosters WHERE id = :id";
        $query = $db->fetch($sql, ['id' => $user_id]);

        if (!empty($query)) {
            //update password
            $update_sql = "UPDATE fosters SET password = :password WHERE id = :id";
            $update_query = $db->execute($update_sql, ['password' => md5($confirm_password), 'id' => $user_id]);
            if ($update_query) {
                $success_message = "Password changed successfully.";
                header("Location: ../profile-change-password.php?success=" . $success_message);
                exit;
            } else {
                $error_message = "Error occurred. Please try again.";
                header("Location: ../profile-change-password.php?error=" . $error_message);
                exit;
            }
        } else {
            $error_message = "Invalid token or user does not exist";
            header("Location: ../profile-change-password.php?error=" . $error_message);
            exit;
        }
    }
} else {
    $error_message = "Permission denied";
    header("Location: ../profile-change-password.php?error=" . $error_message);
    exit;
}
