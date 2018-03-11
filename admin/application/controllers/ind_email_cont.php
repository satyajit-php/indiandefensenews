<?php

class ind_email_cont extends CI_Controller {

    // Controller class for site_settings
    function __construct() {
        parent::__construct();
        $this->load->model('left_panel_model'); // calls the model
        $this->load->model('login_model');

        $this->load->model('site_settings_model'); // calls the model
        $this->load->model('ind_email_model'); // calls the model
        $this->load->library('session');
        $this->load->helper('date');
        if ($this->session->userdata('admin_is_logged_in') != true) {
            $this->session->set_userdata('error_msg', 'Please login first.');
            redirect('login_cont');
        } else if ($this->session->userdata('admin_is_superadmin') != 1) {
            $data = $this->login_model->page_details('ind_email_cont', 'admin_management_list');
            $page_id = $data[0]->id;
            //print_r($this->session->all_userdata());
            $id = $this->session->userdata('admin_uid');
            $admin_val_arr = $this->login_model->page_access('admin', $id);
            $page_arr = explode(',', $admin_val_arr[0]->page_access);
            if (!(in_array($page_id, $page_arr))) {
                $this->session->set_userdata('error_msg', 'You Don\'t Have Permission To Access This Page.');
                redirect('dashboard_cont');
            }
        }
    }

    //=============loading view page==========//
    function index() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $data['email_temp'] = $this->ind_email_model->get_temp('email_template');
        $this->load->view('email/email_temp', $data);
        $this->load->view('includes/footer');
    }

    function mail_send() {
        $sender = $this->input->post('e_address');
        $subject = $this->input->post('subject');
        $body = $this->input->post('email_body');
        $logo = "<a href='" . base_url() . "'><img src='" . base_url() . "assets/images/logo-1.png' alt=''></a>";
        $baseurl_admin = base_url();
        $baseurl = str_replace('admin/', '', $baseurl_admin);
        //this is for footer section in email template//
        //generating social logos//
        $sites = $this->left_panel_model->site_list('site_settings', 'facebook', 'twitter', 'linkedin');
        $social_logo = "<a href='" . $sites->facebook . "' style='cursor: pointer;'><img src='" . base_url() . "assets/images/socailloginicons/facebook-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>
			<a href='" . $sites->linkedin . "' style='cursor: pointer;'><img src='" . base_url() . "assets/images/socailloginicons/linkedin-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>
			<a href='" . $sites->twitter . "' style='cursor: pointer;'><img src='" . base_url() . "assets/images/socailloginicons/twitter-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>";
        //generating social logos//
        //generating static links//
        $static_pages = "<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='" . $baseurl . "home/disclaimer'>Disclaimer</a>
		/ <a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='" . $baseurl . "home/privacy'>Privacy</a> /
		<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='" . $baseurl . "home/termsCondition'> Terms &amp; Conditions</a> /
		<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='" . $baseurl . "home/helpCenter?tab=Guiding'> Help</a>";
        //generating static links//
        //this is for footer section in email template//
        $link = $baseurl . "company/index?company_name=&company_location=&page=1";
        $email_details = array("[LINK]", "[LOGO]", "[SOCIAL_LOGO]", "[STATICPAGES]", "[BASEURL]");
        $email_details_rplc = array($link, $logo, $social_logo, $static_pages, $baseurl);

        $body = str_replace($email_details, $email_details_rplc, $body);

        if ($this->send_mail($sender, $subject, $body) == 0) {
            $this->session->set_userdata('success_msg', 'Email has been sent successfully.');
            redirect('ind_email_cont');
        } else {
            $this->session->set_userdata('error_msg', 'Email not sent.');
            redirect('ind_email_cont');
        }
    }

    function send_mail($email, $subject, $body) {

        require_once PHYSICAL_PATH_FRONT . '/smtpmail/PHPMailerAutoload.php';
        $mail = new PHPMailer;

        $mail->IsSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup server
        $mail->SMTPAuth = true; // Enaele SMTP authentication
        $mail->Username = 'care@creditmonk.com'; // SMTP username
        $mail->Password = 'clrpqjkaumioosze'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted
        $mail->Port = 587; //Set the SMTP port number - 587 for authenticated TLS
        $mail->setFrom('care@creditmonk.com', 'Care Creditmonk'); //Set who the message is to be sent from
        //$mail->addReplyTo('labnol@gmail.com', 'First Last'); //Set an alternative reply-to address
        //$mail->addAddress('milon.kanrar@esolzmail.com', 'Josh Adams'); // Add a recipient
        $mail->isHTML(true);
        $mail->FromName = 'Credit Monk';
        $mail->addAddress($email);     // Add a recipient
        $mail->WordWrap = 50;
        $mail->Subject = $subject;
        $mail->Body = $body;
        //$mail->send();
        if (!$mail->send()) {
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
            $return = 1;
        } else {
            //echo 'Message has been sent';
            $return = 0;
        }
        return $return;
        //die;
    }

}

?>
