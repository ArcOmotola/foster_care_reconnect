<?php
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
$db = new Database();

if (isset($_FILES['image'])) {
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $user_id = $_POST['user_id'];
    //Check if user is logged In
    if (!$db->CheckLogin()) {
        echo json_encode(['status' => 'error', 'message' => 'Permission denied']);
        exit;
    }
    //upload image
    $target_dir = "../uploads/profile/";
    $target_file = $target_dir . basename($image_name);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($image["tmp_name"]);
    if ($check === false) {
        echo json_encode(['status' => 'error', 'message' => 'File is not an image']);
        exit;
    }
    if (file_exists($target_file)) {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, file already exists']);
        exit;
    }
    if ($image['size'] > 2000000) {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, your file is too large']);
        exit;
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed']);
        exit;
    }
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error uploading your file']);
        exit;
    }
    //Update image in database

    $sql = "UPDATE fosters SET profile_image = :profile_image WHERE id = :user_id";
    $query = $db->execute($sql, ['profile_image' => $image_name, 'user_id' => $user_id]);
    if ($query) {
        echo json_encode(['status' => 'success', 'message' => 'Image uploaded successfully']);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error occurred. Please try again']);
        exit;
    }
}
