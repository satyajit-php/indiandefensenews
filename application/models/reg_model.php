<?php
class reg_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function user_registration($table, $data)
	{
		
		
		$this->db->where('email', $data['email']);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		$result = $query->result();
		
		if($query->num_rows == 1)
		{
			
			return 'email_already_exsist';
			
		}
		else
		{ 
			$data['profile_pic']='user_default.png';
			$this->db->insert($table, $data);
			$uid = $this->db->insert_id();
			//$name = explode('@',$data['email'])[0]; 
			
			
			//if($data['first_name']=='' && $data['last_name']=='')
			//{
			//	$name= explode('@',$data['email'])[0];
			//}else if(($data['first_name']!='' || $data['last_name']!='')){
			//	$name= $data['first_name'].' '. $data['last_name'];
			//	//$name = explode('@',$data['email'])[0];
			//}
			
			//$data = array(
			//	'uid' => $uid,
			//	'is_logged_in' => false,
			//	'usernames'=>$name,
			//	'profile_pic'=>$data['profile_pic']
			//	);
			//$session_login = $this->session->set_userdata($data);
			return $uid;
		}
	}
	function mail_chk($table, $data)      //check if mail id already exists or not
	{
		$this->db->where('email',$data['email']);
		$query=$this->db->get($table);
		if($query->num_rows == 1)
		{
			return 1;
		}
		else
			return 0;
	}
	function profile_active($table, $id)
	{
		
	    $this->db->where('id',$id);
		$query=$this->db->get($table);
		//echo $this->db->last_query();
		if($query->num_rows == 1)
		{
			$result = $query->result();
		    
			if($result[0]->status==1)
			{
				return 0;
			}
			else
			{
				$dat_arr=array("status"=>1);
				$this->db->where('id', $id);
				$results=$this->db->update($table, $dat_arr);
				//print_r($re);
				return 1;
			}
		}
	}
}
        