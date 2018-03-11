<?php
class User_management_cont extends CI_Controller {
   
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('left_panel_model');
		$this->load->model('user_model'); 		        //load email template model
		$this->load->model('login_model');
		$this->load->library('session');			//load session library
		$this->load->library('email');				//load email library
		if($this->session->userdata('admin_is_logged_in')!=true)
		{
			$this->session->set_userdata('error_msg', 'Please log in first..');		
			redirect('login_cont');
		}
		else if($this->session->userdata('admin_is_superadmin')!=1)
		{
			$data=$this->login_model->page_details('user_management_cont','admin_management_list');
			$page_id=$data[0]->id;
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
	//=============changin the status of news letter============//
	function change_status_to()
	{
		//echo $this->uri->segment(3);die();
                $stat_param= array(
			'status' => $this->uri->segment(3)
			);
		$id= $this->uri->segment(4);
		$updt_status = $this->user_model->change_status_to($stat_param, $id);
		if($updt_status)
		{
		    $this->session->set_userdata('success_msg', 'Status Updated successfully.');
		}
		else
		{
		    $this->session->set_userdata('error_msg', 'Cannot update status.');
		}
	        redirect('user_management_cont');
	}
    
	//============load view page of email template================//
	function index()
	{
		$flag=$this->uri->segment(3);
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		
		$data['result'] = $this->user_model->select_user();
		$this->load->view('user/user_list', $data);
		
		$this->load->view('includes/footer');
	}
	//============delete data from news letter management================//
	function del_data()
	{
		$id= $this->uri->segment(3);
		$del_data = $this->user_model->del_data('people', $id);
		if($del_data)
		{
			$this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot delete data.');
		}
		redirect('user_management_cont');
	}
	 //============load view page of view details of user================//
	function edit_user()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		//$this->load->view('article/edit_article');
		$id = $this->uri->segment(3);
                $data['user_data']=$this->user_model->get_row_by_id('people', 'id', $id);
				$data['country'] = $this->user_model->country_list();   // getting country list from data location table
		$this->load->view('user/edit_user', $data);
		$this->load->view('includes/footer');
	}
	function get_state()      // get state name
	{
	 $uid=$this->input->post('uid');
	  $dataresult= $this->user_model->account_details('people',$uid);  // getting account details from data base
	  $data['id']=$this->input->post('id');
	  $data = $this->user_model->state_list('location',$data);
	  if($data)
	  {
		
										
		echo"<option value=''>Select State</option>";								
		foreach($data as $row)
		{
			if($row->location_id==$dataresult[0]->city)
			{
				$select="selected";
			}
			else{
				$select="";
			}
			echo "<option value='".$row->location_id."'$select>".$row->name."</option>";
		}
		
	  }else{
		echo "<option value=''>Select State</option>";	
	  }
	}
	function update_user()
	{
		$uid=$this->input->post('user_id');
		
		$data_arr=array("first_name"=>$this->input->post('fname'),
						"last_name"=>$this->input->post('lname'),
						"email"=>$this->input->post('docemail'),
						"phone"=>$this->input->post('phone'),
						"status"=>$this->input->post('status'),
						"display_name"=>$this->input->post('dname'),
						"company_name"=>$this->input->post('compname'),
						"job_title"=>$this->input->post('jobtitle'),
						"work_email"=>$this->input->post('workEmail'),
						"address"=>$this->input->post('address'),
						"zip"=>$this->input->post('Pincode'),
						"gender"=>$this->input->post('radio'),
						"date_of_birth_day"=>$this->input->post('day'),
						"date_of_birth_month"=>$this->input->post('month'),
						"date_of_birth_year"=>$this->input->post('year'),
						"country_id"=>$this->input->post('country'),
						"security_pin"=>$this->input->post('secPin'),
						"city"=>$this->input->post('city')
						);
		$result=$this->user_model->update_user('people',$uid,$data_arr);
		if($result)
		{
			$this->session->set_userdata('success_msg', 'User details sucessfully updated.');
			if($this->input->post('status') == 3)
			{
				//$notificationSendUser = $this->left_panel_model->sendNotification(12, 0,$uid,'people',$uid);
				
				$data_arr=array('id' => '26');
				$emailcontent=$this->left_panel_model->emailTemp('email_template', $data_arr);
				$content =$emailcontent[0]->email_desc;
				
				$logo='<img src="'.base_url().'assets/images/logo-1.png" alt="">';
				$sites = $this->left_panel_model->site_list('site_settings', 'facebook', 'twitter', 'linkedin');
				$social_logo = "<a href='".$sites->facebook."' style='cursor: pointer;'><img src='".base_url()."../assets/images/socailloginicons/facebook-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>
				<a href='".$sites->linkedin."' style='cursor: pointer;'><img src='".base_url()."../assets/images/socailloginicons/linkedin-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>
				<a href='".$sites->twitter."' style='cursor: pointer;'><img src='".base_url()."../assets/images/socailloginicons/twitter-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>";
				//generating social logos//
				
				//generating static links//
				$static_pages = "<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/disclaimer'>Disclaimer</a>
				| <a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/privacy'>Privacy</a> |
				<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/termsCondition'> Terms &amp; Conditions</a> |
				<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/helpCenter?tab=Guiding'> Help</a>";
				//generating static links//
				
				//this is for footer section in email template//
				$baseurl = base_url();
				$email_details = array("[LOGO]","[SOCIAL_LOGO]","[STATICPAGES]","[BASEURL]","[RECEIVER]");
				$email_details_rplc = array($logo,$social_logo,$static_pages,$baseurl,$this->input->post('fname'));
				
				$subject=$emailcontent[0]->email_title;
				$content=str_replace($email_details,$email_details_rplc,$content);
				
				$this->left_panel_model->send_mail($this->input->post('docemail'),$subject,$content);
				
			}
			if($this->input->post('status') == 1)
			{
				//$notificationSendUser = $this->left_panel_model->sendNotification(12, 0,$uid,'people',$uid);
				
				$data_arr=array('id' => '36');
				$emailcontent=$this->left_panel_model->emailTemp('email_template', $data_arr);
				$content =$emailcontent[0]->email_desc;
				
				$logo='<img src="'.base_url().'assets/images/logo-1.png" alt="">';
				$sites = $this->left_panel_model->site_list('site_settings', 'facebook', 'twitter', 'linkedin');
				$social_logo = "<a href='".$sites->facebook."' style='cursor: pointer;'><img src='".base_url()."../assets/images/socailloginicons/facebook-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>
				<a href='".$sites->linkedin."' style='cursor: pointer;'><img src='".base_url()."../assets/images/socailloginicons/linkedin-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>
				<a href='".$sites->twitter."' style='cursor: pointer;'><img src='".base_url()."../assets/images/socailloginicons/twitter-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>";
				//generating social logos//
				
				//generating static links//
				$static_pages = "<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/disclaimer'>Disclaimer</a>
				| <a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/privacy'>Privacy</a> |
				<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/termsCondition'> Terms &amp; Conditions</a> |
				<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/helpCenter?tab=Guiding'> Help</a>";
				//generating static links//
				
				//this is for footer section in email template//
				$baseurl = base_url();
				$email_details = array("[LOGO]","[SOCIAL_LOGO]","[STATICPAGES]","[BASEURL]","[RECEIVER]");
				$email_details_rplc = array($logo,$social_logo,$static_pages,$baseurl,$this->input->post('fname'));
				
				$subject=$emailcontent[0]->email_title;
				$content=str_replace($email_details,$email_details_rplc,$content);
				
				$this->left_panel_model->send_mail($this->input->post('docemail'),$subject,$content);
			}
		}
		else
		{
		$this->session->set_userdata('error_msg', 'Unable to updated.please try again.');	
		}
		redirect('user_management_cont');
	}
	//============select emails================//
	function select_student_cont()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		
		$data['res'] = $this->news_letter_model->select_student_model();
		
		$this->load->view('news_letter/edit_news_letter', $data);
		
		$this->load->view('includes/footer');
	}
	
	//=================send mail to subscribers==================//
	function sendmail_to()
	{
		$data_to_send = array(
					'email_sub' => $_REQUEST['email_sub'],
					'nav_id' => $_REQUEST['nav_id'],
					'send_to' => $_REQUEST['email_type']
				    );
		
		//print_r($data_to_send);
		//die();
		$send_mail = $this->news_letter_model->sendmail_to($data_to_send);
		//$this->session->set_userdata('success_msg', 'Mail sent susseccfully.');
		//if($send_mail)
		//{
		//	$this->session->set_userdata('success_msg', 'Mail sent susseccfully.');
		//}
		//else
		//{
		//	$this->session->set_userdata('error_msg', 'Something is wrong. Mail cannot be sent.');
		//}
		//redirect('news_letter_cont');
	}
	//========export as csv=========//
	function export_news_letter()
	{
		
		$csv_stat = $this->input->post('csv_stat');
		$stat_arr = explode(',', $csv_stat);
		
		
		$email = $this->input->post('csv_val');
		$email_arr = explode(',', $email);
		foreach($email_arr as $email_val)
		{
			$output.=$email_val;
			$output.="\n";
		}

		$output_file=PHYSICAL_PATH.'newletter.csv';
		
		//// Open a new output file
		$file_csv = fopen($output_file,'w');
		
		$heading.='Email';
		//$heading.='Status';
		$heading.="\n";

		
		//// Put contents of $output into the $file_csv
		fputs($file_csv, $heading);
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
		
		
		$this->session->set_userdata('success_msg', 'Data downloaded susseccfully.');
		
		redirect('news_letter_cont');
	}
}
?>