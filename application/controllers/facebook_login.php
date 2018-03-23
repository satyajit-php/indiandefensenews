<?php

class facebook_login extends CI_Controller{
    function __construct()
    {
	    parent::__construct();
	    $this->load->library('encrypt');
	    $this->load->library('session');
	    $this->load->model('fb_model');	//loading model
	    
	    $this->load->helper('url');
    }
    function index()
    {
       $this->load->view('includes/header');
    }
    
    function facebook_login_cont()
    {            
	$data = $this->fb_model->facebook_login_model();
	if($data===true)
	{ 
	    
	    $this->session->set_userdata('success_msg', 'Register successfully');
	    redirect('account_settings/index');
	  
	}
	if($data==='already_has')
	{ 
	    
	    redirect('account_settings/index');
	  
	}
	elseif($data===false)
	{
	    $this->session->set_userdata('error_msg', 'Your facebook email id blocked by admin.');
	    redirect('home');
	}
	else
	{
	    $this->load->view('includes/header');
	    $this->load->view('includes/intermideate_email', $data);
	    $this->load->view('includes/footer');
	}
    }
}
?>
