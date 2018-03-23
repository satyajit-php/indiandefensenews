<?php
class Article_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
    /**
    * Validate the login's data with the database
    * @param string $user_name
    * @param string $password
    * @return void
    */
	//==========fetch data from article table===========//
	function get_article_value()
	{
		$this->db->from('article');
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;
		
		}
	}
	
	//=========insert article value======//
	function insert_article_value($table, $data)
	{
		$this->db->where('title', $data['title']);
		$this->db->where('type', $data['type']);
		$query = $this->db->get('article');
		
		if($query->num_rows == 0)
		{
			$insrt = $this->db->insert($table, $data);
			return '1';
		}
		else
		{
			return '0';
		}
	}

	//=============changin the status of article============//
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

	//=============delete data from article============//
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
	//=============fetch data from article for updating particular rows ============//
	function sel_data_up($id)
	{
		$this->db->where('id',$id);
	   	$rslt = $this->db->get('article');
	    return $rslt->result();
		//echo"<pre>";
		//print_r($rslt);
		//die();
	}
	//=========update article value======//
	function update_article_value($table, $id, $data_to_store)
	{
		$this->db->where('type', $data_to_store['type']);
		$this->db->where('title', $data_to_store['title']);
		$this->db->where('id !=', $id);
		$query = $this->db->get('article');
		if($query->num_rows == 0)
		{
			$this->db->where('id', $id);
			$val = $this->db->update($table,$data_to_store);
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>