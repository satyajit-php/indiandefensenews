<?php
class accountsettings_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_row_by_id($table, $field_name, $field_vl)
	{
		$this->db->where($field_name, $field_vl);
		$this->db->from($table);
		$query = $this->db->get();
		
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;		
		}else{
			return 'false';
		}
	}
	function delete($table, $del_id)
	{
		$this->db->where('id', $del_id);
        $this->db->delete($table);
	}
	
	function country_list()
	{
		
		
		$this->db->where('location_type',0);
		$this->db->where('is_visible',0);
		$query = $this->db->get('location');
		//echo $this->db->last_query();
		return $result = $query->result();
		
		
	}
	
	function state_list($table,$data)
	{
	   
	  
		$this->db->where('parent_id',$data['id']);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		return $result = $query->result();	
	}
	
	function account_details($table,$id)     // geting details from people table
	{
	   
	  
		$this->db->where('id',$id);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		return $result = $query->result();	
	}
	
	function update_details($id,$table,$data_arr)     // update user settins page
	{
		$this->db->where('id', $id);
                return $this->db->update($table, $data_arr); 
	}
	
	function update_per($id,$per)                  // update profile percentage
	{
		$per_arr=array("profileper"=>$per);
	        $this->db->where('id', $id);
                return $this->db->update('people', $per_arr); 	
	}

		function myReviewAll($uid,$limit,$start) {
		$this->db->select('company_details.company_name,company_details.id');
		$this->db->join('company_details', 'company_details.id = company_review.company_id');
		$this->db->where('company_review.added_by', $uid);
		$this->db->limit($limit,$start);
		$this->db->group_by('company_details.id');
		$this->db->order_by('company_review.company_id','DESC');
		$claimCompany = $this->db->get('company_review');
		//echo $this->db->last_query();die;
	//	echo "<pre>" ; print_r($claimCompany->result_array());
		if($claimCompany->num_rows > 0){
			return $claimCompany->result_array();
		}
		else{
			return 0;
		}
	}
	function myReviewPerCompany($uid)
	{
		$this->db->select('company_details.company_name,company_details.id');
		$this->db->join('company_details', 'company_details.id = company_review.company_id');
		$this->db->where('company_review.added_by', $uid);
		$this->db->group_by('company_details.id');
		$this->db->order_by('company_review.company_id','DESC');
		$claimCompany = $this->db->get('company_review');
		return $claimCompany->num_rows();
	}
	
	function mymessages_in($uid,$limit,$start,$searchTerm)
	{
		if($searchTerm == '')
		{
			$this->db->select('email_recieve.*,people.first_name,people.last_name');
			$this->db->from('email_recieve');
			$this->db->join('people', 'people.id = email_recieve.sender');
			$this->db->not_like('email_recieve.purpose', 'claim_company');
			$this->db->where('email_recieve.reciever', $uid);
			$this->db->where('email_recieve.not_view !=', $uid);
			$this->db->where('email_recieve.notification_type <>', 0);
			$this->db->limit($limit,$start);
			$this->db->order_by('email_recieve.id','DESC');
			
			$claimCompany = $this->db->get();
			
			//echo $this->db->last_query();
			if($claimCompany->num_rows > 0){
				return $claimCompany->result();
			}
			else{
				return 0;
			}
		}else {
			
			$this->db->select('email_recieve.*,people.first_name,people.last_name');
			$this->db->from('email_recieve');
			$this->db->join('people', 'people.id = email_recieve.sender');
			$this->db->not_like('email_recieve.purpose', 'claim_company');
			//$this->db->where('email_recieve.notification_type', 14);
			$this->db->where('email_recieve.notification_type <>', 0);
			$this->db->where('email_recieve.reciever', $uid);
			$this->db->where('email_recieve.not_view !=', $uid);
			$this->db->where(("( people.first_name LIKE '%$searchTerm%' || people.last_name LIKE '%$searchTerm%' || people.email LIKE '%$searchTerm%' || email_recieve.purpose LIKE '%$searchTerm%')"));
			
			$this->db->limit($limit,$start);
			$this->db->order_by('email_recieve.id','DESC');
			
			$claimCompany = $this->db->get();
			
			//echo $this->db->last_query();die;
			if($claimCompany->num_rows > 0){
				return $claimCompany->result();
			}
			else{
				return 0;
			}
			
		}
		
	}
	//function mymessages_inCount($uid,$limit,$start,$searchTerm)
	//{
	//	if($searchTerm == '')
	//	{
	//		$this->db->select('email_recieve.*,people.first_name,people.last_name');
	//		$this->db->from('email_recieve');
	//		$this->db->join('people', 'people.id = email_recieve.sender');
	//		$this->db->not_like('email_recieve.purpose', 'claim_company');
	//		$this->db->where('email_recieve.reciever', $uid);
	//		$this->db->where('email_recieve.not_view !=', $uid);
	//		
	//		
	//		$this->db->limit($limit,$start);
	//		$this->db->order_by('email_recieve.id','DESC');
	//		
	//		$claimCompany = $this->db->get();
	//		return $claimCompany->num_rows;
	//	}
	//	else
	//	{
	//		
	//	    $this->db->select('email_recieve.*,people.first_name,people.last_name');
	//		$this->db->from('email_recieve');
	//		$this->db->join('people', 'people.id = email_recieve.sender');
	//		$this->db->not_like('email_recieve.purpose', 'claim_company');
	//		$this->db->where('email_recieve.reciever', $uid);
	//		$this->db->where('email_recieve.not_view !=', $uid);
	//		$this->db->where(("( people.first_name LIKE '%$searchTerm%' || people.last_name LIKE '%$searchTerm%' || email_recieve.purpose LIKE '%$searchTerm%')"));
	//		//$this->db->where(("('people.first_name' LIKE '%$searchTerm%' || 'people.last_name' LIKE '%$searchTerm%' || 'email_recieve.purpose' LIKE '%$searchTerm%' )"));
	//		//$this->db->like('people.first_name', $searchTerm);
	//		//$this->db->or_like('CONCAT(people.first_name," ",people.last_name)', $searchTerm);
	//		//$this->db->or_like('people.last_name', $searchTerm);
	//		//$this->db->or_like('email_recieve.purpose', $searchTerm);
	//		//if($searchTerm !="")
	//		//{
	//		//	//$this->db->where(("('people.first_name' LIKE '%$searchTerm%' || 'people.last_name' LIKE '%$searchTerm%')"));
	//		//	$this->db->like('people.first_name', $searchTerm);
	//		//	$this->db->or_like('CONCAT(people.first_name," ",people.last_name)', $searchTerm);
	//		//	$this->db->or_like('people.last_name', $searchTerm);
	//		//	$this->db->or_like('email_recieve.purpose', $searchTerm);
	//		//}
	//		$this->db->limit($limit,$start);
	//		$this->db->order_by('email_recieve.id','DESC');
	//		
	//		$claimCompany = $this->db->get();
	//		return $claimCompany->num_rows;
	//	}
	//}
	function mymessages_inCount($uid,$searchTerm=null)
	{
		$this->db->select('email_recieve.*,people.first_name,people.last_name');
		$this->db->from('email_recieve');
		$this->db->join('people', 'people.id = email_recieve.sender');
		$this->db->not_like('email_recieve.purpose', 'claim_company');
		$this->db->where('email_recieve.reciever', $uid);
		$this->db->where('email_recieve.notification_type <>', 0);
		//$this->db->where('email_recieve.notification_type', 14);
		$this->db->where('email_recieve.not_view <>', $uid);
		if($searchTerm !="" || $searchTerm != null)
		{
			$this->db->where(("( people.first_name LIKE '%$searchTerm%' || people.last_name LIKE '%$searchTerm%' || people.email LIKE '%$searchTerm%' || email_recieve.purpose LIKE '%$searchTerm%')"));
			/*$this->db->like('people.first_name', $searchTerm);
			$this->db->or_like('CONCAT(people.first_name," ",people.last_name)', $searchTerm);
			$this->db->or_like('people.last_name', $searchTerm);
			$this->db->or_like('people.email', $searchTerm);
			$this->db->or_like('email_recieve.purpose', $searchTerm);*/
		}
		$this->db->order_by('email_recieve.id','DESC');
		$claimCompany = $this->db->get();
		
		return $claimCompany->num_rows;
	}
	function getMessageParticular($tableId, $messageType) {
		
		if($messageType == 'outbox') {
			$this->db->select('email_recieve.*,people.first_name,people.last_name');
			$this->db->from('email_recieve');
			$this->db->join('people', 'people.id = email_recieve.reciever');
			$this->db->where('email_recieve.id', $tableId);
			$this->db->where('email_recieve.not_view <>', $this->session->userdata('uid'));
			$claimCompany = $this->db->get();
			
			if($claimCompany->num_rows > 0) {
				
				$value = $claimCompany->row();
				$content = $value->content;
				$name = $value->first_name . ' ' . $value->last_name;
				$subject = $value->purpose;
				
				$time = $value->date;
				$this->db->where('id', $tableId);
				$this->db->update('email_recieve', array('read_status' => 1));
				return 'To : '.$name.'@@Subject : '.$subject.'@@ '.$content.'@@Time : '.date("F j, Y, g:i a", strtotime($time));
			}
			else {
				return $value = '';
			}
			
		}
		if($messageType == 'inbox') {
			$this->db->select('email_recieve.*,people.first_name,people.last_name');
			$this->db->from('email_recieve');
			$this->db->join('people', 'people.id = email_recieve.sender');
			$this->db->where('email_recieve.id', $tableId);
			$this->db->where('email_recieve.not_view <>', $this->session->userdata('uid'));
			$claimCompany = $this->db->get();
			
			if($claimCompany->num_rows > 0) {
				$value = $claimCompany->row();
				$name = $value->first_name . ' ' . $value->last_name;
				$subject = $value->purpose;
				$content = $value->content;
				$time = $value->date;
				$readStatus = $value->read_status;
				
				$this->db->where('id', $tableId);
				$this->db->update('email_recieve', array('receiver_read_status' => 1));
				return 'From : '.$name.'@@Subject : '.$subject.'@@ '.$content.'@@Time : '.date("F j, Y, g:i a", strtotime($time));
			}
			else {
				return $value = '';
			}
		}
		
	}
	//function deleteMessagesFromDB($ids){
	//	foreach($ids as $id)
	//	{
	//		$this->db->where('id', $id['value']);
	//		$this->db->update('email_recieve', array('not_view' => $this->session->userdata('uid') )); 
	//	}
	//}
	function deleteMessagesFromDB($id)
	{
		$this->db->where('id', $id);
		$this->db->update('email_recieve', array('not_view' => $this->session->userdata('uid') )); 
	}
	function readunreadFromDB($ids, $readunread, $mod)
	{
		if($mod == 'inbox')
		{
			foreach($ids as $id)
			{
				$this->db->where('id', $id['value']);
				$this->db->update('email_recieve', array('receiver_read_status' => $readunread )); 
			}
		}
		else
		{
			foreach($ids as $id)
			{
				$this->db->where('id', $id['value']);
				$this->db->update('email_recieve', array('read_status' => $readunread )); 
			}
		}
	}
	function saveMessageReply($id, $subject, $text) {
		$data = array(
			      'notification_type' => 14,
			      'reciever' => $id,
			      'sender' => $this->session->userdata('uid'),
			      'purpose' => $subject,
			      'content' => $text,
				  'read_status' => 1
			);
		
		$this->db->insert('email_recieve', $data);
		return 1;
	}
	
	function mymessages_out($uid,$limit,$start,$searchTerm)
	{
		if($searchTerm !="")
		{
			$this->db->select('email_recieve.*,people.first_name,people.last_name');
			$this->db->from('email_recieve');
			$this->db->join('people', 'people.id = email_recieve.reciever');
			$this->db->where('email_recieve.sender', $uid);
			$this->db->where('email_recieve.notification_type', 14);
			$this->db->not_like('email_recieve.purpose', 'claim_company');
			$this->db->where('email_recieve.not_view !=', $uid);
			$this->db->where(("( people.first_name LIKE '%$searchTerm%' || people.last_name LIKE '%$searchTerm%' || people.email LIKE '%$searchTerm%' || email_recieve.purpose LIKE '%$searchTerm%')"));
			
			$this->db->limit($limit,$start);
			$this->db->order_by('email_recieve.id','DESC');
		}
		else
		{
			$this->db->select('email_recieve.*,people.first_name,people.last_name');
			$this->db->from('email_recieve');
			$this->db->join('people', 'people.id = email_recieve.reciever');
			$this->db->where('email_recieve.notification_type', 14);
			$this->db->where('email_recieve.sender', $uid);
			$this->db->not_like('email_recieve.purpose', 'claim_company');
			$this->db->where('email_recieve.not_view !=', $uid);
			$this->db->limit($limit,$start);
			$this->db->order_by('email_recieve.id','DESC');
		}
		
		
		$claimCompany = $this->db->get();
		if($claimCompany->num_rows > 0) {
			return $claimCompany->result();
		}
		else {
			return 0;
		}	
		//$this->db->select('email_recieve.*,people.first_name,people.last_name');
		//$this->db->from('email_recieve');
		//$this->db->join('people', 'people.id = email_recieve.reciever');
		//$this->db->where('email_recieve.sender', $uid);
		//$this->db->not_like('email_recieve.purpose', 'claim_company');
		//$this->db->where('email_recieve.not_view <>', $this->session->userdata('uid'));
		//if($searchTerm !="")
		//{
		//$this->db->like('people.first_name', $searchTerm);
		//$this->db->or_like('CONCAT(people.first_name," ",people.last_name)', $searchTerm);
		//$this->db->or_like('people.last_name', $searchTerm);
		//$this->db->or_like('email_recieve.purpose', $searchTerm);
		//}
		//$this->db->limit($limit,$start);
		//$this->db->order_by('email_recieve.id','DESC');
		//
		//$claimCompany = $this->db->get();
		//if($claimCompany->num_rows > 0) {
		//	return $claimCompany->result();
		//}
		//else {
		//	return 0;
		//}	
	}
	function mymessages_outCount($uid,$searchTerm=null)
	{
		$this->db->select('email_recieve.*,people.first_name,people.last_name');
		$this->db->from('email_recieve');
		$this->db->join('people', 'people.id = email_recieve.reciever');
		$this->db->where('email_recieve.notification_type', 14);
		$this->db->where('email_recieve.sender', $uid);
		$this->db->not_like('email_recieve.purpose', 'claim_company');
		$this->db->where('email_recieve.not_view <>', $uid);
		if($searchTerm !="" || $searchTerm != null)
		{
			$this->db->where(("( people.first_name LIKE '%$searchTerm%' || people.last_name LIKE '%$searchTerm%' || people.email LIKE '%$searchTerm%' || email_recieve.purpose LIKE '%$searchTerm%')"));
			/*$this->db->like('people.first_name', $searchTerm);
			$this->db->or_like('CONCAT(people.first_name," ",people.last_name)', $searchTerm);
			$this->db->or_like('people.last_name', $searchTerm);
			$this->db->or_like('people.email', $searchTerm);
			$this->db->or_like('email_recieve.purpose', $searchTerm);*/
		}
		$this->db->order_by('email_recieve.id','DESC');
		$claimCompany = $this->db->get();
		return $claimCompany->num_rows;
	}
	//function myMassageCount($uid,$searchTerm=null) {
	//	$this->db->select('company_details.company_name,email_recieve.*,people.first_name,people.last_name');
	//	$this->db->from('email_recieve');
	//	$this->db->join('company_details', 'company_details.id = email_recieve.company_id','left');
	//	$this->db->join('people', 'people.id = email_recieve.sender','left');
	//	$this->db->where('email_recieve.reciever', $uid);
	//	$this->db->like('company_details.company_name', $searchTerm);
	//	$this->db->order_by('email_recieve.id','DESC');
	//	$claimCompany = $this->db->get();
	//	return $claimCompany->num_rows;
	//}
	function myMassageCount($uid,$searchTerm=null) {
		$this->db->select('email_recieve.*,people.first_name,people.last_name');
		$this->db->from('email_recieve');
		//$this->db->join('company_details', 'company_details.id = email_recieve.company_id','left');
		$this->db->join('people', 'people.id = email_recieve.sender');
		$this->db->where('email_recieve.reciever', $uid);
		$this->db->where('email_recieve.not_view !=', $uid);
		$this->db->where('email_recieve.receiver_read_status !=', 1);
		$this->db->where('email_recieve.notification_type', 14);
		$this->db->not_like('email_recieve.purpose', 'claim_company');
		//$this->db->like('company_details.company_name', $searchTerm);
		$this->db->order_by('email_recieve.id','DESC');
		$claimCompany = $this->db->get();
		return $claimCompany->num_rows;
	}
	function getallStatus($comp_id,$send_id,$status)
	{
		$this->db->where('company_id',$comp_id);
		$this->db->where('claim_id',$send_id);
		$query = $this->db->get('claim_owner');
		//echo $this->db->last_query();die;
		//print_r($query->result);
		return $result = $query->result();
		
	}
	

}
 ?>