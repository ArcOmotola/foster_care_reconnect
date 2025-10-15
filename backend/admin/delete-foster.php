<?php
session_start();
require_once('../../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM fosters WHERE id = :id";
    $result = $db->execute($sql, ['id' => $id]);
    if ($result) {
        $success_message = "Foster deleted successfully";
        header("Location: ../../admin/foster-child.php?success=" . $success_message);
        exit;
    }
} else {
    $php_errormsg = "ID not found";
    header("Location: ../../admin/index.php?error=" . $php_errormsg);
    exit;
}
