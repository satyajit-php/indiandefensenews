<?php
class all_indus_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
        
        function get_all_industries()
        {
            $this->db->select('*');
            $this->db->from('industry_type');
	    $this->db->order_by("pid", "DESC");
            $query = $this->db->get();
            if($query->num_rows > 0)
		{
			return $query->result();
		}
        }
        
        //=============delete data from industry============//
	function del_data($table, $id)
	{
		$this->db->where('pid', $id);
		$val = $this->db->delete($table); 
		if($val)
		{
			return true;
		}
	}
        //=============changin the status of industry============//
        
        function change_status_to($table, $stat_param, $id)
	{
		$this->db->where('pid', $id);
		$val = $this->db->update($table, $stat_param);
		 //echo $this->db->last_query();
		 //die();
		if($val)
		{
			return true;
		}
	}
        function get_industry($id)         //  show data for edit page
	{
                 $this->db->where('pid',$id);
		 $query = $this->db->get('industry_type');
		 return $query->result();
				
	}
        
        function update_industry($data,$id)
        {
           
            $this->db->where('type',$data['type']);
            $query = $this->db->get('industry_type');
	    if($query->num_rows==0)
            {
                $this->db->where('pid', $id);
                $val = $this->db->update('industry_type', $data);
                return true;
            }
        }
	
	//=========insert CSV file value======//
	function insert_csv($table, $data)
	{
		$this->db->where('type', $data['type']);
		$query = $this->db->get('industry_type');
		
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
}
?>