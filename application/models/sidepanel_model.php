<?php
class sidepanel_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
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
	
	function get_sidepanel($id,$table)      // fetch all the side panels data from people table
	{
		$this->db->select("*");
		$this->db->from($table);
		$this->db->join('location', "location.location_id = $table.country_id",'left');
	        $this->db->where("$table.id",$id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $result = $query->result();	
		
	}
	
	function getMyMessageCount($uid){
		
		$this->db->where('reciever', $uid);
		$result = $this->db->get('email_recieve');
		
		return $result->num_rows;
	}
	
	function state($id)
	{
		$this->db->select('location.name as state');
		$this->db->where('location_id',$id);
		$query = $this->db->get('location');
		//echo $this->db->last_query();
		return $result = $query->result();	
	}
	
	function add_profilePic($table,$data,$id)
	{
		$this->db->where('id', $id);
		$data = $this->db->update($table, $data);
		return $data;
		//return $this->db->insert_id();
	}
	function getTotalReview($table,$field,$value)
	{
		$this->db->where($field,$value);
		if($table =='company_review')
		{
			$this->db->where('disable','0');
		}
		$query = $this->db->get($table);
		
		return $query->num_rows;
	}
	function getTotalfollowPerCompany($companyID)
	{
		$this->db->where('company_id',$companyID);
		$this->db->where('follow',1);
		$query = $this->db->get('company_like');
		return $query->num_rows;
	}
	function getImageAndVideoByIDCount($uid)
	{
		$this->db->select('review_files.*, company_review.company_id, company_review.added_by, company_review.review_title,company_details.company_name');
		$this->db->join('company_review', 'company_review.id = review_files.review_id');
		$this->db->join('company_details', 'company_review.company_id = company_details.id');
		$this->db->where('company_review.added_by', $uid);
		$this->db->order_by('review_files.review_id', 'desc');
		$claimCompany = $this->db->get('review_files');
		if($claimCompany->num_rows > 0){
			return $claimCompany->result();
		}
		else{
			return 0;
		}
	}
	//function getComapanyForImage($limit, $start)
	//{
	//	$this->db->select('*');
	//	$this->db->where('review_files.image_name !=',"");
	//	$this->db->group_by('review_files.company_id');
	//	$this->db->limit($limit, $start);
	//	$claimCompany = $this->db->get('review_files');
	//	return $claimCompany->result();
	//}
	function getImageAndVideoByID($uid,$limit, $start,$searchTerm = null)
	{
		//$this->db->select('review_files.*, company_review.company_id, company_review.added_by, company_review.review_title,company_details.company_name');
		//$this->db->join('company_review', 'company_review.id = review_files.review_id');
		//$this->db->join('company_details', 'company_review.company_id = company_details.id');
		//$this->db->like('company_details.company_name',$searchTerm);
		//$this->db->where('company_review.added_by', $uid);
		//$this->db->where('review_files.image_name !=', "");
		//$this->db->order_by('review_files.review_id', 'desc');
		//$this->db->limit($limit, $start);
		//$claimCompany = $this->db->get('review_files');
		//echo $this->db->last_query();die;
		//if($claimCompany->num_rows > 0){
		//	return $claimCompany->result();
		//}
		//else{
		//	return 0;
		//}
		
		$query = $this->db->query("Select new_table.*, company_review.review_title, company_review.added_by,
									company_details.company_name from (select GROUP_CONCAT(review_files.image_name) image_name,
									review_id  from review_files where review_files.image_name!='' group by review_id) as new_table
									join company_review on company_review.id = new_table.review_id
									join company_details on company_details.id = company_review.company_id
									where company_review.added_by='".$uid."' AND company_details.company_name like '%".$searchTerm."%'
									ORDER BY `new_table`.`review_id` ASC LIMIT $start,$limit");
		return $queryResult = $query->result();
	}
	function getImageMyCount($uid,$searchTerm = null)
	{
		//$this->db->select('review_files.*, company_review.company_id, company_review.added_by, company_review.review_title,company_details.company_name');
		//$this->db->join('company_review', 'company_review.id = review_files.review_id');
		//$this->db->join('company_details', 'company_review.company_id = company_details.id');
		//$this->db->like('company_details.company_name',$searchTerm);
		//$this->db->where('company_review.added_by', $uid);
		//$this->db->where('review_files.image_name !=', "");
		//$this->db->order_by('review_files.review_id', 'desc');
		//$claimCompany = $this->db->get('review_files');
		//return $claimCompany->num_rows;
		$query = $this->db->query("Select new_table.*, company_review.review_title, company_review.added_by,
									company_details.company_name from (select GROUP_CONCAT(review_files.image_name) review_image,
									review_id  from review_files where review_files.image_name!='' group by review_id) as new_table
									join company_review on company_review.id = new_table.review_id
									join company_details on company_details.id = company_review.company_id
									where company_review.added_by='".$uid."' AND company_details.company_name like '%".$searchTerm."%'
									ORDER BY `new_table`.`review_id` ASC");
		return $queryResult = $query->num_rows;
	
	}
	function getVideoAllID($uid,$limit, $start,$searchTerm=null)
	{
		//$this->db->select('review_files.*, company_review.company_id, company_review.added_by, company_review.review_title,company_details.company_name');
		//$this->db->join('company_review', 'company_review.id = review_files.review_id');
		//$this->db->join('company_details', 'company_review.company_id = company_details.id');
		//$this->db->like('company_details.company_name',$searchTerm);
		//$this->db->where('company_review.added_by', $uid);
		//$this->db->where('review_files.video_url !=', "");
		//$this->db->order_by('review_files.review_id', 'desc');
		//$this->db->limit($limit, $start);
		//$claimCompany = $this->db->get('review_files');
		//if($claimCompany->num_rows > 0){
		//	return $claimCompany->result();
		//}
		//else{
		//	return 0;
		//}
		$query = $this->db->query("Select new_table.*, company_review.review_title, company_review.added_by,
									company_details.company_name from (select GROUP_CONCAT(review_files.video_url) video_url,
									review_id  from review_files where review_files.video_url!='' group by review_id) as new_table
									join company_review on company_review.id = new_table.review_id
									join company_details on company_details.id = company_review.company_id
									where company_review.added_by='".$uid."' AND company_details.company_name like '%".$searchTerm."%'
									ORDER BY `new_table`.`review_id` ASC LIMIT $start,$limit");
		return $queryResult = $query->result();
	}
	function getVideomyCount($uid,$searchTerm=null)
	{
		//$this->db->select('review_files.*, company_review.company_id, company_review.added_by, company_review.review_title,company_details.company_name');
		//$this->db->join('company_review', 'company_review.id = review_files.review_id');
		//$this->db->join('company_details', 'company_review.company_id = company_details.id');
		//$this->db->like('company_details.company_name',$searchTerm);
		//$this->db->where('company_review.added_by', $uid);
		//$this->db->where('review_files.video_url !=', "");
		//$this->db->order_by('review_files.review_id', 'desc');
		//$claimCompany = $this->db->get('review_files');
		//return $claimCompany->num_rows;
		$query = $this->db->query("Select new_table.*, company_review.review_title, company_review.added_by,
									company_details.company_name from (select GROUP_CONCAT(review_files.video_url) video_url,
									review_id  from review_files where review_files.video_url!='' group by review_id) as new_table
									join company_review on company_review.id = new_table.review_id
									join company_details on company_details.id = company_review.company_id
									where company_review.added_by='".$uid."' AND company_details.company_name like '%".$searchTerm."%'
									ORDER BY `new_table`.`review_id` ASC");
		return $queryResult = $query->num_rows;
	}
	public function getCompmanyCount($uid)
	{

		$this->db->select('company_id');
		$this->db->where('user_id', $uid);
		$this->db->where('follow', 1);
		$claimCompany = $this->db->get('company_like');
		if($claimCompany->num_rows > 0){
			return $claimCompany->result();
		}
		else{
			return 0;
		}
	}
	
	public function companyfollowedlist($uid,$limit,$start,$searchTerm=null)
	{
		$this->db->select('company_details.id,company_details.company_pin,company_details.company_name, company_details.address,company_type.name, industry_type.type,sub_industry_type.subtype_name');
		$this->db->join('company_details', 'company_like.company_id = company_details.id','right');
		$this->db->join('company_type', 'company_type.id = company_details.company_type', 'left');
		$this->db->like('company_details.company_name', $searchTerm);
		$this->db->join('industry_type', 'industry_type.pid = company_details.industry_type','left');
		$this->db->join('sub_industry_type', 'sub_industry_type.id = company_details.sub_industry_type','left');
		$this->db->where('company_like.user_id', $uid);
		$this->db->where('company_like.follow', 1);
		$this->db->order_by("company_like.id", "desc"); 
		$this->db->limit($limit,$start);
		$claimCompany = $this->db->get('company_like');
		//echo $this->db->last_query();die;
		if($claimCompany->num_rows > 0){
			return $claimCompany->result();
		}
		else{
			return 0;
		}
		
	}
	public function getCompmanyFollowCount($uid,$searchTerm=null)
	{
		$this->db->select('company_details.id,company_details.company_pin,company_details.company_name, company_details.address,company_type.name, industry_type.type,sub_industry_type.subtype_name');
		$this->db->join('company_details', 'company_like.company_id = company_details.id','right');
		$this->db->join('company_type', 'company_type.id = company_details.company_type', 'left');
		$this->db->like('company_details.company_name', $searchTerm);
		$this->db->join('industry_type', 'industry_type.pid = company_details.industry_type');
		$this->db->join('sub_industry_type', 'sub_industry_type.id = company_details.sub_industry_type');
		$this->db->where('company_like.user_id', $uid);
		$this->db->where('company_like.follow', 1);
		$this->db->order_by("company_like.id", "desc");
		$claimCompany = $this->db->get('company_like');
		return $claimCompany->num_rows;
	}
	public function reviewDetails($uid)
	{
		$this->db->select('review_files.*, company_review.review_title');
		$this->db->join('company_review', 'company_review.id = review_files.review_id');
		$this->db->where('company_review.added_by', $uid);
		$claimReview = $this->db->get('review_files');
		if($claimReview->num_rows > 0){
			return $claimReview->result();
		}
		else{
			return 0;
		}
	}
	
	function getalldetails($id)    // this function get all details
	{
		$this->db->select('SUM(`company_review`.`overall_pay_exp`) AS `overall_pay_exp`, count(`company_review`.`company_id`) as `totalreview`');
		$this->db->where('company_id', $id);
		$claimCompany = $this->db->get('company_review');
		if($claimCompany->num_rows > 0){
			return $claimCompany->result();
		}
		else{
			return 0;
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
                 $this->db->select('name');
                 $this->db->where('review_count <',$num);
                 $this->db->or_where('review_count',$num);
                 $query = $this->db->get('badge_details',1,0);
                 if($query->num_rows >0)
                       {
                               return $query->result();        
                       }
               
       }
	function companyreview($id)       //   get all company details
	{
	    $this->db->select('company_review.*,company_details.company_name, company_details.id as companyID');
	    $this->db->join('company_details', 'company_details.id = company_review.company_id');
	    $this->db->where('company_review.company_id', $id);
	    $this->db->order_by("company_review.id","desc");
	    $this->db->limit('2','0');
	    $query = $this->db->get('company_review');
	    return $result = $query->result();
	   
	}
	function page_views($id)   // return total number of page views
	{
	 $this->db->select('sum(count) as total');
	 $this->db->where('company_id', $id);
	 $page_views = $this->db->get('company_details_view_count');
	 if($page_views->num_rows > 0){
			return $page_views->result();
		}
		else{
			return 0;
		}
	}
}
 ?>