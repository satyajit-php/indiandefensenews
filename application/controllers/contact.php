<?php

class Contact extends CI_Controller {

    // Controller class for Login
    function __construct() {
        parent::__construct();
        $this->load->model('sidepanel_model'); //loading model

        $this->load->library('session'); //loading session
    }

    //============load home page================//
    function index() {
        $this->load->view('contact/index');
    }

}

?>