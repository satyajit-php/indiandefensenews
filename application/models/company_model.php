<?php
class company_model extends CI_Model {

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
			return '0';
		}
	}
	function get_all_row_oder_by($table, $field_name, $field_value)
	{
		$this->db->from($table);
       	$this->db->order_by($field_name, $field_value);
      	$query = $this->db->get();
      	$result= $query->result();
      	return $result;
	}
	function country_list()
	{
		
		
		$this->db->where('location_type',0);
		$this->db->where('is_visible',0);
		$query = $this->db->get('location');
		//echo $this->db->last_query();
		return $result = $query->result();
		
		
	}
	function get_allCompanies(){
		$this->db->where('status', 1);
		$this->db->where('parent_id', 0);
		$query = $this->db->get('company_details');
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
		$query = $this->db->query("SELECT company_details.*,SUM(`company_review`.`overall_pay_exp`) AS `overall_pay_exp`,count(`company_review`.`company_id`) as `totalreview`
		FROM company_details
		LEFT JOIN company_review ON company_review.company_id = company_details.id
		
		WHERE `company_details`.company_name LIKE '%".$data['getCompany']."%'
		AND `company_details`.address LIKE '%".$data['getLocation']."%'
		AND `company_details`.`status` = '1'
		AND `company_details`.`show_it` = '1'
		AND `company_details`.`parent_id` = '0'
		
		GROUP BY `company_details`.id ORDER BY company_details.id desc LIMIT ".$start.",".$limit);
		//echo $this->db->last_query();
		return $queryResult = $query->result();
	}
	function getMyReviewDetailsForRatingSection($companyID)
	{
		$query = $this->db->query("SELECT SUM(`company_review`.`overall_pay_exp`) AS `overall_pay_exp`,count(`company_review`.`company_id`) as `totalreview`
		FROM company_review
		WHERE `company_review`.`disable` = '0'
		AND `company_review`.company_id = '".$companyID."'
		");
		//echo $this->db->last_query();
		return $queryResult = $query->result();
	}
	function countAllCompany($data)
	{
		//$this->db->like('company_name', $data['getCompany']);
		$this->db->select('count(*) AS TotalCompany');
		$this->db->where("address LIKE '%".$data['getLocation']."%' AND company_name LIKE '%".$data['getCompany']."%'");
		$this->db->where('status', 1);
		$this->db->where('parent_id', 0);
		$this->db->where('show_it', 1);
		$this->db->order_by("id","desc");
		$query = $this->db->get('company_details');
		//echo $this->db->last_query();
		$queryResultAll = $query->row();
		$queryResult = $queryResultAll->TotalCompany;
		return $queryResult;
	}
	function listingAllCity()
	{
		$query = $this->db->get('companycities');
		return $result = $query->result();	
	}
	function listingMyFollowingCompany($data,$limit,$start)
	{
		$uid = $this->session->userdata('uid');
		$query = $this->db->query("SELECT company_details.*,SUM(`company_review`.`overall_pay_exp`) AS `overall_pay_exp`,count(`company_review`.`company_id`) as `totalreview` , `company_type`.`name`,`industry_type`.`type`,`sub_industry_type`.`subtype_name`
		FROM company_details
		LEFT JOIN company_review ON company_review.company_id = company_details.id
		LEFT JOIN company_type ON company_details.company_type = company_type.id
		LEFT JOIN industry_type ON company_details.industry_type = industry_type.pid
		LEFT JOIN sub_industry_type ON company_details.sub_industry_type = sub_industry_type.id
		LEFT JOIN company_like ON company_like.company_id = company_details.id
		WHERE `company_like`.user_id ='".$uid."'
		AND `company_like`.follow ='1'
		AND `company_details`.`status` = 1
		GROUP BY `company_details`.id ORDER BY company_details.id desc LIMIT ".$start.",".$limit);
		//echo $this->db->last_query();
		return $queryResult = $query->result();
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
	function updateCompanyAdditional($id,$table,$data_arr,$field)     // update user settins page
	{
		$this->db->where($field, $id);
		return $this->db->update($table, $data_arr); 
	}
	function company_autocomplete($table,$city)     // update user settins page
	{
		$this->db->like('city_name', $city);
		$this->db->limit('10','0');
		$query = $this->db->get($table);
		return $result = $query->result_array();	
	}
	
	function addDetailsCompany($company_id, $uid, $companyOriginalName) {
		/*$this->db->where('parent_id', $company_id);
		$this->db->where('uid', $uid);
		$this->db->where('status', 2);
		$result = $this->db->get('company_details');
		if($result->num_rows > 0){
			$companyID = $result->row();
			$data = array('company_name' => $companyOriginalName,
				      'parent_id' => $company_id,
				      'show_it' => 0,
				      'uid' => $uid,
				      'status' => 2
				      );
			$this->db->where('id', $companyID->id);
			$this->db->update('company_details', $data);
			
			return $companyID->id;
		}else{ */
			$data = array('company_name' => $companyOriginalName,
				      'parent_id' => $company_id,
				      'show_it' => 0,
				      'uid' => $uid,
				      'status' => 2
				      );
			$this->db->insert('company_details', $data);
			return $this->db->insert_id();
		//}
	}
	
	function companyAdditionalCompetitors($table, $data, $insert_type, $update_id){
		$this->db->where('company_detail_id', $data['company_detail_id']);
		$countDetail = $this->db->get($table);
		//echo $countDetail->num_rows.'@@@@@@'.$insert_type.'@@@@@'.$update_id;die;
		if($countDetail->num_rows > 0){
			if($insert_type == 0){
				$this->db->insert($table, $data);
				return $this->db->insert_id();
			}else{
				if($data['company_name'] == ""){
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->delete($table); 
				}else{
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->update($table, $data);
				}
			}
			
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
		/*if($insert_type == 1){
			if($data['company_name'] == ""){
				$this->db->where('id', $update_id);
				return $this->db->delete($table); 
			}else{
				$this->db->where('id', $update_id);
				return $this->db->update($table, $data);
			}
			
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}*/
	}
	
	function getUpdateFromAdminPanelInIframe($table,$field,$value,$arrayToUpdate)
	{
		$this->db->Where($field,$value);
		$this->db->update($table, $arrayToUpdate);
	}
	
	
	function companyAdditionalSisterConcers($table, $data, $insert_type, $update_id){
		$this->db->where('company_detail_id', $data['company_detail_id']);
		$countDetail = $this->db->get($table);
		if($countDetail->num_rows > 0){
			if($insert_type == 0){
				$this->db->insert($table, $data);
				return $this->db->insert_id();
			}else{
				if($data['sister_concers_name'] == ""){
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->delete($table); 
				}else{
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->update($table, $data);
				}
			}
			
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
		/*if($insert_type == 1){
			if($data['sister_concers_name'] == ""){
				$this->db->where('id', $update_id);
				return $this->db->delete($table); 
			}else{
				$this->db->where('id', $update_id);
				return $this->db->update($table, $data);
			}
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}*/
	}
	
	function companyAdditionalBranchName($table, $data, $insert_type, $update_id){
		$this->db->where('company_detail_id', $data['company_detail_id']);
		$countDetail = $this->db->get($table);
		if($countDetail->num_rows > 0)
		{
			if($insert_type == 0){
				$this->db->insert($table, $data);
				return $this->db->insert_id();
			}else{
				if($data['branch_name'] == ""){
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->delete($table); 
				}else{
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->update($table, $data);
				}
			}
			
			
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
		/*if($insert_type == 1){
			if($data['branch_name'] == ""){
				$this->db->where('id', $update_id);
				return $this->db->delete($table); 
			}else{
				$this->db->where('id', $update_id);
				return $this->db->update($table, $data);
			}
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}*/
	}
	
	function companyAdditionalInfrastructureDetails($table, $data, $insert_type, $update_id)
	{
		$this->db->where('company_detail_id', $data['company_detail_id']);
		$countDetail = $this->db->get($table);
		if($countDetail->num_rows > 0)
		{
			$this->db->where('company_detail_id', $data['company_detail_id']);
			return $this->db->update($table, $data);
		}
		else
		{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
		
		/*if($insert_type == 0) {
			if($update_id == 0) {
				$this->db->insert($table, $data);
				return $this->db->insert_id();
			}else {
				$this->db->where('id', $update_id);
				return $this->db->update($table, $data);
			}
		}else {
			if($update_id > 0) {
				$this->db->where('id', $update_id);
				return $this->db->delete($table);
			}
		}*/
	}
	
	function addCompanyAddresses($table, $data, $insert_type, $update_id) {
		/*echo $table; echo "<br/>";
		echo $update_id; echo "<br/>";
		print_r($data); echo "<br/>";
		echo $insert_type; echo "<br/>";die;*/
		$this->db->where('company_detail_id', $data['company_detail_id']);
		$countDetail = $this->db->get($table);
		if($countDetail->num_rows > 0){
			if($data['address_1'] == "") {
				$this->db->where('company_detail_id', $data['company_detail_id']);
				return $this->db->delete($table); 
			}else {
				
				$this->db->where('company_detail_id', $data['company_detail_id']);
				$valueReturn = $this->db->update($table, $data);
				
				$this->db->select('name');
				$this->db->where('location_id', $data['city_id']);
				$locat = $this->db->get('location');
				$city = $locat->row();
				
				$this->db->select('name');
				$this->db->where('location_id', $data['state_id']);
				$locat = $this->db->get('location');
				$state = $locat->row();
				
				$addressUpdate['address'] = $data['address_1'].', '.$data['address_2'].', '.$city->name.', '.$state->name.', '.$data['country'].', '.$data['zipcode'];
				$addressUpdate['company_pin'] = $data['zipcode'];
				$addressUpdate['email'] = $data['email'];
				$addressUpdate['contact_no'] = $data['phone_number'];
				$addressUpdate['state'] = $data['state_id'];
				$addressUpdate['city'] = $data['city_id'];
				$addressUpdate['country'] = $data['country'];
				
				$this->db->where('id', $data['company_detail_id']);
				$this->db->update('company_details', $addressUpdate);
				return $valueReturn;
			}
		}else{
			$this->db->insert($table, $data);
			$returnValue = $this->db->insert_id();
			
			$this->db->select('name');
			$this->db->where('location_id', $data['city_id']);
			$locat = $this->db->get('location');
			$city = $locat->row();
			
			$this->db->select('name');
			$this->db->where('location_id', $data['state_id']);
			$locat = $this->db->get('location');
			$state = $locat->row();
			
			$addressUpdate['address'] = $data['address_1'].', '.$data['address_2'].', '.$city->name.', '.$state->name.', '.$data['country'].', '.$data['zipcode'];
			$addressUpdate['company_pin'] = $data['zipcode'];
			$addressUpdate['email'] = $data['email'];
			$addressUpdate['contact_no'] = $data['phone_number'];
			$addressUpdate['state'] = $data['state_id'];
			$addressUpdate['city'] = $data['city_id'];
			$addressUpdate['country'] = $data['country'];
			
			$this->db->where('id', $data['company_detail_id']);
			$this->db->update('company_details', $addressUpdate);
			
			return $returnValue;
		}
		
	}
	
	function companyAdditionalBankerDetails($table, $data, $insert_type, $update_id) {
		
		$this->db->where('company_detail_id', $data['company_detail_id']);
		$countDetail = $this->db->get($table);
		//echo $this->db->last_query();echo "1<br/>";
		//echo $countDetail;echo "<br/>";
		if($countDetail->num_rows > 0){
			if($insert_type == 0){
				$this->db->insert($table, $data);
				return $this->db->insert_id();
			}else{
				if($data['bank_name'] == ""){
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->delete($table); 
				}else{
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->update($table, $data);
					//echo $this->db->last_query();die;
				}
			}
			
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
		/*if($insert_type == 1){
			if($data['bank_name'] == ""){
				$this->db->where('id', $update_id);
				return $this->db->delete($table); 
			}else{
				$this->db->where('id', $update_id);
				return $this->db->update($table, $data);
				//echo $this->db->last_query();die;
			}
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}*/
	}
	function addClaimKeyExec($table, $data, $insert_type, $update_id){
		$this->db->where('company_detail_id', $data['company_detail_id']);
		$countDetail = $this->db->get($table);
		if($countDetail->num_rows > 0){
			if($insert_type == 0){
				$this->db->insert($table, $data);
				return $this->db->insert_id();
			}else{
				if($data['designation'] == ""){
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->delete($table); 
				}else{
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->update($table, $data);
				}
			}
			
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
	}
	function addClaim($table, $data, $insert_type, $update_id){
		/*$this->db->where('company_detail_id', $data['company_detail_id']);
		$countDetail = $this->db->get($table);
		if($countDetail->num_rows > 0){
			if($insert_type == 0){
				$this->db->insert($table, $data);
				return $this->db->insert_id();
			}else{
				if($data['designation'] == ""){
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->delete($table); 
				}else{
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->update($table, $data);
				}
			}
			
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}*/
		if($insert_type == 1){
			if($data['designation'] == ""){
				$this->db->where('id', $update_id);
				return $this->db->delete($table); 
			}else{
				$this->db->where('id', $update_id);
				return $this->db->update($table, $data);
			}
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
		
	}
	function companyAdditionalDetailsAdd($table, $data, $insert_type, $update_id)
	{
		$this->db->where('company_detail_id', $data['company_detail_id']);
		$countDetail = $this->db->get($table);
		if($countDetail->num_rows > 0)
		{
			$this->db->where('company_detail_id', $data['company_detail_id']);
			$valueReturn = $this->db->update($table, $data);
			
			$updateMainTable['website'] = $data['website'];
			$updateMainTable['sub_industry_type'] = $data['subindustry_type_id'];
			$updateMainTable['industry_type'] = $data['industry_type_id'];
			$updateMainTable['company_type'] = $data['comapny_type_id'];
			
			$this->db->where('id', $data['company_detail_id']);
			$this->db->update('company_details', $updateMainTable);
			return $returnValue;
			
		}else{
			$this->db->insert($table, $data);
			$returnValue = $this->db->insert_id();
			
			$updateMainTable['website'] = $data['website'];
			$updateMainTable['sub_industry_type'] = $data['subindustry_type_id'];
			$updateMainTable['industry_type'] = $data['industry_type_id'];
			$updateMainTable['company_type'] = $data['comapny_type_id'];
			
			$this->db->where('id', $data['company_detail_id']);
			$this->db->update('company_details', $updateMainTable);
			return $returnValue;
		}
	
		//if($insert_type == 0)
		//{
		//	if($update_id == 0)
		//	{
		//		$this->db->insert($table, $data);
		//		$returnValue = $this->db->insert_id();
		//		
		//		$updateMainTable['website'] = $data['website'];
		//		$updateMainTable['sub_industry_type'] = $data['subindustry_type_id'];
		//		$updateMainTable['industry_type'] = $data['industry_type_id'];
		//		$updateMainTable['company_type'] = $data['comapny_type_id'];
		//		
		//		$this->db->where('id', $data['company_detail_id']);
		//		$this->db->update('company_details', $updateMainTable);
		//		return $returnValue;
		//	}
		//	else
		//	{
		//		$this->db->where('id', $update_id);
		//		$returnValue = $this->db->update($table, $data);
		//		
		//		$updateMainTable['website'] = $data['website'];
		//		$updateMainTable['sub_industry_type'] = $data['subindustry_type_id'];
		//		$updateMainTable['industry_type'] = $data['industry_type_id'];
		//		$updateMainTable['company_type'] = $data['comapny_type_id'];
		//		
		//		$this->db->where('id', $data['company_detail_id']);
		//		$this->db->update('company_details', $updateMainTable);
		//		return $returnValue;
		//	}
		//}
		//else
		//{
		//	if($update_id > 0)
		//	{
		//		
		//		$this->db->where('id', $update_id);
		//		return $this->db->delete($table);
		//	}
		//}
	}
	function companyAdditionalSalesTaxDetails($table, $data, $insert_type, $update_id) {
		$this->db->where('company_detail_id', $data['company_detail_id']);
		$countDetail = $this->db->get($table);
		if($countDetail->num_rows > 0)
		{
			$this->db->where('company_detail_id', $data['company_detail_id']);
			return $this->db->update($table, $data);
		}
		else
		{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
		//$this->db->insert($table, $data);
		//return $this->db->insert_id();
		//if($insert_type == 0) {
		//	if($update_id == 0) {
		//		$this->db->insert($table, $data);
		//		return $this->db->insert_id();
		//	}else {
		//		$this->db->where('id', $update_id);
		//		return $this->db->update($table, $data);
		//	}
		//}else {
		//	if($update_id > 0) {
		//		$this->db->where('id', $update_id);
		//		return $this->db->delete($table);
		//	}
		//}
	}
	function companyAdditionalKeyInformationDetails($table, $data, $insert_type, $update_id)
	{
		$this->db->where('company_detail_id', $data['company_detail_id']);
		$countDetail = $this->db->get($table);
		if($countDetail->num_rows > 0)
		{
			$this->db->where('company_detail_id', $data['company_detail_id']);
			return $this->db->update($table, $data);
		}
		else
		{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
		
		//if($insert_type == 0){
		//	if($update_id == 0){
		//		$this->db->insert($table, $data);
		//		return $this->db->insert_id();
		//	}else{
		//		$this->db->where('id', $update_id);
		//		return $this->db->update($table, $data);
		//	}
		//}else{
		//	if($update_id > 0){
		//		$this->db->where('id', $update_id);
		//		return $this->db->delete($table);
		//	}
		//}
		
	}
	
	function companyAdditionalProductInterest($table, $data, $insert_type, $update_id){
		$this->db->where('company_detail_id', $data['company_detail_id']);
		$countDetail = $this->db->get($table);
		if($countDetail->num_rows > 0){
			if($insert_type == 0){
				$this->db->insert($table, $data);
				return $this->db->insert_id();
			}else{
				if($data['product_id'] == "") {
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->delete($table);
				}else{
					$this->db->where('company_detail_id', $data['company_detail_id']);
					return $this->db->update($table, $data);
				}
			}
			
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}
		/*if($insert_type == 1){
			if($data['product_id'] == "") {
				$this->db->where('company_detail_id', $data['company_detail_id']);
				return $this->db->delete($table);
			}else{
				$this->db->where('company_detail_id', $data['company_detail_id']);
				return $this->db->update($table, $data);
			}
		}else{
			$this->db->insert($table, $data);
			return $this->db->insert_id();
		}*/
	}
	
	function updatePercentage($addDetailsCompany, $companyDetailsPercent) {
		$data['company_data_percent'] = $companyDetailsPercent;
		$this->db->where('id', $addDetailsCompany);
		$this->db->update('company_details', $data);
	}
	
	
	

	

	
	function companyAdditionalResidence($table, $data, $insert_type, $update_id){
		if($insert_type == 0){
			if($update_id == 0){
				$this->db->insert($table, $data);
				return $this->db->insert_id();
			}else{
				$this->db->where('id', $update_id);
				return $this->db->update($table, $data);
			}
		}else{
			if($update_id > 0){
				$this->db->where('id', $update_id);
				return $this->db->delete($table);
			}
		}
	}
	
	function checkClaimedCompany($companyname, $uid){
		$this->db->where('company_id', $companyname);
		$this->db->where('admin_type', 1);
		$result = $this->db->get('claim_owner');
		
		return $result->num_rows;
	}
	
	function getAdditionalDetails($table, $comapnyId, $uid,$flag=null) {
		if($flag == 0)
		{
		$this->db->select('active_id');
		$this->db->where('id', $comapnyId);
		$res = $this->db->get('company_details');
		if($res->num_rows > 0){
			$valueNew = $res->row();
			$activeID = $valueNew->active_id;
		}
		}else
		{
			$activeID = $comapnyId;
		}
		/*if($uid != 0){
			$this->db->where('uid', $uid);
		}*/
		$this->db->where('company_detail_id', $activeID);
		$result = $this->db->get($table);
		
		$data['count'] = $result->num_rows;
		$data['result'] = $result->result();
		
		return $data;
	}
	
	function getAdditionalDetailsh($table, $comapnyId) {
		
		$this->db->where('company_detail_id', $comapnyId);
		$result = $this->db->get($table);
		$data['count'] = $result->num_rows;
		$data['result'] = $result->result();
		
		return $data;
	}
	
	function getAdditionalDetailss($table, $comapnyId, $uid,$flag = null) {
		if($flag == 0)
		{
		$this->db->select('active_id');
		$this->db->where('id', $comapnyId);
		$res = $this->db->get('company_details');
		if($res->num_rows > 0){
			$valueNew = $res->row();
			$activeID = $valueNew->active_id;
		}
		}else{
			$activeID = $comapnyId;
		}
		/*if($uid != 0){
			$this->db->where('uid', $uid);
		}*/
		$this->db->where('company_detail_id', $activeID);
		$result = $this->db->get($table);
		$data['count'] = $result->num_rows;
		$data['result'] = $result->result();
		
		return $data;
	}
	
	function getAdditionalDetailssh($table, $comapnyId) {
		
		$this->db->where('company_detail_id', $comapnyId);
		$result = $this->db->get($table);
		$data['count'] = $result->num_rows;
		$data['result'] = $result->result();
		
		return $data;
	}
	
	function activateClaimCompany($company_id, $user_id){
		
		$this->db->where('company_id', $company_id);
		$this->db->where('claim_id', $user_id);
		$result = $this->db->get('claim_owner');
		$getArray = $result->result();
		if($result->num_rows > 0){
			$results = $result->row();
			if($results->status == 1){
				return 2;
			}else{
				$data = array('status' => 1);
				$this->db->where('company_id', $company_id);
				$this->db->where('claim_id', $user_id);
				$this->db->update('claim_owner', $data);
				$notificationSendUser = $this->login_model->sendNotification(17, 0, $this->session->userdata('uid'),'claim_owner',$getArray[0]->id);
				return 1;
			}
			
		}else{
			return 3;
		}
	}
	
	function getAdminDetails($companyname, $uid){
		$this->db->where('company_id', $companyname);
		$this->db->where('admin_type', 1);
		$result = $this->db->get('claim_owner');
		
		$newResult = $result->row();
		$userID = $newResult->claim_id;
		
		$this->db->where('company_id', $companyname);
		$this->db->where('user_id', $userID);
		$claimDetails = $this->db->get('claim_company_details');
		
		$data = array(
			      'reciever' => $userID,
			      'sender' => $uid,
			      'company_id' => $companyname,
			      'purpose' => 'claim_company'
			);
		
		$emailInsert = $this->db->insert('email_recieve', $data);
		$datas['insert_id'] = $this->db->insert_id();
		$datas['userClaim'] = $claimDetails->row();
		return $datas;
	}
	
	function insertContentMail($insertDataMail, $body){
		$data = array('content' => $body);
		
		$this->db->where('id', $insertDataMail);
		$this->db->update('email_recieve', $data);
	}
	
	function claimedCompanyStatusPermission($id){
		$this->db->where('id', $id);
		$result = $this->db->get('claim_owner');
		$resultArray = $result->result();
		if($result->num_rows > 0){
			$row = $result->row();
			if($row->status == 0){
				$data = array('admin_type' => 0, 'status' => 1);
				$this->db->where('id', $id);
				$this->db->update('claim_owner', $data);
				$notificationSendUser = $this->login_model->sendNotification(17, 0, $this->session->userdata('uid'),'claim_owner',$resultArray[0]->id);
				return 1;
			}else{
				return 3;
			}
		}
	}
	
	function claimedCompanyPermission($id){
		$this->db->where('id', $id);
		$result = $this->db->get('claim_owner');
		$resultArray = $result->result();
		if($result->num_rows > 0){
			$row = $result->row();
			//$notificationSendUser = $this->login_model->sendNotification(5, 0, $this->session->userdata('uid'),'claim_owner', $resultArray[0]->id);
			if($row->admin_type == 0 && $row->status == 0){
				$data = array('admin_type' => 1, 'status' => 1);
				$this->db->where('id', $id);
				$this->db->update('claim_owner', $data);
				$notificationSendUser = $this->login_model->sendNotification(5, 0, $this->session->userdata('uid'),'claim_owner', $resultArray[0]->id);
				//$notificationSendUser = $this->login_model->sendNotification(7, 0, $this->session->userdata('uid'),'claim_owner',$resultArray[0]->id);
				return 1;
			}else{
				return 3;
			}
		}
	}
	
	function insertClaimOwner($companyname, $uid, $adminType, $status,$dev_status) {
		$data_arr = array('company_id' => $companyname,
				'claim_id' => $uid,
				'admin_type' => $adminType,
				'status' => $status,
				'devType' => $dev_status
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
		//$this->db->join('company_review','company_review.company_id = company_details.id','right');
		$this->db->where('claim_owner.claim_id', $uid);
		$this->db->where('claim_owner.status', 1);
		$claimCompany = $this->db->get('claim_owner');
	//	echo "<pre>" ; print_r($claimCompany->result_array());
		if($claimCompany->num_rows > 0){
			
			return $claimCompany->result_array();
		}
		else{
			return 0;
		}
	}
	function getPercentValueOfCompany($compID, $uid){
		$this->db->where('parent_id', $compID);
		$this->db->where('uid', $uid);
		$result = $this->db->get('company_details');
		if($result->num_rows > 0){
			return $result->row();
		}else{
			return 0;
		}
	}
	function getratingPerCompanyId($companyID)
	{
		$this->db->select('SUM(`company_review`.`overall_pay_exp`) AS `overall_pay_exp`,count(`company_review`.`company_id`) as `totalreview` ');
		$this->db->join('company_details','company_review.company_id = company_details.id','left');
		$this->db->where('company_review.company_id',$companyID);
		$this->db->where('company_review.disable','0');
		$claimCompany = $this->db->get('company_review');
	//	echo "<pre>" ; print_r($claimCompany->result_array());
		if($claimCompany->num_rows > 0){
			return $claimCompany->result();
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
	    $this->db->join('people', 'company_review.added_by = people.id');
	    $this->db->where('company_review.company_id', $id);
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
	
	function getCountCompany($companyID)
	{
		$this->db->select('sum(count) as totalView');
		$this->db->where('company_id', $companyID);
		$result = $this->db->get('company_details_view_count');
		
		return $result->result_array();
	}
	function addaditonial_company($table,$data_arr)    // add aditonial details
	{
		$this->db->insert($table, $data_arr);
		return $this->db->insert_id();
	}
	function keyexecDetails($start,$end,$fields,$value)
	{
		$this->db->where($fields, $value);
		$this->db->where('status', 1);
		$this->db->order_by("id","desc");
		$this->db->limit($end,$start);
		$query = $this->db->get('company_key_exec');
		//echo $this->db->last_query();die;
		return $query->result();
	}
	function keyexecDetails_admin($start,$end,$fields,$value)
	{
		$this->db->where('company_detail_id', $value);
		$this->db->where('status', 1);
		$this->db->order_by("id","desc");
		$this->db->limit($end,$start);
		$query = $this->db->get('company_key_exec');
		//echo $this->db->last_query();die;
		return $query->result();
	}
	function getNumRow($table,$fields,$value,$searchTerm = null)
	{
		$this->db->where($fields, $value);
		$query = $this->db->get($table);
		return $query->num_rows();
	}
	
	function infrastructureBusinessPremises() {
		//$this->db->select("*");
		$result = $this->db->get('infrastructure_business_premises');
		return $result->result();
	}
	
	function infrastructureAreaType(){
		$result = $this->db->get('infrastructure_area_type');
		return $result->result();
	}
	
	function productInterest() {
		$result = $this->db->get('product_insert');
		return $result->result();
	}
	
	//My Review Details
	
	function companyreviewmy($uid){
		
		$this->db->select('company_review.*, company_details.company_name,company_details.id as compId');
		$this->db->join('company_details', 'company_details.id = company_review.company_id');
		//$this->db->where('company_review.company_id', $comp_id);
		$this->db->where('company_review.added_by', $uid);
		//$this->db->limit($limit,$start);
		$this->db->order_by('company_review.company_id','DESC');
		$claimCompany = $this->db->get('company_review');
		//echo $this->db->last_query();die;
		//echo "<pre>" ; print_r($claimCompany->result_array());
		if($claimCompany->num_rows > 0){
			return $claimCompany->result();
		}
		else{
			return 0;
		}
	}
	public function select_all_company_Last($start,$limit)  
	{  
	   	$this->db->from('company_details');
		$this->db->where("parent_id", 0);
		$this->db->order_by("id", "DESC");
		$this->db->limit($limit,$start);
		$query = $this->db->get();
	   	$result= $query->result();
	   	return $result;
	}
	function companyreviewmy_details($uid,$limit,$start,$searchTerm)
	{
		
		$this->db->select('company_review.*, company_details.company_name,company_details.id as compId');
		$this->db->join('company_details', 'company_details.id = company_review.company_id');
		$this->db->like('company_details.company_name', $searchTerm);
		$this->db->where('company_review.disable', '0');
		$this->db->where('company_review.anno_review', 0);
		$this->db->where('company_review.added_by', $uid);
		$this->db->limit($limit,$start);
		//$this->db->order_by('company_review.company_id','DESC');
		$this->db->order_by('company_review.id','DESC');
		$claimCompany = $this->db->get('company_review');
		//echo $this->db->last_query();die;
		//echo "<pre>" ; print_r($claimCompany->result_array());
		
		$this->db->select('company_review.*, company_details.company_name,company_details.id as compId');
		$this->db->join('company_details', 'company_details.id = company_review.company_id');
		$this->db->like('company_details.company_name', $searchTerm);
		$this->db->where('company_review.disable', '0');
		$this->db->where('company_review.anno_review', 1);
		$this->db->where('company_review.added_by', $uid);
		$this->db->limit($limit,$start);
		//$this->db->order_by('company_review.company_id','DESC');
		$this->db->order_by('company_review.id','DESC');
		$claimCompanyAnno = $this->db->get('company_review');
		if($claimCompany->num_rows > 0){
			$data['array'] = $claimCompany->result();
			$data['numRow'] = $claimCompany->num_rows ;
		}
		if($claimCompanyAnno->num_rows > 0)
		{
			$data['arrayAnno'] = $claimCompanyAnno->result();
			$data['numRowAnno'] = $claimCompanyAnno->num_rows ;
		}
		//else{
		//	$data['array']  = $data['numRow'] =0;
		//}
		return $data;
	}
	function companyreviewmy_detailsCount($uid,$searchTerm=null)
	{
		
		$this->db->select('company_review.*, company_details.company_name,company_details.id as compId');
		$this->db->join('company_details', 'company_details.id = company_review.company_id');
		$this->db->like('company_details.company_name', $searchTerm);
		$this->db->where('company_review.added_by', $uid);
		$this->db->where('company_review.disable', '0');
		$this->db->where('company_review.anno_review', 0);
		$this->db->order_by('company_review.company_id','DESC');
		//$this->db->order_by('company_review.id','DESC');
		$claimCompany = $this->db->get('company_review');
		$data['numRow'] = $claimCompany->num_rows ;
		
		
		$this->db->select('company_review.*, company_details.company_name,company_details.id as compId');
		$this->db->join('company_details', 'company_details.id = company_review.company_id');
		$this->db->like('company_details.company_name', $searchTerm);
		$this->db->where('company_review.disable', '0');
		$this->db->where('company_review.anno_review', 1);
		$this->db->where('company_review.added_by', $uid);
		$this->db->order_by('company_review.id','DESC');
		$claimCompanyAnno = $this->db->get('company_review');
		$data['numRowAnno'] = $claimCompanyAnno->num_rows ;
		
		return $data;
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
	
	function claimed_all_list($uid) {
		
		$this->db->select('company_details.*,claim_owner.status,claim_owner.admin_type,claim_owner.activation_date');
		$this->db->join('company_details', 'company_details.id = claim_owner.company_id');
		//$this->db->join('company_review','company_review.company_id = company_details.id','right');
		$this->db->where('claim_owner.claim_id', $uid);
		$claimCompany = $this->db->get('claim_owner');
		//echo "<pre>" ; print_r($claimCompany->result_array());
		//echo $this->db->last_query();die;
		if($claimCompany->num_rows > 0){
			
			return $claimCompany->result();
		}
		else{
			return 0;
		}
	}
	
	function updateClaimStatus($owner_id){
		$this->db->where('id', $owner_id);
		$value = $this->db->update('claim_owner', array('status' => 1));
		
		$this->db->where('id', $owner_id);
		$valueResult = $this->db->get('claim_owner');
		if($valueResult->num_rows > 0) {
			$result = $valueResult->row();
			$notificationSendUser = $this->login_model->sendNotification(17, $this->session->userdata('uid'), $result->claim_id, 'claim_owner', $owner_id);
			$data['company_id'] = $result->company_id;
			
			$this->db->where('admin_type', 1);
			$this->db->where('company_id', $data['company_id']);
			$this->db->where('claim_id', $this->session->userdata('uid'));
			$resultA = $this->db->get('claim_owner');
			if($resultA->num_rows > 0){
				$data['admin'] = 1;
			}else{
				$data['admin'] = 0;
			}
			return $data;
			
		}else{
			return 0;
		}
		
	}
	
	function fetch_claimed_memberlist($company_id)
	{
		$this->db->select('people.id,people.first_name,people.last_name,claim_owner.id as claim_owner_id,claim_owner.activation_date,claim_owner.status,claim_owner.admin_type,claim_owner.id as cid');
		$this->db->join('people', 'people.id = claim_owner.claim_id');
		$this->db->where('claim_owner.company_id', $company_id);
		$memberList= $this->db->get('claim_owner');
		
		if($memberList->num_rows > 0)
		{
			return $memberList->result();
		}
		else
		{
			return 0;
		}   
	}
	
	function getAdminofClaimedUser($company_id) {
		
		$this->db->select('people.first_name,people.last_name');
		$this->db->join('people', 'people.id = claim_owner.claim_id');
		$this->db->where('claim_owner.company_id', $company_id);
		$this->db->where('claim_owner.admin_type', 1);
		$claimowner = $this->db->get('claim_owner');
		
		if($claimowner->num_rows > 0) {
			$result = $claimowner->row();
			return $result->first_name . ' ' . $result->last_name;
		}else {
			return 'N/A';
		}
	}
	function getallOwnerPerCompany($companyID)
	{
		$this->db->select('people.first_name,people.last_name,people.id');
		$this->db->join('people', 'people.id = claim_owner.claim_id');
		$this->db->where('claim_owner.company_id', $companyID);
		$this->db->where('claim_owner.admin_type', 0);
		$this->db->where('claim_owner.status', 1);
		$claimCompany = $this->db->get('claim_owner');
		if($claimCompany->num_rows > 0){
			
			return $claimCompany->result();
		}
		else{
			return 0;
		}
	}
	function getupdateOwnerPerCompany($companyId,$claimId)
	{
		$data_arr = array(
				'admin_type'=>1
		);
		$data_arr1 = array(
				'admin_type'=>0
		);
		$this->db->where('company_id', $companyId);
		$this->db->where('claim_id', $claimId);
		$this->db->update('claim_owner', $data_arr);
		
		$this->db->where('company_id', $companyId);
		$this->db->where('claim_id', $this->session->userdata('uid'));
		$this->db->update('claim_owner', $data_arr1);
		
		$this->db->where('company_id', $companyId);
		$this->db->where('claim_id', $claimId);
		$resultArray = $this->db->get('claim_owner');
		$resultResult = $resultArray->row();
		//$resultResult->id = 59;
		//  change as per aditya's instruction
		$notificationSendUser = $this->login_model->sendNotification(7, $this->session->userdata('uid'), $claimId, 'claim_owner', $resultResult->id);
		$notificationSendAdmin = $this->login_model->sendNotification(7, $this->session->userdata('uid'), 0, 'claim_owner', $resultResult->id);
	}
	function calculation($data)    // get my all calculation done
	{
		//print_r($data);die;
		//$months[]=date("Y-m", strtotime( date( 'Y-m-01' )." -0 months"));
		for ($i = 0; $i <= 12; $i++)
		{
            $months[] = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
        }
		//print_r($months);die;
		$preserved = array_reverse($months, true);
	        if(!empty($preserved))
			{
				$result_arr=array();
				foreach($preserved as $index)
				{
				
				if (array_key_exists($index,$data))
				{
				 $result_arr[$index]=(int)$data[$index];	
				}
				else{
				 $result_arr[$index]=0;
				}
				
				}
				//print_r($result_arr);die;
				return $result_arr;
			}
	}
	
	function createmy_graph($id)     // create graph data
	{
	 $this->db->select("sum(count) as total,MONTH(lastDate) as month,YEAR(lastDate) as year");
	 $this->db->where('company_id', $id);
	 $this->db->where('year(lastDate)<=', date("Y-m-d"));
         $this->db->where('year(lastDate)>=', date("Y-m", strtotime( date( 'Y-m-01' )." -12 months")));
	 $this->db->group_by('YEAR(lastDate)',"desc");
	 $this->db->group_by('MONTH(lastDate)',"desc");
	
	 $query = $this->db->get('company_details_view_count');
	//echo  $this->db->last_query();
	//die();
	 if($query->num_rows() > 0)
		{
			
		 $data_arr=$query->result_array();
		 if(!empty($data_arr))
		 {
			$result_arr=array();
			foreach($data_arr as $row)
			{
				$index = $row['year']."-".sprintf("%02d",$row['month']);
			    $result_arr[$index] = $row['total'];	
			}
			
		    return $this->calculation($result_arr);
		 }
		 
		}
		else
		{
		return 0;
		}
	}
	
	function getcompany_city($id)   // get company city name from the database
	{
	 $this->db->select('company_details.*,location.name');
	 $this->db->from('company_details');
	 $this->db->join('location', 'company_details.city = location.location_id');
	 $this->db->where("company_details.id",$id);
	 $query = $this->db->get();
	 return $data_arr=$query->row();
	}
	
	//============Getting data from no_of_employees table=======//
	function get_value($table)
	{
		$query=$this->db->get($table);
		$fetch=$query->result();
		return $fetch;
	}

}
 ?>