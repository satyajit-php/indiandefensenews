<?php
class Contact_list extends CI_Controller {
   // Controller class for admin contact
	function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('download');
		$this->load->model('login_model');
		$this->load->model('left_panel_model');		//load model for sidepanel
		$this->load->model('contact_list_model');	// calls the model
		$this->load->library('session');			//loading session
		if($this->session->userdata('admin_is_logged_in')!=true)
		{
			$this->session->set_userdata('error_msg', 'Please login first.');
			redirect('login_cont');
		}
		else if($this->session->userdata('admin_is_superadmin')!=1)
		{
			$data=$this->login_model->page_details('contact_list','admin_management_list');
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
       
    //============load view page of contact_list================//
	function index()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
	
		$contact_data['result'] = $this->contact_list_model->contact_getdata();// calling the function of that model
		$this->load->view('site_settings/contact_list',$contact_data); //calling the view
		
		$this->load->view('includes/footer');
	}
	//============show values of contact list individual ================//
	function edit_contact($id)
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
	     //echo "hello";
		$contact_data['result'] = $this->contact_list_model->contact_ind($id);// calling the function of that model
		$this->load->view('site_settings/contact_list_ind',$contact_data); //calling the view
		//echo "after model call";
		$this->load->view('includes/footer');
	}

	//============Update values of admin contact details table================//
	function updatecontact($id)
	{
		//if($this->input->post('mode_contact')=='contact')
		//
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$data_to_updt=array(
			'contacted_by' => $this->input->post('contacted_by'),
			'contact_email' => $this->input->post('contact_email'),
			'company_name' => $this->input->post('company_name'),
			'message' => $this->input->post('message'),
			'status' => $this->input->post('status'),
			);
					
		$updt=$this->contact_list_model->update_list('contact_list', $data_to_updt,$id);
		if($updt)
		{
			$this->session->set_userdata('success_msg', 'Data updated successfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Failed to update data.');
		}
		$this->load->view('includes/footer');
		redirect('contact_list');
	}
	function del_data($id)
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$del=$this->contact_list_model->del_data($id);
		if($del)
		{
			$this->session->set_userdata('success_msg', 'Data deleted successfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Failed to delete data.');
		}
		$this->load->view('includes/footer');
		redirect('contact_list');
	}
	function change_status($s,$id)
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$del=$this->contact_list_model->update_status($s,$id);
		if($del)
		{
			$this->session->set_userdata('success_msg','Data updated successfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg','Failed to update data.');
		}
		$this->load->view('includes/footer');
		redirect('contact_list');
		
	}
	function go_reply($id)
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
	
		$data['result'] = $this->contact_list_model->get_con($id);// calling the function of that model
		$this->load->view('contact/send_msg',$data); //calling the view
		
		$this->load->view('includes/footer');
		
	}
	function send_msg()
	{
		
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
	    $t=$this->input->post("to");
		$s=$this->input->post("subject");
		$b=$this->input->post("email_body");
		//echo $t."<br>";
		//echo $s."<br>";
		//echo $b."<br>";
		$data= $this->contact_list_model->send_msg($t,$s,$b);// calling the function of that model
	
		if($data==0)
		{
			$this->session->set_userdata('success_msg','Message is send successfully.');
			redirect('contact_list');
		}
		else
		{
			$this->session->set_userdata('error_msg','Failed to send Message.');
		}
		$this->load->view('includes/footer');
		
	}
	function exportcsv()
	{
		$output1  ="";
		$output1 .='Email,';
		$output1 .='Message,';
		$output1 .='Contacted On,';
		$output1 .="\n";
		//$output = $this->input->post('csv_val');
		
		$contact_arr = $this->contact_list_model->contact_getdata();
		
		$output ="";
		
		foreach($contact_arr as $contact_val)
		{
		    $m=$contact_val->message;
			$m=str_replace(","," ",$m);
			$output .= ''.$contact_val->contact_email.',';
			$output .= ''.$m.',';
			$output .= ''.$contact_val->contacted_on.',';
			$output .= "\n";
		}

		$output_file = PHYSICAL_PATH.'csv_contactlist.csv';
		//echo $output;
		////echo $output_file;
		//die();
		//
		//// Open a new output file
		$file_csv = fopen($output_file,'w');
		
		//// Put contents of $output into the $file_csv
		fputs($file_csv, $output1);
		fputs($file_csv, trim($output));
		
		//// Closing the file $file_csv
		fclose($file_csv);
		chmod($file_csv, 0777);
		
		
		//=================download csv file================//
		$file = $output_file;
		if (file_exists($file))
		{
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($file));
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    ob_clean();
		    flush();
		    readfile($file);
		}
		    
		//// Deleting CSV file from the directory
		unlink($output_file);
		redirect('contact_list');
		
	}
	
}
 ?>   