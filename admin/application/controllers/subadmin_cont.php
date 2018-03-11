<?php
class Subadmin_cont extends CI_Controller {
   
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->model('left_panel_model');		//load model for sidepanel
        $this->load->model('login_model');
        $this->load->model('subadmin_model');		//load model for subadmin
        $this->load->library('session');                //load library for session
        $this->load->library('encrypt');                 // load encryption class
        if($this->session->userdata('admin_is_logged_in')!=true)
        {
            $this->session->set_userdata('error_msg', 'Please login first.');
            redirect('login_cont');
        }
        else if($this->session->userdata('admin_is_superadmin')!=1)
		{
			$data=$this->login_model->page_details('subadmin_cont','admin_management_list');
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
    
    //============load view page of Subadmin================//
    function index()
    {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        
        $data['subadmin_arr']=$this->subadmin_model->fetch_subadmin();
        $this->load->view('subadmin/subadmin', $data);
        
        $this->load->view('includes/footer');
    }
    
    //=============changing the status of subadmin============//
    function change_status_to()
    {
        $stat_param= array(
                        'status' => $this->uri->segment(3)
                    );
        $id= $this->uri->segment(4);
        $updt_status = $this->subadmin_model->change_status_to('admin',$stat_param, $id);
        if($updt_status)
        {
            $this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
        }
        else
        {
            $this->session->set_userdata('error_msg', 'Cannot update status.');
        }
        redirect('subadmin_cont');
    }

    //=============delete subadmin from admin============//
    function del_data()
    {
        $id= $this->uri->segment(3);
        $del_data = $this->subadmin_model->del_data('admin', $id);
        if($del_data)
        {
            $this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
        }
        else
        {
            $this->session->set_userdata('error_msg', 'Cannot delete data.');
        }
        redirect('subadmin_cont');
    }
    
    //============load view page of add_Subadmin================//
    function add_subadmin()
    {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        
        $this->load->view('subadmin/add_subadmin');
        
        $this->load->view('includes/footer');
    }
    
    //============insert subadmin===============//
    function insert_subadmin()
    {
        
        $data_to_store=array(
                        'uname' => $this->input->post('uname'),
                        'password' => $this->input->post('pass'),
                        'email' => $this->input->post('email'),
                        'page_access' => $this->input->post('nav_id')
                        );
        $page_arr=explode(',',$data_to_store['page_access']);
		for($i=0;$i<count($page_arr);$i++)
		{
			$parent=$this->subadmin_model->getparentID($page_arr[$i]);
                        if($parent!=0)
                        {
                            $data_to_store['page_access']=$data_to_store['page_access'].','.$parent;
                        }
                        else{
                            $data_to_store['page_access']=$data_to_store['page_access'];
                        }
		}
             
        //print_r($data_to_store);die();
        $insert_data = $this->subadmin_model->insert_subadmin('admin',$data_to_store);
        //echo $insert_data;
        //die();
        if($insert_data==1)
        {
            $this->session->set_userdata('success_msg', 'Data Inserted successfully. An email has been sent to this user.');
        }
        else if($insert_data == 'username')
        {
            $this->session->set_userdata('error_msg', 'Username must be unique.');
        }
        else if($insert_data == 'email')
        {
            $this->session->set_userdata('error_msg', 'Email must be unique.');
        }
        else if($insert_data=='both')
        {
            $this->session->set_userdata('error_msg', 'Cannot insert duplicate data.');
        }
        redirect('subadmin_cont');
    }
    
    //============Edit subadmin===============//
    function edit_subadmin()
    {
        $id= $this->uri->segment(3);
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        
        $data['subadmin_data'] = $this->subadmin_model->get_subadmin($id);
        $this->load->view('subadmin/edit_subadmin', $data);
        
        $this->load->view('includes/footer');
    }
    
    //============Update subadmin===============//
    function update_subadmin()
    {
        $page_access_array = [];
        $id= $this->uri->segment(3);
		
        $nav_id_array = explode(',', $this->input->post('nav_id'));
        foreach($nav_id_array as $val) {
            if (strpos($val,'-') !== false) {
                $val_array = explode('-', $val);
                array_push($page_access_array, $val_array[0], $val_array[1]);
            }else{
                array_push($page_access_array, $val);
            }
        }
        $page_accesss = array_unique($page_access_array);
        $page_access = implode(',', $page_accesss);
        $data_to_store=array(
                        'uname' =>  $this->input->post('uname'),
                        'email' =>  $this->input->post('email'),
                        'password' => $this->input->post('pass'),
                        'page_access' => $page_access
                        );
        //print_r($data_to_store);die();
        $updt_data = $this->subadmin_model->update_subadmin('admin',$data_to_store, $id);
        
        if($updt_data==1)
        {
            $this->session->set_userdata('success_msg', 'Data Updated successfully. An email has been sent to this user.');
        }
        else if($updt_data == 'username')
        {
            $this->session->set_userdata('error_msg', 'Username must be unique.');
        }
        else if($updt_data == 'email')
        {
            $this->session->set_userdata('error_msg', 'Email must be unique.');
        }
        else if($updt_data=='both')
        {
            $this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
        }
        redirect('subadmin_cont');
    }
    
    function uniquechk()        // chking user for unique
    {
          $element_value=$this->input->post('element_value');
          $flag=$this->input->post('flag');
      
         if($flag==1)
         {
            echo $flag = $this->subadmin_model->uniquechk('admin',$element_value,'uname');  
         }
         else
          echo  $flag = $this->subadmin_model->uniquechk('admin',$element_value,'email');  
         
    }
    
    function uniquechk_edit()
    {
          $element_value=$this->input->post('element_value');
          $flag=$this->input->post('flag');
          $id=$this->input->post('uid');
      
         if($flag==1)
         {
             echo $flag = $this->subadmin_model->uniquechk_edit('admin',$element_value,$id,'uname'); 
         }
         else
           echo $flag = $this->subadmin_model->uniquechk_edit('admin',$element_value,$id,'email'); 
    }
    function getparentID()
    {
        $id = $this->input->post('id');
       echo  $parentID = $this->subadmin_model->getparentID($id);
    }
}