<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1); 
class Faq_con extends CI_Controller {
   
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('left_panel_model');
		$this->load->model('login_model');
		$this->load->model('faq_model'); //load email template model
		$this->load->library('session');			//load session library
		if($this->session->userdata('admin_is_logged_in')!=true)
		{
			$this->session->set_userdata('error_msg', 'Please log in first..');		
			redirect('login_cont');
		}
		else if($this->session->userdata('admin_is_superadmin')!=1)
		{
			$data=$this->login_model->page_details('faq_con','admin_management_list');
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
    
    //============load view page of email template================//
    function index()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		
		$data['result'] = $this->faq_model->select_faqs();
		$this->load->view('faqs/faq_mgmt', $data);
		
		$this->load->view('includes/footer');
	}
    //============load view page of add_article================//
	function add_faq()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$data['result'] = $this->faq_model->g_faq();
		$this->load->view('faqs/add_faq',$data);		
		$this->load->view('includes/footer');
	}
	
    //============insert data into article================//	
	function insert_faq()
	{
		//uploaded_image
		//echo PHYSICAL_PATH;die();
		if($this->input->post('mode_article')=='insert_faq')
		{
			$files = $_FILES['attachment_file'];
			//print_r ($_FILES['attachment_file']);die();
			$this->load->library('upload');
			
			if (isset($_FILES['attachment_file']['name']) && !empty($_FILES['attachment_file']['name']))
			{
				
				$ext=explode('/',strtolower($_FILES["attachment_file"]["type"]));
					
				$DIR_DOC =  PHYSICAL_PATH."uploaded_image/";
				
				$file_size=filesize($_FILES["attachment_file"]["tmp_name"]);
				
				$arra1 = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','/','*','+','~','`','=');
				$arra2 = array('','','','','','','','','','','','','','','','','','','','','','','','','');
			
				$filename = str_replace($arra1, $arra2, $_FILES["attachment_file"]['name']);
				$s=time().rand().$filename;
				 
				$fileNormal = $DIR_DOC.$s;
			
				$file = $_FILES["attachment_file"]['tmp_name'];
				list($width, $height) = getimagesize($file);
				
				$result = move_uploaded_file($file, $fileNormal);
				
				$data_to_store=array(
				'faq_type' => $this->input->post('faq_type'),
				'faq' => $this->input->post('faq'),
				'ans' => $this->input->post('ans'),
				'image' => $s,
				'status' => $this->input->post('status')
			    );
				$insrt_data=$this->faq_model->insert_faq('faq', $data_to_store);
			}
			else{
				$data_to_store=array(
				'faq_type' => $this->input->post('faq_type'),
				'faq' => $this->input->post('faq'),
				'ans' => $this->input->post('ans'),
				'status' => $this->input->post('status')
			    );
				$insrt_data=$this->faq_model->insert_faq('faq', $data_to_store);
				
			}
		
           
			if($insrt_data=='1')
			{
				$this->session->set_userdata('success_msg', 'Data inserted successfully');
				redirect('faq_con');
			}
			else
			{
				$this->session->set_userdata('error_msg', 'Can not insert .');
				redirect('faq_con/add_faq');
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
		$updt_status = $this->faq_model->change_status_faq('faq',$stat_param, $id);
		if($updt_status)
		{
			$this->session->set_userdata('success_msg', 'Status Updated successfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot update status.');
		}
		redirect('faq_con');
	}
    //=============delete the data from country============//
	function del_data()
	{
		$id= $this->uri->segment(3);
		$del_data = $this->faq_model->del_faq('faq',$id);
		if($del_data)
		{
			$this->session->set_userdata('success_msg', 'Data deleted successfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot delete data.');
		}
		redirect('faq_con');
	}
	
	//======================load edit country=====================//
	function edit_faq()
	{
		$id= $this->uri->segment(3);
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$data['result'] = $this->faq_model->edit_faqs('faq', $id);
		//$data['res']=$this->faq_model->get_faq();
		$this->load->view('faqs/edit_faq', $data);
		$this->load->view('includes/footer');
	}
	
	//============update data into article================//	
	function update_faq()
	{
		$id = $this->uri->segment(3);
		
		if (isset($_FILES['attachment_file']['name']) && !empty($_FILES['attachment_file']['name']))
		{
				
			$ext=explode('/',strtolower($_FILES["attachment_file"]["type"]));
				
			$DIR_DOC =  PHYSICAL_PATH."uploaded_image/";
			
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
				$m_img_real = PHYSICAL_PATH."uploaded_image/".$_REQUEST['last_img_big'];
			    
				if (file_exists($m_img_real))
				{
				 unlink($m_img_real);
				}
			}
			$data_to_store=array(
			'faq' => $this->input->post('faq'),
			'ans' => $this->input->post('ans'),
			'image' => $s,
			'status'=>$this->input->post('status')
		    );
            $insrt_data=$this->faq_model->update_faq('faq', $data_to_store, $id);
		}
		else
		{
			$data_to_store=array(
			'faq' => $this->input->post('faq'),
			'ans' => $this->input->post('ans'),
			'status'=>$this->input->post('status')
		    );
            $insrt_data=$this->faq_model->update_faq('faq', $data_to_store, $id);
		}
        

		if($insrt_data==1)
		{
			$this->session->set_userdata('success_msg', 'FAQ updated successfully');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Can not update data.');
		}
		redirect('faq_con');
	}
}
?>