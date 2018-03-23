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
		//print_r($result);
		//echo $result[0]->status;
		//die();
		if($query->num_rows == 1)
		{
			
			return 'email_already_exsist';
			
		}
		else
		{     
			$this->db->insert($table, $data); 
			return 'true';
		}
	}
}
        