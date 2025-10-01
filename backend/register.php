 <?php
    require_once('../includes/config/path.php');
    require_once(ROOT_PATH . 'includes/function.php');
    require_once(ROOT_PATH . 'includes/function.php');
    require_once('email/index.php');
    $db = new Database();

    if (isset($_POST['register'])) {
        $name =  trim(filter_input(INPUT_POST, "full_name", FILTER_SANITIZE_SPECIAL_CHARS));
        $ssn =  trim(filter_input(INPUT_POST, "ssn", FILTER_SANITIZE_SPECIAL_CHARS));
        $email =  trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS));
        $phone =  trim(filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS));
        $password =  trim(htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8"));
        // $country_id =  trim(filter_input(INPUT_POST, "country_id", FILTER_SANITIZE_SPECIAL_CHARS));
        // $state_id =  trim(filter_input(INPUT_POST, "state_id", FILTER_SANITIZE_SPECIAL_CHARS));
        $dob =  trim(filter_input(INPUT_POST, "dob", FILTER_SANITIZE_SPECIAL_CHARS));
        $address =  trim(filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS));
        $foster_home_id =  trim(filter_input(INPUT_POST, "foster_home_id", FILTER_SANITIZE_SPECIAL_CHARS));
        $date_of_admission =  trim(filter_input(INPUT_POST, "date_of_admission", FILTER_SANITIZE_SPECIAL_CHARS));
        $date_of_leaving =  trim(filter_input(INPUT_POST, "date_of_leaving", FILTER_SANITIZE_SPECIAL_CHARS));
        $foster_parent_name =  trim(filter_input(INPUT_POST, "foster_parent_name", FILTER_SANITIZE_SPECIAL_CHARS));
        $case_worker_name =  trim(filter_input(INPUT_POST, "case_worker_name", FILTER_SANITIZE_SPECIAL_CHARS));

        //placement details
        // $placement_name =  trim(filter_input(INPUT_POST, "placement_name", FILTER_SANITIZE_SPECIAL_CHARS));
        // $placement_reason =  trim(filter_input(INPUT_POST, "placement_reason", FILTER_SANITIZE_SPECIAL_CHARS));
        // $last_pickup_date =  trim(filter_input(INPUT_POST, "last_pickup_date", FILTER_SANITIZE_SPECIAL_CHARS));
        // $pickup_location =  trim(filter_input(INPUT_POST, "pickup_location", FILTER_SANITIZE_SPECIAL_CHARS));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Invalid email format";
            header("Location: ../register.php?error=" . $error_message);
            exit;
        } else {
            //check if email already exists
            $sql = "SELECT id FROM fosters WHERE email = :email";
            $query = $db->fetch($sql, ['email' => $email]);
            if (!empty($query)) {
                $error_message = "Email already exists,Kindly check.";
                header("Location: ../register.php?error=" . $error_message);
                exit;
            } else {
                //proceed to insert
                $verificationToken = bin2hex(random_bytes(16));
                $insert_sql = "INSERT INTO fosters (name,foster_home_id,email,ssn,phone_number,password,dob, address, verification_token) VALUES (:name,:foster_home_id,:email,:ssn,:phone_number,:password,:dob, :address, :verification_token)";
                $params = [
                    'name' => $name,
                    'foster_home_id' => $foster_home_id,
                    'email' => $email,
                    'ssn' => $ssn,
                    'password' => md5($password),
                    'phone_number' => $phone,
                    'dob' => $dob,
                    'address' => $address,
                    'verification_token' => $verificationToken
                ];
                $register = $db->execute($insert_sql, $params);
                if (!$register) {
                    $error_message = "Error occurred, try again later";
                    header("Location: ../register.php?error=" . $error_message);
                    exit;
                }
                $success_message = "Registration successful";
                //Send weelcome email to user
                $to = $email;
                // $verificationToken = bin2hex(random_bytes(16));
                $subject = "Welcome to Foster Care Reconnect!";
                $verificationLink = $_SERVER['HTTP_ORIGIN'] . "/verify-email.php?token=" . $verificationToken;
                $body = "
                    <p>Hello $name,</p>
                    <p>Welcome to Foster Care Reconnect! We're excited to have you on board.</p>
                    <p>To complete your registration, please verify your email address by clicking the link below:</p>
                    <p><a href='$verificationLink'>Verify Your Email Address</a></p>
                    <p>If you have any questions or need assistance, feel free to contact our support team at hello@fleggi.com.</p>
                    <p>Best regards,</p>
                    <p>Foster Care Reconnect Team</p>
                    ";
                // sendEmail($to, $name, $subject, $body);
                generalEmailSender($subject, $to, $body, $name);
                header("Location: ../login.php?success=" . $success_message);
                exit;
            }
        }
    } else {
        $error_message = "get method not allowed";
        header("Location: ../register.php?error=" . $error_message);
    }
