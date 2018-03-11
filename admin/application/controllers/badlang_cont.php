

<?php

 ini_set("display_errors", "1");
        error_reporting(E_ALL);
        
class Badlang_cont extends CI_Controller {
   // Controller class for site_settings
	function __construct()
	{
		parent::__construct();
		$this->load->model('left_panel_model'); // calls the model
		$this->load->model('login_model');
		$this->load->model('site_settings_model'); // calls the model
		$this->load->model('badlang_model'); // calls the model
		$this->load->library('session');
        $this->load->helper('date');
		if($this->session->userdata('admin_is_logged_in')!=true)
		{
			$this->session->set_userdata('error_msg', 'Please login first.');
			redirect('login_cont');
		}
		else if($this->session->userdata('admin_is_superadmin')!=1)
		{
			$data=$this->login_model->page_details('badlang_cont','admin_management_list');
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
		
		$data['blog_data']=$this->badlang_model->get_bad_lang();
		$this->load->view('bad_lang/badlang_mgmt', $data);
		
		$this->load->view('includes/footer');
	}
	
	//============load view page of add_article================//
	function add_badlang()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$this->load->view('bad_lang/add_badlang');		
		$this->load->view('includes/footer');
	}
   
    //============insert data into article================//	
	function insert_badlang()
	{
		if($this->input->post('mode_blog')=='insert_blog')
		{
            	
                
                              
                                $data_to_store=array(
                                    'word' => $this->input->post('blog'),
									'status' =>  $this->input->post('status')
                                );
                                $insrt_data=$this->badlang_model->insert_badlang('bad_lang', $data_to_store);
                                if($insrt_data=='1')
                                {
                                    $this->session->set_userdata('success_msg', 'Data inserted successfully');
                                    redirect('badlang_cont');
                                }
                                else
                                {
                                    $this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
                                    redirect('badlang_cont/add_badlang');
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
		$updt_status = $this->badlang_model->change_status_to('bad_lang',$stat_param, $id);
		if($updt_status)
		{
			$this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot update status.');
		}
		redirect('badlang_cont');
	}
	 function del_data()
	 {
	    $id= $this->uri->segment(3);
		
		$del_data = $this->badlang_model->del_data('bad_lang', $id);
		if($del_data)
		{
			$this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot delete data.');
		}
		
        redirect('badlang_cont');
	 }

	//============load view page of edit_article================//
	function edit_blog()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$id= $this->uri->segment(3);
		//$this->load->view('article/edit_article');
		$data['blog_data']=$this->badlang_model->get_badlang($id);
		$this->load->view('bad_lang/edit_badlang',$data);
		$this->load->view('includes/footer');
	}
	
    //============update data into article================//	
	function update_badlang()
	{
		if($this->input->post('mode_blog')=='update_blog')
		{
               $id=$this->input->post('id');
				$data_to_store=array(
				'word' => $this->input->post('blog'),
				
				'status' => $this->input->post('status')
				);
				$upd_data=$this->badlang_model->update_badlang($id, $data_to_store);
				
				if($upd_data)
				{
				$this->session->set_userdata('success_msg', 'Data updated successfully');
				}
				else
				{
				$this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
				}
				redirect('badlang_cont');

                
            
        }
	}
	function add_csv()
	{
	    $this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$this->load->view('bad_lang/uploadcsv');		
		$this->load->view('includes/footer');
	 
	}
	function upload_sampledata()
	{
	      if (isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name']))
			{
	 
				 $fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
				 $flag=0;
				 $count=0;
				 $insert_csv = array();
				while($csv_line = fgetcsv($fp)) 
				{
					  
					  for ($i = 0,$j = count($csv_line); $i < $j; $i++) 
					  {
					     if($count>0)
						 {
							$insert_csv['word'] = $csv_line[0];
							$data=array(
										  "word"=>  $insert_csv['word']
										);
							$check_word=$this->badlang_model->insert_badlang('bad_lang', $data);
							if($check_word=='1')
							{
							   $flag=1;
							}
						 }
					  }
				 $count++;
				  
				} //while loop end
				if($flag==1)
				{
				  $this->session->set_userdata('success_msg', 'Data inserted successfully');
				}
				else
				{
				  $this->session->set_userdata('error_msg', 'Data inserted successfully');
				}
								   
	 
	         
				if ($_FILES["userfile"]["name"]!= "")
				  {
					  $ext=explode('/',strtolower($_FILES["userfile"]["type"]));
						  
					  $DIR_DOC = PHYSICAL_PATH."csv/badlang/";
					  //echo $DIR_DOC;
					  //die();
					  
					  $file_size=filesize($_FILES["userfile"]["tmp_name"]);
					  
					  $arra1 = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');
					  $arra2 = array('','','','','','','','','','','','','','','','','','','','','','','','','');
				  
					  $filename = str_replace($arra1, $arra2, $_FILES["userfile"]['name']);
					  $s=time().rand(000,999).$filename;
				  
					  $fileNormal = $DIR_DOC.$s;
				  
					  $file = $_FILES["userfile"]['tmp_name'];
					 
					  
					  $result = move_uploaded_file($file, $fileNormal);
					  
				  
					  
				  }	
							
			  
			}
			  
	   
	          redirect('badlang_cont');
	   
	   
	}

}
?>