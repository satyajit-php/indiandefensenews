<?php
class Feedback_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	function insert_data($table, $data)
    {
        $this->db->insert($table, $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
    }
    function email_tmp($table, $data)
	{
	    $this->db->where('id',$data);
		$this->db->where('status','Y');
		$query = $this->db->get($table);
		return $result=$query->result();
	
	}
	function fetch_data($table, $data)
	{
	    $this->db->where('id',$data);
		$query = $this->db->get($table);
		return $result=$query->result();
	}
	//Admin mail send query
	function admin_details($table)
	{
		$query = $this->db->get($table);
		return $result=$query->result();
	}
	function get_row_by_id($table, $field_name, $field_vl, $field_name1, $field_vl1)
	{
		$this->db->where($field_name, $field_vl);
		$this->db->where($field_name1, $field_vl1);
		$this->db->where('status', '1');
		$this->db->from($table);
		$query = $this->db->get();
		
		if($query->num_rows > 0)
		{
			return '1';		
		}else{
			return '0';
		}
	}
	function fetch_row_by_id($table, $field_name, $field_vl)
	{
		$this->db->where($field_name, $field_vl);
		//$this->db->where('status', '1');
		$this->db->from($table);
		$query = $this->db->get();
		$result=$query->result();
		if($query->num_rows > 0)
		{
			return $result;
		}else{
			return '0';
		}
	}
	
}
?>