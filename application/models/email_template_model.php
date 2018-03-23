<?php
class email_template_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	//=========fetch data from email template============//
	public function select_email_template()  
	{  
	   	$this->db->from('email_template');
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
	   	$result= $query->result();
	   	return $result;
	}

	//=========insert data into email template============//
	function email_template_admin($table, $data)
	{
		$this->db->where('email_type', $data['email_type']);
		$this->db->where('email_title', $data['email_title']);
		$query = $this->db->get($table);		
		if($query->num_rows == 0)
		{
			$val = $this->db->insert('email_template', $data);
			if($val)
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}
	
	//=============changin the status of email template============//
	function change_status_to($table, $stat_param, $id)
	{
		$this->db->where('id', $id);
		$val = $this->db->update($table, $stat_param);
		// echo $this->db->last_query();
		// die();
		if($val)
		{
			return true;
		}
	}

	//=============delete data from email template============//
	function del_data($table, $id)
	{
		$this->db->where('id', $id);
		$val = $this->db->delete($table); 
		// echo $this->db->last_query();
		// die();
		if($val)
		{
			return true;
		}
	}
	//=========edit data into email template============//
	public function edit_email_template_model($id)  
	{
		$this->db->where('id',$id);
	   	$rslt = $this->db->get('email_template');
	        return $rslt->result();
		//echo"<pre>";
		//print_r($rslt);
		//die();
	   
	}
	//=========update data of email template============//
	public function update_email_template_model($table,$id,$data) 
	{
		//echo $id;die();
		$this->db->where('email_type', $data['email_type']);
		$this->db->where('email_title', $data['email_title']);
		$this->db->where('id !=',$id);
		$query = $this->db->get($table);
		//echo $this->db->last_query();die();
		if($query->num_rows == 0)
		{
			
			$this->db->where('id', $id);
			$val = $this->db->update($table,$data);
			//print_r($data);die();
			if($val)
			{
				//echo $val;die();
				return true;
			}
			
		}
		else
		{
			return false;
		}
	}
	
}
?>