<?php
class Review_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	

	function review_options()
	{
        
        $option_type = array(1,2,3);
        $this->db->where_in('option_type', $option_type);
		$this->db->where('status','1');
        $this->db->order_by('option_type','ASC');
		$query = $this->db->get("review_option");
        
        if($query->num_rows>0)
		{
		     return $result=$query->result();
             
        }else{
            return false;
        }

		
	}
	function review_default_field_values($review_options_id)
	{
		
		$this->db->where('field_type',$review_options_id);
		$this->db->where('status','1');
		$query = $this->db->get("review_default_field_values");
        
        if($query->num_rows>0)
		{
		     return $result=$query->result();
             
        }else{
            return false;
        }
	}


	public function getCompanyDetails($companyID){
		
		$this->db->where('id', $companyID);
		$query =$this->db->get('company_details');
		
		if($query->num_rows>0)
		{
			
		   return $result=$query->result();	
		}
		
	        
	}
	function getDetailsByID($table,$field,$value)
	{
		$this->db->where($field, $value);
		$this->db->order_by("id", "DESC");
		$query =$this->db->get($table);
		
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
	
	function getDetailsLimit($table,$field,$value,$limit,$start)
	{
		
		$this->db->select($table.'.*,people.first_name,people.profile_pic');
		$this->db->from($table);
		$this->db->join('people', "people.id = $table.added_by");
        $this->db->where($field, $value);
		$this->db->order_by("$table.id", 'DESC');
		$this->db->limit($limit, $start);
		$query =$this->db->get();
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
	function getReviewbyID($reviewID,$companyID)
	{
		
		$this->db->select('company_review.*,people.first_name,people.profile_pic');
		$this->db->from('company_review');
		$this->db->join('people', "people.id = company_review.added_by");
		$this->db->where("company_review.id", $reviewID);
		$this->db->order_by("company_review.id", 'DESC');
		$query =$this->db->get();
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
	
	function updateFollow($companyID, $user_id){
		//echo $companyID;die;
		$this->db->where('user_id', $user_id);
		$this->db->where('company_id', $companyID);
		$result = $this->db->get('company_like');
		
		if($result->num_rows > 0){
			$resultNew = $result->row();
			//print_r($resultNew);die;
			if($resultNew->follow == 1){
				$followVal = 2;
			}
			else{
				$followVal = 1;
			}
			$data = array(
					'follow' => $followVal
				);
			$this->db->where('user_id', $user_id);
			$this->db->where('company_id', $companyID);
			$this->db->update('company_like', $data);
			
			return $followVal;
			
		}else{
			$data = array(
				      'user_id' => $user_id,
				      'company_id' => $companyID,
				      'like' => 0,
				      'follow' => 1
				);
			
			$result = $this->db->insert('company_like', $data);
			return 1;
		}
	}
	
	function getImageAndVideoByID($table,$field,$value)
	{
		$this->db->select($table.'.*,company_review.review_title');
		$this->db->from($table);
		$this->db->where($table.'.'.$field, $value);
		$this->db->join('company_review', "company_review.id = review_files.review_id");
		$this->db->order_by("$table.id", "DESC");
		$query =$this->db->get();
		
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
	function getDetails($table,$field,$value)       // get total count
	{
		
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('people', "people.id = $table.added_by");
                $this->db->where($field, $value);
		$this->db->order_by("$table.id", 'DESC');
		$query =$this->db->get();
	        return $query->num_rows;
		
	}
	
	function addImageUrl($field_name, $field_value, $review_id, $field_type){
	
		$data = array('review_id' => $review_id,
					  'company_id' => $this->input->post('company_id'),
				$field_name => $field_value);
		$this->db->insert('review_files', $data);
	}
	
	function add_review($table,$data) // add company details
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
		
	}
	
	function getreviewgidlines()     // get review details
	{
		 $query = $this->db->get_where('article', array('id' => 40,'status'=>0));
		 if($query->num_rows>0)
		 {
		    return $result=$query->result();		
		 }
	}
/************************* Thumbnail Function - start *************************/
    function thumbnail($fileThumb, $file, $Twidth, $Theight, $tag)
    {
	    list($width, $height, $type, $attr) = getimagesize($file);
      //	print_r( getimagesize($file));
      //   echo "type->".$type;
      //		echo "attrib->".$attr;
      //		die();
	    switch($type)
	    {
		    case 1:
		    $img = @ImageCreateFromGIF($file);
		    break;
    
		    case 2:
		    $img = @ImageCreateFromJPEG($file);
		    break;
    
		    case 3:
		    $img = @ImageCreateFromPNG($file);
		    break;
	    }
    
	    if($tag == "width") //width contraint
	    {
		    $Theight = round(($height/$width)*$Twidth);
	    }
	    elseif($tag == "height") //height constraint
	    {
		    $Twidth = round(($width/$height)*$Theight);
	    }
	    elseif($tag=="both")
	    {
		    $Twidth = $Twidth;
		    $Theight = $Theight;
	    }
	    else
	    {
		$old_x=imageSX($img);
		$old_y=imageSY($img);
	       
		// next we will calculate the new dimmensions for the thumbnail image
		// the next steps will be taken:
		// 1. calculate the ratio by dividing the old dimmensions with the new ones
		// 2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
		// and the height will be calculated so the image ratio will not change
		// 3. otherwise we will use the height ratio for the image
		// as a result, only one of the dimmensions will be from the fixed ones
		if(($old_x>$Twidth)||($old_y>$Theight))
		{
		    $ratio1=$old_x/$Twidth;
		    $ratio2=$old_y/$Theight;
		    if($ratio1>$ratio2)
		    {
			$thumb_w=$Twidth;
			$thumb_h=$old_y/$ratio1;
		    }
		    else
		    {
			$thumb_h=$Theight;
			$thumb_w=$old_x/$ratio2;
		    }
		}
		else
		{
		    $thumb_h=$old_y;
		    $thumb_w=$old_x;
		}
	    }
    
	    $thumb = @imagecreatetruecolor($thumb_w, $thumb_h);
    
	    if(@imagecopyresampled($thumb, $img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y))
	    {
		    switch($type)
		    {
			    case 1:
			    ImageGIF($thumb,$fileThumb);
			    break;
    
			    case 2:
			    ImageJPEG($thumb,$fileThumb);
			    break;
    
			    case 3:
			    ImagePNG($thumb,$fileThumb);
			    break;
		    }
    
		    return true;
	    }
    }
/************************* Thumbnail Function - Ends *************************/

	// Add Company review Comments/Problems
	function add_review_comments($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	// Mail to reviewer
	function reviewer_mail($review_id)
	{
		$this->db->select('*');
		$this->db->from('company_review');
		$this->db->join('people', 'company_review.added_by = people.id');
		$this->db->where('company_review.id',$review_id);
		$query = $this->db->get();
		return $result=$query->result();
	}
	// Mail to admin
	function admin_comp_email($table, $compID)
	{
		$query = $this->db->get($table);
		return $result=$query->result();
	}
	// Mail to company owner
	function comp_owner_email($companyID, $userID)
	{
		$this->db->select('*');
		$this->db->from('claim_owner');
		$this->db->join('claim_company_details', 'claim_company_details.company_id = claim_owner.company_id');
		$this->db->where('claim_company_details.company_id',$companyID);
		$this->db->where('claim_company_details.user_id',$userID);
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		return $result=$query->result();
		
	}
	function count_calculate($companyId)
	{
		$myIP =  $_SERVER['REMOTE_ADDR'];
		$currDate = date('Y-m-d');
		
		$this->db->where('ip',$myIP);
		$this->db->where('company_id',$companyId);
		$query =$this->db->get('company_details_view_count');
		$resultArray = $query->result();
		if(empty($resultArray))
		{
			$data = array(
					'ip' => $myIP,
					'lastDate' => $currDate,
					'company_id' => $companyId,
					'count' => 1
					);
			$this->db->insert('company_details_view_count', $data);
		}else{
			if($resultArray[0]->lastDate != $currDate)
			{
				$data = array(
					'lastDate' => $currDate,
					'count' => $resultArray[0]->count + 1
					);
				$this->db->where('id',$resultArray[0]->id);
				$this->db->update('company_details_view_count', $data);
			}
		}
		
	}
	
}
?>