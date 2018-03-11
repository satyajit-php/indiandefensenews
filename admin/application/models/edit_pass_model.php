<?php
class Edit_pass_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
    
    
    function get_row_by_id($table, $field_name, $field_vl)
	{
		$this->db->where($field_name, $field_vl);
		$this->db->from($table);
		$query = $this->db->get();
		
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;		
		}else{
			return 'false';
		}
	}
    //=========update doctor value======//
	function update_recordset($id,$data)
	{
		//echo $id;die();
	    $this->db->where('id', $id);
        $val =$this->db->update('admin', $data);
	    if($val)
	    {
	      return true;
	    }

	}
	//Generate random string 
	
	function generateRandomString($length = 10) {
	    
	    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
    public function get_record($table, $id)  
	{  
	   	$this->db->from($table);
		$this->db->where("id", $id);
		$query = $this->db->get();
	   	$result= $query->result();
	   	return $result;
	}
    // get vlaue according to multipul value
	function get_all_row($table, $where_arr)
	{
		$this->db->where($where_arr);
		$query = $this->db->get($table);
		$result= $query->result();
     	return $result;
	}
	
	function insert_data($table, $data)
	{
		$this->db->insert($table, $data);
		return true;
	}
	
	// use to delete the row of any table
	function delete($table, $del_arr)
	{
		$this->db->delete($table, $del_arr);
		return true;
	}

   
}
?>
