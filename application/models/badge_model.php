<?php
class badge_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	//function badgeAchieveRules($uid) {
	//	$this->db->where('added_by', $uid);
	//	$result = $this->db->get('company_review');
	//	if($result->num_rows > 0) {
	//		
	//		switch ($result->num_rows) {
	//			case label1:
	//			    code to be executed if n=label1;
	//			    break;
	//			case label2:
	//			    code to be executed if n=label2;
	//			    break;
	//			case label3:
	//			    code to be executed if n=label3;
	//			    break;
	//			default:
	//			    code to be executed if n is different from all labels;
	//		}
	//	}
	//}
	
	//function badgeAchieved($uid) {
	//	$this->db->where('user_id', $uid);
	//	$this->db->join('badge_details', '');
	//	$result = $this->db->get('badges');
	//	
	//	if($result->num_rows > 0) {
	//		
	//	}
	//	
	//}
	
	function getallbadges()     // get all my badges details from badge table
	{
		$this->db->select('*');
		$this->db->where("status",1);
		$query=$this->db->get('badge_details');
		if($query->num_rows>0)
		{
			 return $result=$query->result();	
		}
	}
	function getPeopleAll($uid)     // get all my badges details from badge table
	{
		$this->db->select('first_name,last_name');
		$this->db->where("id",$uid);
		$query=$this->db->get('people');
		if($query->num_rows>0)
		{
			 $result=$query->result();
			 return $result[0]->first_name.' '.$result[0]->last_name;
		}
	}
	function getmy_score($uid)         // get my badge score
	{
	    $this->db->select('*');
	    $this->db->where("added_by",$uid);
	    $query=$this->db->get('company_review');
	    if($query->num_rows>0)
	    {
		 if($query->num_rows>100 || $query->num_rows==100)    // this special checking for the monk reviewere
		 {
			$this->db->select('*');
			$this->db->where("added_by",$uid);
			$this->db->where("flag",0);
			$query=$this->db->get('company_review');
			return $query->num_rows;
		 }
		 else{
		     return $query->num_rows;	
		 }
	    }
	    else
	     return 0;
	}
	
	function showreviewname($num)  // show reviewer tag
	{
		  $this->db->select('*');
		  $this->db->where('review_count <',$num);
		  $this->db->or_where('review_count',$num);
		  $query = $this->db->get('badge_details',1,0);
		 // echo $this->db->last_query();
		  if($query->num_rows >0)
			{
				return $query->result();	
			}
		
	}
	function total_rating($id)    // calculate indivisual rating
	{
	  $this->db->select('overall_pay_exp');
	  $this->db->where("added_by",$id);
	  $query = $this->db->get('company_review');
	  if($query->num_rows >0)
	  {
		$total=0;
		$overall=$query->result();
		
		
		foreach($overall as $row)
		{
		  $total+=$row->overall_pay_exp;	
		}
		
		return $result=$total/$query->num_rows;
	  }
	  else{
		return $result=0;
	  }
	}
	
	
	
	
}
?>