<?php
class Usualpay_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	// Fetch All Data from Usual Pay Table
	
    function fetch_usualPay()
	{
        $this->db->select('*');
		$query = $this->db->get('usual_pays');
		return $result=$query->result();	
	}
	
	//Insert
	
	function pay_insert($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	
	function del_data($table, $id)
	{
		$this->db->where('id', $id);
		$val = $this->db->delete($table); 
		if($val)
		{
			return true;
		}
	}
	
	function edit_pay_model($table, $id)  
	{  
	   	$this->db->from($table);
		$this->db->where("id", $id);
		$query = $this->db->get();
	   	$result= $query->result();
	   	return $result;
	}
	
	function update_pay_model($table, $id, $data_to_store)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('usual_pays');
		if($query->num_rows() > 0)
		{
			$this->db->where('id', $id);
			$val = $this->db->update('usual_pays', $data_to_store);
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function change_status_to($table, $stat_param, $id)
	{
		$this->db->where('id', $id);
		$val = $this->db->update($table, $stat_param);
		if($val)
		{
			return true;
		}
	}
 }
 
 ?>