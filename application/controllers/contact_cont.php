<?php
class Contact_cont extends CI_Controller {
   // Controller class for Login
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('form');
		$this->load->library('email');
		//$this->load->model('email_settings_model');	//load model for sending email
		$this->load->model('contact_model');		//loading model
		$this->load->library('session');		//loading session
		//$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		//$this->cache->clean();
		require PHYSICAL_PATH_FRONT.'smtpmail/PHPMailerAutoload.php';
	}
    
    function index()				//load home page
	{
             //$this->load->view('includes/new_header');
			 $this->load->view('includes/header');
			 $send_contact['contact_res'] = $this->contact_model->get_contact();
             $this->load->view('contact/contact',$send_contact);
            //$this->load->view('includes/new_footer');
			 $this->load->view('includes/footer');
	         $this->load->view('contact/contact_script');
	}
	
	function store_contact_details()		//this function will call after form will submit
	{
		if($this->input->post('mode_cont') == "store_contact")
		{
			$data_to_store = array(
						'contacted_by'	=> stripslashes($this->input->post('name_cont')),
						'contact_email' => stripslashes($this->input->post('email_cont')),
						'company_name'	=> stripslashes($this->input->post('comp_cont')),
						'message'	=> stripslashes($this->input->post('msg_cont'))
					       );
			$send_contact = $this->contact_model->store_contact_details('contact_list',$data_to_store);
			
			if($send_contact == 1)
			{
				//$this->session->set_userdata('success_msg', 'Your query was received. Admin will contact you shortly.');die();
				$this->session->set_flashdata('success_msg', 'Your query was received. Admin will contact you shortly.');
				//echo $this->session->flashdata('message');
			}
			else
			{
				//$this->session->set_userdata('error_msg', 'Something is wrong. Please try again after some time.');
				$this->session->set_flashdata('error_msg', 'Something is wrong. Please try again after some time.');
			}
			redirect('contact_cont');
		}
	}
}
?>