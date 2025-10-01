<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    header("Location: backend/verify-email.php?token=" . $token);
    exit;
} else {
    $error_message = "Invalid verification token.";
    header("Location: login.php?error=" . $error_message);
    exit;
}
