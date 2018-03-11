<?php
class Blog_tag_model extends CI_Model {

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
	function get_blog_value()
	{
		$this->db->from('blog_tag');
		//$this->db->where('status',1);
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;
		
		}
	}
	
	function get_all_tag()
	{
		$this->db->from('blog_tag');
		$this->db->where('status',1);
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;
		
		}
	}
	
	function get_blog_tag($id)
	{
		$this->db->from('blog_tag');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;
		
		}
	}
	
	//=========insert article value======//
	function insert_blog_value($table, $data)
	{
		$this->db->where('tag_name', $data['tag_name']);
		$query = $this->db->get('blog_tag');
		
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
	

	//=========update article value======//
	function update_blog_value( $id, $data_to_store)
	{
		$this->db->where('tag_name', $data_to_store['tag_name']);
		$this->db->where('id !=', $id);
		$query = $this->db->get('blog_tag');
		if($query->num_rows == 0)
		{
			$this->db->where('id', $id);
			$val = $this->db->update('blog_tag',$data_to_store);
			return true;
		}
		else
		{
			return false;
		}
	}
   
 
  
  
}
?>