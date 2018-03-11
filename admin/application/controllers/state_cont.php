<?php
class State_cont extends CI_Controller {
   
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->model('left_panel_model');		//load model for sidepanel
        $this->load->model('state_model');		//load model for state
        $this->load->library('session');                //load library for session
		$this->load->library('pagination');
		
        if($this->session->userdata('admin_is_logged_in')!=true)
        {
            $this->session->set_userdata('error_msg', 'Please login first.');
            redirect('login_cont');
        }
    }
    
    //============load view page of State================//
    function index()
    {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $data['state_arr']=$this->state_model->fetch_state();
        $this->load->view('state/state', $data);
        $this->load->view('includes/footer');
    }
    //============load view page of add_state================//
	function add_state()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		//$data['country_arr']=$this->state_model->fetch_state();
        $data['state_arr']=$this->state_model->fetch_state();
		$this->load->view('state/add_state', $data);		
		$this->load->view('includes/footer');
	}
    //============insert data into state================//	
	function insert_state()
	{
		if($this->input->post('mode_state')=='insert_state')
		{
			$data_to_store=array(
				'country_id' => $this->input->post('country_id'),
				'state' => $this->input->post('state'),
				'modified_by' => $this->session->userdata('admin_uid')
				
			);
			$insrt_data=$this->state_model->insert_state_value('state', $data_to_store);
			if($insrt_data=='1')
			{
				$this->session->set_userdata('success_msg','State inserted successfully');
				redirect('state_cont');
			}
			else
			{
				$this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
				redirect('state_cont/add_state');
			}
		}
	}
	//=============changin the status of state============//
	function change_status_to()
	{
		$stat_param= array(
			'status' => $this->uri->segment(3)
			);
		$id= $this->uri->segment(4);
		$updt_status = $this->state_model->change_status_to('state',$stat_param,$id);
		if($updt_status)
		{
			$this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot update status.');
		}
		redirect('state_cont');
	}
	//=============delete the data from state============//
	function del_data()
	{
		$id= $this->uri->segment(3);
		$del_data = $this->state_model->del_data('state', $id);
		if($del_data)
		{
			$this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot delete data.');
		}
		redirect('state_cont');
	}
	
	//======================load edit state=====================//
	function edit_state()
	{
		$id= $this->uri->segment(3);
		$data['state_array'] = $this->state_model->get_state('state', $id);
		
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		
        $this->load->view('state/edit_state', $data);
		$this->load->view('includes/footer');
	}
	//============update data into state================//	
	function update_state()
	{
		$id= $this->input->post('id');
		//echo $id;die();
		$data_to_store=array(
			'country_id' => $this->input->post('country_id'),
			'state' => $this->input->post('state'),
			'status' => $this->input->post('status'),
			'modified_by' => $this->session->userdata('admin_uid')
                       
		);
              
		//print_r($data_to_store);
		//die();
		$insrt_data=$this->state_model->update_state_value('state', $data_to_store, $id);
		if($insrt_data=='1')
		{
			$this->session->set_userdata('success_msg', 'state update successfully');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Can not update duplicate data.');
		}
		redirect('state_cont');
	}
	
}