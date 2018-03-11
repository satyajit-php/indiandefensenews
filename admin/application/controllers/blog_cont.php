<?php
class Blog_cont extends CI_Controller {
   // Controller class for site_settings
	function __construct()
	{
		parent::__construct();
		$this->load->model('left_panel_model'); // calls the model
		$this->load->model('login_model');
		$this->load->model('site_settings_model'); // calls the model
		$this->load->model('blog_model'); // calls the model
		$this->load->model('blog_tag_model');
		$this->load->library('session');
        $this->load->helper('date');
		if($this->session->userdata('admin_is_logged_in')!=true)
		{
			$this->session->set_userdata('error_msg', 'Please login first.');
			redirect('login_cont');
		}
		else if($this->session->userdata('admin_is_superadmin')!=1)
		{
			$data=$this->login_model->page_details('blog_cont','admin_management_list');
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
		
		$data['blog_data']=$this->blog_model->get_blog_value();
		$this->load->view('blog_management/index', $data);
		
		$this->load->view('includes/footer');
	}
	
	//============load view page of add_article================//
	function add_blog()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$this->load->view('blog_management/add_content');		
		$this->load->view('includes/footer');
	}
    function viewcomm($id)
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		
		$d=$this->blog_model->get_comment($id);
		
		foreach($d as $key=>$r)
		{
			$p=$r->posted_by;
	       
			$name=$this->blog_model->comm_detail($p);
			if(!empty($name))
			{
			$d[$key]->name=$name[0]->first_name;
			}
		}
		
		$data['result']=$d;
		
		$this->load->view('blog_management/comm_detail', $data);
		
		$this->load->view('includes/footer');
	}
    //============insert data into article================//	
	function insert_blog_content()
	{
		if($this->input->post('mode_blog')=='insert_blog')
		{
			$files = $_FILES['attachment_file'];
		
				
		if (isset($_FILES['attachment_file']['name']) && !empty($_FILES['attachment_file']['name']))
		{
                        if ($_FILES["attachment_file"]["name"]!= "")
                        {
                            $ext=explode('/',strtolower($_FILES["attachment_file"]["type"]));
                                
                            $DIR_DOC = PHYSICAL_PATH."uploaded_image/normal/";
                            
                            $file_size=filesize($_FILES["attachment_file"]["tmp_name"]);
                            
                            $arra1 = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');
                            $arra2 = array('','','','','','','','','','','','','','','','','','','','','','','','','');
                        
                            $filename = str_replace($arra1, $arra2, $_FILES["attachment_file"]['name']);
                            $s=time()."*^*".$filename;
                        
                            $fileNormal = $DIR_DOC.$s;
                        
                            $file = $_FILES["attachment_file"]['tmp_name'];
                            list($width, $height) = getimagesize($file);
                            $result = move_uploaded_file($file, $fileNormal);
                            if($result==1)
                            {
                                $DIR_IMG_THUMB = PHYSICAL_PATH."uploaded_image/thumbnail/";
                                $fileThumb = $DIR_IMG_THUMB.$s;
                                $thumbWidth = 747;
                                $thumbHeight = 309;
                               
                                //thumbnail($DIR_DOC,$DIR_IMG_THUMB,$thumbWidth,$thumbHeight,$s);			    
                                $update_image = $this->blog_model->thumbnail($fileThumb, $fileNormal, $thumbWidth, $thumbHeight, '');
                            
                
                
                
                                $date = date('Y-m-d H:i:s');
                                $data_to_store=array(
                                    'blog_title' => $this->input->post('blog_title'),
				    'blog_tag' => $this->input->post('get_tag'),
                                    'added_by' => $this->input->post('added_by'),
                                    'added_on' => $date,
                                    'images' => $s,
                                    'details' => $this->input->post('blog_desc'),
									'status' =>  $this->input->post('status')
                                );
                                $insrt_data=$this->blog_model->insert_blog_value('blog', $data_to_store);
                                if($insrt_data=='1')
                                {
                                    $this->session->set_userdata('success_msg', 'Blog content inserted successfully');
                                    redirect('blog_cont');
                                }
                                else
                                {
                                    $this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
                                    redirect('blog_cont/add_blog');
                                }
                            }
                        }
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
		$updt_status = $this->blog_model->change_status_to('blog',$stat_param, $id);
		if($updt_status)
		{
			$this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot update status.');
		}
		redirect('blog_cont');
	}
	 function del_data()
	 {
	    $id= $this->uri->segment(3);
		
		$del_data = $this->blog_model->del_data('blog', $id);
		if($del_data)
		{
			$this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot delete data.');
		}
		
        redirect('blog_cont');
	 }

	//=============delete the data from article============//
	function del_comm()
	{
		$id= $this->uri->segment(3);
		$bid=$this->blog_model->getblog_id($id);
		
		$i=$bid[0]->blog_id;
		$del_data = $this->blog_model->del_data('blog_comment', $id);
		if($del_data)
		{
			$this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot delete data.');
		}
		
        redirect('blog_cont/viewcomm/'.$i);
	}
	//============load view page of edit_article================//
	function edit_blog()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		//$this->load->view('article/edit_article');
		$id = $this->uri->segment(3);
		$data['blog_data']=$this->blog_model->sel_data_up($id);
		$this->load->view('blog_management/edit_content', $data);
		$this->load->view('includes/footer');
	}
	
    //============update data into article================//	
	function update_blog()
	{
		if($this->input->post('mode_blog')=='update_blog')
		{
            $id= $this->input->post('id');
            //print_r($_FILES['attachment_file']);
            if (isset($_FILES['attachment_file']['name']) && !empty($_FILES['attachment_file']['name']))
				{
                      if ($_FILES["attachment_file"]["name"]!= "")
                        {
                            $ext=explode('/',strtolower($_FILES["attachment_file"]["type"]));
                                
                            $DIR_DOC = PHYSICAL_PATH."uploaded_image/normal/";
                            
                            $file_size=filesize($_FILES["attachment_file"]["tmp_name"]);
                            
                            $arra1 = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');
                            $arra2 = array('','','','','','','','','','','','','','','','','','','','','','','','','');
                        
                            $filename = str_replace($arra1, $arra2, $_FILES["attachment_file"]['name']);
                            $s=time()."*^*".$filename;
                             
                            $fileNormal = $DIR_DOC.$s;
                        
                            $file = $_FILES["attachment_file"]['tmp_name'];
                            list($width, $height) = getimagesize($file);
                            $result = move_uploaded_file($file, $fileNormal);
                            if($result==1)
                            {
                                //$m_img_real= $_SERVER['DOCUMENT_ROOT'].'/lab4/project/cms_admin/images/uploaded/'.$_REQUEST['img_last'];
								$m_img_real = PHYSICAL_PATH."uploaded_image/normal/".$_REQUEST['last_img'];
                                $m_img_thumb = PHYSICAL_PATH."uploaded_image/thumbnail/".$_REQUEST['last_img'];
								if (file_exists($m_img_real))
								{
								unlink($m_img_real);
								//unlink($m_img_thumbs);
								}
                                if (file_exists($m_img_thumb))
								{
								unlink($m_img_thumb);
								//unlink($m_img_thumbs);
								}
                                $DIR_IMG_THUMB = PHYSICAL_PATH."uploaded_image/thumbnail/";
                                $fileThumb = $DIR_IMG_THUMB.$s;
                                $thumbWidth = 747;
                                $thumbHeight = 309;
                               
                                //thumbnail($DIR_DOC,$DIR_IMG_THUMB,$thumbWidth,$thumbHeight,$s);			    
                                $update_image = $this->blog_model->thumbnail($fileThumb, $fileNormal, $thumbWidth, $thumbHeight, '');
                            
                                $date = date('Y-m-d H:i:s');
                                $data_to_store=array(
                                    'blog_title' => $this->input->post('blog_title'),
				     'blog_tag' => $this->input->post('get_tag'),
                                    'added_by' => $this->input->post('added_by'),
                                    'added_on' => $date,
                                    'images' => $s,
                                    'details' => $this->input->post('blog_desc'),
									'status' => $this->input->post('status')
                                );
                                $upd_data=$this->blog_model->update_blog_value('blog',$this->input->post('id'), $data_to_store);
                                
                                if($upd_data)
                                {
                                    $this->session->set_userdata('success_msg', 'Blog content updated successfully');
                                }
                                else
                                {
                                    $this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
                                }
                                redirect('blog_cont');
                            }
                        }
                }
                else
                {
                                $date = date('Y-m-d H:i:s');
                                $data_to_store=array(
                                    'blog_title' => $this->input->post('blog_title'),
				    'blog_tag' => $this->input->post('get_tag'),
                                    'added_by' => $this->input->post('added_by'),
                                    'added_on' => $date,
                                    'images' => $this->input->post('last_img'),
                                    'details' => $this->input->post('blog_desc')
                                );
                                $upd_data=$this->blog_model->update_blog_value('blog',$this->input->post('id'), $data_to_store);
                                
                                if($upd_data)
                                {
                                    $this->session->set_userdata('success_msg', 'Blog content updated successfully');
                                }
                                else
                                {
                                    $this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
                                }
                                redirect('blog_cont');
                    
                }
            
        }
	}

}
?>