<?php

class Contact extends CI_Controller {

    // Controller class for Login
    function __construct() {
        parent::__construct();
        $this->load->model('sidepanel_model'); //loading model
        $this->load->model('guest_post_model');
        $this->load->model('site_settings_model'); //loading model
        $this->load->library('session'); //loading session
    }

    //============load home page================//
    function index() {
        $data['htmlcontent'] = $htmlcontent = $this->guest_post_model->contactpage_html();
        if ($this->input->post('writeus')) {
            $writeus = $this->input->post('writeus');
            $writeus['story'] = $writeus['message'];
            unset($writeus['message']);
            $writeus['posted_on'] = date('y-m-d');
            $id = $this->guest_post_model->guest_post_insert($writeus);
            if ($id) {
                $template_html = $this->site_settings_model->get_email_template(28);
                if (!empty($template_html)) {
                    $logourl = "<a href='" . base_url() . "'><img class='img-responsive' src='" . LOGO_URL . "' alt='indiandefensenews.org'></a>";
                    $subject = $template_html[0]['email_title'];
                    $body = $template_html[0]['email_desc'];
                    $body = str_replace("[LOGO]", $logourl, $body);
                    $body = str_replace("[LINK]", base_url(), $body);
                }
                $data = $this->guest_post_model->select_($id);
                $email = $data[0]->email;
                $emailflag = $this->all_function->send_mail($email, $subject, $body);
                if ($emailflag == 1) {
                    $flag = 3;   // email send
                } else {
                    $flag = 4;      // not send
                }
            }
            echo $flag;
        } else {
            $this->load->view('contact/index', $data);
        }
    }

}

?>