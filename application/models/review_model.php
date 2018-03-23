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
		else
		return false;
		
	        
	}
	function getDetailsByID($table,$field,$value)
	{
		$this->db->where($field, $value);
		if($table != "industry_type" && $table != "location")
		{
			$this->db->order_by("id", "DESC");
		}
		if($table == "sub_industry_type")
		{
			$this->db->where("status", "1");
		}
		$query =$this->db->get($table);
		
		if($query->num_rows>0)
		{
		   return $result=$query->result();
		   $this->db->last_query();
		}
		else
		{
		return $result=0;	
		}
		
	}

	function getratingPerReviewForDisable($table,$field,$value)
	{
		$this->db->where($field, $value);
		$this->db->where('disable', '0');
		$query =$this->db->get($table);
		
		if($query->num_rows>0)
		{
		   return $result=$query->result();
		   $this->db->last_query();
		}
		else
		{
		return $result=0;	
		}
		
	}
	
	function getDetailsLimit($table,$field,$value,$limit,$start,$fieldOrder,$ascDesc,$flag)
	{
		
		$this->db->select($table.'.*,people.first_name,people.last_name,people.address,people.profile_pic,people.registered_on,people.status,company_details.company_name');
		$this->db->from($table);
		$this->db->join('people', "people.id = $table.added_by");
		$this->db->join('company_details', "company_details.id = $table.company_id");
        $this->db->where($field, $value);
		$this->db->where($table.'.disable', '0');
		if($flag== 'load')
		{
			$this->db->order_by("$table.id", 'DESC');
		}
		else{
			$this->db->order_by("$table.$fieldOrder", $ascDesc);
		}
		$this->db->limit($limit, $start);
		$query =$this->db->get();
		//echo $this->db->last_query();die;
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
		function getDetailsLimitWithoutAnno($table,$field,$value,$limit,$start,$fieldOrder,$ascDesc,$flag)
	{
		
		$this->db->select($table.'.*,people.first_name,people.last_name,people.address,people.profile_pic,people.registered_on,people.status,company_details.company_name');
		$this->db->from($table);
		$this->db->join('people', "people.id = $table.added_by");
		$this->db->join('company_details', "company_details.id = $table.company_id");
        $this->db->where($table.'.'.$field, $value);
		$this->db->where($table.'.disable', '0');
		$this->db->where($table.'.anno_review', 0);
		if($flag== 'load')
		{
			$this->db->order_by("$table.id", 'DESC');
		}
		else{
			$this->db->order_by("$table.$fieldOrder", $ascDesc);
		}
		$this->db->limit($limit, $start);
		$query =$this->db->get();
		//echo $this->db->last_query();die;
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
	function getDetailsLimitComment($table,$field,$value,$limit,$start)
	{
		
		$this->db->select($table.'.*,people.first_name,people.last_name,people.address,people.profile_pic,company_review.review_title,company_review.added_on,company_review.additional_feedback,company_review.overall_pay_exp,company_review.anno_review,company_review.added_by,company_review.company_id');
		$this->db->from($table);
		$this->db->join('people', "people.id = $table.comment_by");
		$this->db->join('company_review', "company_review.id = $table.review_id");
        $this->db->where($table.'.'.$field, $value);
		$this->db->limit($limit, $start);
		$query =$this->db->get();
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
	function getDetailsLimitCommentWithoutAnno($table,$field,$value,$limit,$start)
	{
		
		$this->db->select($table.'.*,people.first_name,people.last_name,people.address,people.profile_pic,company_review.review_title,company_review.added_on,company_review.additional_feedback,company_review.overall_pay_exp,company_review.anno_review,company_review.added_by,company_review.company_id');
		$this->db->from($table);
		$this->db->join('people', "people.id = $table.comment_by");
		$this->db->join('company_review', "company_review.id = $table.review_id");
        $this->db->where($table.'.'.$field, $value);
		$this->db->where('company_review.anno_review', 0);
		$this->db->limit($limit, $start);
		$query =$this->db->get();
		
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
	function getDetailsLimitCommentCount($table,$field,$value)
	{
		
		$this->db->select($table.'.*,people.first_name,people.last_name,people.address,people.profile_pic,company_review.review_title,company_review.additional_feedback,company_review.overall_pay_exp,company_review.anno_review,company_review.added_by,company_review.company_id');
		$this->db->from($table);
		$this->db->join('people', "people.id = $table.comment_by");
		$this->db->join('company_review', "company_review.id = $table.review_id");
        $this->db->where($table.'.'.$field, $value);
		$query =$this->db->get();
		return $query->num_rows;
		
	}
	function getDetailsLimitCommentCountWithoutAnno($table,$field,$value)
	{
		
		$this->db->select($table.'.*,people.first_name,people.last_name,people.address,people.profile_pic,company_review.review_title,company_review.additional_feedback,company_review.overall_pay_exp,company_review.anno_review,company_review.added_by,company_review.company_id');
		$this->db->from($table);
		$this->db->join('people', "people.id = $table.comment_by");
		$this->db->join('company_review', "company_review.id = $table.review_id");
        $this->db->where($table.'.'.$field, $value);
		
		$this->db->where('company_review.anno_review', 0);
		$query =$this->db->get();
		//echo $this->db->last_query();die;
		return $query->num_rows;
		
	}
	
	function getDetailsOrder($table,$field,$value,$limit,$start,$fieldOrder,$ascDesc)
	{
		$this->db->select($table.'.*,people.first_name,people.profile_pic');
		$this->db->from($table);
		$this->db->join('people', "people.id = $table.added_by");
        $this->db->where($field, $value);
		
		$this->db->order_by("$table.$fieldOrder", $ascDesc);
		$this->db->limit($limit, $start);
		
		$query =$this->db->get();
		//echo $this->db->last_query();die;
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
	function getReviewbyID($reviewID,$companyID)
	{
		
		$this->db->select('company_review.*,people.first_name,people.profile_pic,usual_pays.usual_pay,credits_allowed.credit_allow,payment_method.pay_method,company_details.company_name');
		$this->db->from('company_review');
		$this->db->join('people', "people.id = company_review.added_by");
		$this->db->join('usual_pays',"company_review.usuall_pay = usual_pays.id",'left');
		$this->db->join('credits_allowed',"company_review.credit_allow = credits_allowed.id",'left');
		$this->db->join('payment_method',"company_review.pay_method = payment_method.id",'left');
		$this->db->join('company_details',"company_details.id = company_review.company_id",'left');
		$this->db->where("company_review.id", $reviewID);
		$this->db->order_by("company_review.id", 'DESC');
		$query =$this->db->get();
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
	
	function followCount($companyID, $user_id){
		
		$this->db->where('user_id', $user_id);
		$this->db->where('company_id', $companyID);
		$result = $this->db->get('company_like');
		
		if($result->num_rows > 0){
			$resultNew = $result->row();
			if($resultNew->follow == 1){
				$followVal = 1;
			}
			else{
				$followVal = 2;
			}
		}else{
			$followVal = 2;
		}
		return $followVal;
	}
	
	function updateCompanyLike($company_id,$like_count,$status) {
		if($status == 'like') {
			
			$this->db->where('company_id', $company_id);
			$this->db->where('user_id', $this->session->userdata('uid'));
			$result = $this->db->get('company_like');
			if($result->num_rows > 0){
				$data = array('like' => 1);
				
				$this->db->where('company_id', $company_id);
				$this->db->where('user_id', $this->session->userdata('uid'));
				$this->db->update('company_like', $data);
			}else{
				$data = array('like' => 1,
					      'company_id' => $company_id,
					      'user_id' => $this->session->userdata('uid'),
					      'follow' => 0
					);
				$this->db->insert('company_like', $data);
			}
			
			
			
		}else if($status == 'unlike'){
			
			$this->db->where('company_id', $company_id);
			$this->db->where('user_id', $this->session->userdata('uid'));
			$result = $this->db->get('company_like');
			if($result->num_rows > 0){
				$data = array('like' => 2);
				
				$this->db->where('company_id', $company_id);
				$this->db->where('user_id', $this->session->userdata('uid'));
				$this->db->update('company_like', $data);
			}else{
				$data = array('like' => 2,
					      'company_id' => $company_id,
					      'user_id' => $this->session->userdata('uid'),
					      'follow' => 0
					);
				$this->db->insert('company_like', $data);
			}
		}
		
		return $this->likeUnlikeCount($company_id);
	}
	
	function likeUnlikeCount($companyID){
		$this->db->where('like', 1);
		$this->db->where('company_id', $companyID);
		$like = $this->db->get('company_like');
		$data['like'] = $like->num_rows;
		
		$this->db->where('like', 2);
		$this->db->where('company_id', $companyID);
		$unlike = $this->db->get('company_like');
		$data['unlike'] = $unlike->num_rows;
		
		return $data;
	}
	
	//================function for get like unlike count==================//
	
	function getLikeUnlikeCount($reviewid)
	{
		$this->db->where('likeUnlike', 1);
		$this->db->where('review_id', $reviewid);
		$like = $this->db->get('review_like');
		$data['like'] = $like->num_rows;
		
		//$this->db->where('likeUnlike', 2);
		//$this->db->where('review_id', $reviewid);
		//$this->db->where('uid !=', $this->session->userdata('uid'));
		//$unlike = $this->db->get('review_like');
		//$data['unlike'] = $unlike->num_rows;
		
		return $data;
	}
	
	//===============end function for get like unlike count===============//
	
	function getReviewImgVideo($reviewID, $companyID){
		$this->db->where('company_id', $companyID);
		$this->db->where('review_id', $reviewID);
		$result = $this->db->get('review_files');
		
		if($result->num_rows > 0){
			return $result->result();
		}else{
			return 0;
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
			$lastInsertID = $this->db->insert_id();
			$notificationSendAdmin = $this->login_model->sendNotification(11, $this->session->userdata('uid'), 0,'company_like', $lastInsertID);
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
		
		$this->db->select('company_review.*');
		$this->db->from($table);
		//$this->db->join('people', "people.id = $table.$field");
        $this->db->where($field, $value);
		$this->db->where('company_review.disable','0');
		//$this->db->where('company_review.anno_review',0);
		$this->db->order_by("$table.id", 'DESC');
		$queries =$this->db->get();
		//echo $this->db->last_query();die;
		
		//echo $queries->num_rows;echo "asdf";die;
	        return $queries->num_rows;
		
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
	
	function getCalculateAvgReview($companyID){
		$this->db->select_avg('overall_pay_exp');
		$this->db->where('id', $companyID);
		$this->db->where('disable', 1);
		$q = $this->db->get('company_review');
		
		$qResult = $q->row();
		$avgPayexp = $qResult->overall_pay_exp;
		if(isset($avgPayexp) && ($avgPayexp > 0)){
			$avgPayexpValue = $avgPayexp;
		}else{
			$avgPayexpValue = 0.00;
		}
		
		$this->db->where('id', $companyID);
		$this->db->update('company_details', array('average_rating' => $avgPayexpValue));
		
	}
	
	function getreviewgidlines()     // get review details
	{
		 $query = $this->db->get_where('article', array('id' => 40,'status'=>0));
		 if($query->num_rows>0)
		 {
		    return $result=$query->result();		
		 }
	}
	
	public function checkActiveCompany($companyID){
		$this->db->where('status', 1);
		$this->db->where('id', $companyID);
		$q = $this->db->get('company_details');
		if($q->num_rows > 0){
			return 1;
		}else{
			return 0;
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
	function getCommentsByReview($reviewID,$uid=null)
	{
		$this->db->select('review_comment.*,people.first_name,people.last_name,people.profile_pic,people.email,people.id as peopleID');
		$this->db->from('review_comment');
		$this->db->where('review_comment.review_id', $reviewID);
		$this->db->where('review_comment.seen', 1);
		if($uid !="")
		{
			$this->db->where('review_comment.comment_by', $uid);
		}
		$this->db->join('people', "people.id = review_comment.comment_by");
		$query =$this->db->get();
		
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
	function getLikeReview($reviewID)
	{
		$this->db->select('review_like.*');
		$this->db->where('review_id', $reviewID);
		$this->db->where('uid', $this->session->userdata('uid'));
		$query =$this->db->get('review_like');
		
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
	function getupdateInsertLike($reviewID,$value)
	{
			$this->db->where('review_id', $reviewID);
			$this->db->where('uid', $this->session->userdata('uid'));
			$result = $this->db->get('review_like');
			if($result->num_rows > 0){
				$data = array('likeUnlike' => $value);
				
				$this->db->where('review_id', $reviewID);
				$this->db->where('uid', $this->session->userdata('uid'));
				$this->db->update('review_like', $data);
			}else{
				$data = array('likeUnlike' => $value,
					      'review_id' => $reviewID,
					      'uid' => $this->session->userdata('uid')
					);
				$this->db->insert('review_like', $data);
			}
			
			return $this->getLikeUnlikeCount($reviewID);
	}
	
	function getSameIndus($getIndustryTypeId)
	{
	$query = $this->db->query("SELECT company_details.id,company_details.company_name,SUM(`company_review`.`overall_pay_exp`) AS `overall_pay_exp`,count(`company_review`.`company_id`) as `totalreview`
		FROM company_details
		LEFT JOIN company_review ON company_review.company_id = company_details.id
		Where company_details.industry_type = '".$getIndustryTypeId."'
		AND company_details.parent_id = 0 AND company_details.status = 1
		GROUP BY `company_details`.id");
		
		return $queryResult = $query->result();
	}
	function getSameIndusLastUpdate($getIndustryTypeId)
	{
	$query = $this->db->query("SELECT id,company_name,average_rating
		FROM company_details
		Where company_details.industry_type = '".$getIndustryTypeId."'
		AND company_details.parent_id = 0 AND company_details.status = 1
		ORDER BY rand() Limit 0,6");
		
		return $queryResult = $query->result();
	}
	function getSameIndusCompanyLAst()
	{
		
	}
	
	function getSameIndusType($companyId)
	{
		$this->db->select('company_details.industry_type');
		$this->db->where('id', $companyId);
		$query =$this->db->get('company_details');
		
		if($query->num_rows>0)
		{
		   return $result=$query->result();	
		}
	}
	
	function getall_abuse()    // collect abusive languages
	{
	    $this->db->select('*');
	    $this->db->where('status', 1);
	    $query =$this->db->get('bad_lang');
		
		if($query->num_rows>0)
		{
		   return $result=$query->result_array();	
		}
	}
	
	function count_review($uid,$companyid)    // check if 4 review is added or not
	{
		$this->db->select('*');
		$this->db->where('added_by',$uid);
		$this->db->where('company_id',$companyid);
		$this->db->where('YEAR(added_on) = YEAR(CURDATE())');
		$query = $this->db->get('company_review');
		echo $this->db->last_query();
		//echo $query->num_rows;
		if($query->num_rows >= 4)
		{
			return 1;
		}
		else
		return 0;
	}
	
	function getUsualPays()
	{
		$this->db->select('*');
		$query = $this->db->get('usual_pays');
		return $result=$query->result();	
	}
	
	function getCreditAllowed()
	{
		$this->db->select('*');
		$query = $this->db->get('credits_allowed');
		return $result=$query->result();	
	}
	
	function getPayMethod()
	{
		$this->db->select('*');
		$query = $this->db->get('payment_method');
		return $result=$query->result();	
	}
	function collectdata_database($select,$id)     // get all data from the data base
	{
		
		$this->db->select($select);
		$this->db->where('company_id',$id);
		$this->db->where('disable','0');
		$query = $this->db->get('company_review');
		if($query->num_rows >0)
		return $result=$query->result();
		else
		return 0;
	}
	function getAlertForCompany($companyID)
	{
		$today = date("Y-m-d");
		$this->db->select('*');
		$this->db->where('company_id',$companyID);
		$this->db->where('status','visible');
		$query = $this->db->get('make_alert');
		if($query->num_rows >0)
		{
			$result=$query->result();
			if($result[0]->view_type=="specific" && $result[0]->visible_to >= $today && $result[0]->visible_form <= $today || $result[0]->view_type=="always")
			{
				return $result[0]->notice;
			}
			else{
				return 0;
			}
		}
		else
		{
			return 0;
		}
		
	}
	function getReviewPeruid($uid)
	{
		$query = $this->db->query('SELECT  `overall_pay_exp` AS NUM, COUNT(overall_pay_exp) AS Count FROM company_review WHERE `added_by` ='.$uid.' AND `disable` = "0" GROUP BY NUM');
		if($query->num_rows >0)
			return $result=$query->result();
		else
			return 0;
	}
	function getReviewPercompanyID($companyID)
	{
		$query = $this->db->query('SELECT  `overall_pay_exp` AS NUM, COUNT(overall_pay_exp) AS Count FROM company_review WHERE `company_id` ='.$companyID.' GROUP BY NUM');
		if($query->num_rows >0)
			return $result=$query->result();
		else
			return 0;
	}
	function getTotalLike_peruid($uid)
	{
		$query = $this->db->query('SELECT SUM(`like`) AS AllLike FROM company_like WHERE `user_id` ='.$uid.' AND `like`=1 ');
		if($query->num_rows >0)
			return $result=$query->result();
		else
			return 0;
	}
	function getTotalLike_percompanyID($companyID)
	{
		$query = $this->db->query('SELECT SUM(`like`) AS AllLike FROM company_like WHERE `company_id` ='.$companyID.' AND `like`=1 ');
		if($query->num_rows >0)
			return $result=$query->result();
		else
			return 0;
	}
	function getCompanyClaimedOrNot($companyID)
	{
		$this->db->where('company_id',$companyID);
		//$this->db->where('claim_id',$this->session->userdata('uid'));
		$this->db->where('status',1);
		$query = $this->db->get('claim_owner');
		return $query->num_rows;
	}
	function getAchieveBadgeOrNotForNotification($reviewCount)
	{
		$this->db->select('*');
		$this->db->where('review_count',$reviewCount);
		$this->db->where('status',1);
		$query = $this->db->get('badge_details');
		$totalArray = $query->result();
		$data['numberRow'] = $query->num_rows;
		$data['Array'] = $totalArray;
		return $data;
	}
	
	
	function getDetailsParticularField($table,$field,$value,$getfieldname)
	{
		$this->db->where($field, $value);
		$query =$this->db->get($table);
		$result=$query->result();
		if($query->num_rows>0)
		{
			return $result[0]->$getfieldname;	
		}
		else
		{
			return $result=0;	
		}
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
	function getLastYearData($comapnyID,$month,$year)
	{
		$monthArray = array();
		$resultantArray = array();
		$Currentdate = date('d');
		 $a_date = $year."-".$month."-".$Currentdate;
		// $end_day=date("Y-m-t", strtotime($a_date));
		 $end_day = date("Y-m-d", strtotime("-11 months", strtotime($a_date)));
		// $allmonth = Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		 for ($i=0; $i<12; $i++) {
			if($month == 0)
			{
				$month = 12;
			}
			array_push($monthArray,$month);
			$query = $this->db->query('SELECT AVG(`overall_pay_exp`) AS AllRatingTotal FROM company_review WHERE `company_id` ='.$comapnyID.'
								  AND ((MONTH(`added_on`) = "'.$month.'"))
								  ');
			$result=$query->result();
			$dateObj   = DateTime::createFromFormat('!m', $month);
			array_push($resultantArray,$result[0]->AllRatingTotal.'@'.$dateObj->format('M'));
			$month--;
			if ($month < 0) {
			 $month = 11;
			}
		}
		return $resultantArray;
		//print_r($resultantArray);die;
		//$query = $this->db->query('SELECT AVG(`overall_pay_exp`) AS AllRatingTotal FROM company_review WHERE `company_id` ='.$comapnyID.'
		//						  AND ((DATE(`added_on`) = "'.$a_date.'") || (DATE(`added_on`) < "'.$a_date.'"))
		//						  AND ((DATE(`added_on`) = "'.$end_day.'") || (DATE(`added_on`) > "'.$end_day.'"))');
		//echo $this->db->last_query();die;
	}
}
?>