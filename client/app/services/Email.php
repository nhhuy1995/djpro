<?php
namespace DjClient\Services;

use Phalcon\Mvc\User\Component;

class Email extends Component
{
//    private static $USERNAME = "no-reply@very.vn";
    const MAIL_ADDRESS = "djpro@gmail.com";
    protected static $USERNAME = "noreply-blogradio@vnnplus.vn";
    protected static $PASSWORD = "hoicaigi!@#";

    /*public static function sendMail($subject, $address, $content)
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

    }*/
    public static function sendMail($subject,$to,$body)
    {
        require '../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
        $mail = new \PHPMailer();
        $mail->CharSet = "UTF-8";
//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = static::$USERNAME;                 // SMTP username
        $mail->Password = static::$PASSWORD;                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;                                    // TCP port to connect to

        $mail->setFrom(static::MAIL_ADDRESS, "DjPro");
        $mail->addAddress($to);
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $subject;
        $mail->Body = $body;
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
//            echo 'Message has been sent';
        }
    }
}