

<?php

 ini_set("display_errors", "1");
        error_reporting(E_ALL);
        
class Blog_tag extends CI_Controller {
   // Controller class for site_settings
	function __construct()
	{
		parent::__construct();
		$this->load->model('left_panel_model'); // calls the model
		$this->load->model('login_model');
		$this->load->model('site_settings_model'); // calls the model
		$this->load->model('blog_tag_model'); // calls the model
		$this->load->library('session');
        $this->load->helper('date');
		if($this->session->userdata('admin_is_logged_in')!=true)
		{
			$this->session->set_userdata('error_msg', 'Please login first.');
			redirect('login_cont');
		}
		else if($this->session->userdata('admin_is_superadmin')!=1)
		{
			$data=$this->login_model->page_details('blog_tag','admin_management_list');
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
        //============load view page of article================//
        function index()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		
		$data['blog_data']=$this->blog_tag_model->get_blog_value();
		$this->load->view('blog_tag/blog_tag_mgmt', $data);
		
		$this->load->view('includes/footer');
	}
	
	//============load view page of add_article================//
	function add_blog_tag()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$this->load->view('blog_tag/add_blog_tag');		
		$this->load->view('includes/footer');
	}
   
    //============insert data into article================//	
	function insert_blog_content()
	{
		if($this->input->post('mode_blog')=='insert_blog')
		{
            	
                
                              
                                $data_to_store=array(
                                    'tag_name' => $this->input->post('blog'),
									'status' =>  $this->input->post('status')
                                );
                                $insrt_data=$this->blog_tag_model->insert_blog_value('blog_tag', $data_to_store);
                                if($insrt_data=='1')
                                {
                                    $this->session->set_userdata('success_msg', 'Blog Tag inserted successfully');
                                    redirect('blog_tag');
                                }
                                else
                                {
                                    $this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
                                    redirect('blog_tag/add_blog_tag');
                                }
                            
                        
                
                

		}
	}

	//=============changin the status of article============//
	function change_status_to()
	{
		$stat_param= array(
			'status' => $this->uri->segment(3)
			);
		$id= $this->uri->segment(4);
		$updt_status = $this->blog_tag_model->change_status_to('blog_tag',$stat_param, $id);
		if($updt_status)
		{
			$this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot update status.');
		}
		redirect('blog_tag');
	}
	 function del_data()
	 {
	    $id= $this->uri->segment(3);
		
		$del_data = $this->blog_tag_model->del_data('blog_tag', $id);
		if($del_data)
		{
			$this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot delete data.');
		}
		
        redirect('blog_tag');
	 }

	//============load view page of edit_article================//
	function edit_blog()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$id= $this->uri->segment(3);
		//$this->load->view('article/edit_article');
		$data['blog_data']=$this->blog_tag_model->get_blog_tag($id);
		$this->load->view('blog_tag/edit_blog_tag',$data);
		$this->load->view('includes/footer');
	}
	
    //============update data into article================//	
	function update_blog()
	{
		if($this->input->post('mode_blog')=='update_blog')
		{
               
				$data_to_store=array(
				'tag_name' => $this->input->post('blog'),
				
				'status' => $this->input->post('status')
				);
				$upd_data=$this->blog_tag_model->update_blog_value($this->input->post('id'), $data_to_store);
				
				if($upd_data)
				{
				$this->session->set_userdata('success_msg', 'Blog Tag updated successfully');
				}
				else
				{
				$this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
				}
				redirect('blog_tag');

                
            
        }
	}

}
?>