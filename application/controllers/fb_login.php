<?php
    class fb_login extends CI_Controller{
        function index(){
            $this->load->helper(array('html','form'));
            $this->load->view("page_header");
            $this->load->view("site_form");
            $this->load->view("page_footer");
            
        }
        
        public function sbmt(){
            $this->load->database();
            $this->load->view("submt");
        }
    }
?>