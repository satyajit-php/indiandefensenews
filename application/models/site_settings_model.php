<?php
class Site_settings_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	//=========== Select data from site_settings table============//
	function site_getdata()
	{
		$site_settings_query = $this->db->get('site_settings');
		$val = $site_settings_query-> result();
		return $val;
	}
	
	//=========== Update data of site_settings table============//
	function update_data($table, $data_to_updt)
	{
		$this->db->where('id', '1');
		$val = $this->db->update($table, $data_to_updt);
		if($val)
		{
			return true;
		}
	}
}
?>