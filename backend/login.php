<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

if (isset($_POST['submit'])) {

    $email =  trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS));
    $password =  trim(htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8"));

    if ($email == "" || $password == "") {
        $error_message = "Required field can not be empty";
    } else {
        $sql = "SELECT id,email, password FROM fosters WHERE email = :email";
        $query = $db->fetch($sql, ['email' => $email]);
        if (empty($query)) {
            $error_message = "Invalid credentials,Kindly check.";
            header("Location: ../login.php?error=" . $error_message);
        } else {
            if (!isset($_SESSION['last_login_time'])) {
                $_SESSION['id'] = $query['id'];
                $_SESSION['name'] = $query['name'];
                $_SESSION['email'] = $query['email'];
                $_SESSION['last_login_time'] = time();
                header("Location: ../index.php");
            } else {
                header("Location: ../index.php");
            }
        }
    }
} else {
    $error_message = "Required field can not be empty";
    header("Location: ../login.php?error=" . $error_message);
}
