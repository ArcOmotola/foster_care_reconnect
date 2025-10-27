<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
require_once('email/index.php');
$db = new Database();

if (isset($_POST['submit'])) {
    $token =  trim(htmlspecialchars($_POST['token'], ENT_QUOTES, "UTF-8"));
    if ($token != "") {
        $check_token_sql = "SELECT * FROM two_factor_auth WHERE token = :token";
        $check_token = $db->fetch($check_token_sql, ['token' => md5($token)]);
        if (empty($check_token)) {
            $error_message = "Token not found";
            header("Location: ../social-auth-factor.php?error=" . $error_message);
            exit;
        } else {
            $expire_at = $check_token['expire_at'];
            if (time() < $expire_at) {
                $error_message = "Token has been expired";
                header("Location: ../social-auth-factor.php?error=" . $error_message);
                exit;
            } else {
                $success_message = "Token has been verified";
                header("Location: ../social-members.php?success=" . $success_message);
                exit;
            }
        }
    } else {
        $error_message = "Required field can not be empty";
        header("Location: ../social-auth-factor.php?error=" . $error_message);
        exit;
    }
} else {
    $error_message = "Post data not found";
    header("Location: ../social-auth-factor.php?error=" . $error_message);
    exit;
}
