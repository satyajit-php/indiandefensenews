<?php


class Guiding_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	

   //=========fetch data from faq============//
	public function get_guiding()  
	{
		
	   	$this->db->from('guiding');
		$this->db->order_by("id", "DESC");
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
	function insert_faq_value($table, $data_to_store)
	{
		$this->db->where('name', $data_to_store['name']);
		$query = $this->db->get('faq_types');
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
	//=============insert into faq============//
	
	
	
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
	function update_faq_value($table, $data_to_store, $id)
	{
		$this->db->where('name', $data_to_store['name']);
		$this->db->where('id !=', $id);
		$query = $this->db->get('faq_types');
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
   //===================== for faq=====================//
   
   function insert_guiding($table, $data_to_store)
	{
		//$this->db->where('name', $data_to_store['faq_typ_name']);
		//$query = $this->db->get('faq_types');
		////echo $this->db->last_query();
		////die();
		
			$insrt = $this->db->insert($table, $data_to_store);
			return $insrt;
	
	}
	public function g_guiding()  
	{
		
	   	$this->db->from('guiding');
		$this->db->where('status',1);
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
	   	$result= $query->result();
	   	return $result;
	}
	public function select_faqs()  
	{  
	    $this->db->from('faq');
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
	   	$result= $query->result();
	   	return $result;
	}
   
   public function select_faq()  
	{  
	   	$query=$this->db->query('select f.*,ft.name  from faq as f,faq_types as ft where f.faq_type=ft.id  ORDER BY f.id DESC');
		$query=$query->result();
		return $query;
	}
	function edit_guiding($table,$id)
	{
		$this->db->where('id',$id);
		$q=$this->db->get('guiding');
		$res=$q->result();
		
		return $res;
		
	}
	
	
	function update_guiding($table, $data_to_store, $id)
	{
		
			$this->db->where('id', $id);
			$val = $this->db->update($table, $data_to_store);
			//echo $val;
			//die();
			if($val)
			{
			   return 1;
		    }
	    	else
		    {
			   return 0;
		    }
	}
	function change_status_guiding($table, $stat_param, $id)
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
		function del_guiding($table, $id)
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
	
	


}
?>
        