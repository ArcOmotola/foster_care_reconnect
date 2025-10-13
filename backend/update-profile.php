<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');
require_once('email/index.php');
$db = new Database();
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit;
}
$user_id = $_SESSION['id'];
if (isset($_POST['submit'])) {
    $name =  trim(htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8"));
    $dob =  trim(htmlspecialchars($_POST['dob'], ENT_QUOTES, "UTF-8"));
    $address =  trim(htmlspecialchars($_POST['address'], ENT_QUOTES, "UTF-8"));
    $ssn =  trim(htmlspecialchars($_POST['ssn'], ENT_QUOTES, "UTF-8"));
    $phone_number =  trim(htmlspecialchars($_POST['phone_number'], ENT_QUOTES, "UTF-8"));
    if ($name == "" || $dob == "" || $address == "" || $ssn == "" || $phone_number == "") {
        $error_message = "Required field can not be empty";
        header("Location: ../update-profile.php?error=" . $error_message);
        exit;
    } else {
        $sql = "SELECT *  FROM fosters WHERE id = :id";
        $query = $db->fetch($sql, ['id' => $user_id]);
        if (!empty($query)) {
            $update_sql = "UPDATE fosters SET 
            name = :name,dob = :dob,address = :address,ssn = :ssn,phone_number = :phone_number WHERE id = :id";
            $update_query = $db->execute($update_sql, [
                'name' => $name,
                'dob' => $dob,
                'address' => $address,
                'ssn' => $ssn,
                'phone_number' => $phone_number,
                'id' => $user_id
            ]);
            if ($update_query) {
                //log ptofile update
                $log_update = "INSERT INTO loggers (foster_id,log_type,actions,message) VALUE (:foster_id, :log_type, :actions, :message)";
                $params = [
                    "foster_id" => $user_id,
                    "log_type" => "profile update",
                    "actions" => "put",
                    "message" => "Update my profile data"
                ];
                $db->execute($log_update, $params);
                $success_message = "Profile updated successfully, thanks.";
                header("Location: ../update-profile.php?success=" . $success_message);
                exit;
            } else {
                $error_message = "Error occurred. Please try again.";
                header("Location: ../update-profile.php?error=" . $error_message);
                exit;
            }
        } else {
            $error_message = "Permission denied, user not found";
            header("Location: ../update-profile.php?error=" . $error_message);
            exit;
        }
    }
} else {
    $error_message = "Permission denied";
    header("Location: ../update-profile.php?error=" . $error_message);
    exit;
}
