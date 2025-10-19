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

    if (isset($_POST['form_type'])) {
        $form_type = $_POST['form_type'];
        if ($form_type == "profile_update") {
            $name =  trim(htmlspecialchars($_POST['name'], ENT_QUOTES, "UTF-8"));
            $dob =  trim(htmlspecialchars($_POST['dob'], ENT_QUOTES, "UTF-8"));
            $address =  trim(htmlspecialchars($_POST['address'], ENT_QUOTES, "UTF-8"));
            $ssn =  trim(htmlspecialchars($_POST['ssn'], ENT_QUOTES, "UTF-8"));
            $phone_number =  trim(htmlspecialchars($_POST['phone_number'], ENT_QUOTES, "UTF-8"));
            if ($name == "" || $dob == "" || $address == "" || $ssn == "" || $phone_number == "") {
                $error_message = "Required field can not be empty";
                header("Location: ../update-placement.php?error=" . $error_message);
                exit;
            } else {

                //Check if image is uploaded
                if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
                    $image = $_FILES['profile_image'];
                    $image_name = $image['name'];

                    //upload image
                    $target_dir = "../uploads/profile/";
                    $target_file = $target_dir . basename($image_name);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $check = getimagesize($image["tmp_name"]);
                    if ($check === false) {
                        $error_message = "File is not an image";
                        header("Location: ../update-placement.php?error=" . $error_message);
                        exit;
                    }
                    if (file_exists($target_file)) {
                        $error_message = "Sorry, file already exists";
                        header("Location: ../update-placement.php?error=" . $error_message);
                        exit;
                    }
                    if ($image['size'] > 2000000) {
                        $error_message = "Sorry, your file is too large";
                        header("Location: ../update-placement.php?error=" . $error_message);
                        exit;
                    }
                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
                        header("Location: ../update-placement.php?error=" . $error_message);
                        exit;
                    }
                    //check if directory exists else create it
                    if (!is_dir($target_dir)) {
                        mkdir($target_dir, 0777, true);
                    }
                    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
                        $error_message = "Sorry, there was an error uploading your file";
                        header("Location: ../update-placement.php?error=" . $error_message);
                        exit;
                    }
                    $image_path = "uploads/profile/" . $image_name;
                }
                $sql = "SELECT *  FROM fosters WHERE id = :id";
                $query = $db->fetch($sql, ['id' => $user_id]);
                if (!empty($query)) {
                    $update_sql = "UPDATE fosters SET 
                    name = :name,dob = :dob,address = :address,ssn = :ssn,phone_number = :phone_number, profile_image = :profile_image WHERE id = :id";
                    $update_query = $db->execute($update_sql, [
                        'name' => $name,
                        'dob' => $dob,
                        'address' => $address,
                        'ssn' => $ssn,
                        'phone_number' => $phone_number,
                        'profile_image' => $image_path ?? $query['profile_image'],
                        'id' => $user_id,
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
        } elseif ($form_type == "placement") {
            $placement_name =  trim(htmlspecialchars($_POST['placement_name'], ENT_QUOTES, "UTF-8"));
            $placement_reason =  trim(htmlspecialchars($_POST['placement_reason'], ENT_QUOTES, "UTF-8"));
            $last_pickup_date =  trim(htmlspecialchars($_POST['last_pickup_date'], ENT_QUOTES, "UTF-8"));
            $final_placement_outcome =  trim(htmlspecialchars($_POST['final_placement_outcome'], ENT_QUOTES, "UTF-8"));
            if ($placement_name == "" || $placement_reason == "" || $last_pickup_date == ""  || $final_placement_outcome == "") {
                $error_message = "Required field can not be empty";
                header("Location: ../update-placement.php?error=" . $error_message);
                exit;
            } else {

                $sql = "SELECT * FROM foster_placements WHERE foster_id = :foster_id";
                $query = $db->fetch($sql, ['foster_id' => $user_id]);
                if (!empty($query)) {
                    $update_sql_placement = "UPDATE foster_placements SET 
                    placement_name = :placement_name,
                    placement_reason = :placement_reason,
                    last_pickup_date = :last_pickup_date,
                    final_placement_outcome = :final_placement_outcome
                     WHERE foster_id = :foster_id";
                    $update_query = $db->execute($update_sql_placement, [
                        'placement_name' => $placement_name,
                        'placement_reason' => $placement_reason,
                        'last_pickup_date' => $last_pickup_date,
                        'final_placement_outcome' => $final_placement_outcome,
                        'foster_id' => $user_id
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
                        header("Location: ../update-placement.php?success=" . $success_message);
                        exit;
                    } else {
                        $error_message = "Error occurred. Please try again.";
                        header("Location: ../update-placement.php?error=" . $error_message);
                        exit;
                    }
                } else {
                    $error_message = "Permission denied, placement not found";
                    header("Location: ../update-placement.php?error=" . $error_message);
                    exit;
                }
            }
        } elseif ($form_type == "education") {
            $school_name =  trim(htmlspecialchars($_POST['school_name'], ENT_QUOTES, "UTF-8"));
            $pets =  trim(htmlspecialchars($_POST['pets'], ENT_QUOTES, "UTF-8"));
            $holidays =  trim(htmlspecialchars($_POST['holidays'], ENT_QUOTES, "UTF-8"));
            $favourite_activities =  trim(htmlspecialchars($_POST['favourite_activities'], ENT_QUOTES, "UTF-8"));
            if ($school_name == "" || $pets == "" || $holidays == "" || $favourite_activities == "") {
                $error_message = "Required field can not be empty";
                header("Location: ../update-education.php?error=" . $error_message);
                exit;
            } else {

                $sql = "SELECT * FROM foster_experiences WHERE foster_id = :foster_id";
                $query = $db->fetch($sql, ['foster_id' => $user_id]);
                if (!empty($query)) {
                    $update_sql = "UPDATE foster_experiences SET 
                    school_name = :school_name,
                    pets = :pets,
                    holidays = :holidays,
                    favourite_activities = :favourite_activities
                     WHERE foster_id = :foster_id";
                    $update_query = $db->execute($update_sql, [
                        'school_name' => $school_name,
                        'pets' => $pets,
                        'holidays' => $holidays,
                        'favourite_activities' => $favourite_activities,
                        'foster_id' => $user_id,
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
                        header("Location: ../update-education.php?success=" . $success_message);
                        exit;
                    } else {
                        $error_message = "Error occurred. Please try again.";
                        header("Location: ../update-education.php?error=" . $error_message);
                        exit;
                    }
                } else {
                    $error_message = "Permission denied, user not found";
                    header("Location: ../update-education.php?error=" . $error_message);
                    exit;
                }
            }
        } else {
            $error_message = "Update type not found";
            header("Location: ../update-education.php?error=" . $error_message);
            exit;
        }
    } else {
        $error_message = "Type not found";
        header("Location: ../update-profile.php?error=" . $error_message);
        exit;
    }
} else {
    $error_message = "Method not allowed";
    header("Location: ../update-profile.php?error=" . $error_message);
    exit;
}
