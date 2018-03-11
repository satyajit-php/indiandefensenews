<?php
class Feedback_model extends CI_Model {	
	
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
    
    //================fetch all feedback================//
	
    function get_all_feedback()
	{
		$this->db->select('*');
		$this->db->from('feedback');
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;		
		}else{
			return 'false';
		}
	}

	//=================end fetch all feedback===============//
	
	 //====================start delete feedback==============//
	 
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
	 
	 //=====================end delete feedback================//
	 
	 //===================fetch particular feedback============//
	 function feedback_update($id)
	 {
		$this->db->select('*');
		$this->db->from('feedback');
        $this->db->where('id',$id);
	    $query = $this->db->get();
		$result=$query->row();
	    
		  return $result;
	    
	 }
	 
	 
	 //=================end fetched particular feedback========//
	
	
}
?>