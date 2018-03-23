<?php
class accountsettings_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
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

}
 ?>