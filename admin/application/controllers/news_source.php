<?php

class News_source extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('left_panel_model');
        $this->load->model('news_source_model'); //load email template model
        $this->load->library('session');   //load session library

        if ($this->session->userdata('admin_is_logged_in') != true) {
            $this->session->set_userdata('error_msg', 'Please log in first..');
            redirect('login_cont');
        }
    }

    //============load view page of email template================//
    function index() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');

        $data['result_data'] = $this->news_source_model->lists('news_source');
        $this->load->view('news_source/list', $data);

        $this->load->view('includes/footer');
    }

    //============load view page of add_article================//
    function add() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $this->load->view('news_source/add');
        $this->load->view('includes/footer');
    }

    //============insert data into article================//	
    function insert_source() {
        if ($this->input->post('source')) {
            $data_to_store = $this->input->post('source');
            $insrt_data = $this->news_source_model->insert_source('news_source', $data_to_store);
            if ($insrt_data == '1') {
                $this->session->set_userdata('success_msg', 'Inserted successfully');
                redirect('news_source');
            } else {
                $this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
                redirect('news_source/add');
            }
        }
    }

    //=============changin the status of article============//
    function change_status_to() {
        $stat_param = array(
            'status' => $this->uri->segment(3)
        );
        $id = $this->uri->segment(4);
        $updt_status = $this->news_source_model->change_status_to('news_source', $stat_param, $id);
        if ($updt_status) {
            $this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot update status.');
        }
        redirect('news_source');
    }

    //=============delete the data from country============//
    function del_data() {
        $id = $this->uri->segment(3);
        $del_data = $this->news_source_model->del_data('news_source', $id);
        if ($del_data) {
            $this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot delete data.');
        }
        redirect('news_source');
    }

    //======================load edit country=====================//
    function edit() {
        $id = $this->uri->segment(3);
        $data_arr = $this->news_source_model->select_faqs('news_source', $id);
        $data['data_arr'] = $data_arr[0];

        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $this->load->view('news_source/edit', $data);
        $this->load->view('includes/footer');
    }

    //============update data into article================//	
    function update() {

        $data_to_store = $this->input->post('source');
        $id = $data_to_store['id'];
        unset($data_to_store['id']);
        $insrt_data = $this->news_source_model->update_data('news_source', $data_to_store, $id);
        if ($insrt_data == '1') {
            $this->session->set_userdata('success_msg', ' Updated successfully');
        } else {
            $this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
        }
        redirect('news_source');
    }

}

?>