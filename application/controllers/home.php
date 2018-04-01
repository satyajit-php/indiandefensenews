<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Home extends CI_Controller {

    // Controller class for Login
    function __construct() {
        parent::__construct();

        $this->load->model('site_settings_model'); //loading model
        $this->load->model('home_model'); //loading model
    }

    //============load home page================//
    function index() {
        $data['slider'] = $slider = $this->home_model->get_slider();
        $this->load->view('home/index', $data);
    }

    function log_out() {           // log out function
        $this->session->unset_userdata('is_logged_in');
        $this->session->unset_userdata('uid');
        $this->session->unset_userdata('comenterid');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('profile_pic');
        $this->session->set_userdata('success_msg', 'You have logged out successfully.');
        redirect('home');
    }

    function subsciption() {
        $email = $this->input->post('subsciptionmail');
        $flag = $this->site_settings_model->subscription($email);
        if ($flag==1) {
            $template_html = $this->site_settings_model->get_email_template(37);

            if (!empty($template_html)) {
                $subject = $template_html[0]['email_title'];
                $body = $template_html[0]['email_desc'];
//                print_r($email);
//                die();
                $flag = $this->send_mail($email, $subject, $body);
            }
        }
        echo $flag;
    }

    function send_mail($email, $subject, $body) {

        require_once PHYSICAL_PATH_FRONT . '/smtpmail/PHPMailerAutoload.php';
        $mail = new PHPMailer;

        $mail->SMTPAuth = true; // Enaele SMTP authentication
        $mail->Username = 'AKIAJ6AJODAGYITYGQBA'; // SMTP username
        $mail->Password = 'Au+CqTt19E+zv/KhcCxyfaiNO7Mru0BqUssB8pvNgqU4'; // SMTP password
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