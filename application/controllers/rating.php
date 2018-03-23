
<?php
class Rating extends CI_Controller {
   // Controller class for Login
	function __construct()
	{
		parent::__construct();
		$this->load->model('review_model');	//loading model
		$this->load->model('home_model');	//loading model
		$this->load->model('login_model');	//loading model
		$this->load->library('session');	//loading session
		$this->load->model('sidepanel_model');
		$this->load->model('feedback_model');
		$this->load->model('site_settings_model');
		$this->load->model('badge_model');
		$this->load->model('company_model');
		$this->load->model('left_panel_model');
		$this->load->helper('captcha');
	}
    
    //============load home page================//
    
    function myPagination($total=0,$per_page=3,$page=1,$url='?',$companyID)
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
	function index()    // this function call first
	{
		$comapnyId = $companyID = $this->uri->segment(3);
		$data['companyID'] = $companyID;
		$checkActiveCompany = $this->review_model->checkActiveCompany($companyID);
		if($checkActiveCompany == 0){
			$this->session->set_userdata('error_msg', 'Sorry! This company has been blocked by Admin for some reason. You can contact with us at care@creditmonk.com.');
			redirect('company/index?company_name=&company_location=&page=1');
		}
		
		$fieldASC = 'overall_pay_exp';
		$ascDesc = 'ASC';
		$data['limit']=3;
		$data['start']=0;
		$data['company_details'] = $this->review_model->getCompanyDetails($companyID);
	
		if(!empty($data['company_details']))
		{	$activeCompanyID = $data['company_details'][0]->active_id;
				$data['company_details_active'] = $this->review_model->getCompanyDetails($activeCompanyID);
				
				$data['review_details'] = $this->review_model->getratingPerReviewForDisable('company_review','company_id',$companyID);
				
				$uid=$this->session->userdata('uid');
				$data['followCount'] = $this->review_model->followCount($companyID, $uid);
				$data['like_unlike_count'] = $this->review_model->likeUnlikeCount($companyID);
				$data['result'] = $this->sidepanel_model->get_sidepanel($uid,'people'); 
				$data['review_all_pegi'] = $this->review_model->getDetailsLimit('company_review','company_id',$companyID,$data['limit'],$data['start'],$fieldASC,$ascDesc,'load');
				$data['total'] = $this->review_model->getDetails('company_review','company_id',$companyID);
				//$data['review_all_pegiiis'] = $this->review_model->getDetailsLimit('company_review','company_id',$companyID,$data['limit'],$data['start'],$fieldASC,$ascDesc);
				//$data['totallls'] = $this->review_model->getDetails('company_review','company_id',$companyID);
				$data['pageindex']=$this->myPagination($data['total'],$per_page=3,$page=1,$url='?',$companyID);
				
				$data['files'] = $this->review_model->getImageAndVideoByID('review_files','company_id',$companyID);
				
				$data['infrastructure_business_premises'] = $this->company_model->infrastructureBusinessPremises();
				$data['product_interests_value'] = $this->company_model->productInterest();
				$data['product_interest_options'] = $this->company_model->productInterest();
				$data['infrastructure_area_type'] = $this->company_model->infrastructureAreaType();
				
				$data['competitors'] = $this->company_model->getAdditionalDetails('company_competitors', $companyID, $this->session->userdata('uid'));
				$data['sister_concerns'] = $this->company_model->getAdditionalDetails('sister_concerns', $companyID, $this->session->userdata('uid'));
				$data['company_branches'] = $this->company_model->getAdditionalDetails('company_branches', $companyID, $this->session->userdata('uid'));
				$data['product_interests'] = $this->company_model->getAdditionalDetails('product_interests', $companyID, $this->session->userdata('uid'));
				$data['company_sales_tax_details'] = $this->company_model->getAdditionalDetails('company_sales_tax_details', $companyID, $this->session->userdata('uid'));
				$data['company_residence'] = $this->company_model->getAdditionalDetails('company_residence', $companyID, $this->session->userdata('uid'));
				$data['banker_details'] = $this->company_model->getAdditionalDetails('banker_details', $companyID, $this->session->userdata('uid'));
				$data['infrastructure_details'] = $this->company_model->getAdditionalDetails('infrastructure_details', $companyID, $this->session->userdata('uid'));
				$data['key_information'] = $this->company_model->getAdditionalDetails('key_information', $companyID, $this->session->userdata('uid'));
				$data['company_keyExecutive'] = $this->company_model->getAdditionalDetails('company_key_exec', $companyID, $this->session->userdata('uid'));
				$data['company_address'] = $this->company_model->getAdditionalDetailss('company_address', $companyID, $this->session->userdata('uid'));
				$data['company_additional'] = $this->company_model->getAdditionalDetails('company_additional', $companyID, $this->session->userdata('uid'));
				
				$data['competitorss'] = $this->company_model->getAdditionalDetailsh('company_competitors', $activeCompanyID);
				$data['sister_concernss'] = $this->company_model->getAdditionalDetailsh('sister_concerns', $activeCompanyID);
				$data['company_branchess'] = $this->company_model->getAdditionalDetailsh('company_branches', $activeCompanyID);
				$data['product_interestss'] = $this->company_model->getAdditionalDetailsh('product_interests', $activeCompanyID);
				$data['company_sales_tax_detailss'] = $this->company_model->getAdditionalDetailsh('company_sales_tax_details', $activeCompanyID);
				$data['company_residences'] = $this->company_model->getAdditionalDetailsh('company_residence', $activeCompanyID);
				$data['banker_detailss'] = $this->company_model->getAdditionalDetailsh('banker_details', $activeCompanyID);
				$data['infrastructure_detailss'] = $this->company_model->getAdditionalDetailsh('infrastructure_details', $activeCompanyID);
				$data['key_informations'] = $this->company_model->getAdditionalDetailsh('key_information', $activeCompanyID);
				$data['company_keyExecutives'] = $this->company_model->getAdditionalDetailsh('company_key_exec', $activeCompanyID);
				$data['company_addresss'] = $this->company_model->getAdditionalDetailssh('company_address', $activeCompanyID);
				$data['company_additionals'] = $this->company_model->getAdditionalDetailsh('company_additional', $activeCompanyID);
				$data['alertMessage'] = $this->review_model->getAlertForCompany($companyID);
				
				$insertAndUpdateCount = $this->review_model->count_calculate($companyID);
				
				/*$vals = array(
					'img_path' => './assets/images/captcha/',
					'img_url' => base_url().'assets/images/captcha/',
					'font_path'	=> './path/to/fonts/texb.ttf',
					'img_width'	=> '295',
					'img_height' => 57,
					'expiration' => 7200
				);
				$data['captcha'] = create_captcha($vals);*/
				$code= random_string('alnum',8);
	  $vals = array(
		    'word'  => $code,
			'img_path'	=> 'images_captcha/',
			'img_url'	=> base_url().'images_captcha/',
			'img_width'	=> '170',
			'img_height' => 70,
			'expiration' => 7200,
			
			);
	  
	  
	  /* Generate the captcha */
      $data['captcha'] = create_captcha($vals);
	  
      /* Store the captcha value (or 'word') in a session to retrieve later */
      $this->session->set_userdata('captchaWord', $data['captcha']['word']);

				
				//$data['all_company'] = $this->company_model->get_allCompanies();   // get all company
				$data['all_company'] = $this->company_model->select_all_company_Last(0,10);   // get all company
				
				$data['companyDetails'] = $this->review_model->getCompanyDetails($comapnyId);
				//$data['review_details'] = $this->review_model->getDetailsByID('company_review','company_id',$comapnyId);
				$data['key_exec'] = $this->company_model->keyexecDetails(0,5,'company_id',$comapnyId);
				$numOfTotal = $this->company_model->getNumRow('company_key_exec','company_id',$comapnyId);
			
				//$data['competitors'] = $this->company_model->getAdditionalDetails('company_competitors', $comapnyId, $this->session->userdata('uid'));
				//$data['sister_concerns'] = $this->company_model->getAdditionalDetails('sister_concerns', $comapnyId, $this->session->userdata('uid'));
				//$data['company_branches'] = $this->company_model->getAdditionalDetails('company_branches', $comapnyId, $this->session->userdata('uid'));
				//$data['product_interests'] = $this->company_model->getAdditionalDetails('product_interests', $comapnyId, $this->session->userdata('uid'));
				//$data['company_sales_tax_details'] = $this->company_model->getAdditionalDetails('company_sales_tax_details', $comapnyId, $this->session->userdata('uid'));
				//$data['company_residence'] = $this->company_model->getAdditionalDetails('company_residence', $comapnyId, $this->session->userdata('uid'));
				//$data['banker_details'] = $this->company_model->getAdditionalDetails('banker_details', $comapnyId, $this->session->userdata('uid'));
				//$data['infrastructure_details'] = $this->company_model->getAdditionalDetails('infrastructure_details', $comapnyId, $this->session->userdata('uid'));
				//$data['key_information'] = $this->company_model->getAdditionalDetails('key_information', $comapnyId, $this->session->userdata('uid'));
				//$data['company_keyExecutive'] = $this->company_model->getAdditionalDetails('company_key_exec', $comapnyId, $this->session->userdata('uid'));
				//$data['company_address'] = $this->company_model->getAdditionalDetailss('company_address', $comapnyId, $this->session->userdata('uid'));
				//$data['company_additional'] = $this->company_model->getAdditionalDetails('company_additional', $comapnyId, $this->session->userdata('uid'));
				//$data['competitors'] = $this->company_model->getAdditionalDetails('company_competitors', $comapnyId, $this->session->userdata('uid'));
			
				$data['pegi']= $this->myPagination($numOfTotal,'5','1',$url='?',$comapnyId);
				$this->load->view('rating/rating',$data);
		}else{
			redirect('home/index');
		}
		
	}
	
	function company_like_unlike() {
		
		$company_id = $this->input->post('company_id');
		$like_count = $this->input->post('like_count');
		$status = $this->input->post('status');
		
		$result = $this->review_model->updateCompanyLike($company_id,$like_count,$status);
		echo $result['like'].'@@'.$result['unlike'];
	}
	
	function follow_company(){
		$companyID = $this->input->post('com_id');
		$user_id = $this->session->userdata('uid');
		//echo $companyID.' '; echo $user_id;die;
		//echo $companyID;die;
		$result = $this->review_model->updateFollow($companyID, $user_id);
		echo $result;die;
		
	}
	
	function benifit_claimed()
	{
		$data['quote']=$this->home_model->get_quote();
		$this->load->view('benifit_claimed/benifit_claimed',$data);
	}
	
	function pagination_comment()
	{
	   
	    $per_page = 3;
	    $page=$this->input->post('page');
	    $companyID=$this->input->post('companyid');
	    //$num= $this->review_model->getDetails_review('company_review','company_id',$companyID);
		$url_hid = $this->input->post('url');
		$limit=3;
		$ascDesc = $this->input->post('ascDesc');
		$fieldASC = $this->input->post('field');
	    $start=($page*$per_page)-$per_page;
	    //$start=$num-($page*$per_page);
	    $data['total'] = $this->review_model->getDetails('company_review','company_id',$companyID);
	    $data['review_all_pegi'] = $this->review_model->getDetailsLimit('company_review','company_id',$companyID,$limit,$start,$fieldASC,$ascDesc,'ajax');
	   
		$data['pageindex']=$this->myPagination($data['total'],$per_page,$page,$url='?',$companyID);
		$data['company_id'] = $companyID;
		$data['url_det'] = $url_hid;
		//$code= random_string('alnum',8);
		$vals = array(
			//'word'  => $code,
			'img_path'	=> 'images_captcha/',
			'img_url'	=> base_url().'images_captcha/',
			//'font_path'	=> './path/to/fonts/texb.ttf',
			'img_width'	=> '295',
			'img_height' => 57,
			'expiration' => 7200
        );
        $data['captcha'] = create_captcha($vals);
	
	//$this->session->set_userdata('captcha',$data['captcha']['word']);

		$this->load->view('rating/raiting_section',$data);
	  
	}
//	function orderCommment()
//	{
//		$per_page = 3;
//	    $page=$this->input->post('page');
//	    $companyID=$this->input->post('companyid');
//		$ascDesc = $this->input->post('ascDesc');
//		$fieldASC = $this->input->post('field');
//		$url_hid = $this->input->post('url');
//	    $limit=3;
//	    $start=($page*$per_page)-$per_page;
//	    $data['total'] = $this->review_model->getDetails('company_review','company_id',$companyID);
//	    $data['review_all_pegi'] = $this->review_model->getDetailsOrder('company_review','company_id',$companyID,$limit,$start,$fieldASC,$ascDesc);
//	    $data['pageindex']=$this->myPagination($data['total'],$per_page,$page,$url='?',$companyID);
//		$data['company_id'] = $companyID;
//		$data['url_det'] = $url_hid;
//		
//		$vals = array(
//			'img_path' => './assets/images/captcha/',
//			'img_url' => base_url().'assets/images/captcha/',
//			'font_path'	=> './path/to/fonts/texb.ttf',
//			'img_width'	=> '295',
//			'img_height' => 57,
//			'expiration' => 7200
//        );
//        $data['captcha'] = create_captcha($vals);
//	    $this->load->view('rating/raiting_section',$data);
//	}
	function insertMessages()
	{
		$redirectTo = $this->input->post('urlToredirect');
		$companyID= $this->input->post('companyID');
		$companyDetails = $this->review_model->getDetailsByID('company_details','id',$companyID);
		$data_arr = array(
			'reciever'=> $this->input->post('fromId'),
			'sender' => $this->session->userdata('uid'),
			'purpose' =>$this->input->post('subject'),
			'company_id' => $companyID,
			'content'=> $this->input->post('messageDetails'),
			'notification_type' => 14
			);
		$insert_comments = $this->review_model->add_review_comments('email_recieve', $data_arr); // Review Comments
		$this->session->set_userdata('success_msg', 'Message sent. Thank you for helping the CreditMonk community.');
		redirect('rating/'.$redirectTo.'/'.$companyID.'/'.urlencode($companyDetails[0]->company_name));
	}
	function allcoments()
	{
		$uid=$this->session->userdata('uid');
		$companyID = $this->uri->segment(3);
		$data['companyID']=$companyID;
		$data['company_details'] = $this->review_model->getCompanyDetails($companyID);
		if(!empty($data['company_details']))
		{
			$fieldASC = 'overall_pay_exp';
			$ascDesc = 'ASC';
			$data['limit']=3;
			$data['start']=0;
			$data['review_details'] = $this->review_model->getDetailsByID('company_review','company_id',$companyID);
			$data['review_all_pegi'] = $this->review_model->getDetailsLimit('company_review','company_id',$companyID,$data['limit'],$data['start'],$fieldASC,$ascDesc,'load');
			$data['total'] = $this->review_model->getDetails('company_review','company_id',$companyID);
			$data['pageindex']=$this->myPagination($data['total'],$per_page=3,$page=1,$url='?',$companyID);
			
			$data['followCount'] = $this->review_model->followCount($companyID, $uid);
			$data['like_unlike_count'] = $this->review_model->likeUnlikeCount($companyID);
			
			
			 $vals = array(
				'img_path' => './assets/images/captcha/',
				'img_url' => base_url().'assets/images/captcha/',
				'font_path'	=> './path/to/fonts/texb.ttf',
				'img_width'	=> '295',
				'img_height' => 57,
				'expiration' => 7200
			);
			$data['captcha'] = create_captcha($vals);
			$this->load->view('rating/allrating_listing',$data);
		}
		else{
			redirect('home/index');
		}
	}
	function changeCaptcha()
	{
		 //$code= random_string('alnum',8);
		$vals = array(
			//'word'  => $code,
			'img_path'	=> 'images_captcha/',
			'img_url'	=> base_url().'images_captcha/',
			//'font_path'	=> './path/to/fonts/texb.ttf',
			'img_width'	=> '295',
			'img_height' => 57,
			'expiration' => 7200
        );
        $captcha = create_captcha($vals);
		//echo $captcha['image'].'@@@@'.$captcha['word'];
		echo "<img src='".base_url()."captcha/captcha.php' style='max-width: 100%;' id='captcha' />".'@@@@'.$captcha['word'];
		die;
	}
	function allImageVideo()
	{
		$uid=$this->session->userdata('uid');
		$companyID = $this->uri->segment(3);
		$data['flag'] = $this->uri->segment(4);
		$data['review_details'] = $this->review_model->getDetailsByID('company_review','company_id',$companyID);
		$data['company_details'] = $this->review_model->getCompanyDetails($companyID);
		$data['files'] = $this->review_model->getImageAndVideoByID('review_files','company_id',$companyID);
		
		$data['followCount'] = $this->review_model->followCount($companyID, $uid);
		$data['like_unlike_count'] = $this->review_model->likeUnlikeCount($companyID);
		$this->load->view('rating/allImage',$data);
	}
	
	// mail sending function start
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
			//$mail->addAddress('ellen@example.com'); // Name is optional
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');
			$mail->WordWrap = 50; // Set word wrap to 50 characters
			//$mail->addAttachment('/usr/labnol/file.doc'); // Add attachments
			//$mail->addAttachment('/images/image.jpg', 'new.jpg'); // Optional name
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
			   $return=0;
			}
			else
			{
			   //echo 'Message has been sent';
			   $return=1;
			}
			return $return;
			//die;
	}
	// mail sending function end
	
	function addComments()
	{
		 //$comment_id = $this->input->post('comment_id');
		$comment_text= $this->input->post('comment_text');
		//echo $comment_text;die;
		$company_id= $this->input->post('company_id');
		$reviewer_id = $this->input->post('reviewer_id');
		$url_redirect = $this->input->post('url_prob');
		$logo = "<a href='".base_url()."'><img src='".base_url()."assets/images/logo-1.png' alt=''></a>";
		$data_arr = array(
			'review_id'=> $reviewer_id,
			'uid' => $this->session->userdata('uid'),
			'problem_comment' =>$comment_text
		);
		if($this->session->userdata('uid') != "")
		{
			$insert_comments = $this->review_model->add_review_comments('company_review_details', $data_arr); // Review Comments
			$review_mail = $this->review_model->reviewer_mail($reviewer_id); // Mail To the Reviewer
			
			//$admin_comp_email = $this->review_model->admin_comp_email('claim_owner', $company_id);
			//$claim_id = $admin_comp_email[0]->claim_id; // User Id
			$notificationSend = $this->login_model->sendNotification(9, $this->session->userdata('uid'), 0, 'company_review_details', $insert_comments);
			
			
			$data_arr=array('id' => '34');
			$emailcontent=$this->login_model->email_tmp('email_template', $data_arr);
			
			$content =$emailcontent[0]->email_desc;
			$site='Credit monk';
			
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
			| <a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/privacy'>Privacy</a> |
			<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/termsCondition'> Terms &amp; Conditions</a> |
			<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/helpCenter?tab=Guiding'> Help</a>";
			//generating static links//
			$link = base_url()."home/helpCenter?tab=Contact";
			//this is for footer section in email template//
			
			
			
			// Mail Sent to the reviewer
			
			$receiver_name = $review_mail[0]->first_name;
			$receiver_email = $review_mail[0]->email;
			$email_plcholders2 = array("[RECEIVER]","[SENDER]","[RECEIVER_EMAIL]","[SENDER_EMAIL]","[DATE]","[PRICE]","[SITENAME]","[LINK]","[LOGO]","[BODY]","[SOCIAL_LOGO]","[STATICPAGES]","[BASEURL]");
			$email_plcholders_rplc2 = array($receiver_name,"","","","","","",$link,$logo,$comment_text,$social_logo,$static_pages,$baseurl);
			$body = str_replace($email_plcholders2,$email_plcholders_rplc2,$content);
			if(!empty($review_mail))
			{
				//if($this->send_mail($receiver_email, $emailcontent[0]->email_title,$body))
				//{
				//}
				//else
				//{
				//}	
			}
			else
			{
				//$this->session->set_userdata('error_msg', 'Unable to send email due to some administrative restrictions.');
			}
			echo "success";die;
			
		}
		else{
			echo "login_required";die;
		}
	}
	function addReviewComment()
	{
		
		$comment_text = $this->input->post("comments");
		$comment_id = $this->input->post("reviewCommentID");
		//$url_redirect = $this->input->post('url');
		$data_arr = array(
			'review_id'=> $comment_id,
			'comment_by' => $this->session->userdata('uid'),
			'comment' =>$comment_text
		);
		
		$insert_comments = $this->review_model->add_review_comments('review_comment', $data_arr); // Review Comments
		$last_id= $this->db->insert_id();
		$getCompanyDet = $this->review_model->getDetailsByID('company_review','id',$comment_id);
		$notificationSendAdmin = $this->login_model->sendNotification(8, $this->session->userdata('uid'), 0,'review_comment', $insert_comments);
		if($this->session->userdata('uid') != $getCompanyDet[0]->added_by)
		{
		$notificationSendUser = $this->login_model->sendNotification(8, 0,$this->session->userdata('uid'),'review_comment', $insert_comments);
		}
		$getUserIdForCompany = $this->review_model->getDetailsByID('company_details','id',$getCompanyDet[0]->company_id);
		
		$notificationSend = $this->login_model->sendNotification(36, 0,$getUserIdForCompany[0]->uid, 'company_review', $comment_id);
		
		////////############################## Send mail to the comments of any review here ######################////////////////
				
				$data_arr=array('id' => '32');
				$emailcontent=$this->login_model->email_tmp('email_template', $data_arr);
				$getReviewDetails = $this->review_model->getDetailsByID('company_review','id',$comment_id);
				$getCompanyDetails = $this->review_model->getDetailsByID('company_details','id',$getReviewDetails[0]->company_id);
				$getPeopleDetails = $this->review_model->getDetailsByID('people','id',$getReviewDetails[0]->added_by);
				$content =$emailcontent[0]->email_desc;
				$site='Credit monk';
				$logo = "<a href='".base_url()."'><img src='".base_url()."assets/images/logo-1.png' alt=''></a>";
				$link = base_url().'company/index?company_name=&company_location=&page=1';
				
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
				| <a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/privacy'>Privacy</a> |
				<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/termsCondition'> Terms &amp; Conditions</a> |
				<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/helpCenter?tab=Guiding'> Help</a>";
				//generating static links//
				
				//this is for footer section in email template//
				
				$email_details = array("[LINK]","[LOGO]","[SITENAME]","[RECEIVER]","[SOCIAL_LOGO]","[STATICPAGES]","[BASEURL]","[REVIEW]","[COMPANY]");
				$email_details_rplc = array($link,$logo,$site,$getPeopleDetails[0]->first_name,$social_logo,$static_pages,$baseurl,$getReviewDetails[0]->review_title,$getCompanyDetails[0]->company_name);
				$subject=$emailcontent[0]->email_title;
				$content=str_replace($email_details,$email_details_rplc,$content);
				if($getReviewDetails[0]->added_by != $this->session->userdata('uid'))
				{
				$mailSend = $this->left_panel_model->send_mail($getPeopleDetails[0]->email,$subject,$content);
				}
				//////////////////// ###### Send mail for Comments on any review ######################////////////////////////////////////
		
		
		
		
		
		$getAllComments = $this->review_model->getCommentsByReview($comment_id);
		//if($insert_comments) {
			
				$commentAll = '';
				if(!empty($getAllComments))
				{
					$i=0;
				foreach($getAllComments as $getAllCommentsAll)
				{
					$result=$this->sidepanel_model->get_sidepanel($getAllCommentsAll->comment_by,'people');    
					if($result[0]->first_name !='' || $result[0]->last_name !='')
					{
						$comm_name= '<p><a href="'.base_url().'login_cont/user_profile/'.$getAllCommentsAll->peopleID.'/'.$getAllCommentsAll->first_name.' '.$getAllCommentsAll->last_name.'">'.$getAllCommentsAll->first_name.' '.$getAllCommentsAll->last_name.'</a></p>';
					}else{
						$arr=  explode("@",$result[0]->email);
						$comm_name= '<p><a href="'.base_url().'login_cont/user_profile/'.$getAllCommentsAll->peopleID.'/'.$getAllCommentsAll->first_name.' '.$getAllCommentsAll->last_name.'">'.$arr[0].'</a>';
					}
					//$getAllCommentsAll->comment_by; //The person who commented
					//$getAllCommentsAll->review_id; // Will be used to fetch comapny id
					$fetch_company_id= $this->feedback_model->fetch_row_by_id('company_review', 'id', $getAllCommentsAll->review_id);
					//echo ("<pre>");
					//print_r($fetch_company_id);die;
					$find_claim_owner= $this->feedback_model->get_row_by_id('claim_owner', 'company_id', $fetch_company_id[0]->company_id, 'claim_id', $getAllCommentsAll->comment_by);
					$commentAll .='<div class="clearfix comment-blog">';
					$commentAll .='<div class="review-detail-Subpic">';
					$commentAll .='<div class="review-detail-icon">';
					$commentAll .='<div class="bg-style imageBckgr" style="background: url('.base_url().'assets/images/profile_picture/thumbnail/'.$getAllCommentsAll->profile_pic.');background-repeat: no-repeat;background-position: center center;height:33px;"></div>';
					$commentAll .='</div>';
					$commentAll .='</div>';
					  
					$commentAll .='<div class="commentArea">';
					$commentAll .= $comm_name;
					if($find_claim_owner == 1)
					{
					$commentAll .='<div class="claime-tag">';
					$commentAll .='Claimed Person';
					$commentAll .='</div>';
					}
					$commentAll .= '</p>';
					//if($getAllCommentsAll->first_name !='' && $getAllCommentsAll->last_name !='')
					//{
					//	$commentAll .='<p><a href="javascript:void(0);">'.$getAllCommentsAll->first_name.' '.$getAllCommentsAll- >last_name.'</a></p>';
					//}else{
					//	$commentAll .='<p><a href="javascript:void(0);">'.$getAllCommentsAll->email.'</a></p>';
					//}
					//$commentAll .='<p><a href="javascript:void(0);">'.$getAllCommentsAll->first_name.' '.$getAllCommentsAll->last_name.'</a></p>';
					$commentAll .='<p class="date-comment" style="color: darkorange;margin-left: 5px;"><u>Date </u>: '.date("F j, Y",strtotime($getAllCommentsAll->comment_on)).'</p>';
					$commentAll .='<br><p class="comment-section">'.$getAllCommentsAll->comment.'</p>';
					$commentAll .='</div>';
					$commentAll .='</div>';
					$i++;
				}
				echo $commentAll.'@@@'.$i;
				}
		
		//redirect($url_redirect);
	}
	
	function match_my_string()
	{
		//if (strpos($haystack, $needle) !== false) return true;
		//else return false;
		    $all_abusive=array();
			$nedel_arr=$this->review_model->getall_abuse();
			if(!empty($nedel_arr))
			{
				$k=0;
				foreach($nedel_arr as $row)
				{
					$all_abusive[$k]=$row['word'];
					$k++;
				}
				return $all_abusive;
			}
	}
	function language_filter()     // lagguage filter
	{
		$haystack=$this->input->post('word');
		$haystack=explode(" ",$haystack);
		
		$gali_arr=$this->match_my_string();
		if(!empty($gali_arr))
		{
			
			foreach($haystack as $index=>$value)
			{
				
				if(in_array($value, $gali_arr))
				{
					 echo 1;
					 break; 
				}
			}
		}
	
		

		
	}
	
	function calculator_piechart($advance,$para)    // calculate the piechart
		{
				if(!empty($advance))
				{
				   $total=count($advance);
				   $yes=0;
				   $no=0;
				   $maybe=0;
				   foreach($advance as $row)
				   {
					if($row->$para=="1")
					{
						$yes++;	
					}
					elseif($row->$para=="2")
					{
						$no++;
					}
					else
					 $maybe++;
					
				   }
				   $yespercentage=100/$total*$yes;
				   $nopercentage=100/$total*$no;
				   $maybepercentage=100/$total*$maybe;
				}
				else
				{
						$yespercentage=0;
						$nopercentage=0;
						$maybepercentage=0;		
				}
				return "ESOLZ".ceil($yespercentage).",".ceil($nopercentage).",".ceil($maybepercentage);
		}
		function calculator_graph($advance,$para)    // calculate the piechart
		{
				if(!empty($advance))
				{
				   $total=count($advance);
				   $thirtydays=0;
				   $sixstiydays=0;
				   $ninteydays=0;
				   $onetwenty=0;
				   $oneeighty=0;
				   $threesixty=0;
				   $threesixtyfive=0;
				 foreach($advance as $row)
				   {
					if($row->$para=="1")
					{
						$thirtydays++;	
					}
					elseif($row->$para=="2")
					{
						$sixstiydays++;
					}
					elseif($row->$para=="3")
					{
						$ninteydays++;
					}
					elseif($row->$para=="4")
					{
						$onetwenty++;
					}
					elseif($row->$para=="5")
					{
						$oneeighty++;
					}
					elseif($row->$para=="6")
					{
						$threesixty++;
					}
					else
					 $threesixtyfive++;
					
				   }
				   $percentage_1=100/$total*$thirtydays;
				   $percentage_2=100/$total*$sixstiydays;
				   $percentage_3=100/$total*$ninteydays;
				   $percentage_4=100/$total*$onetwenty;
				   $percentage_5=100/$total*$oneeighty;
				   $percentage_6=100/$total*$threesixty;
				   $percentage_7=100/$total*$threesixtyfive;
				
				}
				else
				{
				   $percentage_1=0;
				   $percentage_2=0;
				   $percentage_3=0;
				   $percentage_4=0;
				   $percentage_5=0;
				   $percentage_6=0;
				   $percentage_7=0;		
				}
				return "ESOLZ".ceil($percentage_1).",".ceil($percentage_2).",".ceil($percentage_3).",".ceil($percentage_4).",".ceil($percentage_5).",".ceil($percentage_6).",".ceil($percentage_7);
		}
		function calculator_graph_sec($advance,$para)    // calculate the piechart
		{
				if(!empty($advance))
				{
					$total=count($advance);
					$thirtydays=0;
					$sixstiydays=0;
					$ninteydays=0;
					$onetwenty=0;
					$oneeighty=0;
					$threesixty=0;
				 
					foreach($advance as $row)
					{
						if($row->$para=="1")
						{
							$thirtydays++;	
						}
						elseif($row->$para=="2")
						{
							$sixstiydays++;
						}
						elseif($row->$para=="3")
						{
							$ninteydays++;
						}
						elseif($row->$para=="4")
						{
							$onetwenty++;
						}
						elseif($row->$para=="5")
						{
							$oneeighty++;
						}
						elseif($row->$para=="6")
						{
							$threesixty++;
						}
						
						
					}
					$percentage_1=100/$total*$thirtydays;
					$percentage_2=100/$total*$sixstiydays;
					$percentage_3=100/$total*$ninteydays;
					$percentage_4=100/$total*$onetwenty;
					$percentage_5=100/$total*$oneeighty;
					$percentage_6=100/$total*$threesixty;
				   
					
				}
				else
				{
					$percentage_1=0;
					$percentage_2=0;
					$percentage_3=0;
					$percentage_4=0;
					$percentage_5=0;
					$percentage_6=0;
				  	
				}
				return "ESOLZ".ceil($percentage_1).",".ceil($percentage_2).",".ceil($percentage_3).",".ceil($percentage_4).",".ceil($percentage_5).",".ceil($percentage_6);
		}
		
		function send_data()    // send data for the piechart
		{
			$companyID=$this->input->post('companyID');
			$para=$this->input->post('para');
			
			if($para==1)
			{
			$advance=$this->review_model->collectdata_database('advance_chk',$companyID);   // this function calculate advance order
			echo $result=$this->calculator_piechart($advance,'advance_chk');	
			}
			else if($para==2){
			$advance=$this->review_model->collectdata_database('delayed_chk',$companyID);   // this function calculate delayed order
			echo $result=$this->calculator_piechart($advance,'delayed_chk');	
			}
			else if($para==3)
			{
			$advance=$this->review_model->collectdata_database('commited_fraud',$companyID);   // this function calculate comited faurd
			echo $result=$this->calculator_piechart($advance,'commited_fraud');	
			}
			else if($para==4)
			{
			$advance=$this->review_model->collectdata_database('bad_debt',$companyID);   // this function calculate bad debt
			echo $result=$this->calculator_piechart($advance,'bad_debt');	
			}
			else if($para==5)
			{
			$advance=$this->review_model->collectdata_database('legal_proceedings',$companyID);   // this function calculate legal_proceedings
			echo $result=$this->calculator_piechart($advance,'legal_proceedings');	
			}
			else if($para==6)
			{
			$advance=$this->review_model->collectdata_database('cheque_return_chk',$companyID);   // this function calculate cheque_return_chk
			echo $result=$this->calculator_piechart($advance,'cheque_return_chk');	
			}
			else if($para==7)
			{
			$advance=$this->review_model->collectdata_database('hold_checks',$companyID);   // this function calculate hold_checks
			echo $result=$this->calculator_piechart($advance,'hold_checks');	
			}
			else if($para==8)
			{
			$advance=$this->review_model->collectdata_database('concessional_forms',$companyID);   // this function calculate concessional_forms
			echo $result=$this->calculator_piechart($advance,'concessional_forms');	
			}
			
			
		}
		function get_graph_data()   // calculate the geaph data
		{
		    $companyID=$this->input->post('companyID');
		    $para=$this->input->post('para');
		    if($para==1)
		    {
			  $usuall_pay=$this->review_model->collectdata_database('usuall_pay',$companyID);   // this function calculate concessional_forms
			  echo $result=$this->calculator_graph($usuall_pay,'usuall_pay');	
		    }
		    elseif($para==2)
		    {
			 $credit_allow=$this->review_model->collectdata_database('credit_allow',$companyID);   // this function calculate concessional_forms
			 echo $result=$this->calculator_graph($credit_allow,'credit_allow');	
		    }
		   elseif($para==3)
		    {
			 $credit_allow=$this->review_model->collectdata_database('pay_method',$companyID);   // this function calculate concessional_forms
			 echo $result=$this->calculator_graph_sec($credit_allow,'pay_method');	
		    }
		 
		}
		
	function requestToRemove()
	{
		$reviewId = $this->uri->segment(3);
		$review_mail = $this->review_model->reviewer_mail($reviewId); // Mail To the Reviewer
		$this->db->Where('id',$reviewId);
		$this->db->update('company_review',array('disable' => 1));
		
		$replaceDetails = "Review Title : ".$review_mail[0]->review_title. "<br> Additional Feedback : ".$review_mail[0]->additional_feedback. "<br> Company Name : ".$review_mail[0]->company_name;
		$logo = "<a href='".base_url()."'><img src='".base_url()."assets/images/logo-1.png' alt=''></a>";
		$notificationSendAdmin = $this->login_model->sendNotification(16, $this->session->userdata('uid'), 0, 'company_review', $reviewId);
		$notificationSendUser = $this->login_model->sendNotification(16, 0, $this->session->userdata('uid'), 'company_review', $reviewId);
		
		$emailtmpadminreview = $this->feedback_model->email_tmp('email_template', $notificationSendAdmin['admin_email_temp_id']); // Mail Template to the admin against the review
		$body1 = $emailtmpadminreview[0]->email_desc;
		$site_settings_data = $this->site_settings_model->site_getdata();
		$email_plcholders1 = array("[RECEIVER]","[SENDER]","[RECEIVER_EMAIL]","[SENDER_EMAIL]","[DATE]","[PRICE]","[SITENAME]","[LINK]","[LOGO]","[BODY]");
		$email_plcholders_rplc1 = array("Admin","",$review_mail[0]->email,"","","","","",$logo,$replaceDetails);
		$body2 = str_replace($email_plcholders1,$email_plcholders_rplc1,$body1);
		if($this->send_mail($site_settings_data[0]->admin_email,$emailtmpadminreview[0]->email_title,$body2))
		{
			//$this->session->set_userdata('success_msg', 'Thank you for your comments');
		}
		else
		{
			//$this->session->set_userdata('error_msg', 'Unable to send email please try again.');
		}
		$this->session->set_userdata('success_msg', 'Your Review Successfully Deleted..');
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	function trends()
	{
		$companyID = $this->uri->segment(3);
		$uid = $this->session->userdata('uid');
		$data['company_details'] = $this->review_model->getCompanyDetails($companyID);
		$data['followCount'] = $this->review_model->followCount($companyID, $uid);
		$data['like_unlike_count'] = $this->review_model->likeUnlikeCount($companyID);
		$this->load->view('rating/trends',$data);
	}
	function getLastYearRating()
	{
		$companyID = $this->input->post('companyID');
		$month = date('m');
		$year = date('Y');
		$getlastData = $this->review_model->getLastYearData($companyID,$month,$year);
		$string = '';
		//foreach($getlastData as $getlastDataAll)
		//{
		//	$string .='='.$getlastDataAll;
		//}
		$string = implode('==',$getlastData);
		echo $string;
	}
	
	
	function refresh_captcha()
	{
	  $this->load->view('rating/captcha');	
	}
	
}
?>