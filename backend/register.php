 <?php
    require_once('../includes/config/path.php');
    require_once(ROOT_PATH . 'includes/function.php');
    require_once(ROOT_PATH . 'includes/function.php');
    require_once('email/index.php');
    $db = new Database();

    //check for each step

    if (isset($_POST['register'])) {
        //sanitize and validate inputs
        if (isset($_POST['step']) && !empty($_POST['step'])) {
            $step = $_POST['step'];
            if ($step == 1) {
                $name =  trim(filter_input(INPUT_POST, "full_name", FILTER_SANITIZE_SPECIAL_CHARS));
                $ssn =  trim(filter_input(INPUT_POST, "ssn", FILTER_SANITIZE_SPECIAL_CHARS));
                $email =  trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS));
                $phone =  trim(filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS));
                $password =  trim(htmlspecialchars($_POST['password'], ENT_QUOTES, "UTF-8"));
                $dob =  trim(filter_input(INPUT_POST, "dob", FILTER_SANITIZE_SPECIAL_CHARS));
                $address =  trim(filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS));
                $foster_home_id =  trim(filter_input(INPUT_POST, "foster_home_id", FILTER_SANITIZE_SPECIAL_CHARS));
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
                        $success_message = "Proceed to Step 2";
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
                    <p>If you have any questions or need assistance, feel free to contact our support team at hello@reconnect.com</p>
                    <p>Best regards,</p>
                    <p>Foster Care Reconnect Team</p>
                    ";
                        generalEmailSender($subject, $to, $body, $name);
                        $foster_id = $db->lastInsertId();
                        header("Location: ../register-step-2.php?forster_id=" . $foster_id . "&success=" . $success_message . "&step=2");
                        exit;
                    }
                }
            } elseif ($step == 2) {
                $placement_name =  trim(filter_input(INPUT_POST, "placement_name", FILTER_SANITIZE_SPECIAL_CHARS));
                $placement_reason =  trim(filter_input(INPUT_POST, "placement_reason", FILTER_SANITIZE_SPECIAL_CHARS));
                $last_pickup_date =  trim(filter_input(INPUT_POST, "last_pickup_date", FILTER_SANITIZE_SPECIAL_CHARS));
                $final_placement_outcome =  trim(filter_input(INPUT_POST, "final_placement_outcome", FILTER_SANITIZE_SPECIAL_CHARS));
                $foster_id =  trim(filter_input(INPUT_POST, "foster_id", FILTER_SANITIZE_SPECIAL_CHARS));

                //Insert to Placement table
                $sql_placement = "INSERT INTO foster_placements (
                foster_id,placement_name,
                placement_reason,last_pickup_date,
                last_pickup_addresss,
                final_placement_outcome
                ) 
                VALUES (
                :foster_id,
                :placement_name,
                :placement_reason,
                :last_pickup_date,
                :last_pickup_addresss,
                :final_placement_outcome
                )";
                $params_placement = [
                    'foster_id' => $foster_id,
                    'placement_name' => $placement_name ?? null,
                    'placement_reason' => $placement_reason ?? null,
                    'last_pickup_date' => $last_pickup_date ?? null,
                    'last_pickup_addresss' => $pickup_location ?? null,
                    'final_placement_outcome' => $final_placement_outcome ?? null
                ];

                $register_placement = $db->execute($sql_placement, $params_placement);
                if (!$register_placement) {
                    $error_message = "Error occurred, try again later";
                    header("Location: ../register-step-2.php?error=" . $error_message . "&step=2");
                    exit;
                }
                $success_message = "Proceed to Step 3";
                header("Location: ../register-step-3.php?forster_id=" . $foster_id . "&success=" . $success_message . "&step=3");
                exit;
            } elseif ($step == 3) {
                $school_name =  trim(filter_input(INPUT_POST, "school_name", FILTER_SANITIZE_SPECIAL_CHARS));
                $event_attend =  trim(filter_input(INPUT_POST, "event_attend", FILTER_SANITIZE_SPECIAL_CHARS));
                $pet =  trim(filter_input(INPUT_POST, "pet", FILTER_SANITIZE_SPECIAL_CHARS));
                $holiday =  trim(filter_input(INPUT_POST, "holiday", FILTER_SANITIZE_SPECIAL_CHARS));
                $fun_fact =  trim(filter_input(INPUT_POST, "fun_fact", FILTER_SANITIZE_SPECIAL_CHARS));
                $foster_id =  trim(filter_input(INPUT_POST, "foster_id", FILTER_SANITIZE_SPECIAL_CHARS));

                //Insert to Placement table
                $sql_experience = "INSERT INTO foster_experiences (
                foster_id,school_name,
                events_attended,
                favourite_activities,
                pets,
                holidays
                ) 
                VALUES (
                :foster_id,
                :school_name,
                :events_attended,
                :favourite_activities,
                :pets,
                :holidays
                )";
                $params_experience = [
                    'foster_id' => $foster_id,
                    'school_name' => $school_name ?? null,
                    'events_attended' => $events_attended ?? null,
                    'favourite_activities' => $fun_fact ?? null,
                    'pets' => $pets ?? null,
                    'holidays' => $holidays ?? null
                ];

                $register_placement = $db->execute($sql_experience, $params_experience);
                if (!$register_placement) {
                    $error_message = "Error occurred, try again later";
                    header("Location: ../register-step-3.php?error=" . $error_message . "&step=2");
                    exit;
                }
                $success_message = "Registration completed successfully, Kindly check your email to verify your account";
                header("Location: ../login.php?&success=" . $success_message);
                exit;
            } else {
                $error_message = "Invalid step";
                header("Location: ../register.php?error=" . $error_message);
                exit;
            }
        } else {
            $error_message = "Permission denied";
            header("Location: ../register.php?error=" . $error_message);
            exit;
        }
    } else {
        $error_message = "get method not allowed";
        header("Location: ../register.php?error=" . $error_message);
    }
