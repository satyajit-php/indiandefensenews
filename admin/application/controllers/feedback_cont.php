<?php

class Feedback_cont extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('left_panel_model'); // calls the model
        $this->load->model('site_settings_model'); // calls the model
        $this->load->model('login_model');
        $this->load->model('slider_model'); // calls the model
        $this->load->model('feedback_model');    //calls the model
        $this->load->model('flag_off_model');

        $this->load->library('session');
        $this->load->helper('date');
        if ($this->session->userdata('admin_is_logged_in') != true) {
            $this->session->set_userdata('error_msg', 'Please login first.');
            redirect('login_cont');
        } else if ($this->session->userdata('admin_is_superadmin') != 1) {
            $data = $this->login_model->page_details('feedback_cont', 'admin_management_list');
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

    //============load view page of feedback================//
    function index() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $data['feedback_details'] = $this->feedback_model->get_all_feedback();
        $this->load->view('feedback/feedback_list', $data);
        $this->load->view('includes/footer');
    }

    //============= start delete feedback============//
    function del_data() {
        $id = $this->uri->segment(3);
        $del_data = $this->feedback_model->del_data('feedback', $id);
        if ($del_data) {
            $this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot delete data.');
        }
        redirect('feedback_cont');
    }

    //===============update feedback===================//

    function update_feedback() {
        $feedbackId = $this->uri->segment(3);
        $data['particular_feedback'] = $this->feedback_model->feedback_update($feedbackId);
        //print_r($data['particular_feedback']);
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $this->load->view('feedback/feedback_edit', $data);
        $this->load->view('includes/footer');
    }

    //================end update feedback================//
    //==================email section start=======================//

    function sendMessage() {
        //$userId = $this->input->post('message_to');
        $feedback_id = $this->input->post('feedback_id');
        $messageSubject = $this->input->post('message_subject');
        $messageDesc = $this->input->post('message_desc');
        //$data_arr_people=array('id' => $userId);
        $receiver_email = $this->input->post('receiver_mail');

        $emailtmp = $this->flag_off_model->emailTempfedd('email_template', 11);
        $body = $emailtmp[0]->email_desc;

        $logo = "<a href='" . base_url() . "'><img src='" . base_url() . "assets/images/logo-1.png' alt=''></a>";

        //$sessionFlash = 0;

        $baseurl_admin = base_url();
        $baseurl = str_replace('admin/', '', $baseurl_admin);
        //this is for footer section in email template//
        //generating social logos//
        $sites = $this->left_panel_model->site_list('site_settings', 'facebook', 'twitter', 'linkedin');
        $social_logo = "<a href='" . $sites->facebook . "' style='cursor: pointer;'><img src='" . base_url() . "assets/images/facebook-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>
		<a href='" . $sites->linkedin . "' style='cursor: pointer;'><img src='" . base_url() . "assets/images/linkedin-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>
		<a href='" . $sites->twitter . "' style='cursor: pointer;'><img src='" . base_url() . "assets/images/twitter-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>";
        //generating social logos//
        //echo $social_logo;die();
        //generating static links//
        $static_pages = "<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='" . $baseurl . "home/disclaimer'>Disclaimer</a>
		/ <a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='" . $baseurl . "home/privacy'>Privacy</a> /
		<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='" . $baseurl . "home/termsCondition'> Terms &amp; Conditions</a> /
		<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='" . $baseurl . "home/helpCenter?tab=Guiding'> Help</a>";
        //generating static links//
        //this is for footer section in email template//
        $link = base_url() . "company/index?company_name=&company_location=&page=1";
        $email_name = explode('@', $receiver_email);
        // Sende mail section
        $email_plcholders2 = array("[RECEIVER]", "[LINK]", "[LOGO]", "[SOCIAL_LOGO]", "[STATICPAGES]", "[BASEURL]", "Your comments have been successfully delivered to our team of moderators. Your comments, help to make us perform better.");
        $email_plcholders_rplc2 = array($email_name[0], $link, $logo, $social_logo, $static_pages, $baseurl, $messageDesc);
        $body = str_replace($email_plcholders2, $email_plcholders_rplc2, $body);

        if ($this->send_mail($receiver_email, $messageSubject, $body) == 0) {
            $this->session->set_userdata('success_msg', 'Email has been sent successfully.');
            redirect('feedback_cont/update_feedback/' . $feedback_id);
        } else {
            $this->session->set_userdata('error_msg', 'Email not sent.');
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
        $mail->isHTML(true);
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

    //====================email section end========================//
}
