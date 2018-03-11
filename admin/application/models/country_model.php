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
	
	public function select_all_country($searchData=null)  
	{  
	   	$this->db->from('location');
		if($searchData !="")
		{
			$this->db->like('name',"$searchData");
		}
		$this->db->order_by("location_id", "DESC");
		$query = $this->db->get();
	   	$result= $query->result();
	   	return $result;
	}
	public function select_all_country_last($searchData,$start,$limit)  
	{  
	   	$this->db->from('location');
		if($searchData !="")
		{
			$this->db->like('name',"$searchData");
		}
		$this->db->limit($limit,$start);
		$this->db->order_by("location_id", "DESC");
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
		$this->db->where('location_id', $id);
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
		$this->db->where('name', $data_to_store['name']);
		
		$query = $this->db->get('location');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows()== 0)
		{
			$insrt = $this->db->insert($table, $data_to_store);
			return 1;
		}
		else
		{
			return 0;
		}
	}
    //=============delete data from country============//
	function del_data($table, $id)
	{
		$this->db->where('location_id', $id);
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
		$this->db->where('name', $data_to_store['name']);
		$this->db->where('location_id != ', $id);
		$query = $this->db->get('location');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows() == 0)
		{
			$this->db->where('location_id', $id);
			$val = $this->db->update($table, $data_to_store);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function update_state_value($table, $data_to_store, $id)
	{
		$this->db->where('name', $data_to_store['name']);
		$this->db->where('location_id != ', $id);
		$query = $this->db->get('location');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows() == 0)
		{
			$this->db->where('location_id', $id);
			$val = $this->db->update($table, $data_to_store);
			return true;
		}
		else
		{
			return false;
		}
	}
	function update_district_value($table, $data_to_store, $id)
	{
		$this->db->where('name', $data_to_store['name']);
		$this->db->where('location_id != ', $id);
		$query = $this->db->get('location');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows() == 0)
		{
			$this->db->where('location_id', $id);
			$val = $this->db->update($table, $data_to_store);
			return true;
		}
		else
		{
			return false;
		}
	
	}
	function update_city_value($table, $data_to_store, $id)
	{
		$this->db->where('name', $data_to_store['name']);
		$this->db->where('location_id != ', $id);
		$query = $this->db->get('location');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows() == 0)
		{
			$this->db->where('location_id', $id);
			$val = $this->db->update($table, $data_to_store);
			return true;
		}
		else
		{
			return false;
		}
	}
	function get_location_id($id)
	{
		$this->db->where('location_id', $id);
		$query = $this->db->get('location');
		$result=$query->result();
		return $result;
	}

    function fetch_all_countries()  
	{
		
            $this->db->from('location');
	        $this->db->where('parent_id', 0);
            $this->db->order_by("location_id", "DESC");
            $query = $this->db->get();
			$result= $query->result();
			return $result;


	}
	  function fetch_all_state_of_country($id)  
	{
		
            $this->db->from('location');
	        $this->db->where('parent_id',$id);
            $this->db->order_by("location_id", "DESC");
            $query = $this->db->get();
			$result= $query->result();
			return $result;


	}
	 function country_name($id)
	{
		    $this->db->from('location');
	        $this->db->where('location_id',$id);
            $query = $this->db->get();
			$result= $query->result();
			return $result;
	}
	
	
	
}
?>
        