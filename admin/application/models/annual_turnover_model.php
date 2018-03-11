<?php
class annual_turnover_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
//========Getting All Details Of company_type Table========//
	function get_all_rating()
	{
		$this->db->from('annual_turnover');
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;
		
		}
	}
//=============Delete Record From company_type Table========//
	function del_data($table, $id)
	{
		$this->db->where('id', $id);
		$val = $this->db->delete($table); 
		
		if($val)
		{
			return true;
		}
	}
//============== Change Status===============// 
    function change_status_to($table, $stat_param, $id)
	{
		
		$this->db->where('id', $id);
		$val = $this->db->update($table, $stat_param);
		if($val)
		{
			return true;
		}
	}
//=============Insert Company Type============//
	function insert_company_value($table,$data)
	{
		$this->db->where('turnover',$data['turnover']);
		$query=$this->db->get($table);
		$num=$query->num_rows();
		if($num==0)
		{
			$this->db->insert($table,$data);
			return true;
		}
		else{
			return false;
		}
		
	}
//==============Get Company Details=======//
	function get_credit_rating($id)
	{
		$this->db->where('id',$id);
		$query=$this->db->get('annual_turnover');
		$num=$query->num_rows();
		if($num==1)
		{
			$result=$query->result();
			return $result;
		}
		
	}
//==========Update Data==============//
	function update_data($table,$id,$data)
	{
		$this->db->where('id',$id);
		$this->db->update($table,$data);
		return true;
	}
}
?>