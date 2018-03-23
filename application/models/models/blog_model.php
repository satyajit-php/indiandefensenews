<?php
class Blog_model extends CI_Model {

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
		$this->db->from('blog');
		$this->db->order_by("id", "DESC");
		$this->db->where('status',1);
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
		$this->db->where('blog_title', $data['title']);
		$query = $this->db->get('blog');
		
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


	//=============fetch data from article for updating particular rows ============//
	function sel_data_up($id)
	{
		$this->db->where('id',$id);
	   	$rslt = $this->db->get('blog');
	    return $rslt->result();
		//echo"<pre>";
		//print_r($rslt);
		//die();
	}
	function insert_comment($table,$data)
	{
		$insrt = $this->db->insert($table, $data);
		if($insrt)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


/************************* Thumbnail Function - Ends *************************/
}
?>