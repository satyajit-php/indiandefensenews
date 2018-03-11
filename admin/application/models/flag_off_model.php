<?php
class flag_off_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	//=========fetch all subadmins from admin============//
	public function flag_off_all_notification($flag)  
	{
		
		if($flag == 'new')
		{
			$status=0;
		}else if($flag == 'hold') {
			$status=1;
		}
		else if($flag == 'escalate') {
			$status=2;
		}
		else if($flag == 'disallow') {
			$status=3;
		}else if($flag == 'all'){
			$status = 4;
		}
		$this->db->select('email_recieve.*,notification_type.label_color,notification_type.type_name');
		$this->db->join('notification_type', 'notification_type.id = email_recieve.notification_type');
		$this->db->where("email_recieve.notification_type", "9");
		$this->db->where("email_recieve.reciever", "0");
		$this->db->where("email_recieve.status", $status);
		$this->db->order_by("email_recieve.id", "DESC");
		$query = $this->db->get('email_recieve');
		//echo $this->db->last_query();
		$result= $query->result();
		return $result;
	}
	public function flag_off_all_notification_count($flag)  
	{
		
		if($flag == 'new')
		{
			$status=0;
		}else if($flag == 'hold') {
			$status=1;
		}
		else if($flag == 'escalate') {
			$status=2;
		}
		else if($flag == 'disallow') {
			$status=3;
		}else if($flag == 'all')
		{
			$status = 4;
		}
		$this->db->select('email_recieve.*,notification_type.label_color,notification_type.type_name');
		$this->db->join('notification_type', 'notification_type.id = email_recieve.notification_type');
		$this->db->where("email_recieve.notification_type", "9");
		$this->db->where("email_recieve.reciever", "0");
		$this->db->where("email_recieve.status", $status);
		$query = $this->db->get('email_recieve');
		$numrows=$query->num_rows();
		return $numrows;
	}
	//=============count for database notification================//
	public function dbrule_num($flag)  
	{
		
		
		//$status=0;
		if($flag == 'new')
		{
			$status=0;
		}else if($flag == 'hold') {
			$status=1;
		}
		else if($flag == 'escalate') {
			$status=2;
		}
		else if($flag == 'disallow') {
			$status=3;
		}else if($flag == 'all')
		{
			$status = 4;
		}
		$this->db->select('email_recieve.*,notification_type.label_color,notification_type.type_name');
		$this->db->join('notification_type','email_recieve.notification_type = notification_type.id');
		$this->db->where("email_recieve.notification_type", "4");
		$this->db->where("email_recieve.reciever", "0");
		$this->db->where("email_recieve.status", $status);
		//$this->db->order_by("email_recieve.id", "DESC");
		$query = $this->db->get('email_recieve');
		//echo $this->db->last_query();
		$numrows=$query->num_rows();
		return $numrows;
	}
	function dbrule_allnum($type)
	{
		$this->db->select('email_recieve.*,notification_type.label_color,notification_type.type_name');
		$this->db->join('notification_type','email_recieve.notification_type = notification_type.id');
		$this->db->where("email_recieve.notification_type",$type);
		$this->db->where("email_recieve.reciever", "0");
		$query = $this->db->get('email_recieve');
		$numrows=$query->num_rows();
		return $numrows;
	}
	//=============end of count for database notification================//
	function get_row_by_numb($table, $field_name, $field_vl)
	{
		$this->db->where($field_name, $field_vl);
		$this->db->from($table);
		$query = $this->db->get();
		$num = $query->num_rows();
		
		return $num;
	}
	
	function system_generated_all_notification($flag,$label=null)
	{
		$status = '!=""';
		if($flag == 'new')
		{
			$status=0;
		}else if($flag == 'hold') {
			$status=1;
		}
		else if($flag == 'escalate') {
			$status=2;
		}
		else if($flag == 'disallow') {
			$status=3;
		}
		else if($flag == 'resolved') {
			$status=4;
		}
		$notifyArray =array('1','2','3','5','6','7','8','10','11','12','13','15','16','17','18','19','20','21','29');
		$this->db->select('email_recieve.*,notification_type.label_color,notification_type.type_name');
		$this->db->join('notification_type', 'notification_type.id = email_recieve.notification_type');
		if($label !="")
		{
			$this->db->where("email_recieve.notification_type", $label);
		}
		$this->db->where_in("email_recieve.notification_type", $notifyArray);
		$this->db->where("email_recieve.reciever", "0");
		$this->db->where("email_recieve.status", $status);
		$this->db->order_by("email_recieve.id", "DESC");
		$query = $this->db->get('email_recieve');
		//echo $this->db->last_query();
		$result= $query->result();
		return $result;
	}
	
	function system_generated_all_notification_count($flag,$label=null)
	{
		$status = '!=""';
		if($flag == 'new')
		{
			$status=0;
		}else if($flag == 'hold') {
			$status=1;
		}
		else if($flag == 'escalate') {
			$status=2;
		}
		else if($flag == 'disallow') {
			$status=3;
		}
		$notifyArray =array('1','2','3','5','6','7','8','10','11','12','13','15','16','17','18','19','20','29');
		$this->db->select('email_recieve.*,notification_type.label_color,notification_type.type_name');
		$this->db->join('notification_type', 'notification_type.id = email_recieve.notification_type');
		if($label !="")
		{
			$this->db->where("email_recieve.notification_type", $label);
		}
		$this->db->where_in("email_recieve.notification_type", $notifyArray);
		$this->db->where("email_recieve.reciever", "0");
		$this->db->where("email_recieve.status", $status);
		$this->db->order_by("email_recieve.id", "DESC");
		$query = $this->db->get('email_recieve');
		//echo $this->db->last_query();
		$result= $query->result();
		return $result;
	}
	public function database_rules_all_notification($flag)  
	{
		$status = 4;
		if($flag == 'new')
		{
			$status=0;
		}else if($flag == 'hold') {
			$status=1;
		}
		else if($flag == 'escalate') {
			$status=2;
		}
		else if($flag == 'disallow') {
			$status=3;
		}
		$this->db->select('email_recieve.*,notification_type.label_color,notification_type.type_name');
		$this->db->join('notification_type', 'notification_type.id = email_recieve.notification_type');
		$this->db->where("email_recieve.notification_type", "4");
		$this->db->where("email_recieve.reciever", "0");
		$this->db->where("email_recieve.status", $status);
		$this->db->order_by("email_recieve.id", "DESC");
		$query = $this->db->get('email_recieve');
		//echo $this->db->last_query();
		$result= $query->result();
		return $result;
	}
	public function getNotification()
	{
		$notifyArray =array('1','2','3','5','6','7','8','10','15','16','18','19','20','21');
		$this->db->select('*');
		$this->db->where_in("notification_type.id", $notifyArray);
		$this->db->order_by("notification_type.id", "DESC");
		$query = $this->db->get('notification_type');
		$result= $query->result();
		return $result;
	}
	public function getFlagoffContent($event_table, $event_primary_id) {
		
		$this->db->select('problem_comment');
		$this->db->where('id', $event_primary_id);
		$getResult = $this->db->get($event_table);
		if($getResult->num_rows > 0){
			$result = $getResult->row();
			return $result->problem_comment;
		}else{
			return 'N/A';
		}
	}
	public function getAdminNote($allNewNotificationAllid) {
		$this->db->select('reply');
		$this->db->where('notification_id', $allNewNotificationAllid);
		$result = $this->db->get('admin_notification_reply');
		if($result->num_rows > 0) {
			$return = $result->row();
			return $return->reply;
		}else{
			return 'N/A';
		}
	}
	public function flag_off_perticular_notification($notificationID)
	{
		
		$this->db->select('email_recieve.*,notification_type.label_color,notification_type.type_name, CONCAT(people.first_name, " ", people.last_name) AS report_by_name, people.email AS report_email, company_review_details.review_id, company_review_details.problem_comment');
		$this->db->join('notification_type', 'notification_type.id = email_recieve.notification_type');
		$this->db->join('company_review_details', 'company_review_details.id = email_recieve.event_primary_id');
		$this->db->join('people', 'people.id = company_review_details.uid');
		$this->db->where('email_recieve.id', $notificationID);
		$this->db->order_by('email_recieve.id', 'DESC');
		$query = $this->db->get('email_recieve');
		//echo $this->db->last_query();die;
		$result= $query->result();
		return $result;
	}
	public function database_rules_perticular_notification($notificationID)
	{
		
		$this->db->select('email_recieve.*,notification_type.label_color,notification_type.type_name, CONCAT(people.first_name, " ", people.last_name) AS report_by_name, people.email AS report_email, get_rules.id AS RuleID,get_rules.rule_name, get_rules.rules_no,get_rules.change');
		$this->db->join('notification_type', 'notification_type.id = email_recieve.notification_type');
		$this->db->join('get_rules', 'get_rules.id = email_recieve.event_primary_id');
		$this->db->join('people', 'people.id = email_recieve.sender');
		$this->db->where('email_recieve.id', $notificationID);
		$this->db->order_by('email_recieve.id', 'DESC');
		$query = $this->db->get('email_recieve');
		//echo $this->db->last_query();die;
		$result= $query->result();
		return $result;
	}
	public function reviewedByFlag($review_id) {
		$this->db->select('CONCAT(people.first_name, " ", people.last_name) AS reviewed_by_name, people.id, people.email AS reviewed_email');
		$this->db->join('company_review', 'people.id = company_review.added_by');
		$this->db->where('company_review.id', $review_id);
		$result = $this->db->get('people');
		if($result->num_rows > 0){
			$query = $result->row();
			$reviewFlag['reviewed_id'] = $query->id;
			$reviewFlag['reviewed_email'] = $query->reviewed_email;
			$reviewFlag['reviewed_by_name'] = $query->reviewed_by_name;
		}else{
			$reviewFlag['reviewed_id'] = 0;
			$reviewFlag['reviewed_email'] = 'N/A';
			$reviewFlag['reviewed_by_name'] = 'N/A';
		}
		return $reviewFlag;
	}
	function getDetailsByID($table,$field,$value)
	{
		$this->db->where($field, $value);
		if($table == 'email_template')
		{
			$this->db->where('status','Y');
		}
		$query =$this->db->get($table);
		
		if($query->num_rows>0)
		{
			return $result=$query->result();	
		}
		else
		{
			return $result=0;	
		}
	}
	function getDetailscount($table,$notificationID)
	{
		$this->db->where('admin_id',$this->session->userdata('admin_uid') );
		$this->db->where('notification_id',$notificationID );
		$query =$this->db->get($table);
		return $query->num_rows;
	}
	function emailTemp($table, $data)
	{
		$this->db->where('id',$data['id']);
		$this->db->where('status','Y');
		$query = $this->db->get($table);
		return $result=$query->result();
	}
	function fetchDetailsById($table, $data)
	{
		$this->db->where('id',$data['id']);
		$query = $this->db->get($table);
		return $result=$query->result();
	}
	
	public function getNameOfDetails($table, $fieldID, $fieldName, $id){
		$this->db->where($fieldID, $id);
		$qur = $this->db->get($table);
		if($qur->num_rows > 0){
			$res = $qur->row();
			$name = $res->$fieldName;
			return $name;
		}else{
			return 'N/A';
		}
	}
	
	public function getReviewDetails($review_id) {
		$this->db->where('id', $review_id);
		$qu = $this->db->get('company_review');
		if($qu->num_rows > 0){
			$result = $qu->row();
			return $result;
		}else{
			return 'N/A';
		}
	}
	
	public function perticular_system_notification_notification($notificationID,$table=null,$primaryKey=null)
	{
		if($table !="")
		{
		$this->db->select('email_recieve.id AS NotificationID,email_recieve.notification_type,email_recieve.reciever,
						email_recieve.sender,email_recieve.company_id,email_recieve.purpose,email_recieve.content,
						email_recieve.date,email_recieve.read_status,email_recieve.event_table,email_recieve.event_primary_id,email_recieve.token_number,email_recieve.status AS NotificationStatus,
						notification_type.label_color,notification_type.type_name,'.$table.'.* ');
		$this->db->join('notification_type', 'notification_type.id = email_recieve.notification_type');
		$this->db->join($table, $table.'.id = email_recieve.event_primary_id');
		$this->db->where('email_recieve.id', $notificationID);
		$this->db->order_by('email_recieve.id', 'DESC');
		$query = $this->db->get('email_recieve');
		//echo $this->db->last_query();
		$result= $query->result();
		}
		return $result;
	}
	public function perticular_system_notification_message($notificationID)
	{
		$this->db->select('email_recieve.id AS NotificationID,email_recieve.notification_type,email_recieve.reciever,
						email_recieve.sender,email_recieve.company_id,email_recieve.purpose,email_recieve.content,
						email_recieve.date,email_recieve.read_status,email_recieve.event_table,email_recieve.event_primary_id,email_recieve.token_number,email_recieve.status AS NotificationStatus,
						notification_type.label_color,notification_type.type_name');
		$this->db->join('notification_type', 'notification_type.id = email_recieve.notification_type');
		$this->db->where('email_recieve.id', $notificationID);
		$this->db->order_by('email_recieve.id', 'DESC');
		$query = $this->db->get('email_recieve');
		//echo $this->db->last_query();
		$result= $query->result();
		
		return $result;
	}
	//=============count for system notification================//
	
	function system_num($flag)
	{
		$status = '!=""';
		
		if($flag == 'new')
		{
			$status=0;
		}else if($flag == 'hold') {
			$status=1;
		}
		else if($flag == 'escalate') {
			$status=2;
		}
		else if($flag == 'disallow') {
			$status=3;
		}
		else if($flag == 'resolved') {
			$status=4;
		}
		$this->db->select('email_recieve.*,notification_type.label_color,notification_type.type_name');
		$this->db->join('notification_type','email_recieve.notification_type = notification_type.id');
		$this->db->where("email_recieve.notification_type !=", "4");
		$this->db->where("email_recieve.notification_type !=", "14");
		$this->db->where("email_recieve.notification_type !=", "9");
		$this->db->where("email_recieve.notification_type !=", "0");
		$this->db->where("email_recieve.reciever", "0");
		$this->db->where("email_recieve.status", $status);
		//$this->db->order_by("email_recieve.id", "DESC");
		$query = $this->db->get('email_recieve');
		//echo $this->db->last_query();
		$numrows=$query->num_rows();
		return $numrows;
	}
	
	
	function system_allnum()
	{
		$this->db->select('email_recieve.*,notification_type.label_color,notification_type.type_name');
		$this->db->join('notification_type','email_recieve.notification_type = notification_type.id');
		$this->db->where("email_recieve.notification_type !=", "4");
		$this->db->where("email_recieve.notification_type !=", "14");
		$this->db->where("email_recieve.notification_type !=", "9");
		$this->db->where("email_recieve.notification_type !=", "0");
		$this->db->where("email_recieve.reciever", "0");
		$query = $this->db->get('email_recieve');
		$numrows=$query->num_rows();
		return $numrows;
	}
	
	function emailTempfedd($table,$data)
	 {
		$this->db->where('id',$data);
		$this->db->where('status','Y');
		$query = $this->db->get($table);
		return $result=$query->result();
	 }
}