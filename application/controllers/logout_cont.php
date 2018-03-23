<?php
class Logout_cont extends CI_Controller {
   
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}
	
    //============Implementing functionality of logout================//
    function index()
	{
		$this->session->unset_userdata('is_logged_in');
		$this->session->unset_userdata('user_name');
		$this->session->set_userdata('success_msg', 'Logged Out Successfully.');
		redirect('login_cont');
	}
}