<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class LibEmail {
    public $CI;
    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('ghPartner');
    }

    public function contentNotificationPersonalIncome(){
        $content = file_get_contents('emailtemplate/contentNotificationPersonalIncome.php');
        return $content;
    }

    public function sendEmail($mail_from, $mail_to, $subject, $content){
        $mail = new PHPMailer();
        $name_to = "TEST NAME TO";

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->SMTPDebug = 0;
            $mail->CharSet = "UTF-8";
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'mynameismrbinh@gmail.com';                     // SMTP username
            $mail->Password   = 'xanhdotimvang';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('mynameismrbinh@gmail.com', 'GioHang');
            $mail->addAddress($mail_to, $name_to);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $content;

            $success = $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    public function sendEmailFromServer($mail_to,$name_to, $subject, $content){
        $mail = new PHPMailer();

        $serverConfig = [
            'Host' => 'mail.supremecluster.com',
            'SMTPDebug' => 0,
            'Port' => "25/2525",
            'SMTPAuth' => true,
            'Username' => 'love@gh.sinva.vn',
            'Password' => 'gioHang@134679@',
        ];

        try {
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';

            $mail->Host       = $serverConfig['Host']; // SMTP server example
            $mail->SMTPDebug  = $serverConfig['SMTPDebug'];                     // enables SMTP debug information (for testing)
            $mail->SMTPAuth   = $serverConfig['SMTPAuth'];                  // enable SMTP authentication
            $mail->Port       = $serverConfig['Port'];                    // set the SMTP port for the GMAIL server
            $mail->Username   = $serverConfig['Username']; // SMTP account username example
            $mail->Password   = $serverConfig['Password'];        // SMTP account password example
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $content;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            //Recipients
            $mail->setFrom($serverConfig['Username'], 'GioHang');
            $mail->addAddress($mail_to, $name_to);     // Add a recipient
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }


}
?>