<?php
class Change_pass_cont extends CI_Controller {
   
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->model('left_panel_model');		//load model for sidepanel
        $this->load->model('profile_dtls_model');		//load model for change pass
        $this->load->library('session');                //load library for session
		$this->load->library('pagination');
		
        if($this->session->userdata('is_logged_in')!=true)
        {
            $this->session->set_userdata('error_msg', 'Please login first.');
            redirect('login_cont');
        }
    }
    
    //============load view page of change pass================//
    function index()
    {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $this->load->view('profile_details/change_pass');
        $this->load->view('includes/footer');
    }
    //============update data into admin================//
	
	function update_pass()
	{
		$id= $this->input->post('id');
		
		$data_to_store=array(
			
			'password' => $this->input->post('Confirm_Password')
		);
		
		//print_r($data_to_store);
		//die();
		$update_data=$this->profile_dtls_model->update_pass_value('admin', $data_to_store, $id);
		if($update_data=='1')
		{
			$this->session->set_userdata('success_msg', 'Password updated successfully');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Can not update data.');
		}
		redirect('profile_details_cont');
	}
	
}