<?php
class Email_template_cont extends CI_Controller {
   
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('left_panel_model');
		$this->load->model('email_template_model'); //load email template model
		$this->load->library('session');			//load session library
		if($this->session->userdata('is_logged_in')!=true)
		{
			$this->session->set_userdata('error_msg', 'Please log in first..');		
			redirect('login_cont');
		}
	}
    
    //============load view page of email template================//
    function index()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		
		$data['result'] = $this->email_template_model->select_email_template();
		$this->load->view('email_template/email_template', $data);
		
		$this->load->view('includes/footer');
	}

    //============load view page to add email template================//
	function add_email_template()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		
		$this->load->view('email_template/add_email_template');
		
		$this->load->view('includes/footer');
	}

    //============insert data into email template================//
	function insert_email_template()
	{
		$data=array(
					'email_type' => $this->input->post('email_type'),
					'email_title' => $this->input->post('email_title'),
					'email_desc' => $this->input->post('email_body'),
					'modified_by' => $this->session->userdata('uid')
					);
		
		$insrt_data = $this->email_template_model->email_template_admin('email_template',$data);
		if($insrt_data)
		{
			$this->session->set_userdata('success_msg', 'Data added susseccfully.');
			redirect('email_template_cont');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot add duplicate data.');
			redirect('email_template_cont/add_email_template');
		}

	}

	//=============changin the status of email template============//
	function change_status_to()
	{
		$stat_param= array(
			'status' => $this->uri->segment(3)
			);
		$id= $this->uri->segment(4);
		$updt_status = $this->email_template_model->change_status_to('email_template',$stat_param, $id);
		if($updt_status)
		{
			$this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot update status.');
		}
		redirect('email_template_cont');
	}

	//=============delete the data from email template============//
	function del_data()
	{
		$id= $this->uri->segment(3);
		$del_data = $this->email_template_model->del_data('email_template', $id);
		if($del_data)
		{
			$this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot delete data.');
		}
		redirect('email_template_cont');
	}
	
	 //============load view page to edit email template================//
	function edit_email_template()
	{	$id = $this->uri->segment(3);
	         //echo $id;die();
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$email_template_data['details'] = $this->email_template_model->edit_email_template_model($id);
		//echo"<pre>";
		//print_r($email_template_data['details']);
		//die();
		$this->load->view('email_template/edit_email_template',$email_template_data);
		
		$this->load->view('includes/footer');
	}

    //============update data of email template================//
	function update_email_template()
	{
		$id= $this->input->post('id');
		//echo $id;die();
		$data=array(
					'email_type' => $this->input->post('email_type'),
					'email_title' => $this->input->post('email_title'),
					'email_desc' => $this->input->post('email_body'),
					'status' => $this->input->post('status'),
					'modified_by' => $this->session->userdata('uid')
					);
		
		$update_data = $this->email_template_model->update_email_template_model('email_template',$id,$data);
		if($update_data)
		{
			$this->session->set_userdata('success_msg', 'Data updated susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
		}
			redirect('email_template_cont');

	}


}