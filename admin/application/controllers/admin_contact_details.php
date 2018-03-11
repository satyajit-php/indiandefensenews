<?php
class Admin_contact_details extends CI_Controller {
   // Controller class for admin contact
	function __construct()
	{
		parent::__construct();
		$this->load->model('left_panel_model');		//load model for sidepanel
		$this->load->model('admin_contact_model');	// calls the model
		$this->load->model('login_model');
		$this->load->library('session');			//loading session
		if($this->session->userdata('admin_is_logged_in')!=true)
		{
			$this->session->set_userdata('error_msg', 'Please login first.');
			redirect('login_cont');
		}
		else if($this->session->userdata('admin_is_superadmin')!=1)
		{
			$data=$this->login_model->page_details('admin_contact_details','admin_management_list');
			$page_id=$data[0]->id;
			//print_r($this->session->all_userdata());
			$id=$this->session->userdata('admin_uid');
			$admin_val_arr=$this->login_model->page_access('admin',$id);
			$page_arr=explode(',', $admin_val_arr[0]->page_access);
			if(!(in_array($page_id,$page_arr)))
			{
			$this->session->set_userdata('error_msg', 'You Don\'t Have Permission To Access This Page.');		
			redirect('dashboard_cont');
			}

		}
	}
       
    //============load view page of admin contact================//
	function index()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
	
		$admin_data['rows'] = $this->admin_contact_model->admin_getdata();// calling the function of that model
		$this->load->view('site_settings/admin_contact',$admin_data); //calling the view
		
		$this->load->view('includes/footer');
	}

	//============Update values of admin contact details table================//
	function update_contact()
	{
		if($this->input->post('mode_settings')=='admin_settings')
		{
			$data_to_updt=array(
				'email' => $this->input->post('adminEmail'),
				'phone_no' => $this->input->post('adminPh'),
				);
						
			$updt_settings = $this->admin_contact_model->update_data('admin_contact_details', $data_to_updt);
			if($updt_settings)
			{
				$this->session->set_userdata('success_msg', 'Data updated successfully.');
			}
			else
			{
				$this->session->set_userdata('error_msg', 'Failed to update data.');
			}
			redirect('admin_contact_details');
		}
	}
}
 ?>   