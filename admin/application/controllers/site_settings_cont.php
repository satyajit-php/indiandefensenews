<?php
class Site_settings_cont extends CI_Controller {
   // Controller class for site_settings
	function __construct()
	{
		parent::__construct();
		$this->load->model('elastic_model');	
		$this->load->model('left_panel_model');		//load model for sidepanel
		$this->load->model('site_settings_model');	// calls the model
		$this->load->model('login_model');
		$this->load->library('session');			//loading session
		if($this->session->userdata('admin_is_logged_in')!=true)
		{
			$this->session->set_userdata('error_msg', 'Please login first.');
			redirect('login_cont');
		}
		else if($this->session->userdata('admin_is_superadmin')!=1)
		{
			$data=$this->login_model->page_details('site_settings_cont','admin_management_list');
			$page_id=$data[0]->id;
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
       
    //============load view page of site settings================//
	function index()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
	        
		$site_settings_data['rows'] = $this->site_settings_model->site_getdata();// calling the function of that model
		$this->load->view('site_settings/site_settings',$site_settings_data); //calling the view
		
		$this->load->view('includes/footer');
	}

	//============Update values of site settings table================//
	function update_site()
	{
		if($this->input->post('mode_settings')=='site_settings')
		{
			$data_to_updt=array(
				'site_name' => $this->input->post('webname'),
				'website_url' => $this->input->post('weburl'),
				'admin_email' => $this->input->post('adminEmail'),
				'notificationemail' => $this->input->post('notificationEmail'),
				'meta_key' => $this->input->post('metakey'),
				'meta_title' => $this->input->post('metatitle'),
				'meta_desc' => $this->input->post('metadesc'),
				'rec_per_page_admin' => $this->input->post('rppAdmin'),
				'rec_per_page_user' => $this->input->post('rppUser'),
				'facebook' => $this->input->post('fb'),
				'twitter' => $this->input->post('twit'),
				'rss' => $this->input->post('rss'),
				'linkedin' => $this->input->post('linkedin'),
				'instagram' => $this->input->post('instagram'),
				'google_plus' => $this->input->post('google'),
				'youtube' => $this->input->post('youtube'),
				'pinterest' => $this->input->post('pinterest'),
				'reditt' => $this->input->post('reditt'),
				'vimeo' => $this->input->post('vimeo'),
				'elastick'=> $this->input->post('elastick')
				);
						
			$updt_settings = $this->site_settings_model->update_data('site_settings', $data_to_updt);
			if($updt_settings)
			{
				$this->session->set_userdata('success_msg', 'Data updated successfully.');
			}
			else
			{
				$this->session->set_userdata('error_msg', 'Failed to update data.');
			}
			redirect('site_settings_cont');
		}
	}
}
 ?>   