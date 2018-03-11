<?php
class Indus_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

    
	function get_all_data()      // get all indus tries data
	{
		
		//$query=$this->db->query("SELECT * FROM industry_type	LEFT JOIN sub_industry_type ON industry_type.pid=sub_industry_type.industry_type ORDER BY industry_type.type;");
		
		
		$this->db->select('*');
		$this->db->from('sub_industry_type');
		$this->db->join('industry_type', 'industry_type.pid = sub_industry_type.industry_type');
		$this->db->order_by('sub_industry_type.id','DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();
		//die();
		if($query->num_rows > 0)
		{
			return $query->result();
		}
              
		
	}
	
	
	function get_single_data($id)         //  show data for edit page
	{
		$this->db->select('*');
                $this->db->from('industry_type');
                $this->db->join('sub_industry_type', 'industry_type.pid = sub_industry_type.industry_type','left');
		$this->db->where('industry_type.pid', $id);
	        $query = $this->db->get();
		if($query->num_rows > 0)
		{
			return $query->result();
		}
	}
	
	function insert_indus($table,$data_to_insert,$type)     // insert industres
	{
		//print_r($data_to_insert);
		//die();
		$this->db->select('*');
		$this->db->from($table);
		if($type==1)      // for industres
		{
		  $this->db->where('pid',$data_to_insert['pid']);
		  $this->db->or_where('type',$data_to_insert['type']);	
		}
		else                  // for sub_industry
		{
			$this->db->where('subtype_name',$data_to_insert['subtype_name']);
			
		}
		
		$query=$this->db->get();
	
		if($query->num_rows ==0)
		{
		   $insert_customer = $this->db->insert($table, $data_to_insert);
			if($insert_customer)
			{
			return true;
			}	
		}
		
	    
	}
	
	
	function change_status_to($table, $stat_param, $id)
	{
		$this->db->where('id', $id);
		$val = $this->db->update($table, $stat_param);
		 //echo $this->db->last_query();
		 //die();
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
		 //echo $this->db->last_query();
		 //die();
		if($val)
		{
			return true;
		}
	}
	
	function upd_data($data)
	{
		$this->db->where('pid', $data['pid']);
	    $data_store=array("type"=>$data['type'],
						  "pstatus"=>$data['pstatus']);	
		$val = $this->db->update('industry_type', $data_store);
								
		$this->db->select('*');
		$this->db->from('sub_industry_type');
		$this->db->where('industry_type',$data['pid']);
		$query=$this->db->get();
	
		if($query->num_rows>0)
		{
		$this->db->where('industry_type', $data['pid']);
	    $data_store=array(
						  "subtype_name"=>$data['subtype_name']);	
		$val = $this->db->update('sub_industry_type', $data_store);	
		}
		else
		{
			$data_store=array("subtype_name"=>$data['subtype_name'],
					  "industry_type"=>$data['pid']);
		       $val = $this->db->insert('sub_industry_type', $data_store);	
		}
	
		return $val;
	}
	
	function insert_industry($data)
	{
		
		 $val=0;
		 $ind=$data['type'];
		 $this->db->where('type',$ind);
		 $query=$this->db->get('industry_type');
		 $count=$query->num_rows();
		 if($count==0)
		 {
		    $val = $this->db->insert('industry_type', $data);
		     return true;
		 }
		else
		{
			return false;
		}
		
	}
	function get_ind_industry($id)         //  show data for edit page
	{
		       
		        $this->db->where('pid', $id);
	            $query = $this->db->get('industry_type');
				if($query->num_rows > 0)
				{
					return $query->result();
				}
	}
	function update_industry($data)
	{
		 $val=0;
		 $ind=$data['type'];
		 $this->db->where('type',$ind);
		 $query=$this->db->get('industry_type');
		 $count=$query->num_rows();
		 if($count==0)
		 {
			$this->db->where('pid', $data['pid']);
		    $val = $this->db->update('industry_type', $data_store);
		 }
		
		 return $val;
	}
	function get_all_industry( )         //  show data for edit page
	{
		 $query = $this->db->get('industry_type');
		 return $query->result();
				
	}
	function get_ind_subind($id)         //  show data for edit page
	{
		       
		        $this->db->where('id', $id);
	            $query = $this->db->get('sub_industry_type');
				if($query->num_rows > 0)
				{
					return $query->result();
				}
	}
	function insert_subindustry($data)
	{
		$this->db->where('industry_type',$data['industry_type']);
		$this->db->where('subtype_name',$data['subtype_name']);
		$query = $this->db->get('sub_industry_type');
		if($query->num_rows==0)
		{
			$val = $this->db->insert('sub_industry_type', $data);
			return true;
		}
	}
	function upd_subindustry($data,$id)
	{
		 $val=0;
		 $this->db->where('id !=',$id);
		 $this->db->where('industry_type',$data['industry_type']);
		 $this->db->where('subtype_name',$data['subtype_name']);
		 $query=$this->db->get('sub_industry_type');
		 $count=$query->num_rows();
		 if($count==0)
		 {
			$this->db->where('id', $id);
		    $val = $this->db->update('sub_industry_type', $data);
		 }
		
		 return $val;
	}
	
	
	
	//=========insert CSV file value======//
	function insert_csv($table, $data)
	{
		$this->db->where('industry_type',$data['industry_type']);
		$this->db->where('subtype_name',$data['subtype_name']);
		$query = $this->db->get('sub_industry_type');
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
	
	function get_all_subindustries()
	{
	    $this->db->select('*');
            $this->db->from('sub_industry_type');
	    $this->db->order_by("id", "DESC");
            $query = $this->db->get();
            if($query->num_rows > 0)
		{
			return $query->result();
		}
	}
}
?>