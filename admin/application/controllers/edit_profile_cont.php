<?php

class Edit_profile_cont extends CI_Controller {
   // Controller class for site_settings
	function __construct()
	{
		parent::__construct();
		$this->load->model('left_panel_model'); // calls the model
		$this->load->model('login_model'); // calls the model
		$this->load->model('site_settings_model'); // calls the model
		$this->load->model('edit_profile_model'); // calls the model
		$this->load->library('session');
		if($this->session->userdata('is_logged_in')!=true)
		{
			$this->session->set_userdata('error_msg', 'Please login first.');
			redirect('login_cont');
		}else if($this->session->userdata('admin_is_superadmin')!=1)
		{
			$data=$this->login_model->page_details('edit_profile_cont','admin_management_list');
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
//		error_reporting(E_ALL);
//        ini_set('display_errors', '1');
	}
    
	//============load view page of feature================//
    function index()
	{
		$id=$this->session->userdata('uid');
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$data['features']=$this->edit_profile_model->get_all($id);
		$this->load->view('edit_profile/edit_profile',$data);
		$this->load->view('includes/footer');
	}
	
	
	//============show values of contact list individual ================//
   
	//==========load view page of edit features===============//
	
	function update($id)
	{
			$id= $this->uri->segment(3);
			 //echo $id;die(); 
			$this->load->view('includes/header');
			$this->load->view('includes/top_header');
			$this->load->view('includes/left_panel');
			$f=$this->input->post('fname');
			$l=$this->input->post('lname');
			$u=$this->input->post('uname');
			
            //print_r($_FILES['attachment_file']);
            if (isset($_FILES['attachment_file']['name']) && !empty($_FILES['attachment_file']['name']))
		{
                      if ($_FILES["attachment_file"]["name"]!= "")
                        {
                            $ext=explode('/',strtolower($_FILES["attachment_file"]["type"]));
                                
                            $DIR_DOC = PHYSICAL_PATH."images/normal/";
                            
                            $file_size=filesize($_FILES["attachment_file"]["tmp_name"]);
                            
                            $arra1 = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');
                            $arra2 = array('','','','','','','','','','','','','','','','','','','','','','','','','');
                        
                            $filename = str_replace($arra1, $arra2, $_FILES["attachment_file"]['name']);
                            $s=time().rand().$filename;
                             
                            $fileNormal = $DIR_DOC.$s;
                        
                            $file = $_FILES["attachment_file"]['tmp_name'];
                            list($width, $height) = getimagesize($file);
							
                            $result = move_uploaded_file($file, $fileNormal);
							//echo "pic uploaded";
						   
                            if($result==1)
                            {
								
                                
				$m_img_real = PHYSICAL_PATH."images/thumbnail/".$_REQUEST['last_img'];
				$m_img_thumb = PHYSICAL_PATH."images/thumbnail/".$_REQUEST['last_img'];
								//echo $m_img_real;
				if (file_exists($m_img_real) && $_REQUEST['last_img']!="")
				{
				unlink($m_img_real);
				//unlink($m_img_thumbs);
				}
				if (file_exists($m_img_thumb) && $_REQUEST['last_img']!="")
				{
				unlink($m_img_thumb);
				//unlink($m_img_thumbs);
				}
				$DIR_IMG_THUMB = PHYSICAL_PATH."images/thumbnail/";
				$fileThumb = $DIR_IMG_THUMB.$s;
				$thumbWidth = 150;
				$thumbHeight = 150;
			       
				//thumbnail($DIR_DOC,$DIR_IMG_THUMB,$thumbWidth,$thumbHeight,$s);			    
				$update_image = $this->edit_profile_model->thumbnail($fileThumb, $fileNormal, $thumbWidth, $thumbHeight, '');
			    
			       //echo $id;die();
			       $data_to_sub=array(
				'first_name'=>$f,
				'last_name'=>$l,
				'uname'=>$u,
				'image' => $s,
				);
								
                               
                                
                            }
                        }
                }
		else
		{
		$data_to_sub=array(
				    'first_name'=>$f,
				    'last_name'=>$l,
				    'uname'=>$u,
							    
				  );
		}		
								
		$upd_data=$this->edit_profile_model->update_pro('admin', $data_to_sub,$id);
		
		if($upd_data)
		{
			$this->session->set_userdata('success_msg', 'Profile updated successfully');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot update  Profile.');
		}
		redirect('edit_profile_cont');
		$this->load->view('includes/footer');
	
		
		
	           
	}
	
}
?>