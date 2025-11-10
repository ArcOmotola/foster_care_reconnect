<?php
session_start();
require_once('../../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
require_once('../email/index.php');
$db = new Database();

if (isset($_POST['submit'])) {
    $email =  trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS));
    $password =  trim(htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8"));

    if ($email == "" || $password == "") {
        $error_message = "Required field can not be empty";
        header("Location: ../../admin/login.php?error=" . $error_message);
        exit;
    } else {
        $sql = "SELECT id,email,password FROM admins WHERE email = :email";
        $query = $db->fetch($sql, ['email' => $email]);
        if (empty($query)) {
            $error_message = "Admin does not exist, Please register.";
            header("Location: ../../admin/login.php?error=" . $error_message);
        } else {
            //checking if password is correct
            if ($query['password'] != md5($password)) {
                $error_message = "Invalid credentials,Kindly check.";
                header("Location: admin/login.php?error=" . $error_message);
                exit;
            }

            $sql = "DELETE FROM two_factor_auth WHERE email = :email";
            $db->execute($sql, ['email' => $email]);
            //Send OTP
            $otp = rand(100000, 999999);
            $insert_opt = "INSERT INTO two_factor_auth (email,token,expires_at) VALUES (:email,:token, NOW() + INTERVAL 5 MINUTE)";
            $db->execute($insert_opt, [
                'email' => $email,
                'token' => md5($otp),
            ]);

            $to = $query['email'];
            $subject = "One Time Password!";
            $body = "
                    <p>Hello  Admin,</p>
                    <p>You have request to login as social worker.</p>
                    <p>Kindly use the following OTP:</p>
                    <p><a href='#'>OTP : $otp</a></p>
                    <p>Best regards,</p>
                    <p>Foster Care Reconnect Team</p>
                    ";
            generalEmailSender($subject, $to, $body, $name);
            if (!isset($_SESSION['last_admin_login_time'])) {
                $_SESSION['id'] = $query['id'];
                $_SESSION['name'] = 'Admin';
                $_SESSION['email'] = $query['email'];
                $_SESSION['last_admin_login_time'] = time();
                header("Location: ../../admin/index.php");
            } else {
                header("Location: ../../admin/index.php");
            }
        }
    }
} else {
    $error_message = "method not allowed";
    header("Location: admin/login.php?error=" . $error_message);
}
