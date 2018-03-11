<?php
class ind_email_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function get_temp($table)
	{
		$this->db->where('id',37);
		$query=$this->db->get($table);
		$result=$query->result();
		return $result;
	}
        
}
?>