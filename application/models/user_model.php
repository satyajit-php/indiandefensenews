<?php
class User_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	

	function get_user_profile_data($user_id)
	{
        //will not validate user as he is already logged In
        
		$this->db->where('id',$user_id);
		$query = $this->db->get("people");
        
        if($query->num_rows == 1)
		{
		     return $result=$query->result();
             
        }else{
            return false;
        }

		
	}

	

	
}
?>