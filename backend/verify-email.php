<?php
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');

$db = new Database();

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql = "SELECT verification_token, email, is_verified FROM fosters WHERE verification_token = :verification_token";
    $query = $db->fetch($sql, ['verification_token' => $token]);
    if (!empty($query)) {
        //check is_verified to 1
        if ($query['is_verified'] == 1) {
            $error_message = "Email already verified. Please login.";
            header("Location: ../login.php?error=" . $error_message);
            exit;
        } else {
            //update is_verified to 1
            $update_sql = "UPDATE fosters SET is_verified = 1 WHERE verification_token = :verification_token";
            $update_query = $db->execute($update_sql, ['verification_token' => $token]);
            if ($update_query) {
                $success_message = "Email verified successfully. You can now login.";
                header("Location: ../login.php?success=" . $success_message);
                exit;
            } else {
                $error_message = "Error verifying email. Please try again.";
                header("Location: ../login.php?error=" . $error_message);
                exit;
            }
        }
    } else {
        $error_message = "Invalid token or user does not exist";
        header("Location: ../login.php?error=" . $error_message);
        exit;
    }
}
$error_message = "permission denied";
header("Location: ../register.php?error=" . $error_message);
