<?php
class Forgot_pass_cont extends CI_Controller {
   // Controller class for Login
	function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');	//loading model
		$this->load->library('session');	//loading session
		if($this->session->userdata('is_logged_in')==true)
		{
			redirect('dashboard_cont');			
		}
		else if($this->session->userdata('admin_is_superadmin')!=1)
		{
			$data=$this->login_model->page_details('forgot_pass_cont','admin_management_list');
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
    
    //============load view page of login================//
    function index()
	{
		$this->load->view('includes/header');
		$this->load->view('forgot_password/forgot_pass');
	}
	
	//============submit login page(After login this function is called)================//
        function after_login()
	{
		if($this->input->post('mode_login')=='after_login')
		{
			//============this is for remember me section==============//
			if($this->input->post('remember_me')=='checked')
			{
				setcookie('cookie_value','checked',time()+60*60*60*24*365);
				setcookie('cookie_email',$this->input->post('email'),time()+60*60*60*24*365);
				setcookie('cookie_password',$this->input->post('password'),time()+60*60*60*24*365);
			}
			//============this is for remember me section==============//
			
			$data_to_store=array(
				'uname' => $this->input->post('email'),
				'password' => $this->input->post('password')
			);
			
			$login = $this->login_model->login_admin('admin', $data_to_store);
			//echo $login;
			//die();
			if($login == 1)
			{
				$this->session->set_userdata('success_msg', 'Logged In successfully');
				redirect('dashboard_cont');
			}
			else if($login == 'block')
			{
				$this->session->set_userdata('error_msg', 'Cannot login. You are blocked by admin.');
				redirect('login_cont');
			}
			else if($login == 'wrong')
			{
				$this->session->set_userdata('error_msg', 'Username or password is wrong.');
				redirect('login_cont');
			}
		}
	}
	function check_mail()     // check if this email id registerd as admin
	{
	   $email=$this->input->post('email');
	   $data_to_store=array("email"=>$email);
	  echo  $login = $this->login_model->mail_id('admin', $data_to_store);
	   
	}
}
?>