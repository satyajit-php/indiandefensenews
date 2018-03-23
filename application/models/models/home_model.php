<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); 

class Home_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	//=========fetch data from quote============//
	public function get_quote()
	{
	  	$this->db->from('quote');
		$this->db->where('status',1);
		$this->db->order_by("added_on", "DESC");
		$query = $this->db->get();
	   	$result= $query->result();
	   	return $result;
	}
}
?>
        