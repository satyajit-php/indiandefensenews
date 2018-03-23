<?php
class Email_settings_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    /**
    * Validate the login's data with the database
    * @param string $user_name
    * @param string $password
    * @return void
    */

    //==============send mail function=============================//
    function send_mail($email,$subject,$body)
    {
        require PHYSICAL_PATH_FRONT.'smtpmail/PHPMailerAutoload.php';
        $mail = new PHPMailer();
       
        $mail->isSMTP();                                       // Set mailer to use SMTP
        $mail->Host = "ssl://smtp.gmail.com";                 // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                              // Enable SMTP authentication
        $mail->Username = 'esolz.technologies@gmail.com';   // SMTP username
        $mail->Password = 'un!techvikas';                  // SMTP password
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);                              // Set email format to HTML
        $mail->From = 'esolz.technologies@gmail.com';
        $mail->Port = 465;                               // TCP port to connect to
     
        //$mail->Port=26;    // Enable encryption, 'ssl' also accepted
        //$mail->From = ADMIN_EMAIL;
        //$mail->FromName = SITE_NAME;
        $mail->FromName = 'CreditMonk';
        $mail->addAddress($email);     // Add a recipient
        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        //$mail->send();
        if(!$mail->send())
        {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           $return=1;
           exit;
        }
        else
        {
           //echo 'Message has been sent';
           $return=0;
        }
        return $return;  
    }
}
?>