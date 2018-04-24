<?php

class all_function {

    function show_hello_world() {
        return 'Hello World';
    }

    function send_mail($email, $subject, $body) {

        require_once PHYSICAL_PATH_FRONT . '/smtpmail/PHPMailerAutoload.php';
        $mail = new PHPMailer;

        $mail->SMTPAuth = true; // Enaele SMTP authentication
        $mail->Username = 'AKIAI34IEADUOJKQNDMQ'; // SMTP username
        $mail->Password = 'Aqw2mEsLrWvrJUvC1bhb6y4IohwMTMsFTlDOc6GDySin'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted
        $mail->Host = 'email-smtp.us-east-1.amazonaws.com';
        $mail->Port = 587; //Set the SMTP port number - 587 for authenticated TLS
        $mail->setFrom('indiandefensenews6@gmail.com', 'indian defence news'); //Set who the message is to be sent from
        //$mail->addReplyTo('labnol@gmail.com', 'First Last'); //Set an alternative reply-to address
        //$mail->addAddress('care@creditmonk.com', 'Josh Adams'); // Add a recipient

        $mail->isHTML(true);
        $mail->FromName = 'Indiandefencenews';
        $mail->addAddress($email);     // Add a recipient
        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        //$mail->send();
        if (!$mail->send()) {
            // echo 'Message could not be sent.';
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
            $return = 0;
        } else {
            // echo 'Message has been sent';
            $return = 1;
        }
        return $return;
    }

}

?>