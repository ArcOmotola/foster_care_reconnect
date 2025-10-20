<?php
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');

$db = new Database();

if (isset($_POST['search'])) {
    $seach = $_POST['search'];
    header("Location: ../search.php?search=$seach");
    exit;
} else {
    header("Location: ../search.php");
    exit;
}
