<?php

class rules_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$CI =& get_instance();
	}
	
	function checkRuleStatus() {
		//$this->db->where('rule_no', $rules);
		$this->db->where('status', 1);
		$result = $this->db->get('get_rules');
		
		return $result->result();
		/*if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}*/
	}
	
	function rules($uid, $review_id) {
		$this->db->where('id', $review_id);
		$getReviewPerDetails = $this->db->get('company_review');
		$getRowReview = $getReviewPerDetails->row();
		$reviewOverAllPayExp = $getRowReview->overall_pay_exp;
		//echo $review_id;echo ' '.$uid;
		$ruleStatus = $this->checkRuleStatus();
		$ruleBreakCount = 0;
		foreach($ruleStatus as $val)
		{
			/*if($ruleBreakCount > 0){
				break;
			}else{*/
				//echo $val->rules_no;
				switch ($val->rules_no){
					case 13:
						$rules= $val->rules_no.'@@@'.$val->rule_name;
						$numberOfReviewInDay = $this->totalReviewByUser($uid, 1);
						//print_r($numberOfReviewInDay['total_number']);echo "<br/>";print_r($val->change);die;
						if($numberOfReviewInDay['total_number'] > $val->change){
							
							$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);//Added on 11th Feb
							//$this->sendMail($uid, $rules);
							$ruleBreakCount++;
						}
						break;
					case 1:
						$rules = $val->rules_no.'@@@'.$val->rule_name;
						$totalReviews = $this->totalReviewByUser($uid, 0);
						$belowRatingReview = $this->totalBelowRatingReview($uid,$rules,$review_id);
						//print_r($totalReviews);echo "<br/>"; print_r($belowRatingReview);die;
						if($totalReviews['total_number'] > 2){
							
							$getPercentage = (( $belowRatingReview['total_number'] * 100 )/ $totalReviews['total_number']);
							//echo $getPercentage;die;
							if($getPercentage > 50){  // Notify user to give more positive review if badreview percentage greater than 50
								//echo $getPercentage;die;
								//$this->sendMail($uid, $rules);
								$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
								$notificationSendUser = $this->login_model->sendNotification(4,  0, $uid,'get_rules', $val->id, $review_id);
								$ruleBreakCount++;
							}
							
						}
						
						break;
					case '2a':
						$rules = $val->rules_no.'@@@'.$val->rule_name;
						$getBadReviewInOneMonth = $this->totalBelowRatingReview($uid, $rules, $review_id); // Notify user when more than one negative review posting in a month.
						
						if($getBadReviewInOneMonth['total_number'] > 1){
							//$this->sendMail($uid, $rules);
							$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
							$ruleBreakCount++;
						}
						break;
					case '2b':
						$rules= $val->rules_no.'@@@'.$val->rule_name;
						$getBadReviewInOneMonth = $this->totalPositiveRatingReview($uid, $rules, $review_id); // Notify user when more than one positive review posting in a month.
						
						if($getBadReviewInOneMonth['total_number'] > 2){
							//$this->sendMail($uid, $rules);
							$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
							$ruleBreakCount++;
						}
						break;
					case '3a':
						if($reviewOverAllPayExp < 3){
							$rules= $val->rules_no.'@@@'.$val->rule_name;
							$getBadReviewInOneMonth = $this->totalBelowRatingReview($uid, $rules, $review_id); // Notify user when more than one negative review posting in a month.
							//print_r($getBadReviewInOneMonth);echo "<br/>"; print_r($val->change);die;
							if($getBadReviewInOneMonth['total_number'] > $val->change){
								//$this->sendMail($uid, $rules);
								$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
								$ruleBreakCount++;
							}
						}
						break;
					case '3b':
						if($reviewOverAllPayExp > 3){
							$rules= $val->rules_no.'@@@'.$val->rule_name;
							$getBadReviewInOneMonth = $this->totalPositiveRatingReview($uid, $rules, $review_id); // Notify user when more than one negative review posting in a month.
							//print_r($getBadReviewInOneMonth);echo "<br/>"; print_r($val->change);die;
							if($getBadReviewInOneMonth['total_number'] > $val->change){
								//$this->sendMail($uid, $rules);
								$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
								$ruleBreakCount++;
							}
						}
						break;
					case '4a':
						if($reviewOverAllPayExp < 3) {
							$rules= $val->rules_no.'@@@'.$val->rule_name;
							$getBadReviewInOneMonth = $this->totalBelowRatingReview($uid, $rules, $review_id); // Notify user when more than one negative review posting in a month.
							
							if($getBadReviewInOneMonth['total_number'] > $val->change) {
								//$this->sendMail($uid, $rules);
								$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
								$ruleBreakCount++;
							}
						}
						break;
					case '4b':
						if($reviewOverAllPayExp > 3) {
							$rules= $val->rules_no.'@@@'.$val->rule_name;
							$getBadReviewInOneMonth = $this->totalPositiveRatingReview($uid, $rules, $review_id); // Notify user when more than one negative review posting in a month.
							
							if($getBadReviewInOneMonth['total_number'] > $val->change){
								//$this->sendMail($uid, $rules);
								$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
								$ruleBreakCount++;
							}
						}
						break;
					case '8a':
						if($reviewOverAllPayExp < 3){
							$rules= $val->rules_no.'@@@'.$val->rule_name;
							$getBadReviewInOneMonth = $this->totalBelowRatingReview($uid, $rules, $review_id); // Notify user when more than one negative review posting in a month.
							
							if($getBadReviewInOneMonth['total_number'] >= $val->change){
								//$this->sendMail($uid, $rules);
								$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
								$ruleBreakCount++;
							}
						}
						break;
					case '8b':
						
						if($reviewOverAllPayExp > 3){
							$rules= $val->rules_no.'@@@'.$val->rule_name;
							$getBadReviewInOneMonth = $this->totalPositiveRatingReview($uid, $rules, $review_id); // Notify user when more than one negative review posting in a month.
							//print_r($getBadReviewInOneMonth); echo '<br/>'; print_r($val->change);
							if($getBadReviewInOneMonth['total_number'] >= $val->change){
								//$this->sendMail($uid, $rules);
								$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
								$ruleBreakCount++;
							}
						}
						break;
					case 5:
						$rules= $val->rules_no.'@@@'.$val->rule_name;
						$checkClaimed = $this->thisClaimedUser($uid);
						//print_r($checkClaimed);
						if($checkClaimed['claim_count'] > 0) {
							$checkClaimedIndustry = $this->checkingIndustryType($review_id, $checkClaimed['claim_industries']);
							if($checkClaimedIndustry == 1) {
								//$this->sendMail($uid, $rules);
								$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
								$ruleBreakCount++;
							}
						}
						break;
					case 6:
						$rules= $val->rules_no.'@@@'.$val->rule_name;
						$annoCheck = $this->getReviewDetails($review_id);
						if($annoCheck->anno_review == 1){
							$annoReviewNumber = $this->checkAnnoReviewTime($uid, $annoCheck->company_id);
							if($annoReviewNumber > 1){
								//$this->sendMail($uid, $rules);
								$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
								$notificationSendUser = $this->login_model->sendNotification(4,  0, $uid,'get_rules', $val->id, $review_id);
								$ruleBreakCount++;
							}
						}
						break;
					case '12a':
						if($reviewOverAllPayExp < 3){
							$rules = $val->rules_no.'@@@'.$val->rule_name;
							$getUserWorkEmail = $this->getReviewerWorkEmail($uid);
							$getBelowReviewEmails = $this->totalBelowRatingReview($uid, $rules, $review_id);
							//echo "<pre>"; print_r($getBelowReviewEmails);die;
							$reviewerEmailId = explode('@', $getUserWorkEmail);
							$review12aCount = 0;
							$excludeEmailIds = array('gmail.com','yahoo.com','hotmail.com','Outlook.com','rediffmail.com','mail.com','Yandex.Mail','inbox.com','zoho.com','icloud.com');
							//print_r($getBelowReviewEmails['reviews']);
								foreach($getBelowReviewEmails['reviews'] as $email) {
									$emailId = explode('@', $email->email);
									
									if(($reviewerEmailId[1] == $emailId[1]) && (!in_array($reviewerEmailId[1], $excludeEmailIds))) {
										$review12aCount++;
									}
								}
								if($review12aCount > $val->change)
								{
									$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
									//$this->sendMail($uid, $rules);
									$ruleBreakCount++;
								}
						}
						
						break;
					case '12b':
						if($reviewOverAllPayExp > 3){
							$rules= $val->rules_no.'@@@'.$val->rule_name;
							$getUserWorkEmail = $this->getReviewerWorkEmail($uid);
							$getBelowReviewEmails = $this->totalPositiveRatingReview($uid, $rules, $review_id);
							$reviewerEmailId = explode('@', $getUserWorkEmail);
							$review12bCount = 0;
							$excludeEmailIds = array('gmail.com','yahoo.com','hotmail.com','Outlook.com','rediffmail.com','mail.com','Yandex.Mail','inbox.com','zoho.com','icloud.com');
								foreach($getBelowReviewEmails['reviews'] as $email) {
								
									$emailId = explode('@', $email->email);
									
									if(($reviewerEmailId[1] == $emailId[1]) && (!in_array($reviewerEmailId[1], $excludeEmailIds))) {
										$review12bCount++;
									}
								}
								if($review12bCount > $val->change)
								{
									$notificationSendAdmin = $this->login_model->sendNotification(4, $uid, 0,'get_rules', $val->id, $review_id);
									//$this->sendMail($uid, $rules);
									$ruleBreakCount++;
								}
						}
						break;
				}
			//}
		}
		
	}
	
	function getReviewerWorkEmail($uid){
		
		$this->db->select('email');
		$this->db->where('id', $uid);
		$result = $this->db->get('people');
		$workEmail = $result->row();
		
		return $workEmail->email;
	}
	
	function checkAnnoReviewTime($uid, $company_id){
		//$this->db->where("added_on BETWEEN NOW() - INTERVAL 90 DAY AND NOW()");    //Now time no bar for same compnay multiple times as annonymus.
		$this->db->where('company_id', $company_id);
		$this->db->where('added_by', $uid);
		$result = $this->db->get('company_review');
		
		$total_number = $result->num_rows;
		
		return $total_number;
	}
	
	function checkingIndustryType($review_id, $claimedIndustries){
		
		$reviewDetails = $this->getReviewDetails($review_id);
		$company_id = $reviewDetails->company_id;
		
		$this->db->select('industry_type');
		$this->db->where('id', $company_id);
		$result = $this->db->get('company_details');
		//echo $this->db->last_query();
		$industryType = $result->row();
		
		//print_r($claimedIndustries);echo "<br/>";print_r($industryType);
		if(in_array($industryType->industry_type,$claimedIndustries)){
			return 1;
		}else{
			return 0;
		}
	}
	
	function thisClaimedUser($uid){
		$claim_indus = array();
		$this->db->select('company_details.industry_type');
		$this->db->join('company_details', 'company_details.id = claim_owner.company_id');
		$this->db->where('claim_owner.claim_id', $uid);
		$this->db->where('claim_owner.status', 1);
		$this->db->group_by('company_details.industry_type');
		$result = $this->db->get('claim_owner');
		
		$data['claim_count'] = $result->num_rows;
		$resultValues = $result->result();
		//print_r($resultValues);
		foreach($resultValues as $val){
			
			array_push($claim_indus, $val->industry_type);
			//print_r($claim_indus);
		}
		
		$data['claim_industries'] = $claim_indus;
		
		return $data;
	}
	
	function getReviewDetails($review_id){
		//echo ' '.$review_id;
		$query_val = 'SELECT * FROM `company_review` WHERE `id` = '. $review_id;
		$CI =& get_instance();
		/*$CI->db->where('id',$review_id);
		$result = $CI->db->get('company_review');
		echo $CI->db->last_query();*/
		$result = $CI->db->query($query_val);
		return $result->row();
	}
	
	function totalReviewByUser($uid, $date){
		
		$this->db->where('company_review.added_by', $uid);
		if($date==1){
			$this->db->where('DATE(company_review.added_on)', 'CURDATE()');
		}
		$result = $this->db->get('company_review');
		
		
		$data['total_number'] = $result->num_rows;
		$data['reviews'] = $result->result();
		
		return $data;
	}
	
	function totalBelowRatingReview($uid, $rules,$review_id){
		//echo $review_id;die;
		$ruless = explode("@@@",$rules);
		$rules = $ruless[0];
		
		$getReviewDetails = $this->getReviewDetails($review_id);
		
		if($rules == "12a") {
			$this->db->select('people.email, company_review.*');
			$this->db->where('company_review.company_id', $getReviewDetails->company_id);
			$this->db->where("company_review.added_on BETWEEN NOW() - INTERVAL 30 DAY AND NOW()");
			$this->db->join('people', 'people.id = company_review.added_by');
		}
		$this->db->where('overall_pay_exp < ', '3');
		//echo $review_id;
		//print_r($getReviewDetails);die;
		if($rules == 1)
		{
			$this->db->where('added_by', $uid);
		}
		if($rules == "2a")
		{
			$this->db->where("added_on BETWEEN NOW() - INTERVAL 30 DAY AND NOW()");
			$this->db->where('ip_address', $getReviewDetails->ip_address);
			$this->db->where('company_id', $getReviewDetails->company_id);
		}
		if($rules == "3a")
		{
			$this->db->where('company_id', $getReviewDetails->company_id);
			$this->db->where("added_on BETWEEN NOW() - INTERVAL 1 DAY AND NOW()");
		}
		if($rules == "4a")
		{
			$this->db->where('company_id', $getReviewDetails->company_id);
			$this->db->where("added_on BETWEEN NOW() - INTERVAL 7 DAY AND NOW()");
		}
		if($rules == "8a")
		{
			$this->db->where('added_by', $uid);
			$this->db->where("added_on BETWEEN NOW() - INTERVAL 1 DAY AND NOW()");
			
		}
		
		$result = $this->db->get('company_review');
		//echo $this->db->last_query();
		$data['total_number'] = $result->num_rows;
		$data['reviews'] = $result->result();
		
		return $data;
		
	}
	
	function totalPositiveRatingReview($uid, $rules, $review_id){
		
		$ruless = explode("@@@",$rules);
		$rules = $ruless[0];
		
		$getReviewDetails = $this->getReviewDetails($review_id);
		
		if($rules == "12b") {
			$this->db->select('people.email, company_review.*');
			$this->db->where("company_review.added_on BETWEEN NOW() - INTERVAL 30 DAY AND NOW()");
			$this->db->where('company_review.company_id', $getReviewDetails->company_id);
			$this->db->join('people', 'people.id = company_review.added_by');
			
		}
		$this->db->where('overall_pay_exp > ', '3');
		
		if($rules == "2b")
		{
			$this->db->where("added_on BETWEEN NOW() - INTERVAL 30 DAY AND NOW()");
			$this->db->where('ip_address', $getReviewDetails->ip_address);
			$this->db->where('company_id', $getReviewDetails->company_id);
		}
		if($rules == "3b")
		{
			$this->db->where('company_id', $getReviewDetails->company_id);
			$this->db->where("added_on BETWEEN NOW() - INTERVAL 1 DAY AND NOW()");
		}
		if($rules == "4b")
		{
			$this->db->where('company_id', $getReviewDetails->company_id);
			$this->db->where("added_on BETWEEN NOW() - INTERVAL 7 DAY AND NOW()");
		}
		if($rules == "8b")
		{
			$this->db->where('added_by', $uid);
			$this->db->where("added_on BETWEEN NOW() - INTERVAL 1 DAY AND NOW()");
			
		}
		if($rules == 1)
		{
			$this->db->where('added_by', $uid);
		}
		$result = $this->db->get('company_review');
		
		$data['total_number'] = $result->num_rows;
		$data['reviews'] = $result->result();
		
		return $data;
		
	}
	function sendMail($uid, $rules)
	{
		/*$data_arr=array('id' => '22');
		$getMyEmail = $this->review_model->getDetailsByID('people','id',$uid);
		$rules = explode('@@@',$rules);
		$email = $getMyEmail[0]->email;
		$emailcontent=$this->login_model->email_tmp('email_template', $data_arr);
		$subject = $emailcontent[0]->email_title;
		$details = 'Rules ID ('.$rules[0].') - '.$rules[1];
		
		
		$body =$emailcontent[0]->email_desc;
		$logo = "<a href='".base_url()."'><img src='".base_url()."assets/images/logo-1.png' alt=''></a>";
		//$body=str_replace("[LINK]",$li,$body);
		$email_details = array("[BODY]","[LOGO]");
		$email_details_rplc = array($details,$logo);
		$body=str_replace($email_details,$email_details_rplc,$body);
		$this->MailSend($email,$subject,$body);
		
		$getAdminEmail = $this->review_model->getDetailsByID('site_settings','id',1);
		//$rules = explode('@@@',$rules);
		$email = $getAdminEmail[0]->admin_email;
		$emailcontent=$this->login_model->email_tmp('email_template', $data_arr);
		$subject = $emailcontent[0]->email_title;
		$details = 'Rules ID ('.$rules[0].') - '.$rules[1];
		
		
		$body =$emailcontent[0]->email_desc;
		$logo = "<a href='".base_url()."'><img src='".base_url()."assets/images/logo-1.png' alt=''></a>";
		//$body=str_replace("[LINK]",$li,$body);
		$email_details = array("[BODY]","[LOGO]");
		$email_details_rplc = array($details,$logo);
		$body=str_replace($email_details,$email_details_rplc,$body);
		$this->MailSend($email,$subject,$body);*/
	}
	function MailSend($email,$subject,$body)
	{
		require_once PHYSICAL_PATH_FRONT.'/smtpmail/PHPMailerAutoload.php';
		$mail = new PHPMailer;
		
		$mail->isSMTP();                                      	// Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  			// Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                              	// Enable SMTP authentication
		$mail->Username = 'saurav.dikshit@esolzmail.com';       // SMTP username
		$mail->Password = 'souravesolz123';                     // SMTP password
		$mail->SMTPSecure = 'tls';
		$mail->isHTML(true);                                  	// Set email format to HTML
		$mail->From = 'saurav.dikshit@esolzmail.com';
		$mail->FromName = 'Credit Monk';
		$mail->addAddress($email);     				// Add a recipient
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
	
}
?>