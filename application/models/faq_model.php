<?php
class Faq_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	
	//=========fetch data from country============//
	
 
	public function g_faq()  
	{
		
	   	$this->db->from('faq_types');
		$this->db->where('status',1);
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
	   	$result= $query->result_array();
	   	return $result;
	}
	
   
   public function select_faq($r)  
	{
        $st=1;
	   	$query=$this->db->query("select f.*,ft.name  from faq as f,faq_types as ft where f.faq_type=ft.id and ft.name='".$r."' and ft.status='".$st."' and f.status='".$st."' order by id desc ");
		$query=$query->result_array();
		return $query;
	}

	
	public function filter_faq($id)  
	{
		
	   	$this->db->from('faq');
		$this->db->where('faq_type',$id);
        $this->db->where('status',1);
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
	   	$result= $query->result_array();
	   	return $result;
	}
	


}
?>