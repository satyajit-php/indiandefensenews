<?php
class Edit_pass_cont extends CI_Controller {
   // Controller class for site_settings
	function __construct()
	{
		parent::__construct();
		$this->load->model('left_panel_model'); // calls the model
		$this->load->model('site_settings_model'); // calls the model
		$this->load->model('edit_pass_model'); // calls the model
		$this->load->library('session');
		$this->load->library('encrypt');                //load the encrypt class
		//if($this->session->userdata('is_logged_in')!=true)
		//{
		//	$this->session->set_userdata('error_msg', 'Please login first.');
		//	redirect('login_cont');
		//}
		
	}
    //============load view page of feature================//
    function index()
	{
	
        $this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$data['admin_data']=$this->edit_pass_model->get_row_by_id('admin', 'its_superadmin', 1);
		$this->load->view('edit_pass/edit_pass', $data);		
		$this->load->view('includes/footer');
	}
    //Updating password
    function update_pass()
	{
		$id = $this->input->post('user_id');
		$pwd = $this->input->post('new_pass');
		$pwd = $this->encrypt->encode($pwd);
		$data_to_pass=array(
							'password' => $pwd
							);
		$upd_data= $this->edit_pass_model->update_recordset($id, $data_to_pass);	
		
		if($upd_data==1)
		{
			$this->session->set_userdata('success_msg', 'Password updated successfully');
			redirect('dashboard_cont');
		}
        else if($upd_data==0)
		{
			$this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
			redirect('dashboard_cont');
		}
		redirect('dashboard_cont');       
	}
   
}
?>