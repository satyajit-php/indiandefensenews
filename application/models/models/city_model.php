<?php
class city_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	//=========fetch all cities============//
	public function fetch_city()  
	{  
		$this->db->from('city');
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
		$city = $query->result();
		
                return $city;
       
	}
	//=========fetch all states============//
	public function fetch_state()  
	{	
		$query=$this->db->get('state');
		$state = $query->result();
		//echo"<pre>";
		//print_r($state);
		//die();
                return $state;
   
                
	}
     //=========fetch all country============//
	public function fetch_country()  
	{
		$query=$this->db->get('country');
		//$this->db->from('country');
		//$this->db->order_by("id", "DESC");
		//$query = $this->db->get();
		$country = $query->result();
              
	      return $country;
                
	}
	 //=========select all state============//
	public function Select_state($country_id)
	{
		$this->db->where('country_id',$country_id);
		$query=$this->db->get('state');
		$state = $query->result();
		//echo"<pre>";
		//print_r($state);
		//die();
                return $state;
	}
        
        //=============changing the status of city============//
	function change_status_to($table, $stat_param, $id)
	{
            $this->db->where('id', $id);
            $val = $this->db->update($table, $stat_param);
             //echo $this->db->last_query();
             //die();
            if($val)
            {
                return true;
            }
	}

	//=============delete city============//
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
        
        //=========================insert city========================//
        function city_insert($table,$data)
        {
		$this->db->where('city', $data['city']);
		$this->db->where('country_id', $data['country_id']);
		$this->db->where('state_id', $data['state_id']);
		
		$query = $this->db->get($table);		
		if($query->num_rows == 0)
		{
			$val = $this->db->insert('city', $data);
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
	//=========edit data into city============//
	public function edit_city_model($id)  
	{
		$this->db->where('id',$id);
	   	$rslt = $this->db->get('city');
	        return $rslt->result();
		//echo"<pre>";
		//print_r($rslt);
		//die();
	   
	}
	
//=========update data of city============//
	public function update_city_model($table,$id,$data) 
	{
		//echo $id;die();
		$this->db->where('city', $data['city']);
		$this->db->where('country_id', $data['country_id']);
		$this->db->where('state_id', $data['state_id']);
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