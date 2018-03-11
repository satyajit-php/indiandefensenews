<?php

class Article_cont extends CI_Controller {
   // Controller class for site_settings
	function __construct()
	{
		parent::__construct();
		$this->load->model('left_panel_model'); // calls the model
		$this->load->model('site_settings_model'); // calls the model
		$this->load->model('article_model'); // calls the model
		$this->load->library('session');
		if($this->session->userdata('admin_is_logged_in')!=true)
		{
			$this->session->set_userdata('error_msg', 'Please login first.');
			redirect('login_cont');
		}
	}
        //============load view page of article================//
        function index()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		
		$data['article_data']=$this->article_model->get_article_value();
		$this->load->view('article/article', $data);
		
		$this->load->view('includes/footer');
	}
	
	//============load view page of add_article================//
	function add_article()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$this->load->view('article/add_article');		
		$this->load->view('includes/footer');
	}
	
    //============insert data into article================//	
	function insert_article()
	{
		if($this->input->post('mode_article')=='insert_article')
		{
			
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
                            $s=time().rand(000,999).$filename;
                        
                            $fileNormal = $DIR_DOC.$s;
                        
                            $file = $_FILES["attachment_file"]['tmp_name'];
                            list($width, $height) = getimagesize($file);
							//echo "width->". $width;
							//echo "hight->" .$height;
							//die();
							
							     $result = move_uploaded_file($file, $fileNormal);
							
							
									if($result==1)
									{
										$DIR_IMG_THUMB = PHYSICAL_PATH."uploaded_image/thumbnail/";
										$fileThumb = $DIR_IMG_THUMB.$s;
										$thumbWidth = 448;
										$thumbHeight = 399;
									   
										//thumbnail($DIR_DOC,$DIR_IMG_THUMB,$thumbWidth,$thumbHeight,$s);			    
										$update_image = $this->article_model->thumbnail($fileThumb, $fileNormal, $thumbWidth, $thumbHeight, '');
									
						
						
						
									
										 $data_to_store=array(
																'type' => $this->input->post('article_type'),
																'description' => $this->input->post('article_desc'),
																'title' => $this->input->post('article_title'),
																'modified_by' => $this->session->userdata('admin_uid'),
																'img' => $s
															);
										
									}
                            
							
                       }
                

		       }
			   else{
				         $data_to_store=array(
												'type' => $this->input->post('article_type'),
												'description' => $this->input->post('article_desc'),
												'title' => $this->input->post('article_title'),
												'modified_by' => $this->session->userdata('admin_uid')
											);
				
			   }
			
			
			
		    
			$insrt_data=$this->article_model->insert_article_value('article', $data_to_store);
			if($insrt_data=='1')
			{
				$this->session->set_userdata('success_msg', 'Article inserted successfully');
				redirect('article_cont');
			}
			else
			{
				$this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
				redirect('article_cont/add_article');
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
		$updt_status = $this->article_model->change_status_to('article',$stat_param, $id);
		if($updt_status)
		{
			$this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot update status.');
		}
		redirect('article_cont');
	}

	//=============delete the data from article============//
	function del_data()
	{
		$id= $this->uri->segment(3);
		$del_data = $this->article_model->del_data('article', $id);
		if($del_data)
		{
			$this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot delete data.');
		}
		redirect('article_cont');
	}
	//============load view page of edit_article================//
	function edit_article()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		//$this->load->view('article/edit_article');
		$id = $this->uri->segment(3);
		$data['article_data']=$this->article_model->sel_data_up($id);
		$this->load->view('article/edit_article', $data);
		$this->load->view('includes/footer');
	}
	
    //============update data into article================//	
	function update_article()
	{
		if($this->input->post('mode_article')=='update_article')
		{
			$id= $this->input->post('id');
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
                            $s=time().rand().$filename;
                             
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
                                $thumbWidth = 1200;
                                $thumbHeight = 800;
                               
                                //thumbnail($DIR_DOC,$DIR_IMG_THUMB,$thumbWidth,$thumbHeight,$s);			    
                                $update_image = $this->article_model->thumbnail($fileThumb, $fileNormal, $thumbWidth, $thumbHeight, '');
                            
                                $data_to_store=array(
														'type' => $this->input->post('article_type'),
														'title' => $this->input->post('article_title'),
														'description' => $this->input->post('article_desc'),
														'img' => $s,
														'modified_by' => $this->session->userdata('admin_uid'),
														'status' => $this->input->post('article_status')
													);
                                
                            }
                        }
                }
			
			    else{
                                $data_to_store=array(
									'type' => $this->input->post('article_type'),
									'title' => $this->input->post('article_title'),
									'description' => $this->input->post('article_desc'),
									'modified_by' => $this->session->userdata('admin_uid'),
									'status' => $this->input->post('article_status')
								);
					
				}
			$upd_data=$this->article_model->update_article_value('article',$id, $data_to_store);
			
			if($upd_data)
			{
				$this->session->set_userdata('success_msg', 'Article updated successfully');
			}
			else
			{
				$this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
			}
			redirect('article_cont');
		}
	}

}
?>