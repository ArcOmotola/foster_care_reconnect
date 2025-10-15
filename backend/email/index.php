<?php



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//


function generalEmailSender($subject, $email, $body, $recipient_name)
{
    require_once 'PHPMailer-master/src/Exception.php';
    require_once 'PHPMailer-master/src/PHPMailer.php';
    require_once 'PHPMailer-master/src/SMTP.php';
    // Instantiation and passing [ICODE]true[/ICODE] enables exceptions
    $mail = new PHPMailer(true);
    try {

        //Server settings

        $mail->SMTPDebug = 0;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP

        $mail->Host       = '';  // Specify main and backup SMTP servers

        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication

        $mail->Username   = '';                     // SMTP username

        $mail->Password   = '';                               // SMTP password

        $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, [ICODE]ssl[/ICODE] also accepted

        $mail->Port       = 465;                                    // TCP port to connect to



        //Recipients

        $mail->setFrom('', 'Foster care reconnnect');

        $mail->addAddress($email, $recipient_name);     // Add a recipient

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;

        $mail->Body    = '<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Welcome Email</title>

    <style>

        body {

            font-family: Arial, sans-serif;

            background-color: #ab4b4b;

            color: #333;

            margin: 0;

            padding: 0;

        }

        .container {

            width: 80%;

            max-width: 600px;

            margin: 20px auto;

            background-color: #fff;

            padding: 20px;

            border-radius: 10px;

            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

        }

        .header {

            text-align: center;

            padding: 10px 0;

            background-color: #000000;

            color: white;

            border-radius: 10px 10px 0 0;

        }

        .header img {

            max-width: 150px;

            margin: 10px auto;

        }

        .content {

            padding: 20px;

            text-align: left;

        }

        .footer {

            text-align: center;

            padding: 10px 0;

            background-color: #f1f1f1;

            border-radius: 0 0 10px 10px;

            font-size: 0.9em;

        }

        .btn {

            display: inline-block;

            padding: 10px 20px;

            margin: 20px 0;

            background-color: #ab4b4b;

            color: white;

            text-decoration: none;

            border-radius: 5px;

        }

    </style>

</head>

<body>

    <div class="container">

        <div class="header">

            <img src="../assets/img/logo.png" alt="Foster care Logo">
        </div>
        <div class="content">' .

            $body
            . '
            <p>Best regards,<br>FOSTER CARE Team</p>

        </div>

        <div class="footer">

            <p>&copy; 2025 FOSTER CARE. All rights reserved.</p>

        </div>

    </div>

</body>

</html>

';

        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';



        $mail->send();



        return 'success';

        // Log::info("Email sent Successfully");



    } catch (Exception $e) {

        // Log::error("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");

        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
