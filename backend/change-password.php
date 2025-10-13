<?php
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');

$db = new Database();

if (isset($_POST['submit'])) {

    $password =  trim(htmlspecialchars($_POST['new_password'], ENT_QUOTES, "UTF-8"));
    $confirm_password =  trim(htmlspecialchars($_POST['confirm_password'], ENT_QUOTES, "UTF-8"));

    if ($password == "" || $confirm_password == "") {
        $error_message = "Required field can not be empty";
        header("Location: ../change-password.php?error=" . $error_message);
        exit;
    } else {

        $token = $_POST['token'];
        $sql = "SELECT verification_token, email   FROM fosters WHERE verification_token = :verification_token";
        $query = $db->fetch($sql, ['verification_token' => $token]);

        if (!empty($query)) {
            //update password
            $update_sql = "UPDATE fosters SET password = :password WHERE verification_token = :verification_token";
            $update_query = $db->execute($update_sql, ['password' => md5($confirm_password), 'verification_token' => $token]);
            if ($update_query) {
                $success_message = "Password changed successfully. You can now login.";
                header("Location: ../login.php?success=" . $success_message);
                exit;
            } else {
                $error_message = "Error occurred. Please try again.";
                header("Location: ../login.php?error=" . $error_message);
                exit;
            }
        } else {
            $error_message = "Invalid token or user does not exist";
            header("Location: ../login.php?error=" . $error_message);
            exit;
        }
    }
} else {
    $error_message = "Permission denied";
    header("Location: ../login.php?error=" . $error_message);
    exit;
}
