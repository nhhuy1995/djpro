<?php
namespace DjClient\Services;

use Phalcon\Mvc\User\Component;

class Email extends Component
{
    const MAIL_ADDRESS = "no-reply@very.vn";

    public static function sendMail($subject, $address, $content)
    {
        $headers = 'MIME-Version: 1.0' . "\r\n";
//        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//        $headers .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From:" . self::MAIL_ADDRESS;
        mail($address, $subject, $content, $headers);
//        require_once('web/plugin/phpmailer/class.phpmailer.php');
//        $mail = new \PHPMailer(); // create a new object
//        $mail->IsSMTP(); // enable SMTP
//        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
//        $mail->SMTPAuth = true; // authentication enabled
//        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
//        $mail->Host = "mail.authonly.vn";
//        $mail->Port = 25; // or 587
//        $mail->IsHTML(true);
//        $mail->Username = "support@authonly.vn";
//        $mail->Password = "sp123";
//        $mail->SetFrom("support@authonly.vn", "Authonly");
//        $mail->Subject = "Test";
//        $mail->Body = "hello";
//        $mail->AddAddress("nhhuy1995@gmail.com");
//        if (!$mail->Send()) {
//            echo "Mailer Error: " . $mail->ErrorInfo;
//            die;
//        } else {
//            echo "Message has been sent";
//            die;
//        }

    }
}