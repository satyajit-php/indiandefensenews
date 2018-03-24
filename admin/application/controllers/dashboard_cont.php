<?php

class Dashboard_cont extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('left_panel_model');  //load model for sidepanel
        $this->load->model('login_model');  //load model for sidepanel

        $this->load->library('session');
        if ($this->session->userdata('admin_is_logged_in') != true) {
            $this->session->set_userdata('error_msg', 'Please login first.');
            redirect('login_cont');
        }
    }

    //============load view page of Dashboard================//
    function index() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $data['view'] = $this->login_model->get_totalViewer();
        $data['feedback'] = $this->login_model->get_totalNoReview('feedback');
        $data['blog'] = $this->login_model->get_totalNoReview('blog');
        $data['user'] = $this->login_model->get_totalNo('people', 'status', '1');
        $data['location'] = $this->login_model->get_totalNo('location', 'is_visible', '0');
        $data['subadmin'] = $this->login_model->get_totalNo('admin', 'its_superadmin', '0');



        $this->load->view('dashboard/dashboard', $data);
        $this->load->view('includes/footer');
    }

    //==============get total viewers listing page==============//
    function site_view() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $date = date('Y-m-d');
        $data['viewer'] = $this->login_model->get_allViewer('viewers_details', $date);
        //print_r($data);
        $this->load->view('dashboard/visitors', $data);
        $this->load->view('includes/footer');
    }

    //============visitors details ajax function=================//
    function visitor_ajax() {
        $day = $this->input->post('day');
        if ($day == 1) {
            //$date=date('Y-m-d',strtotime("+1 days"));
            $date = date('Y-m-d');
            $data['viewer'] = $this->login_model->get_allViewer('viewers_details', $date);
        } else if ($day == 2) {
            $yday = date('Y-m-d', strtotime("-1 days"));
            $data['viewer'] = $this->login_model->get_allViewer('viewers_details', $yday);
        } else if ($day == 3) {
            $date = date('Y-m-d');
            $yday = date('Y-m-d', strtotime("-7 days"));
            $data['viewer'] = $this->login_model->get_days_visitors('viewers_details', $date, $yday);
        } else if ($day == 4) {
            $date = date('Y-m-d');
            $yday = date('Y-m-d', strtotime("-30 days"));
            $data['viewer'] = $this->login_model->get_days_visitors('viewers_details', $date, $yday);
        } else if ($day == 5) {
            $date = date('Y-m-d');
            $yday = date('Y-m-d', strtotime("-365 days"));
            $data['viewer'] = $this->login_model->get_days_visitors('viewers_details', $date, $yday);
        }
        // print_r($data);
        $this->load->view('dashboard/visitors_ajax', $data);
    }

    public function my404($param) {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $this->load->view('dashboard/404');
        $this->load->view('includes/footer');
    }

}
