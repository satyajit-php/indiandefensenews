<?php
class district_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	

	
	 //=========================insert district========================//
        function dist_insert($table,$data,$flag)
        {
		$parent = $data['parent_id'];
		
		$this->db->where('name', $data['name']);
		$this->db->where('parent_id', $parent);
		//$this->db->where('state_id', $data['state_id']);
		
		$query = $this->db->get($table);		
		if($query->num_rows() == 0)
		{
			$val = $this->db->insert('location', $data);
			if($val)
			{
				return 1;
			}
		}
		else
		{
			return 0;
		}
	}
	//=========edit data into district============//
	
	
}
?>