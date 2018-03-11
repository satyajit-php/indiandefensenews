<?php
class Left_panel_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
       
    }
    /**
    * Validate the login's data with the database
    * @param string $user_name
    * @param string $password
    * @return void
    */
    
    //==========fetch admin details===========//
    function get_admin()
    {
        $uid=$this->session->userdata('admin_uid');
        $this->db->from('admin');
        $this->db->where('id', $uid);
        $query = $this->db->get();
        if($query->num_rows > 0)
        {
            $val = $query->result();
            return $val;
        }
    }
    
    //==========fetch admin details by id===========//
    function get_admin_by_id($uid)
    {
        $this->db->from('admin');
        $this->db->where('id', $uid);
        $query = $this->db->get();
        if($query->num_rows > 0)
        {
            $val = $query->result();
            return $val;
        }
    }
    
    //==========fetch all parent navigations from article table===========//
    function get_nav_value()
    {
        $this->db->from('admin_management_list');
        $this->db->where('parent_menu', '0');
        $this->db->where('status', 'Y');
        $query = $this->db->get();
        if($query->num_rows > 0)
        {
            $val = $query->result();
            return $val;
        }
    }
    
    //==========fetch all child navigations from article table===========//
    function get_childnav_value($parent_menu)
    {
        $this->db->from('admin_management_list');
        $this->db->where('parent_menu', $parent_menu);
        $this->db->where('status', 'Y');
        $query = $this->db->get();
        if($query->num_rows > 0)
        {
            $val = $query->result();
            return $val;
        }
    }
    
    //==============send mail function=============================//
    function send_mail($email,$subject,$body)
   {
        require '/var/www/html/smtpmail/PHPMailerAutoload.php';
        $mail = new PHPMailer();
       
        $mail->IsSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup server
        $mail->SMTPAuth = true; // Enaele SMTP authentication
        $mail->Username = 'care@creditmonk.com'; // SMTP username
		$mail->Password = 'clrpqjkaumioosze'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted
        $mail->Port = 587; //Set the SMTP port number - 587 for authenticated TLS
        $mail->setFrom('care@creditmonk.com', 'Shraddha Ghogare'); //Set who the message is to be sent from
        //$mail->addReplyTo('labnol@gmail.com', 'First Last'); //Set an alternative reply-to address
        $mail->addAddress('care@creditmonk.com', 'Josh Adams'); // Add a recipient
      
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
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           $return=1;
           exit;
        }
        else
        {
           //echo 'Message has been sent';
           $return=0;
        }
        return $return;
  
   }
   
    function sendNotification($notification_type, $actor, $receiver, $event_table, $event_primary_id) {
            if($notification_type == 23){
                $this->db->select('first_name,email');
                $this->db->where('id', $receiver);
                $variable = $this->db->get('people');
                if($variable->num_rows > 0) {
                        $nameResult = $variable->row();
                        $firstName = $nameResult->first_name;
                        $user_email=$nameResult->email;
                }
                $this->db->select('company_name');
                $this->db->where('id', $event_primary_id);
                $qq = $this->db->get($event_table);
                if($qq->num_rows > 0){
                    $resQQ = $qq->row();
                    $companyName = $resQQ->company_name;
                }
                
                $this->db->where('id', $notification_type);
                $result = $this->db->get('notification_type');
                if($result->num_rows > 0) {
                        $resultValue = $result->row();
                        $purpose = $resultValue->user_message;
                        $content = $resultValue->user_content;
                        $replace = array("[username]","[COMPANY_NAME]");
                        $replaceBy = array($firstName, $companyName);
                        $content = str_replace($replace, $replaceBy, $content);
                }
            }else if($notification_type == 17){
			
                    $this->db->where('id', $event_primary_id);
                    $res = $this->db->get($event_table);
                    if($res->num_rows > 0){
                            $valueCompany = $res->row();
                            
                            $this->db->select('company_name');
                            $this->db->where('id', $valueCompany->company_id);
                            $qq = $this->db->get('company_details');
                            if($qq->num_rows > 0){
                                    $resQQ = $qq->row();
                                    $companyName = $resQQ->company_name;
                            }
                    }
                    
                    $this->db->where('id', $notification_type);
                    $result = $this->db->get('notification_type');
                    if($result->num_rows > 0) {
                            $resultValue = $result->row();
                            $purpose = $resultValue->user_message;
                            $content = $resultValue->user_content;
                            $replace = array("[COMPANY_NAME]");
                            $replaceBy = array($companyName);
                            $content = str_replace($replace, $replaceBy, $content);
                    }
            }else if($notification_type == 13){
			
                    $this->db->where('id', $event_primary_id);
                    $res = $this->db->get($event_table);
                    if($res->num_rows > 0){
                            $valueCompany = $res->row();
                            
                            $this->db->select('company_name');
                            $this->db->where('id', $valueCompany->company_id);
                            $qq = $this->db->get('company_details');
                            $resQQ = $qq->row();
                            $companyName = $resQQ->company_name;
                            
                            $this->db->select('first_name,last_name');
                            $this->db->where('id', $valueCompany->added_by);
                            $qq = $this->db->get('people');
                            $resQQ = $qq->row();
                            $PeopleName = $resQQ->first_name.' '.$resQQ->last_name;
                    }
                    
                    $this->db->where('id', $notification_type);
                    $result = $this->db->get('notification_type');
                    if($result->num_rows > 0) {
                            $resultValue = $result->row();
                            $purpose = $resultValue->user_message;
                            $content = $resultValue->user_content;
                            $replace = array("[COMPANY_NAME]","[USERNAME]","[REVIEW]");
                            $replaceBy = array($companyName,$PeopleName,$valueCompany->review_title);
                            $content = str_replace($replace, $replaceBy, $content);
                            $purpose = str_replace($replace, $replaceBy, $purpose);
                    }
            }
                    else if($notification_type == 34){
                    $this->db->select('company_name');
                    $this->db->where('id', $event_primary_id);
                    $qq = $this->db->get($event_table);
                    if($qq->num_rows > 0){
                        $resQQ = $qq->row();
                        $companyName = $resQQ->company_name;
                    }
                    $this->db->where('id', $notification_type);
                    $result = $this->db->get('notification_type');
                    if($result->num_rows > 0) {
                        $resultValue = $result->row();
                        //$CompanyNameLink = '<a href="'.base_url().'rating/index/'.$getdetailsReview->company_id.'/'.$getdetailsCompany->company_name.'">'.$getdetailsCompany->company_name.'</a>';
                        $purpose = $resultValue->user_message;
                        $content = $resultValue->user_content;
                        $replace = array("[COMPANY_NAME]");
                        $replaceBy = array($companyName);
                        $content = str_replace($replace, $replaceBy, $content);
                        $purpose = str_replace($replace, $replaceBy, $purpose);
                    }
                }
                else if($notification_type == 35){
                    $this->db->select('company_name');
                    $this->db->where('id', $event_primary_id);
                    $qq = $this->db->get($event_table);
                    if($qq->num_rows > 0){
                        $resQQ = $qq->row();
                        $companyName = $resQQ->company_name;
                    }
                    $this->db->where('id', $notification_type);
                    $result = $this->db->get('notification_type');
                    if($result->num_rows > 0) {
                        $resultValue = $result->row();
                        //$CompanyNameLink = '<a href="'.base_url().'rating/index/'.$getdetailsReview->company_id.'/'.$getdetailsCompany->company_name.'">'.$getdetailsCompany->company_name.'</a>';
                        $purpose = $resultValue->user_message;
                        $content = $resultValue->user_content;
                        $replace = array("[COMPANY_NAME]");
                        $replaceBy = array($companyName);
                        $content = str_replace($replace, $replaceBy, $content);
                        $purpose = str_replace($replace, $replaceBy, $purpose);
                    }
                }
            else if($notification_type == 25){
			
                    $this->db->where('id', $event_primary_id);
                    $res = $this->db->get($event_table);
                    if($res->num_rows > 0){
                            $valueCompany = $res->row();
                            
                            $this->db->select('company_name');
                            $this->db->where('id', $valueCompany->company_id);
                            $qq = $this->db->get('company_details');
                            if($qq->num_rows > 0){
                                    $resQQ = $qq->row();
                                    $companyName = $resQQ->company_name;
                            }
                    }
                    
                    $this->db->where('id', $notification_type);
                    $result = $this->db->get('notification_type');
                    if($result->num_rows > 0) {
                            $resultValue = $result->row();
                            $purpose = $resultValue->user_message;
                            $content = $resultValue->user_content;
                            $replace = array("[COMPANY_NAME]");
                            $replaceBy = array($companyName);
                            $content = str_replace($replace, $replaceBy, $content);
                    }
            }
            else if($notification_type == 31){
			$this->db->select('company_name');
			$this->db->where('id', $event_primary_id);
			$qq = $this->db->get($event_table);
			if($qq->num_rows > 0){
			    $resQQ = $qq->row();
			    $companyName = $resQQ->company_name;
			}
			$this->db->where('id', $notification_type);
			$result = $this->db->get('notification_type');
			if($result->num_rows > 0) {
				$resultValue = $result->row();
				$purpose = $resultValue->user_message;
				$content = $resultValue->user_content;
				$replace = array("[COMPANY_NAME]");
				$replaceBy = array($companyName);
				$content = str_replace($replace, $replaceBy, $content);
				$purpose = str_replace($replace, $replaceBy, $purpose);
			}
		}
		else if($notification_type == 32){
			$this->db->select('company_name');
			$this->db->where('id', $event_primary_id);
			$qq = $this->db->get($event_table);
			if($qq->num_rows > 0){
			    $resQQ = $qq->row();
			    $companyName = $resQQ->company_name;
			}
			$this->db->where('id', $notification_type);
			$result = $this->db->get('notification_type');
			if($result->num_rows > 0) {
				$resultValue = $result->row();
				//$CompanyNameLink = '<a href="'.base_url().'rating/index/'.$getdetailsReview->company_id.'/'.$getdetailsCompany->company_name.'">'.$getdetailsCompany->company_name.'</a>';
				$purpose = $resultValue->user_message;
				$content = $resultValue->user_content;
				$replace = array("[COMPANY_NAME]");
				$replaceBy = array($companyName);
				$content = str_replace($replace, $replaceBy, $content);
				$purpose = str_replace($replace, $replaceBy, $purpose);
			}
        }
            else if($notification_type == 3){
                $this->db->select('company_name');
                $this->db->where('id', $event_primary_id);
                $qq = $this->db->get($event_table);
                if($qq->num_rows > 0){
                    $resQQ = $qq->row();
                    $companyName = $resQQ->company_name;
                }
                $this->db->where('id', $notification_type);
                $result = $this->db->get('notification_type');
                if($result->num_rows > 0) {
                        $resultValue = $result->row();
                        $purpose = $resultValue->user_message;
                        $content = $resultValue->user_content;
                        $replace = array("[COMPANY_NAME]");
                        $replaceBy = array($companyName);
                        $content = str_replace($replace, $replaceBy, $content);
                }
            }else if($notification_type == 26){
                    $this->db->where('id', $event_primary_id);
                    $res = $this->db->get($event_table);
                    if($res->num_rows > 0){
                            $valueCompany = $res->row();
                            
                            $this->db->select('first_name,last_name');
                            $this->db->where('id', $valueCompany->added_by);
                            $qq = $this->db->get('people');
                            if($qq->num_rows > 0){
                                    $resQQ = $qq->row();
                                    $fullName = $resQQ->first_name.' '.last_name;
                            }
                    }
                    //echo $fullName;die;
                    $this->db->where('id', $notification_type);
                    $result = $this->db->get('notification_type');
                    if($result->num_rows > 0) {
                            $resultValue = $result->row();
                            $purpose = $resultValue->user_message;
                            $content = $resultValue->user_content;
                            $replace = array("[username]","[REVIEW_NAME]");
                            $replaceBy = array($fullName,$valueCompany->review_title);
                            $content = str_replace($replace, $replaceBy, $content);
                    }
            }else if($notification_type == 28){
                    $this->db->where('id', $event_primary_id);
                    $res = $this->db->get($event_table);
                    if($res->num_rows > 0){
                            $valueCompany = $res->row();
                            
                            $this->db->select('first_name,last_name');
                            $this->db->where('id', $valueCompany->added_by);
                            $qq = $this->db->get('people');
                            if($qq->num_rows > 0){
                                    $resQQ = $qq->row();
                                    $fullName = $resQQ->first_name.' '.last_name;
                            }
                    }
                    
                    $this->db->where('id', $notification_type);
                    $result = $this->db->get('notification_type');
                    if($result->num_rows > 0) {
                            $resultValue = $result->row();
                            $purpose = $resultValue->user_message;
                            $content = $resultValue->user_content;
                            $replace = array("[username]","[REVIEW_NAME]");
                            $replaceBy = array($fullName,$valueCompany->review_title);
                            $content = str_replace($replace, $replaceBy, $content);
                    }
            }
            else if($notification_type == 27){
                    $this->db->where('id', $event_primary_id);
                    $res = $this->db->get($event_table);
                    if($res->num_rows > 0){
                            $valueCompany = $res->row();
                            
                            $this->db->select('company_name');
                            $this->db->where('id', $valueCompany->company_id);
                            $qq = $this->db->get('company_details');
                            if($qq->num_rows > 0){
                                    $resQQ = $qq->row();
                                    $companyName = $resQQ->company_name;
                            }
                            
                            $this->db->select('first_name,last_name');
                            $this->db->where('id', $valueCompany->added_by);
                            $qq = $this->db->get('people');
                            if($qq->num_rows > 0){
                                    $resQQ = $qq->row();
                                    $fullName = $resQQ->first_name.' '.last_name;
                            }
                    }
                    
                    $this->db->where('id', $notification_type);
                    $result = $this->db->get('notification_type');
                    if($result->num_rows > 0) {
                            $resultValue = $result->row();
                            $purpose = $resultValue->user_message;
                            $content = $resultValue->user_content;
                            $replace = array("[username],[company_name]");
                            $replaceBy = array($fullName,$companyName);
                            $content = str_replace($replace, $replaceBy, $content);
                    }
            }else if($notification_type == 4){
                    
                    if($receiver == 0){
                            $this->db->select('first_name');
                            $this->db->where('id', $actor);
                            $variable = $this->db->get('people');
                            if($variable->num_rows > 0){
                                    $nameResult = $variable->row();
                                    $firstName = $nameResult->first_name;
                            }
                            
                            $this->db->where('id', $event_primary_id);
                            $result = $this->db->get($event_table);
                            if($result->num_rows > 0) {
                                    $resultValue = $result->row();
                                    $purpose = $resultValue->admin_subject;
                                    $content = $resultValue->admin_message;
                                    $replace = array("[username]");
                                    $replaceBy = array($firstName);
                                    $content = str_replace($replace, $replaceBy, $content);
                            }
                    }else{
                            $this->db->select('first_name');
                            $this->db->where('id', $receiver);
                            $variable = $this->db->get('people');
                            if($variable->num_rows > 0){
                                    $nameResult = $variable->row();
                                    $firstName = $nameResult->first_name;
                            }
                            
                            $this->db->where('id', $event_primary_id);
                            $result = $this->db->get($event_table);
                            if($result->num_rows > 0) {
                                    $resultValue = $result->row();
                                    $purpose = $resultValue->system_subject;
                                    $content = $resultValue->system_message;
                                    $replace = array("[username]");
                                    $replaceBy = array($firstName);
                                    $content = str_replace($replace, $replaceBy, $content);
                            }
                    }
            }else{
                    $this->db->where('id', $notification_type);
                    $result = $this->db->get('notification_type');
                    
                    if($result->num_rows > 0){
                            $notificationResult = $result->row();
                            if($receiver == 0){
                                    $purpose = $notificationResult->admin_message;
                                    $content = $notificationResult->admin_content;
                                    $returnDetails['admin_email_temp_id'] = $notificationResult->email_temp_id_admin;
                                    $returnDetails['user_email_temp_id'] = $notificationResult->email_temp_id_user;
                            }else{
                                    $purpose = $notificationResult->user_message;
                                    $content = $notificationResult->user_content;
                                    $returnDetails['admin_email_temp_id'] = $notificationResult->email_temp_id_admin;
                                    $returnDetails['user_email_temp_id'] = $notificationResult->email_temp_id_user;
                            }
                    }
            }
            
            $this->db->select('token_number');
            $this->db->order_by('id', 'desc');
            $this->db->limit(1);
            $result_array = $this->db->get('email_recieve');
            if($result_array->num_rows > 0){
                    $result_token = $result_array->row();
                    $token_number = ($result_token->token_number + 1);
            }else{
                    $token_number = 1;
            }
            $data = array(
                            'notification_type' => $notification_type,
                            'reciever' => $receiver,
                            'sender' => $actor,
                            'purpose' => $purpose,
                            'content' => $content,
                            'event_table' => $event_table,
                            'event_primary_id' => $event_primary_id,
                            'token_number' => $token_number
                    );
            
            $this->db->insert('email_recieve', $data);
            $lastInsertID = $this->db->insert_id();
            $returnDetails['last_id'] = $lastInsertID;
            
            return $returnDetails;
    }
    /*function sendNotification($notification_type, $actor, $receiver, $event_table, $event_primary_id) {
		
		$this->db->where('id', $notification_type);
		$result = $this->db->get('notification_type');
		
		if($result->num_rows > 0){
			$notificationResult = $result->row();
			if($receiver == 0){
				$purpose = $notificationResult->admin_message;
				$content = $notificationResult->admin_content;
				$returnDetails['admin_email_temp_id'] = $notificationResult->email_temp_id_admin;
				$returnDetails['user_email_temp_id'] = $notificationResult->email_temp_id_user;
			}else{
				$purpose = $notificationResult->user_message;
				$content = $notificationResult->user_content;
				$returnDetails['admin_email_temp_id'] = $notificationResult->email_temp_id_admin;
				$returnDetails['user_email_temp_id'] = $notificationResult->email_temp_id_user;
			}
		}
		$this->db->select('token_number');
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$result_array = $this->db->get('email_recieve');
		if($result_array->num_rows > 0){
			$result_token = $result_array->row();
			$token_number = ($result_token->token_number + 1);
		}else{
			$token_number = 1;
		}
		$data = array(
				'notification_type' => $notification_type,
				'reciever' => $receiver,
				'sender' => $actor,
				'purpose' => $purpose,
				'content' => $content,
				'event_table' => $event_table,
				'event_primary_id' => $event_primary_id,
				'token_number' => $token_number
			);
		
		$this->db->insert('email_recieve', $data);
		$lastInsertID = $this->db->insert_id();
		$returnDetails['last_id'] = $lastInsertID;
		
		return $returnDetails;
    }*/
	
   	function sendNotificationForSendingMassage($notification_type, $actor, $receiver,$massageSubject,$massageBody) {
		
		$this->db->where('id', $notification_type);
		$result = $this->db->get('notification_type');
		
		if($result->num_rows > 0){
			$notificationResult = $result->row();
			if($receiver == 0){
               
                $purpose = $massageSubject;
                $content = $massageBody;
				$returnDetails['admin_email_temp_id'] = $notificationResult->email_temp_id_admin;
				$returnDetails['user_email_temp_id'] = $notificationResult->email_temp_id_user;
			}else{
				//$purpose = $notificationResult->user_message;
				//$content = $notificationResult->user_content;
                $purpose = $massageSubject;
                $content = $massageBody;
				$returnDetails['admin_email_temp_id'] = $notificationResult->email_temp_id_admin;
				$returnDetails['user_email_temp_id'] = $notificationResult->email_temp_id_user;
			}
		}
		$this->db->select('token_number');
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$result_array = $this->db->get('email_recieve');
		if($result_array->num_rows > 0){
			$result_token = $result_array->row();
			$token_number = ($result_token->token_number + 1);
		}else{
			$token_number = 1;
		}
		$data = array(
				'notification_type' => $notification_type,
				'reciever' => $receiver,
				'sender' => $actor,
				'purpose' => $purpose,
				'content' => $content,
				'token_number' => $token_number
			);
		
		$this->db->insert('email_recieve', $data);
		$lastInsertID = $this->db->insert_id();
		$returnDetails['last_id'] = $lastInsertID;
		
		return $returnDetails;
	}
    function site_list($table, $field1, $field2, $field3)            //getting details from site_settings table
	{
		$this->db->select("$field1,$field2,$field3");
		$query = $this->db->get($table);
		
		return $result = $query->row();
	}
    function emailTemp($table, $data)
	{
		$this->db->where('id',$data['id']);
		$this->db->where('status','Y');
		$query = $this->db->get($table);
		return $result=$query->result();
	}
}
?>