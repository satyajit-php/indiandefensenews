<?php
class company_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	
	function country_list()
	{
		
		
		$this->db->where('location_type',0);
		$this->db->where('is_visible',0);
		$query = $this->db->get('location');
		//echo $this->db->last_query();
		return $result = $query->result();
		
		
	}
	function indus_list()
	{
		$this->db->where('pstatus',1);
		$query=$this->db->get('industry_type');
		return $result = $query->result();
	}
	function subindus_list($id)
	{
		$this->db->where('industry_type',$id);
		$query=$this->db->get('sub_industry_type');
		return $result = $query->result();
	}
	function add_company($table,$data) // add company details
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
		
	}
	function notification_mailid()       // get add company notification mail id
	{
		$this->db->select('admin_email');
		$this->db->from('site_settings');
		$query=$this->db->get();
		return $result = $query->row();
	}
	function company_type()     // get company type list
	{
	       $this->db->where('status',1);
		$query=$this->db->get('company_type');
		return $result = $query->result();	
	}
	function state_list($table,$data)
	{
	   
		$this->db->where('parent_id',$data['id']);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		return $result = $query->result();	
	}
	
	function listingAllCompany($data,$limit,$start) {
		
		//$this->db->like('company_details.company_name', $data['getCompany']);
		//$this->db->like('company_details.company_location', $data['getLocation']);
		//$this->db->order_by("company_details.id","desc");
		//$this->db->group_by("company_details.id");
		//$this->db->limit($limit,$start);
		//$this->db->select('company_details.* ,SUM(company_review.overall_pay_exp) AS overall_pay_exp');
		//$this->db->get('company_details');
		//$this->db->join('company_review', 'company_review.company_id = company_details.id','left');
		//$this->db->last_query();
		$query = $this->db->query("SELECT company_details.*,SUM(`company_review`.`overall_pay_exp`) AS `overall_pay_exp`,count(`company_review`.`company_id`) as `totalreview` , `company_type`.`name`,`industry_type`.`type`,`sub_industry_type`.`subtype_name`
		FROM company_details
		LEFT JOIN company_review ON company_review.company_id = company_details.id
		LEFT JOIN company_type ON company_details.company_type = company_type.id
		LEFT JOIN industry_type ON company_details.industry_type = industry_type.pid
		LEFT JOIN sub_industry_type ON company_details.sub_industry_type = sub_industry_type.id
		WHERE `company_details`.company_name LIKE '%".$data['getCompany']."%'
		AND `company_details`.company_location LIKE '%".$data['getLocation']."%'
		GROUP BY `company_details`.id ORDER BY company_details.id desc LIMIT ".$start.",".$limit);
		
		return $queryResult = $query->result();
	}
	function countAllCompany($data)
	{
		$this->db->like('company_name', $data['getCompany']);
		$this->db->like('company_location', $data['getLocation']);
		$this->db->order_by("id","desc");
		$query = $this->db->get('company_details');
		
		$queryResult = $query->num_rows();
		return $queryResult;
	}
	function listingAllCity()
	{
		$query = $this->db->get('companycities');
		return $result = $query->result();	
	}
	function company_details($id)   // get all company details
	{
		
		
		
			$this->db->select('company_details.*,location.name as country,location.location_id as countryid');
			$this->db->from('company_details');
			$this->db->join('location', 'location.location_id = company_details.country');
			$this->db->join('company_type', 'company_type.id = company_details.company_type');
			$this->db->join('industry_type indus', 'indus.pid = company_details.industry_type');
			$this->db->join('sub_industry_type', 'sub_industry_type.id = company_details.sub_industry_type');
			$this->db->where('company_details.id',$id);
	                $this->db->where('company_details.status',1);
			$query = $this->db->get();
			//echo $this->db->last_query();
	
			return $result=$query->result();
				
	 
	}
	
	function state($id)
	{
		$this->db->select('location.name as state');
	        $this->db->where('location_id',$id);
		$query = $this->db->get('location');
		//echo $this->db->last_query();
		return $result = $query->result();	
	}
	
	function account_details($table,$id)     // geting details from people table
	{
	   
	  
		$this->db->where('id',$id);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		return $result = $query->result();	
	}
	
	function update_details($id,$table,$data_arr)     // update user settins page
	{
		$this->db->where('id', $id);
		return $this->db->update($table, $data_arr); 
	}
	
	function company_autocomplete($table,$city)     // update user settins page
	{
		$this->db->like('city_name', $city);
		$this->db->limit('10','0');
		$query = $this->db->get($table);
		return $result = $query->result_array();	
	}
	
	function addClaim($table, $data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	
	function checkClaimedCompany($companyname, $uid){
		$this->db->where('company_id', $companyname);
		$this->db->where('admin_type', 1);
		$result = $this->db->get('claim_owner');
		
		return $result->num_rows;
	}
	
	function insertClaimOwner($companyname, $uid, $adminType, $status) {
		$data_arr = array('company_id' => $companyname,
				'claim_id' => $uid,
				'admin_type' => $adminType,
				'status' => $status
			);
		
		$this->db->insert('claim_owner', $data_arr);
		return $this->db->insert_id();
	}
	
	function checkComapnyClaimExist($companyemail, $companyname) {
		$this->db->where('company_id', $companyname);
		$this->db->where('email', $companyemail);
		$emailCheck = $this->db->get('claim_company_details');
		
		return $emailCheck->num_rows;
	}
	
	function claimedCompanies($uid) {
		$this->db->select('company_details.*');
		$this->db->join('company_details', 'company_details.id = claim_owner.company_id');
		$this->db->where('claim_owner.claim_id', $uid);
		$this->db->where('claim_owner.status', 1);
		$claimCompany = $this->db->get('claim_owner');
		
		if($claimCompany->num_rows > 0){
			return $claimCompany->result_array();
		}
		else{
			return 0;
		}
	}
	
	function subindustry_autocomplete($table,$id,$subindustry)     // update user settins page
	{
		$this->db->like('subtype_name', $subindustry);
		$this->db->where('id', $id);
		$this->db->where('status', 1);
		$this->db->limit('10','0');
		$query = $this->db->get($table);
		return $result = $query->result_array();	
	}
	function allcompanylist()    // get all company list
	{
		$this->db->select('*');
		$this->db->where('status', 1);
		$query = $this->db->get('company_details');
		return $result = $query->result();
	}
	
	function companyreview($id)       //   get all company details
	{
	    $this->db->select('company_review.*,company_details.company_name, company_details.id as companyID');
	    $this->db->join('company_details', 'company_details.id = company_review.company_id');
	    $this->db->where('company_id', $id);
	    $this->db->order_by("company_review.id","desc");
	    $this->db->limit('2','0');
	    $query = $this->db->get('company_review');
	    return $result = $query->result();
	   
	}
	
	function companyNameGet($companyId) {
		$this->db->select('company_name');
		$this->db->where('id', $companyId);
		$result = $this->db->get('company_details');
		
		return $result->result();
	}
}
 ?>