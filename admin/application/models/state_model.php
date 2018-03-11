<?php
class State_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	//=========fetch all Country Name with respect to country id ============//
	public function fetch_country($id)  
	{  
            $this->db->from('country');
	        $this->db->order_by("id", "DESC");
            $this->db->where("id", $id);
            $query = $this->db->get();
			//echo $this->db->last_query();
            //die();
			$res = $query->result();
			return $res;
			
	}
	//=========fetch all countries============//
	public function fetch_all_countries()  
	{
		
            $this->db->from('location');
	        $this->db->where('parent_id', 0);
            $this->db->order_by("location_id", "DESC");
            $query = $this->db->get();
			$result= $query->result();
			return $result;


	}
	
	//=========fetch all states============//
	public function fetch_state()  
	{
		$this->db->select('*');
		$this->db->from('state');
		$this->db->order_by('id',"DESC");
           // $this->db->where('id', 'DESC');
            $query = $this->db->get();
            $result= $query->result();
            return $result;
	}
		//=========fetch data from country============//
	public function get_state($table, $id)  
	{  
	   	$this->db->from($table);
		$this->db->where("id", $id);
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
	   	$result= $query->result();
	   	return $result;
	}
        
        //=============changing the status of states============//
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
	//=========insert state value======//
	function insert_state_value($table, $data_to_store)
	{
		//print_r($data_to_store); die();
		$this->db->where('name', $data_to_store['name']);
		$query = $this->db->get('location');
	
		if($query->num_rows() == 0)
		{
			$insrt = $this->db->insert($table, $data_to_store);
			
			return 1;
		}
		else
		{
			return 0;
		}
	}
	//=============delete states============//
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
	
	//=========update state value======//
	function update_state_value($table, $data_to_store, $id)
	{
		$this->db->where('state', $data_to_store['state']);
		$this->db->where('id !=', $id);
		$query = $this->db->get('state');
		//echo $this->db->last_query();
		//die();
		if($query->num_rows() == 0)
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