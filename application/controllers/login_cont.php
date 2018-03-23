<?php
class Login_cont extends CI_Controller {
   // Controller class for Login
	function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');      // encrypt helper class
		$this->load->model('login_model');	//loading model
		$this->load->model('company_model');
		$this->load->library('session');	//loading session
		$this->load->helper('cookie');		// loading Cookie
		$this->load->model('sidepanel_model');
		$this->load->model('review_model');
		$this->load->model('badge_model');
		$this->load->model('feedback_model');
		//if($this->session->userdata('is_logged_in')==true)
		//{
		//	redirect('dashboard_cont');			
		//}
	}
	
	
	function activate_claimed_user(){
		$company_id = $this->uri->segment(3);
		$user_id = $this->uri->segment(4);
		$result = $this->company_model->activateClaimCompany($company_id, $user_id);
		if($result == 1)
		{
			
			$this->session->set_userdata('success_msg', 'User activated for the requested company.');
		}else if($result == 2)
			$this->session->set_userdata('error_msg', 'User already activated.');
		else
			$this->session->set_userdata('error_msg', 'Some error occurred.');
		
		redirect('home/index');
	}
	
	function activate_own_claimed_company() {
		
		$result = $this->company_model->claimedCompanyPermission($this->uri->segment(3));
		
		if($result == 1)
		{
			
			$this->session->set_userdata('success_msg', 'Request successful! You are now the Admin of your claimed company.');
		}
		else if($result == 2)
			$this->session->set_userdata('error_msg', 'User already activated.');
		else
			$this->session->set_userdata('error_msg', 'Some error occurred.');
		
		redirect('home/index');
	}
	
	function activate_claimed_company_permission(){
		$result = $this->company_model->claimedCompanyStatusPermission($this->uri->segment(3));
		
		if($result == 1)
		{
			
			$this->session->set_userdata('success_msg', 'Request successful! You have succesfully claimed your company.');
		}
		else if($result == 2)
			$this->session->set_userdata('error_msg', 'User already activated.');
		else
			$this->session->set_userdata('error_msg', 'Some error occurred.');
		
		redirect('home/index');
	}
	
	//============load view page of login================//
	function index()
	{
		//$this->load->view('includes/header');
		//$this->load->view('includes/login');
	}
	
	//============submit login page(After login this function is called)================//
	function after_login()
	{
		if($this->input->post('mode_login')=='after_login')
		{
			
			//============this is for remember me section==============//
			if($this->input->post('remember_me')=='checked')
			{
				//set_cookie('cookie_value','checked',time()+60*60*60*24*365);
				//set_cookie('cookie_email',$this->input->post('email'),time()+60*60*60*24*365);
				//set_cookie('cookie_password',$this->input->post('password'),time()+60*60*60*24*365);
				//get_cookie('cookie_email');die;
				$cookie = array(
						'name'   => 'cookie_value',
						'value'  => 'checked',
						'expire' => time()+60*60*60*24*365,
						);
				set_cookie($cookie);
				$cookie_email = array(
						'name'   => 'cookie_email',
						'value'  => $this->input->post('email1'),
						'expire' => time()+60*60*60*24*365,
						);
				set_cookie($cookie_email);
				$cookie_pass = array(
						'name'   => 'cookie_password',
						'value'  => $this->input->post('password1'),
						'expire' => time()+60*60*60*24*365,
						);
				set_cookie($cookie_pass);
			}
			//============this is for remember me section end ==============//
			
			$data_to_store=array(
				'email' => trim(addslashes($this->input->post('email1'))),
				'password' => trim($this->input->post('password1'))
			);
			//echo "afdsadf";die;
			$login = $this->login_model->login_admin('people', $data_to_store);
			//print_r($login);die;
			if($login == "sucess")
			{
				//echo $login;die();
				$this->session->set_userdata('success_msg', '');
			        $url=$this->input->post('currenturl');  // get the redirect url
				$this->session->set_userdata("modal",$this->input->post('modal_para'));  // this modal need to show on page load
				header("Location: $url");
				//redirect();
			}
			else if($login == 'attempt_relogin') {
				$this->session->unset_userdata('is_logged_in');
				$this->session->unset_userdata('uid');
				$this->session->unset_userdata('comenterid');
				$this->session->unset_userdata('name');
				$this->session->unset_userdata('profile_pic');
				if($this->session->flashdata('attempt_relogin')){
					if($this->session->flashdata('tried_uid') && $this->session->flashdata('tried_uid') > 0){
						redirect('login_cont/getconfirmation_page');
					}else{
						$this->session->set_userdata('error_msg', 'Oops, An error occured. Please recheck username and password and try again!');
						redirect('home');
					}
				}else{
					$this->session->set_userdata('error_msg', 'Oops, An error occured. Please recheck username and password and try again!');
					redirect('home');
				}
				//echo $this->session->userdata('tried_uid');echo $this->session->userdata('attempt_relogin');die;
			}
			else if($login == 'block')
			{
				//echo $login;
				//die();
				$this->session->set_userdata('error_msg', 'Your account is not active. Please click on the activation link sent to your registered email address.');
				redirect('home');
			}
			else if($login == 'adminblock')
			{
				$this->session->set_userdata('error_msg', 'We are sorry to inform you, we have currently had to disable your account. ');
				redirect('home');
			}
			else if($login == 'wrong')
			{
				$this->session->set_userdata('error_msg', 'We can\'t find you in our system. Please create a new account and login!');
				redirect('home');
			}
			else{
				$this->session->set_userdata('error_msg', 'We can\'t find you in our system. Please create a new account and login!');
				redirect('home');
			}
		}
	}
	function checkCorrectValueForLogin()
	{
		$data_to_store=array(
				'email' => trim(addslashes($this->input->post('emailId'))),
				'password' => trim($this->input->post('passWord'))
			);
		echo $login = $this->login_model->login_admin('people', $data_to_store);
		//print_r($login);
		die;
	}
	function forgot_password()       // load forgot password view page
	{
		$this->load->view('includes/password');
	}
	
	function checkemailid()          // check email id status
	{
	   
	    
	    	$data_to_store=array(
			'email' => trim($this->input->post('email'))
		);
		
		$login = $this->login_model->mailstatus('people', $data_to_store);
		if($login==0)
		{
		    echo "block";	
		}
		elseif($login==1)
		{
		   echo "live";
		}
		elseif($login==2)
		{
		    echo "none";	
		}
		elseif($login==3)
		{
			echo "social";
		}
		elseif($login==4)
		{
			echo "blocked_by_user";
		}
	}
	
		 //smtp mail sending 
      
    function send_mail($email,$subject,$body)
    {

	          require_once PHYSICAL_PATH_FRONT.'/smtpmail/PHPMailerAutoload.php';
	          $mail = new PHPMailer;
       
		$mail->IsSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup server
        $mail->SMTPAuth = true; // Enaele SMTP authentication
		$mail->Username = 'care@creditmonk.com'; // SMTP username
        $mail->Password = 'clrpqjkaumioosze'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted
        $mail->Port = 587; //Set the SMTP port number - 587 for authenticated TLS
        $mail->setFrom('care@creditmonk.com', 'Shraddha Ghogare'); //Set who the message is to be sent from
        //$mail->addReplyTo('labnol@gmail.com', 'First Last'); //Set an alternative reply-to address
        //$mail->addAddress('care@creditmonk.com', 'Josh Adams'); // Add a recipient
        
        $mail->isHTML(true); 
		$mail->FromName = 'Credit Monk';
		$mail->addAddress($email);     // Add a recipient
		$mail->WordWrap = 50;
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body    = $body;
		//$mail->send();
		if(!$mail->send())
		{
		   //echo 'Message could not be sent.';
		   //echo 'Mailer Error: ' . $mail->ErrorInfo;
		   $return=1;
		}
		else
		{
		   //echo 'Message has been sent';
		   $return=0;
		}
		return $return;
		//die;
		}
	
	
	
	function password_email()
	{
		$data_arr=array('email' => trim($this->input->post('email')));
		$password=$this->login_model->get_password('people', $data_arr);
		$getPeopleDetails = $this->review_model->getDetailsByID('people','email',$this->input->post('email'));
		$uid = $getPeopleDetails[0]->id;
		
		if($password)
		{
			$data_arr=array('id' => '7');
			$emailcontent=$this->login_model->email_tmp('email_template', $data_arr);
			
			$content =$emailcontent[0]->email_desc;
			$site='Credit monk';
			
			$img='<img src="'.base_url().'assets/images/logo-1.png" alt="">';
			$base_64=base64_encode($uid);
			
			$link=base_url()."login_cont/reset_pass/$base_64";
			$li="<a href='".$link."'>Click here</a>";
			$logo = "<a href='".base_url()."'><img src='".base_url()."assets/images/logo-1.png' alt=''></a>";
			//$body=str_replace("[LINK]",$li,$body);
			
			$baseurl = base_url();
			
			//this is for footer section in email template//
			
			//generating social logos//
			$sites = $this->login_model->site_list('site_settings', 'facebook', 'twitter', 'linkedin');
			$social_logo = "<a href='".$sites->facebook."' style='cursor: pointer;'><img src='".base_url()."assets/images/socailloginicons/facebook-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>
			<a href='".$sites->linkedin."' style='cursor: pointer;'><img src='".base_url()."assets/images/socailloginicons/linkedin-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>
			<a href='".$sites->twitter."' style='cursor: pointer;'><img src='".base_url()."assets/images/socailloginicons/twitter-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>";
			//generating social logos//
			
			//generating static links//
			$static_pages = "<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/disclaimer'>Disclaimer</a>
			/ <a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/privacy'>Privacy</a> /
			<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/termsCondition'> Terms &amp; Conditions</a> /
			<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/helpCenter?tab=Guiding'> Help</a>";
			//generating static links//
			
			//this is for footer section in email template//
			
			$email_details = array("[LINK]","[LOGO]","[SITENAME]","[RECEIVER]","[SOCIAL_LOGO]","[STATICPAGES]","[BASEURL]");
			$email_details_rplc = array($li,$logo,$site,$getPeopleDetails[0]->first_name,$social_logo,$static_pages,$baseurl);
			$subject=$emailcontent[0]->email_title;
			$content=str_replace($email_details,$email_details_rplc,$content);
			
			
		  if($this->send_mail($this->input->post('email'),$subject,$content)==0)
		  {
		     $this->session->set_userdata('success_msg', 'A password reset link has been sent to your email.');
		  }
		  else{
			$this->session->set_userdata('error_msg', 'Unable to send email please try again.');
		  }
		     redirect('home');
		}
	}
	public function reset_pass()
	{
		$this->session->unset_userdata('uid');
		$this->load->view('includes/reset_pass');
	}
	public function change_pass()
	{
		//$this->session->unset_userdata('uid');
		$uid = $this->input->post('userID');
		
		//$pass = base64_encode($this->input->post('new_pass'));
		$pass = $this->encrypt->encode($this->input->post('new_pass'));
		
		$data = array('password' => $pass);
				
		$this->db->where('id', $uid);
		$this->db->update('people', $data);
		$this->session->set_userdata('success_msg', 'You have changed your password successfully.');
		redirect('home');
	}
	public function analyticks_data()   // calculate the analyticks graph
	{

		 $companyID=$this->input->post('companyID');
		 $result=$this->company_model->createmy_graph($companyID);
		//echo "<pre>"; print_r($result);die;
		 echo json_encode($result);
		
	}
	public function user_profile()
	{
		$uid = $this->uri->segment(3);
		$data['limit']=3;
		$data['start']=0;
		$fieldASC = 'overall_pay_exp';
		$ascDesc = 'ASC';
		$data['user_details'] = $this->review_model->getDetailsByID('people','id',$uid);
		if(!empty($data['user_details']))
		{
			$data['review_details'] = $this->review_model->getDetailsByID('company_review','added_by',$uid);
			$data['review_all_pegi_Withowt_Anno'] = $this->review_model->getDetailsLimitWithoutAnno('company_review','added_by',$uid,$data['limit'],$data['start'],$fieldASC,$ascDesc);
			$data['total'] = $this->review_model->getDetails('company_review','added_by',$uid);
			$data['pageindex']=$this->myPagination($data['total'],$per_page=3,$page=1,$url='?',$uid);
			
			$data['review_all_pegiComment'] = $this->review_model->getDetailsLimitCommentWithoutAnno('review_comment','comment_by',$uid,$data['limit'],$data['start']);
			$data['totalComment'] = $this->review_model->getDetailsLimitCommentCountWithoutAnno('review_comment','comment_by',$uid);
			//echo "<pre>";print_r($data['review_all_pegiComment']);
			
			$data['pageComment']=$this->myPaginationcomment($data['totalComment'],$per_page=3,$page=1,$url='?',$uid);
			$this->load->view('includes/user_profile_details',$data);
		}else{
			redirect('home');
		}	
	}
	function pagination_userDetails_comment()
	{
	   
		$uid = $this->input->post('uid');
		$per_page = 3;
		$page=$this->input->post('page');
		
		$data['start']=($page*$per_page)-$per_page;
		$data['limit']=3;
		$fieldASC = 'overall_pay_exp';
		$ascDesc = 'ASC';
		$data['user_details'] = $this->review_model->getDetailsByID('people','id',$uid);
		$data['review_details'] = $this->review_model->getDetailsByID('company_review','added_by',$uid);
		
		$data['review_all_pegiComment'] = $this->review_model->getDetailsLimitCommentWithoutAnno('review_comment','comment_by',$uid,$data['limit'],$data['start']);
		$data['totalComment'] = $this->review_model->getDetailsLimitCommentCountWithoutAnno('review_comment','comment_by',$uid);
		$data['pageComment']=$this->myPaginationcomment($data['totalComment'],$per_page=3,$page,$url='?',$uid);
		
		$this->load->view('includes/commentSectionProfile',$data);
	  
	}
	
	function pagination_userDetails()
	{
	   
	    $uid = $this->input->post('uid');
		$per_page = 3;
	    $page=$this->input->post('page');
	    $data['start']=($page*$per_page)-$per_page;
		$data['limit']=3;
		$fieldASC = 'overall_pay_exp';
		$ascDesc = 'ASC';
		$data['user_details'] = $this->review_model->getDetailsByID('people','id',$uid);
		$data['review_details'] = $this->review_model->getDetailsByID('company_review','added_by',$uid);
		$data['review_all_pegi'] = $this->review_model->getDetailsLimitWithoutAnno('company_review','added_by',$uid,$data['limit'],$data['start'],$fieldASC,$ascDesc);
		$data['total'] = $this->review_model->getDetails('company_review','added_by',$uid);
		$data['pageindex']=$this->myPagination($data['total'],$per_page=3,$page,$url='?',$uid);
	
		$this->load->view('includes/userDetailsRating',$data);
	  
	}
	
	function myPaginationcomment($total=0,$per_page=3,$page,$url='?',$companyID)
	{
		
			$total = $total;
			$adjacents = "2"; 
			   
			 $prevlabel = "&lsaquo; Prev";
			 $nextlabel = "Next &rsaquo;";
			 $lastlabel = "Last &rsaquo;&rsaquo;";
			   
			 $page = ($page == 0 ? 1 : $page);  
			 $start = ($page - 1) * $per_page;                               
			   
			 $prev = $page - 1;                          
			 $next = $page + 1;
			   
			 $lastpage = ceil($total/$per_page);
		 
			 if($lastpage < 2){
				 return '';
			 }
			 $lpm1 = $lastpage - 1; // //last page minus 1
			   
			 $pagination = "";
			 if($lastpage > 1){   
				 $pagination .= "<ul class='pagination'>";
				 $pagination .= "<li class='page_info'><span>Page {$page} of {$lastpage}</span></li>";
					   
					 if ($page > 1) $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination1($prev,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$prev}'>{$prevlabel}</a></li>";
					   
				 if ($lastpage < 7 + ($adjacents * 2)){   
					 for ($counter = 1; $counter <= $lastpage; $counter++){
						 if ($counter == $page)
							 $pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
						 else
							 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination1($counter,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
					 }
				   
				 } elseif($lastpage > 5 + ($adjacents * 2)){
					   
					 if($page < 1 + ($adjacents * 2)) {
						   
						 for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
							 if ($counter == $page)
								 $pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
							 else
								 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination1($counter,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
						 }
						 $pagination.= "<li class='dot'>...</li>";
						 $pagination.= "<li><a href='javascript:void(0);'  onclick='get_mypagination1($lpm1,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
						 $pagination.= "<li><a href='javascript:void(0);'  onclick='get_mypagination1($lastpage,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";  
							   
					 } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
						   
						 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination1(1,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='1'>1</a></li>";
						 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination1(2,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='2'>2</a></li>";
						 $pagination.= "<li class='dot'>...</li>";
						 for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
							 if ($counter == $page)
								 $pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
							 else
								 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination($counter,$companyID);' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
						 }
						 $pagination.= "<li class='dot'>..</li>";
						 $pagination.= "<li><a href='javascript:void(0);'  onclick='get_mypagination1($lpm1,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
						 $pagination.= "<li><a href='javascript:void(0);'  onclick='get_mypagination1($lastpage,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";      
						   
					 } else {
						   
						 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination1(1,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='1'>1</a></li>";
						 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination1(2,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='2'>2</a></li>";
						 $pagination.= "<li class='dot'>..</li>";
						 for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
							 if ($counter == $page)
								 $pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
							 else
								 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination1($counter,$companyID);'  class='GoSearchPagi' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
						 }
					 }
				 }
				   
					 if ($page < $counter - 1) {
						 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination1($next,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$next}'>{$nextlabel}</a></li>";
						 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination1($lastpage,$companyID);'  class='GoSearchPagi' id='GoSearchPagi' page='{$lastpage}'>{$lastlabel}</a></li>";
					 }
				   
				 $pagination.= "</ul>";        
			 }
			   
			 return $pagination;
	}
	
	function myPagination($total=0,$per_page=3,$page,$url='?',$companyID)
	{
		
			$total = $total;
			$adjacents = "2"; 
			   
			 $prevlabel = "&lsaquo; Prev";
			 $nextlabel = "Next &rsaquo;";
			 $lastlabel = "Last &rsaquo;&rsaquo;";
			   
			 $page = ($page == 0 ? 1 : $page);  
			 $start = ($page - 1) * $per_page;                               
			   
			 $prev = $page - 1;                          
			 $next = $page + 1;
			   
			 $lastpage = ceil($total/$per_page);
		 
			 if($lastpage < 2){
				 return '';
			 }
			 $lpm1 = $lastpage - 1; // //last page minus 1
			   
			 $pagination = "";
			 if($lastpage > 1){   
				 $pagination .= "<ul class='pagination'>";
				 $pagination .= "<li class='page_info'><span>Page {$page} of {$lastpage}</span></li>";
					   
					 if ($page > 1) $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination($prev,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$prev}'>{$prevlabel}</a></li>";
					   
				 if ($lastpage < 7 + ($adjacents * 2)){   
					 for ($counter = 1; $counter <= $lastpage; $counter++){
						 if ($counter == $page)
							 $pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
						 else
							 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination($counter,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
					 }
				   
				 } elseif($lastpage > 5 + ($adjacents * 2)){
					   
					 if($page < 1 + ($adjacents * 2)) {
						   
						 for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
							 if ($counter == $page)
								 $pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
							 else
								 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination($counter,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
						 }
						 $pagination.= "<li class='dot'>...</li>";
						 $pagination.= "<li><a href='javascript:void(0);'  onclick='get_mypagination($lpm1,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
						 $pagination.= "<li><a href='javascript:void(0);'  onclick='get_mypagination($lastpage,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";  
							   
					 } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
						   
						 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination(1,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='1'>1</a></li>";
						 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination(2,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='2'>2</a></li>";
						 $pagination.= "<li class='dot'>...</li>";
						 for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
							 if ($counter == $page)
								 $pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
							 else
								 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination($counter,$companyID);' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
						 }
						 $pagination.= "<li class='dot'>..</li>";
						 $pagination.= "<li><a href='javascript:void(0);'  onclick='get_mypagination($lpm1,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
						 $pagination.= "<li><a href='javascript:void(0);'  onclick='get_mypagination($lastpage,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";      
						   
					 } else {
						   
						 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination(1,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='1'>1</a></li>";
						 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination(2,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='2'>2</a></li>";
						 $pagination.= "<li class='dot'>..</li>";
						 for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
							 if ($counter == $page)
								 $pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
							 else
								 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination($counter,$companyID);'  class='GoSearchPagi' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
						 }
					 }
				 }
				   
					 if ($page < $counter - 1) {
						 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination($next,$companyID);' class='GoSearchPagi' id='GoSearchPagi' page='{$next}'>{$nextlabel}</a></li>";
						 $pagination.= "<li><a href='javascript:void(0);' onclick='get_mypagination($lastpage,$companyID);'  class='GoSearchPagi' id='GoSearchPagi' page='{$lastpage}'>{$lastlabel}</a></li>";
					 }
				   
				 $pagination.= "</ul>";        
			 }
			   
			 return $pagination;
	}
	function getconfirmation_page()
	{
		//echo $this->session->flashdata('tried_uid');echo $this->session->flashdata('attempt_relogin');
		if($this->session->flashdata('attempt_relogin')){
			if($this->session->flashdata('tried_uid') && $this->session->flashdata('tried_uid') > 0){
				$this->load->view('account_settings/get_confirmationToActivate');
			}else{
				$this->session->set_userdata('error_msg', 'Oops, An error occured. Please recheck username and password and try again!');
				redirect('home');
			}
		}else{
			$this->session->set_userdata('error_msg', 'Oops, An error occured. Please recheck username and password and try again!');
			redirect('home');
		}
	}
	function reactivate_account()
	{
		$uid = $this->input->post('profile_id');
		$data = array('status' => 1);
				
		$this->db->where('id', $uid);
		$this->db->update('people', $data);
		
		$this->db->where('id', $uid);
		$query = $this->db->get('people');
		if($query->num_rows > 0){
			$result = $query->row();
			if($result->first_name == '' && $result->last_name == '') {
				$name = explode('@',$result->email)[0];
			}else {
				$name = $result->first_name.' '. $result->last_name;  
			}
			$data = array(
					'uid' => $result->id,
					'is_logged_in' => true,
					'name'=>$name,
					'profile_pic'=>$result->profile_pic
				);	
			$this->session->set_userdata($data);
			$this->session->set_userdata('success_msg', 'Your account has been re-activated successfully!');
			$notificationSendAdmin = $this->login_model->sendNotification(20, $uid, 0,'people', $uid);
			$notificationSendUser = $this->login_model->sendNotification(20,0,$uid,'people', $uid);
			redirect('account_settings/index');
		}else{
			$this->session->set_userdata('error_msg', 'We cannnot find you in our system. Please create a new account and login!');
			redirect('home');
		}
		
		
	}
	//===========store ip address of viewer==========//
	function total_viewer($data)
	{
		$date=date('Y-m-d');
		$data_to_store=array(
			'ip_address' =>$data,
			'date' => $date,
		);
		//print_r($data_to_store);
		//$this->login_model->store_ip($data_to_store);
	}
	//==============check=============//
	function show()
	{
	$this->load->view('includes/test');
	}
}
?>