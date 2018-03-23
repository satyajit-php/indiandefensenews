<?php
class sidepanel_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
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
	
	function state($id)
	{
		$this->db->select('location.name as state');
	    $this->db->where('location_id',$id);
		$query = $this->db->get('location');
		//echo $this->db->last_query();
		return $result = $query->result();	
	}
	
	function add_profilePic($table,$data,$id)
	{
		$this->db->where('id', $id);
		$this->db->update($table, $data); 
		//return $this->db->insert_id();
	}
	
	

}
 ?>