<?php
class Country_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	//=========fetch data from country============//
	public function select_country_mgmt()  
	{  
	   	$this->db->from('country');
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
	   	$result= $query->result();
	   	return $result;
	}
	
	//=========fetch data from country============//
	public function get_country_mgmt($table, $id)  
	{  
	   	$this->db->from($table);
		$this->db->where("id", $id);
		$query = $this->db->get();
	   	$result= $query->result();
	   	return $result;
	}
	
    //=============changin the status of country============//
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
    //=========insert country value======//
	function insert_country_value($table, $data_to_store)
	{
		$this->db->where('country_name', $data_to_store['country_name']);
		$query = $this->db->get('country');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows == 0)
		{
			$insrt = $this->db->insert($table, $data_to_store);
			return '1';
		}
		else
		{
			return '0';
		}
	}
    //=============delete data from country============//
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
	
	//=========update country value======//
	function update_country_value($table, $data_to_store, $id)
	{
		$this->db->where('country_name', $data_to_store['country_name']);
		$this->db->where('id !=', $id);
		$query = $this->db->get('country');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows == 0)
		{
			$this->db->where('id', $id);
			$val = $this->db->update($table, $data_to_store);
			return true;
		}
		else
		{
			return false;
		}
	}


}
?>
        