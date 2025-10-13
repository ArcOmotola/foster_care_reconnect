<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
require_once('email/index.php');
$db = new Database();

if (isset($_POST['submit'])) {

    $email =  trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS));

    if ($email == "") {
        $error_message = "Required field can not be empty";
    } else {
        $sql = "SELECT id,email,name FROM fosters WHERE email = :email";
        $query_email = $db->fetch($sql, ['email' => $email]);

        if (empty($query_email)) {
            $error_message = "User does not exist.";
            header("Location: ../forget-password.php?error=" . $error_message);
        } else {
            $verificationToken = bin2hex(random_bytes(16));
            $sql = "UPDATE fosters SET verification_token = :verification_token WHERE email = :email";
            $query = $db->execute($sql, ['verification_token' => $verificationToken, 'email' => $email]);
            if (!$query) {
                $error_message = "Error occurred, try again later";
                header("Location: ../forget-password.php?error=" . $error_message);
            } else {
                $to = $email;
                $name = $query_email['name'];
                $subject = "Your password reset link for Foster Care Reconnect";
                $verificationLink = $_SERVER['HTTP_ORIGIN'] . "/change-password.php?token=" . $verificationToken;
                $body = "
                    <p>Hi $name,</p>
                    <p>You recently requested to reset your password for your [Your Brand] account. Simply click the button below to choose a new one.</p>
                    <p><a href='$verificationLink'>Reset Password</a></p>
                    <p>If you did not request a password reset, you can safely ignore this email. No changes have been made to your account.</p>
                    <p>Best regards,</p>
                    <p>Foster Care Reconnect Team</p>
                    ";
                $success_message = "Verification link sent to your email, kindly check.";
                generalEmailSender($subject, $to, $body, $name);
                header("Location: ../forget-password.php?success=" . $success_message);
            }
            //Reset Password
        }
    }
} else {
    $error_message = "Required field can not be empty";
    header("Location: ../forget-password.php?error=" . $error_message);
}
