<?php

class Privacypolicy extends CI_Controller {

    // Controller class for site_settings
    function __construct() {
        parent::__construct();
        $this->load->model('left_panel_model'); // calls the model
        $this->load->model('login_model');
        $this->load->model('site_settings_model'); // calls the model
        $this->load->model('privacypolicy_model'); // calls the model
        $this->load->library('session');
        $this->load->helper('date');
        if ($this->session->userdata('admin_is_logged_in') != true) {
            $this->session->set_userdata('error_msg', 'Please login first.');
            redirect('login_cont');
        } else if ($this->session->userdata('admin_is_superadmin') != 1) {
            $data = $this->login_model->page_details('blog_cont', 'admin_management_list');
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

    //============load view page of article================//
    function index() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $data['privacy_data'] = $this->privacypolicy_model->get_privacy_value();
        $this->load->view('privacy/index', $data);
        $this->load->view('includes/footer');
    }

    //============load view page of edit_article================//
    function edit_privacypolicy() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        //$this->load->view('article/edit_article');
        $id = $this->uri->segment(3);
        $data['privacy_data'] = $this->privacypolicy_model->sel_data_up($id);
        $this->load->view('privacy/edit', $data);
        $this->load->view('includes/footer');
    }

    //============update data into article================//	
    function update_privacypolicy() {
        if ($this->input->post('mode_privacy') == 'update') {
            $id = $this->input->post('id');
            $data_to_store = array(
                'message' => $this->input->post('message'),
                'status' => $this->input->post('status'),
            );
            $upd_data = $this->privacypolicy_model->update_policy_value('privacy_policy', $this->input->post('id'), $data_to_store);

            if ($upd_data) {
                $this->session->set_userdata('success_msg', 'Privacy Policy content updated successfully');
            } else {
                $this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
            }
            redirect('privacypolicy');
        }
    }

}

?>