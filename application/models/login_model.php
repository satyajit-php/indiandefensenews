<?php
class Login_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	function get_password($table, $data)
	{
	     
		$this->db->where('email',$data['email']);
		$query = $this->db->get($table);
		$result=$query->result();
		return $this->encrypt->decode($result[0]->password);
		
	}
	function get_sidepanel($id,$table)      // fetch all the side panels data from people table
	{
		$this->db->select("*");
		$this->db->from($table);
		$this->db->join('location', "location.location_id = $table.country_id",'left');
	        $this->db->where("$table.id",$id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result = $query->result();	
		
	}
	function email_tmp($table, $data)
	{
		$this->db->where('id',$data['id']);
		//$this->db->where('status',1);
		$this->db->where('status','Y');
		$query = $this->db->get($table);
		return $result=$query->result();
	}
	
	function mailstatus($table, $data)
	{
		$this->db->where('email',$data['email']);
		$query = $this->db->get($table);
		
		if($query->num_rows == 1)
		{
			$result=$query->result();
			if($result[0]->login_type==0)
			{
				if($result[0]->status==1)
				{
					return 1;
				}else if($result[0]->status == 4){
					return 4;
				}
				else{
					return 0;
				}
			}
			else{
				return 3;
			}
		    
		      
		}
		else{
			return 2;
		}
	}
	function login_admin($table, $data)
	{
		$this->db->where('email', $data['email']);
		$this->db->where('login_type', '0');
		$query = $this->db->get($table);
		
		if($query->num_rows == 1)
		{
			$val=$query->result();
			
			if($val[0]->status==1)
			{
				if($data['password']==$this->encrypt->decode($val[0]->password))
				{
					$uid=$val[0]->id;
					$data = array(
						'last_logged_in' => date('Y-m-d H:i:s')
					);
					
					$this->db->where('id', $uid);
					$this->db->update('people', $data);
						
					if($val[0]->first_name == '' && $val[0]->last_name == '') {
						$name = explode('@',$val[0]->email)[0];
					}else {
						$name = $val[0]->first_name.' '. $val[0]->last_name;  
					}
						
					$data = array(
						'uid' => $uid,
						'is_logged_in' => true,
						'name'=>$name,
						'profile_pic'=>$val[0]->profile_pic
					);	
					$session_login = $this->session->set_userdata($data);
					return "sucess";
				}else{
					return 'wrong_password';
				}
			}
			else if($val[0]->status == 3) {
			   return "adminblock";	
			}
			else if($val[0]->status == 4) {
				if($data['password']==$this->encrypt->decode($val[0]->password)) {
					$uid=$val[0]->id;
					$data = array(
						'last_logged_in' => date('Y-m-d H:i:s')
					);
					
					$this->db->where('id', $uid);
					$this->db->update('people', $data);
						
					if($val[0]->first_name == '' && $val[0]->last_name == '')
					{
						$name = explode('@',$val[0]->email)[0];
					}else{
						$name = $val[0]->first_name.' '. $val[0]->last_name;  
					}
						
					$data = array(
						'tried_uid' => $uid,
						'attempt_relogin' => 'user_block'
					);	
					$session_login = $this->session->set_flashdata($data);
					return "attempt_relogin";
				}else {
					return 'block_relogin_wrong_pass';
				}
			}
			else {
			     return "block";		
			}
		}
		else {
			return 'un_registered';
		}
	}
	
	function email_chk_admin($table, $data)
	{
		$this->db->where('email', $data['email']);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		//die();
		$result = $query->result();
		$id=base64_encode($result[0]->id);
		
		//print_r(($result[0]->id));die();
		
		$url_id = rtrim($id, '=');
		if($query->num_rows > 0)
		{
			$email = $data['email'];
			
			$link = site_url()."/login_cont/reset_password/$url_id";
			$subject = "Retrive Your Password";
			$body = "For reset password please click on this link..".$link;
			$mail = $this->left_panel_model->send_mail($email,$subject,$body);
			return true;
			
		}
		else
		{
			return false;
		}
		
	}
	
	function update_password($table,$data, $newid)
	{
	    $this->db->from($table);
	    $this->db->where('id', $newid);
            $query = $this->db->get();
	    
		//echo $this->db->last_query();
		//die();
	    
	    $reset_password1 = $query->result();
	    $email =$reset_password1[0]->email;
	    //echo $email;
	    //die();
            if($query->num_rows == 0 || $reset_password1[0]->id == $newid)
            {
                $this->db->where('id', $newid);
		$updt = $this->db->update($table, $data);
		//echo $this->db->last_query();
		//die();
                if($updt)
                {
		    $pass = $data['password'];
		    $link = base_url();
		    $subject = "Password has been reset";
		    $body = "Your password has been reset. Here is your new password:<br><br>Please click on the following link to go to the site and use the new password for login:<br><br>".$link;
                    $mail = $this->left_panel_model->send_mail($email,$subject,$body);
                    return true;
                }
		else
		{
			return false;
		}
            }
            
	}
	function get_admin()
	{
		$this->db->where('id',1);
		$query=$this->db->get('admin_contact_details');
		$result=$query->result();
		return $result;
		
	}
	
	function selectcompany()    // select company
	{
		$this->db->where('status',1);
		$query=$this->db->get('company_type');
		if($query->num_rows > 0)
		{
		$result=$query->result();
		
		return $result;
		}
		else
		return false;
		
	}
	
   function selectindustry()    // select industry
	{
		$this->db->where('pstatus',1);
		$query=$this->db->get('industry_type');
		if($query->num_rows > 0)
		{
		$result=$query->result();
		return $result;
		}
		else
		return false;
		
		
	}
	function allcitylist($id)    // select all city list
	{
		$this->db->select('*');
		$this->db->where('location_type',2);
		$this->db->where('parent_id',$id);
		$query=$this->db->get('location');
		if($query->num_rows > 0)
		{
		$result=$query->result();
		return $result;
		}
		else
		return false;
		
		
	}
	function allstatelist()    // select industry
	{
		$this->db->select('*');
		$this->db->where('location_type',1);
		$this->db->where('parent_id',100);
		$query=$this->db->get('location');
		if($query->num_rows > 0)
		{
		$result=$query->result();
		return $result;
		}
		else
		return false;
		
		
	}
	
	function site_list($table, $field1, $field2, $field3)            //getting details from site_settings table
	{
		$this->db->select("$field1,$field2,$field3");
		$query = $this->db->get($table);
		
		return $result = $query->row();
	}
    
	function company_claimd($uid,$companyid)     // check this company
	{
		if($uid)
		{
			$this->db->where('claim_id',$uid);
			$this->db->where('company_id',$companyid);
			$this->db->where('status',1);
			$query = $this->db->get('claim_owner');
			//echo $this->db->last_query();
			//echo $query->num_rows;
			if($query->num_rows > 0)
			{
				return 1;
			}
			else
			return 0;
		}
		else
		return 2;
	}
    
    function getallbadges()     // get all my badges details from badge table
	{
		$this->db->select('*');
		$this->db->where("status",1);
		$query=$this->db->get('badge_details');
		if($query->num_rows>0)
		{
			 return $result=$query->result();	
		}
	}
	
	function getmy_score($uid)         // get my badge score
	{
	    $this->db->select('*');
	    $this->db->where("added_by",$uid);
	    $query=$this->db->get('company_review');
	    if($query->num_rows>0)
	    {
		 if($query->num_rows>100 || $query->num_rows==100)    // this special checking for the monk reviewere
		 {
			$this->db->select('*');
			$this->db->where("added_by",$uid);
			$this->db->where("flag",0);
			$query=$this->db->get('company_review');
			return $query->num_rows;
		 }
		 else{
		     return $query->num_rows;	
		 }
		
	    }
	    else
	     return 0;
	}
	
	function showreviewname($num)  // show reviewer tag
	{
		  $this->db->select('name');
		  $this->db->where('review_count <',$num);
		  $this->db->or_where('review_count',$num);
		  $query = $this->db->get('badge_details',1,0);
		  if($query->num_rows >0)
			{
				return $query->result();	
			}
		
	}
	
	function sendNotification($notification_type, $actor, $receiver, $event_table, $event_primary_id, $review_id=0) {
		if($notification_type == 23){
			$this->db->select('first_name');
			$this->db->where('id', $receiver);
			$variable = $this->db->get('people');
			if($variable->num_rows > 0) {
				$nameResult = $variable->row();
				$firstName = $nameResult->first_name;
				
			}
			$this->db->select('company_name,id');
			$this->db->where('id', $event_primary_id);
			$qq = $this->db->get($event_table);
			if($qq->num_rows > 0){
				$resQQ = $qq->row();
				$companyName = $resQQ->company_name;
				//$companyName = '<a href="'.base_url().'rating/index/'.$resQQ->id.'/'.$resQQ->company_name.'">'.$resQQ->company_name.'</a>';
				
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
				$purpose = str_replace($replace, $replaceBy, $purpose);
			}
		}else if($notification_type == 25){
			
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
		}else if($notification_type == 3){
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
		}else if($notification_type == 5){
			$this->db->select('company_id');
			$this->db->where('id', $event_primary_id);
			$qq = $this->db->get($event_table);
			    $resQQ = $qq->row();
			    $companyId = $resQQ->company_id;
			
			$this->db->select('company_name,id');
			$this->db->where('id', $companyId);
			$resultAll = $this->db->get('company_details');
			
			
				$resultAllValue = $resultAll->row();
				//$companyName = $resultAllValue->company_name;
				$companyName = '<a href="'.base_url().'rating/index/'.$resultAllValue->id.'/'.$resultAllValue->company_name.'">'.$resultAllValue->company_name.'</a>';
				$this->db->where('id', $notification_type);
				$result = $this->db->get('notification_type');
				$resultValue = $result->row();
				$purpose = $resultValue->user_message;
				$content = $resultValue->user_content;
				$replace = array("[COMPANY_NAME]");
				$replaceBy = array($companyName);
				$content = str_replace($replace, $replaceBy, $content);
				$purpose = str_replace($replace, $replaceBy, $purpose);
			
			
		}else if($notification_type == 16){
			
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
			else if($notification_type == 7){
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
                            $this->db->where('id', $valueCompany->claim_id);
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
                            $replace = array("[COMPANY_NAME]","[USERNAME]");
                            $replaceBy = array($companyName,$PeopleName);
							$content = str_replace($replace, $replaceBy, $content);
                            $purpose = str_replace($replace, $replaceBy, $purpose);
                    }
            }
			else if($notification_type == 19){
			
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
		else if($notification_type == 6){
			$this->db->select('company_id');
			$this->db->where('id', $event_primary_id);
			$qq = $this->db->get($event_table);
			    $resQQ = $qq->row();
			    $companyId = $resQQ->company_id;
			
			$this->db->select('company_name');
			$this->db->where('id', $companyId);
			$resultAll = $this->db->get('company_details');
			
			
				$resultAllValue = $resultAll->row();
				$companyName = $resultAllValue->company_name;
				$this->db->where('id', $notification_type);
				$result = $this->db->get('notification_type');
				$resultValue = $result->row();
				$purpose = $resultValue->user_message;
				$content = $resultValue->user_content;
				$replace = array("[COMPANY_NAME]");
				$replaceBy = array($companyName);
				$content = str_replace($replace, $replaceBy, $content);
				$purpose = str_replace($replace, $replaceBy, $purpose);
			
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
		else if($notification_type == 10){
			$this->db->select('name');
			$this->db->where('id', $event_primary_id);
			$qq = $this->db->get($event_table);
			if($qq->num_rows > 0){
			    $resQQ = $qq->row();
			    $BadgeName = $resQQ->name;
			}
			$this->db->where('id', $notification_type);
			$result = $this->db->get('notification_type');
			if($result->num_rows > 0) {
				$resultValue = $result->row();
				$purpose = $resultValue->user_message;
				$content = $resultValue->user_content;
				$replace = array("[BADGE]");
				$replaceBy = array($BadgeName);
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
		}else if($notification_type == 36){
			    $ReviewID = $event_primary_id;
				$this->db->select('review_title,company_id');
				$this->db->where('id',$ReviewID);
				$getdetailsReview = $this->db->get('company_review');
				$getdetailsReview = $getdetailsReview->row();
				
				$this->db->select('company_name');
				$this->db->where('id',$getdetailsReview->company_id);
				$getdetailsCompany = $this->db->get('company_details');
				$getdetailsCompany = $getdetailsCompany->row();
				$ReviewNameLink = '<a href="'.base_url().'review/review_details/'.$getdetailsReview->company_id.'?detailID='.$ReviewID.'">'.$getdetailsReview->review_title.'</a>';
				$CompanyNameLink = '<a href="'.base_url().'rating/index/'.$getdetailsReview->company_id.'/'.$getdetailsCompany->company_name.'">'.$getdetailsCompany->company_name.'</a>';
				
			
			$this->db->where('id', $notification_type);
			$result = $this->db->get('notification_type');
			if($result->num_rows > 0) {
				$resultValue = $result->row();
				$purpose = $resultValue->user_message;
				$content = $resultValue->user_content;
				$replace = array("[REVIEW]","[COMPANY_NAME]");
				$replaceBy = array($ReviewNameLink,$CompanyNameLink);
				$content = str_replace($replace, $replaceBy, $content);
				$purpose = str_replace($replace, $replaceBy, $purpose);
			}
		}
		else if($notification_type == 30){
			    $ReviewID = $event_primary_id;
				$this->db->select('review_title,company_id');
				$this->db->where('id',$ReviewID);
				$getdetailsReview = $this->db->get('company_review');
				$getdetailsReview = $getdetailsReview->row();
				
				$this->db->select('company_name');
				$this->db->where('id',$getdetailsReview->company_id);
				$getdetailsCompany = $this->db->get('company_details');
				$getdetailsCompany = $getdetailsCompany->row();
				$ReviewNameLink = '<a href="'.base_url().'review/review_details/'.$getdetailsReview->company_id.'?detailID='.$ReviewID.'">'.$getdetailsReview->review_title.'</a>';
				$CompanyNameLink = '<a href="'.base_url().'rating/index/'.$getdetailsReview->company_id.'/'.$getdetailsCompany->company_name.'">'.$getdetailsCompany->company_name.'</a>';
				
			
			$this->db->where('id', $notification_type);
			$result = $this->db->get('notification_type');
			if($result->num_rows > 0) {
				$resultValue = $result->row();
				$purpose = $resultValue->user_message;
				$content = $resultValue->user_content;
				$replace = array("[REVIEW]","[COMPANY_NAME]");
				$replaceBy = array($ReviewNameLink,$CompanyNameLink);
				$content = str_replace($replace, $replaceBy, $content);
				$purpose = str_replace($replace, $replaceBy, $purpose);
			}
		}else if($notification_type == 33){
			    $ReviewID = $event_primary_id;
				$this->db->select('review_title,company_id');
				$this->db->where('id',$ReviewID);
				$getdetailsReview = $this->db->get('company_review');
				$getdetailsReview = $getdetailsReview->row();
				
				$this->db->select('company_name');
				$this->db->where('id',$getdetailsReview->company_id);
				$getdetailsCompany = $this->db->get('company_details');
				$getdetailsCompany = $getdetailsCompany->row();
				$ReviewNameLink = '<a href="'.base_url().'review/review_details/'.$getdetailsReview->company_id.'?detailID='.$ReviewID.'">'.$getdetailsReview->review_title.'</a>';
				$CompanyNameLink = '<a href="'.base_url().'rating/index/'.$getdetailsReview->company_id.'/'.$getdetailsCompany->company_name.'">'.$getdetailsCompany->company_name.'</a>';
				
			
			$this->db->where('id', $notification_type);
			$result = $this->db->get('notification_type');
			if($result->num_rows > 0) {
				$resultValue = $result->row();
				$purpose = $resultValue->user_message;
				$content = $resultValue->user_content;
				$replace = array("[REVIEW]","[COMPANY_NAME]");
				$replaceBy = array($ReviewNameLink,$CompanyNameLink);
				$content = str_replace($replace, $replaceBy, $content);
				$purpose = str_replace($replace, $replaceBy, $purpose);
			}
		}
		else if($notification_type == 8){
			$this->db->select('review_id');
			$this->db->where('id', $event_primary_id);
			$qq = $this->db->get($event_table);
			if($qq->num_rows > 0){
			    $resQQ = $qq->row();
			    $ReviewID = $resQQ->review_id;
				
				$this->db->select('review_title,company_id');
				$this->db->where('id',$ReviewID);
				$getdetailsReview = $this->db->get('company_review');
				$getdetailsReview = $getdetailsReview->row();
				
				$this->db->select('company_name');
				$this->db->where('id',$getdetailsReview->company_id);
				$getdetailsCompany = $this->db->get('company_details');
				$getdetailsCompany = $getdetailsCompany->row();
				$ReviewNameLink = '<a href="'.base_url().'review/review_details/'.$getdetailsReview->company_id.'?detailID='.$ReviewID.'">'.$getdetailsReview->review_title.'</a>';
				$CompanyNameLink = '<a href="'.base_url().'rating/index/'.$getdetailsReview->company_id.'/'.$getdetailsCompany->company_name.'">'.$getdetailsCompany->company_name.'</a>';
			}
			$this->db->where('id', $notification_type);
			$result = $this->db->get('notification_type');
			if($result->num_rows > 0) {
				$resultValue = $result->row();
				$purpose = $resultValue->user_message;
				$content = $resultValue->user_content;
				$replace = array("[REVIEW]","[COMPANY]");
				$replaceBy = array($ReviewNameLink,$CompanyNameLink);
				$content = str_replace($replace, $replaceBy, $content);
			}
		}else if($notification_type == 21)
		{
			$this->db->select('company_name,id,parent_id');
			$this->db->where('id', $event_primary_id);
			$qq = $this->db->get($event_table);
			if($qq->num_rows > 0){
			    $resQQ = $qq->row();
			    $CompanyID = $resQQ->parent_id;
				
				$this->db->select('first_name,last_name');
				$this->db->where('id',$this->session->userdata('uid'));
				$getdetailsPeople = $this->db->get('people');
				$getdetailsPeople = $getdetailsPeople->row();
				
				$UserNameLink = '<a href="'.base_url().'login_cont/user_profile/'.$this->session->userdata('uid').'/'.$getdetailsPeople->first_name.' '.$getdetailsPeople->last_name.'">'.$getdetailsPeople->first_name.' '.$getdetailsPeople->last_name.'</a>';
				$CompanyNameLink = '<a href="'.base_url().'rating/index/'.$CompanyID.'/'.$resQQ->company_name.'">'.$resQQ->company_name.'</a>';
			}
			$this->db->where('id', $notification_type);
			$result = $this->db->get('notification_type');
			if($result->num_rows > 0) {
				$resultValue = $result->row();
				$purpose = $resultValue->user_message;
				$content = $resultValue->user_content;
				$replace = array("[username]","[COMPANY_NAME]");
				$replaceBy = array($UserNameLink,$CompanyNameLink);
				$content = str_replace($replace, $replaceBy, $content);
				$purpose = str_replace($replace, $replaceBy, $purpose);
			}
		}
		else if($notification_type == 4){
			
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
				'token_number' => $token_number,
				'review_id' => $review_id
			);
		
		$this->db->insert('email_recieve', $data);
		$lastInsertID = $this->db->insert_id();
		$returnDetails['last_id'] = $lastInsertID;
		
		return $returnDetails;
	}
	
	function databaseRulesCheck($uid, $companyID) {
		
		$data['claimed'] = 0;
		$data['daily_max'] = 0;
		$data['one_company_thirty_day'] = 0;
		$data['one_company_twelve_month'] = 0;
		
		$this->db->where('claim_id',$uid);
		$this->db->where('company_id',$companyID);
		$this->db->where('status',1);
		$query = $this->db->get('claim_owner');
		
		if($query->num_rows > 0){
			$data['claimed'] = 1;
		}else{
			/*$this->db->select('id');
			$this->db->where('added_by', $uid);
			$this->db->where('DATE(added_on)', 'DATE(CURDATE())');
			$query = $this->db->get('company_review');*/
			$this->db->select('id');
			$this->db->where('added_by', $uid);
			$this->db->where('company_id', $companyID);
			$this->db->where('disable', '0');
			$this->db->where('added_on >= NOW() - INTERVAL 1 MONTH');
			$query = $this->db->get('company_review');
			/*if($query->num_rows >= 10){
				$data['daily_max'] = 1;
			}else{*/
			if($query->num_rows > 0){
				$data['one_company_thirty_day'] = 1;
			}else{
				$this->db->select('id');
				$this->db->where('added_by', $uid);
				$this->db->where('company_id', $companyID);
				$this->db->where('disable', '0');
				$this->db->where('added_on >= NOW() - INTERVAL 12 MONTH');
				$query = $this->db->get('company_review');
				if($query->num_rows >= 4){
					$data['one_company_twelve_month'] = 1;
				}
			}
				//echo "I am here!";die;
			//}
			
		}
		return $data;
	}
	
	function getUserDetails($id){
		$this->db->where('id', $id);
		$result = $this->db->get('people');
		if($result->num_rows > 0){
			return $result->row();
		}else{
			return false;
		}
	}
	function createUniqueCompanyID($companyName,$state,$pin,$companyTypeId,$industryID,$subindustryID)
	{
		//$companyName = 'Ibm';
		//$state = 'Karnataka';
		//$pin = '560017';
		//$companyTypeId = 2;
		//$industryID = 7;
		//$subindustryID = 72200;
		
		$companyName = strtoupper($companyName);
		$state = strtoupper($state);
		$vowelsAndSpecial = array('A','E','I','O','U',' ','/','\\',':',';','!','@','#','$','%','^','*','(',')','_','+','=','|','{','}','[',']','"',"'",'<','>',',','?','~','`','&',' ','.');
		$companyName = str_replace($vowelsAndSpecial, "", $companyName);
		$state = str_replace($vowelsAndSpecial, "", $state);
		if($state == "GOA")
		{
			$stateFScrtr = 'GAO';
		}else{
			$stateFScrtr = substr($state,0,3);
		}
		
		if(strlen($companyName) >=7 )
		{
			$data['createID'] = substr($pin,0,1).substr($companyName, 3,4).substr($pin,1,2).$stateFScrtr.substr($pin,3,2).substr($companyName, 0,3).substr($pin,5,1);
			$data['newCompanyName'] = '';
		}
		else{
			$companyTypeId = sprintf("%02d", $companyTypeId);
			$industryID = sprintf("%02d", $industryID);
			if(strlen($subindustryID) < 4)
			{
				$formatedSubIndustryNumber = str_replace('.','',number_format($subindustryID, 4-strlen($subindustryID)));
			}else{
				$formatedSubIndustryNumber = sprintf("%04d",substr($subindustryID, -4));
			}
			$newCompanyName = $companyName.$companyTypeId.$industryID.$formatedSubIndustryNumber;// Create new company name.
			$data['createID'] = substr($pin,0,1).substr($newCompanyName, 3,4).substr($pin,1,2).$stateFScrtr.substr($pin,3,2).substr($newCompanyName, 0,3).substr($pin,5,1);
			$data['newCompanyName'] = $newCompanyName;
		}
		return $data;
	}
	
	//==================store viewers ip address============//
	function total_viewer($data)
	{
		//print_r($data);
		$this->db->where('date',$data['date']);
		$this->db->where('ip_address',$data['ip_address']);
		$query=$this->db->get('viewers_details');
		//echo $num=$query->num_rows();
		if($query->num_rows == 0)
		{
		$this->db->insert('viewers_details',$data);
		return true;
		}
		else{
			return false;
		}
	}
}
?>