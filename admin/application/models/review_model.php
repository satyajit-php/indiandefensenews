<?php
class Review_model extends CI_Model {	
	
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
    
    
    function get_row_by_id($table, $field_name, $field_vl)
	{
		$this->db->where($field_name, $field_vl);
		$this->db->from($table);
		$this->db->order_by($field_name, 'DESC');
		$query = $this->db->get();
		
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;		
		}else{
			return 'false';
		}
	}
	function get_row_by_numb($table, $field_name, $field_vl)
	{
		$this->db->where($field_name, $field_vl);
		$this->db->from($table);
		$query = $this->db->get();
		$num = $query->num_rows();
		
		return $num;
	}
	function get_motor_vendor($destnation_id)
	{
		$this->db->where('destination_id', $destnation_id);
		$this->db->where('vendor_type_id', 15);
		$this->db->from('vendor');
		$query = $this->db->get();
		
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;		
		}else{
			return 'false';
		}
	}
	function get_motor_coaches($vendor_id)
	{
		$this->db->where('vendor_list_id', $vendor_id);
		$this->db->where('product_type_id', 1);
		$this->db->from('product');
		$query = $this->db->get();
		
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;		
		}else{
			return 'false';
		}
	}
	function get_mela_vendor($destnation_id)
	{
		$this->db->where('destination_id', $destnation_id);
		$this->db->where('vendor_type_id', 21);
		$this->db->from('vendor');
		$query = $this->db->get();
		
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;		
		}else{
			return 'false';
		}
	}
	function get_event_vendor($destnation_id)
	{
		$this->db->where('destination_id', $destnation_id);
		$this->db->where('vendor_type_id', 23);
		$this->db->from('vendor');
		$query = $this->db->get();
		
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;		
		}else{
			return 'false';
		}
	}
	function get_hotel_vendor($destnation_id)
	{
		$this->db->where('destination_id', $destnation_id);
		$this->db->where('vendor_type_id', 20);
		$this->db->from('vendor');
		$query = $this->db->get();
		
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;		
		}else{
			return 'false';
		}
	}
	function get_hotel_product($vendor_id)
	{
		$this->db->where('vendor_list_id', $vendor_id);
		$this->db->where('product_type_id', 20);
		$this->db->from('product');
		$query = $this->db->get();
		
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;		
		}else{
			return 'false';
		}
	}
	//Generate random string for booking
	public function get_attraction()
	{
		
		$this->db->where('published',1);
		$q = $this->db->get('attraction');
		
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row)
			{
				$data[] = $row;
			}
			
			return $data;
		}
	}
	public function get_destination()
	{
		
		$this->db->where('status', 1);
		$this->db->where('parent_id', 0);
		$q = $this->db->get('destination');
		
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row)
			{
				$data[] = $row;
			}
			
			return $data;
		}
	}
	public function get_destination_all()
	{
		
		$this->db->where('status', 1);
		$q = $this->db->get('destination');
		
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row)
			{
				$data[] = $row;
			}
			
			return $data;
		}
	}
	public function get_city()
	{
		
		$this->db->where('status',1);
		$q = $this->db->get('city_management');
		
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row)
			{
				$data[] = $row;
			}
			
			return $data;
		}
	}
	public function get_room_typ()
	{
		
		$this->db->where('status',1);
		$q = $this->db->get('room_type');
		
		if($q->num_rows() > 0)
		{
			foreach ($q->result() as $row)
			{
				$data[] = $row;
			}
			
			return $data;
		}
	}
	
	function update_booking_details_id($booking_id)
	{
		$data=array(
			'proposal'=>1,
		);
		$this->db->where('id',$booking_id);
		$this->db->update('booking_details',$data);
	}
	function del_data($table, $id)
	{
		$this->db->where('booking_id', $id);
		$val = $this->db->delete($table); 
		// echo $this->db->last_query();
		// die();
		if($val)
		{
			return true;
		}
	}
	
	
	//============= Upate the value ============//
	function update_value($table, $arr, $field_name, $field_value)
	{
		$this->db->where($field_name, $field_value);
		$val = $this->db->update($table, $arr);
		
		if($val)
		{
			return true;
			
		}else{
			
			return false;
		}
	}
	
	//============= Upate the proposal value of booking  and booking details tables============//
	
	
	// to get the value from table order by field name 
	function get_all_row_oder_by($table, $field_name, $field_value)
	{
		$this->db->from($table);
       	$this->db->order_by($field_name, $field_value);
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
	
	function get_all_rows($table, $where_arr, $order_by_field, $order_by)
	{
		$this->db->where($where_arr);
		$this->db->from($table);
		if($order_by_field != '')
		{	
			$this->db->order_by($order_by_field, $order_by);
		}
		$query = $this->db->get();
				
		$val = $query->result();
		return $val;
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