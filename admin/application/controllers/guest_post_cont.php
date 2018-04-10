<?php

class guest_post_cont extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('left_panel_model');
        $this->load->model('login_model');
        $this->load->model('guest_post_model');   //load email template model
        $this->load->library('session');   //load session library
        $this->load->library('email');    //load email library
        if ($this->session->userdata('admin_is_logged_in') != true) {
            $this->session->set_userdata('error_msg', 'Please log in first..');
            redirect('login_cont');
        } else if ($this->session->userdata('admin_is_superadmin') != 1) {
            $data = $this->login_model->page_details('email_template_cont', 'admin_management_list');
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

    //=============changin the status of news letter============//
    function change_status_to() {
        $stat_param = array(
            'status' => $this->uri->segment(3)
        );
        $id = $this->uri->segment(4);
        $updt_status = $this->guest_post_model->change_status_to('newsletter', $stat_param, $id);
        if ($updt_status) {
            $this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot update status.');
        }
        redirect('news_letter_cont');
    }

    function edit($id = false) {
        if ($id) {

            $data['data_arr'] = $this->guest_post_model->get_data('guest_post', $id);
            $this->load->view('includes/header');
            $this->load->view('includes/top_header');
            $this->load->view('includes/left_panel');
            $this->load->view('guest_post/edit', $data);
            $this->load->view('includes/footer');
        } else {
            if ($this->input->post('id')) {
                $id = $this->input->post('id');
                if ($this->input->post('status') == "P") {
                    redirect("blog_cont/add_blog/$id");
                } else {
                    $stat_param['status'] = $this->input->post('status');
                    $flag = $this->guest_post_model->change_status_to('guest_post', $stat_param, $id);
                    if ($flag) {
                        $this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
                    } else {
                        $this->session->set_userdata('error_msg', 'Cannot update status.');
                    }
                    redirect('guest_post_cont');
                }
            } else {
                redirect('guest_post_cont');
            }
        }
    }

    //============load view page of email template================//
    function index() {
        $flag = $this->uri->segment(3);
        $status = $this->input->get('status');
        if ($status) {
            $data['result'] = $this->guest_post_model->select_post($status);
        } else {
            $data['result'] = $this->guest_post_model->select_post();
        }

        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $this->load->view('guest_post/index', $data);
        $this->load->view('includes/footer');
    }

    //=================send mail to subscribers==================//
    function sendmail_to() {
        $data_to_send = array(
            'email_sub' => $_REQUEST['email_sub'],
            'nav_id' => $_REQUEST['nav_id'],
            'send_to' => $_REQUEST['email_type']
        );

        //print_r($data_to_send);
        //die();
        $send_mail = $this->guest_post_model->sendmail_to($data_to_send);
        //$this->session->set_userdata('success_msg', 'Mail sent susseccfully.');
        //if($send_mail)
        //{
        //	$this->session->set_userdata('success_msg', 'Mail sent susseccfully.');
        //}
        //else
        //{
        //	$this->session->set_userdata('error_msg', 'Something is wrong. Mail cannot be sent.');
        //}
        //redirect('news_letter_cont');
    }

}

?>