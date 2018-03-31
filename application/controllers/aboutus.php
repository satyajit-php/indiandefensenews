<?php

class Aboutus extends CI_Controller {

    // Controller class for Login
    function __construct() {
        parent::__construct();
        $this->load->model('sidepanel_model'); //loading model
        $this->load->model('site_settings_model'); //loading model
        $this->load->library('session'); //loading session
    }

    //============load home page================//
    function index() {
        $aboutus = $this->site_settings_model->aboutus();
        $data['aboutus'] = $aboutus[0];
        $this->load->view('aboutus/index', $data);
    }

}

?>