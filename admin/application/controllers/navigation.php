<?php

class Navigation extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->model('left_panel_model');  //load model for sidepanel
        $this->load->library('session');                //load library for session
        $this->load->library('pagination');
        $this->load->model('navigation_model');
        $this->load->model('state_model');

        if ($this->session->userdata('admin_is_logged_in') != true) {
            $this->session->set_userdata('error_msg', 'Please login first.');
            redirect('login_cont');
        }
    }

    //============load view page of State================//
    function index() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $data['nav_arr'] = $this->navigation_model->fetch_data();
        $this->load->view('navigation/index', $data);
        $this->load->view('includes/footer');
    }

    //============load view page of add_state================//
    function add_navigation() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        //$data['country_arr']=$this->navigation_model->fetch_state();

        $this->load->view('navigation/add_navigation');
        $this->load->view('includes/footer');
    }

    //============insert data into state================//	
    function insert_nav() {
        if ($this->input->post('name')) {
            $data_to_store = array(
                'parent_id' => $this->input->post('parent_id'),
                'name' => $this->input->post('name'),
                'url' => $this->input->post('url'),
                'status' => $this->input->post('status')
            );
            $insrt_data = $this->navigation_model->insert_nav_value('navbar', $data_to_store);
            if ($insrt_data == '1') {
                $this->session->set_userdata('success_msg', 'Navigation inserted successfully');
                redirect('navigation');
            } else {
                $this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
                redirect('navigation/add_navigation');
            }
        }
    }

    //=============changin the status of state============//
    function change_status_to() {
        $stat_param = array(
            'status' => $this->uri->segment(3)
        );
        $id = $this->uri->segment(4);
        $updt_status = $this->navigation_model->change_status_to('navbar', $stat_param, $id);
        if ($updt_status) {
            $this->session->set_userdata('success_msg', 'Navigation Updated susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot update status.');
        }
        redirect('navigation');
    }

    //=============delete the data from state============//
    function del_data() {
        $id = $this->uri->segment(3);
        $del_data = $this->navigation_model->del_data('navbar', $id);
        if ($del_data) {
            $this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot delete data.');
        }
        redirect('navigation');
    }

    //======================load edit state=====================//
    function edit_navigation() {
        $id = $this->uri->segment(3);
        $data['nav_array'] = $this->navigation_model->get_nav('navbar', $id);

        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');

        $this->load->view('navigation/edit_navigation', $data);
        $this->load->view('includes/footer');
    }

    //============update data into state================//	
    function update_state() {
        $id = $this->input->post('id');
        //echo $id;die();
        $data_to_store = array(
            'parent_id' => $this->input->post('parent_id'),
            'name' => $this->input->post('name'),
            'url' => $this->input->post('url'),
            'status' => $this->input->post('status')
        );

        //print_r($data_to_store);
        //die();
        $insrt_data = $this->navigation_model->update_nav_value('navbar', $data_to_store, $id);
        if ($insrt_data == '1') {
            $this->session->set_userdata('success_msg', 'Navigation update successfully');
        } else {
            $this->session->set_userdata('error_msg', 'Can not update duplicate data.');
        }
        redirect('navigation');
    }

}

?>