<?php

class Login_cont extends CI_Controller {

    // Controller class for Login
    function __construct() {
        parent::__construct();
        $this->load->model('left_panel_model');
        $this->load->model('login_model'); //loading model
        $this->load->library('session'); //loading session
        $this->load->library('encrypt');
        if ($this->session->userdata('admin_is_logged_in') == true) {
            redirect('dashboard_cont');
        }
    }

    //============load view page of login================//
    function index() {
        $this->load->view('includes/header');
        $this->load->view('login/login');
    }

    //============submit login page(After login this function is called)================//
    function after_login() {
        if ($this->input->post('mode_login') == 'after_login') {
            //============this is for remember me section==============//
            if ($this->input->post('remember_me') == 'checked') {
                setcookie('cookie_value', 'checked', time() + 60 * 60 * 60 * 24 * 365);
                setcookie('cookie_email', $this->input->post('email'), time() + 60 * 60 * 60 * 24 * 365);
                setcookie('cookie_password', $this->input->post('password'), time() + 60 * 60 * 60 * 24 * 365);
            }
            //============this is for remember me section==============//

            $data_to_store = array(
                'uname' => $this->input->post('email'),
                'password' => $this->input->post('password')
            );

            $login = $this->login_model->login_admin('admin', $data_to_store);
            //echo $login;
            //die();
            if ($login == 1) {
                $this->session->set_userdata('success_msg', 'Logged In successfully');
                redirect('dashboard_cont');
            } else if ($login == 'block') {
                $this->session->set_userdata('error_msg', 'Cannot login. You are blocked by admin.');
                redirect('login_cont');
            } else if ($login == 'wrong') {
                $this->session->set_userdata('error_msg', 'Username or password is wrong.');
                redirect('login_cont');
            }
        }
    }

    function forgotpass() {
        if ($this->input->post('forgot_pass') == 'forgot_password') {

            $data_email = array(
                'email' => $this->input->post('email')
            );
            //print_r($data_email);die();
            $data['email_chk'] = $this->login_model->email_chk_user('admin', $data_email);

            if ($data['email_chk']) {
                $this->session->set_userdata('success_msg', ' An email has been sent to you.If it is not found in inbox please check in spam');
                redirect('forgot_pass_cont');
            } else {
                $this->session->set_userdata('error_msg', 'Failed to send activation code .');
                redirect('login_cont');
            }
        }
    }

    function getact() {
        $code = $this->uri->segment(3);
        $data['admin_exist'] = $this->login_model->check_security($code);
        //echo "<pre>";
        //print_r($data);
        //die();
        if ($data['admin_exist']['num'] > 0) {
            $this->load->view('includes/header');
            $this->load->view('forgot_password/reset', $data);
        } else {
            $this->session->set_userdata('error_msg', 'Retrieve password code is not correct.');
            redirect('login_cont');
        }
    }

    function getpassword() {
        $sc = $this->input->post('sec');
        $data['security'] = $sc;
        $r = $this->login_model->check_security($sc);
        if ($r == 1) {


            $this->load->view('includes/header');
            $this->load->view('forgot_password/reset', $data);
        } else {
            $this->session->set_userdata('error_msg', 'Activation code is wrong.');
            redirect('login_cont/getact');
        }
    }

    function update() {
        $id = $this->input->post('admin_id');
        $pw = $this->input->post('pass');
        $pw = $this->encrypt->encode($pw);
        $r = $this->login_model->update($id, $pw);
        if ($r == 1) {
            $res = $this->login_model->login_forgotpass($id);
            if ($res) {
                $this->session->set_userdata('success_msg', 'Password has been updated successfully.');
                redirect('dashboard_cont');
            } else {
                $this->session->set_userdata('error_msg', 'Fail to Retrive the Password.');
                redirect('login_cont');
            }
        }
    }

}

?>