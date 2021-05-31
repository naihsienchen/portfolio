<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

function send_email($to_email, $to_name, $subject, $body)
{
    $mail = new PHPMailer();
    try {
        //Server settings
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure= 'tls';
        $mail->Port       = 587;
        $mail->Username   = 'onroutehelp@gmail.com';
        $mail->Password   = 'vjcttwpcykojgfrr';

        //Recipients
        $mail->setFrom('onroutehelp@gmail.com', 'Mailer');
        $mail->addAddress($to_email, $to_name);

        //Content
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        // echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

