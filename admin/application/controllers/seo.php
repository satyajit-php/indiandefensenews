<?php

class Seo extends CI_Controller {

    // Controller class for site_settings
    function __construct() {
        parent::__construct();
        $this->load->model('left_panel_model'); // calls the model
        $this->load->model('login_model');
        $this->load->model('site_settings_model'); // calls the model
        $this->load->model('seo_model'); // calls the model
        $this->load->library('session');
        $this->load->helper('date');
        if ($this->session->userdata('admin_is_logged_in') != true) {
            $this->session->set_userdata('error_msg', 'Please login first.');
            redirect('login_cont');
        } else if ($this->session->userdata('admin_is_superadmin') != 1) {
            $data = $this->login_model->page_details('seo', 'admin_management_list');
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
        $data['seo_data'] = $this->seo_model->get_seo_value();
        $this->load->view('seo/index', $data);
        $this->load->view('includes/footer');
    }

    //============load view page of edit_article================//
    function edit() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        //$this->load->view('article/edit_article');
        $id = $this->uri->segment(3);
        $data['seo_data'] = $this->seo_model->sel_data_up($id);
        $this->load->view('seo/edit', $data);
        $this->load->view('includes/footer');
    }

    function add() {

        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $this->load->view('seo/add');
        $this->load->view('includes/footer');
        if ($this->input->post()) {
            $data_to_store = array(
                'routes' => $this->input->post('routes'),
                'keyword' => $this->input->post('keyword'),
                'description' => $this->input->post('description'),
                'url' => $this->input->post('url'),
                'title' => $this->input->post('title'),
                'og_description' => $this->input->post('og_description'),
                'og_type' => $this->input->post('og_type')
            );
            $insert_data = $this->seo_model->insert_seo_value('seo', $data_to_store);
            if ($insert_data) {
                $this->session->set_userdata('success_msg', 'Seo content added successfully');
                redirect('seo');
            } else {
                $this->session->set_userdata('error_msg', 'Cannot add data.');
                redirect('seo/add');
            }
        }
    }

    //============update data into article================//	
    function update() {
        if ($this->input->post('mode') == 'update') {
            $id = $this->input->post('id');
            //print_r($_FILES['attachment_file']);
             $data_to_store = array(
                'routes' => $this->input->post('routes'),
                'keyword' => $this->input->post('keyword'),
                'description' => $this->input->post('description'),
                'url' => $this->input->post('url'),
                'title' => $this->input->post('title'),
                'og_description' => $this->input->post('og_description'),
                'og_type' => $this->input->post('og_type')
            );
            $upd_data = $this->seo_model->update_value('seo', $this->input->post('id'), $data_to_store);

            if ($upd_data) {
                $this->session->set_userdata('success_msg', 'Seo content updated successfully');
            } else {
                $this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
            }
            redirect('seo');
        }
    }

}

?>