<?php
session_start();
require_once('../../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
require_once('../email/index.php');
$db = new Database();

if (isset($_POST['submit'])) {
    $country =  trim(htmlspecialchars($_POST['country'], ENT_QUOTES, "UTF-8"));
    $state =  trim(htmlspecialchars($_POST['state'], ENT_QUOTES, "UTF-8"));
    $foster_name =  trim(htmlspecialchars($_POST['foster_name'], ENT_QUOTES, "UTF-8"));
    $home_address =  trim(htmlspecialchars($_POST['home_address'], ENT_QUOTES, "UTF-8"));
    $phone_number =  trim(htmlspecialchars($_POST['phone_number'], ENT_QUOTES, "UTF-8"));
    $email =  trim(htmlspecialchars($_POST['email'], ENT_QUOTES, "UTF-8"));
    $password =  trim(htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8"));
    //$cover_image =  trim(htmlspecialchars($_POST['cover_image'], ENT_QUOTES, "UTF-8"));
    $id = $_GET['id'];
    if ($country == "" && $state == "" && $foster_name == "" && $home_address == "" && $phone_number == "" && $email == "") {
        $error_message = "Required field can not be empty";
        header("Location: ../../admin/add-social-worker.php?error=" . $error_message);
        exit;
    } else {
        $check_home_sql = "SELECT * FROM foster_homes WHERE id = :id";
        $check_home = $db->fetch($check_home_sql, ['id' => $id]);
        if (!$check_home) {
            $error_message = "Social worker not found";
            header("Location: ../../admin/edit-social-worker.php?error=" . $error_message);
            exit;
        } else {

            //Check if Image is valid
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == 0) {
                $image = $_FILES['cover_image'];
                $image_name = $image['name'];

                //upload image
                $target_dir = "../../uploads/social-worker/";
                $target_file = $target_dir . time() . "_" . basename($image_name);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $check = getimagesize($image["tmp_name"]);
                if ($check === false) {
                    $error_message = "File is not an image";
                    header("Location: ../../admin/add-social-worker.php?error=" . $error_message);
                    exit;
                }
                if (file_exists($target_file)) {
                    $error_message = "Sorry, file already exists";
                    header("Location: ../../admin/add-social-worker.php?error=" . $error_message);
                    exit;
                }
                if ($image['size'] > 2000000) {
                    $error_message = "Sorry, your file is too large";
                    header("Location: ../../admin/add-social-worker.php?error=" . $error_message);
                    exit;
                }
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
                    header("Location: ../../admin/add-social-worker.php?error=" . $error_message);
                    exit;
                }
                //check if directory exists else create it
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                if (!move_uploaded_file($image["tmp_name"], $target_file)) {
                    $error_message = "Sorry, there was an error uploading your file";
                    header("Location: ../../admin/add-social-worker.php?error=" . $error_message);
                    exit;
                }
                $cover_image = "uploads/social-worker/" . $target_file;
            }
            $save_home = "UPDATE foster_homes SET 
                country_id = :country_id,
                state_id = :state_id,
                foster_name = :foster_name,
                home_address = :home_address,
                contact_number = :contact_number,
                email = :email,
                password = :password,
                cover_image = :cover_image
                WHERE id = :id
            ";

            $social_save = $db->execute($save_home, [
                'country_id' => $country ?? $check_home['country_id'],
                'state_id' => $state ?? $check_home['state_id'],
                'foster_name' => $foster_name ?? $check_home['foster_name'],
                'home_address' => $home_address ?? $check_home['home_address'],
                'contact_number' => $phone_number ?? $check_home['contact_number'],
                'email' => $email ?? $check_home['email'],
                'password' => md5($password) ?? $check_home['password'],
                'cover_image' => $cover_image ?? $check_home['cover_image'],
                'id' => $id
            ]);
            if ($social_save) {
                $error_message = "Social worker updated successfully";
                header("Location: ../../admin/home.php?success=" . $error_message);
                exit;
            } else {
                $error_message = "Failed to update social worker";
                header("Location: ../../admin/edit-social-worker.php?error=" . $error_message);
                exit;
            }
        }
    }
} else {
    $error_message = "method not allowed";
    header("Location: admin/login.php?error=" . $error_message);
}
