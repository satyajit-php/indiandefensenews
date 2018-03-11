<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1); 
class New_comp extends CI_Controller {
   // Controller class for site_settings
	function __construct()
	{
		parent::__construct();
		$this->load->model('left_panel_model'); // calls the model
		$this->load->model('site_settings_model'); // calls the model
		$this->load->model('slider_model'); // calls the model
		$this->load->model('indus_model');  
		$this->load->model('flag_off_model');  
		$this->load->model('new_company_model');
		$this->load->model('elastic_model');     // this is the elastic search model
		$this->load->model('login_model');
		$this->load->library('session');
        $this->load->helper('date');
		if($this->session->userdata('admin_is_logged_in')!=true)
		{
			$this->session->set_userdata('error_msg', 'Please login first.');
			redirect('login_cont');
		}else if($this->session->userdata('admin_is_superadmin')!=1)
		{
			$data=$this->login_model->page_details('subadmin_cont','admin_management_list');
			$page_id=$data[0]->id;
			//print_r($this->session->all_userdata());
			$id=$this->session->userdata('admin_uid');
			$admin_val_arr=$this->login_model->page_access('admin',$id);
			$page_arr=explode(',', $admin_val_arr[0]->page_access);
			if(!(in_array($page_id,$page_arr)))
			{
			$this->session->set_userdata('error_msg', 'You Don\'t Have Permission To Access This Page.');		
			redirect('dashboard_cont');
			}

		}
	}
        //============load view page of article================//
        function index()
	{
		$data['state']=$this->new_company_model->get_state('101');
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		
		$this->load->view('newComp/new_comp',$data);
		$this->load->view('includes/footer');
		/*$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$this->load->view('newComp/new_comp.php');
		$this->load->view('includes/footer');*/
	}
	
	function autocompletecityname()
	   {
			$city=$this->input->post('key3');
			$data = $this->new_company_model->company_autocomplete('companycities',$city);
			//print_r($data);
			$cityNames = array();
			$i= 0;
			foreach($data as $cityName){
				
				$cityNames[$i]=$cityName['city_name'];
				$i++;
			//	$cityNames = array_add($cityNames,$i,$cityName->city_name);
			//    $i++;
			}
			 //print_r($cityNames);
			echo json_encode($cityNames);
			//die;
			
	   }
	   
	   function subindustry()
	   {
			$subindustry=$this->input->post('key3');
			$id=$this->input->post('id');
			$data = $this->new_company_model->company_autocomplete('sub_industry_type',$id,$subindustry);
			$subindustry = array();
			$i= 0;
				foreach($data as $subindustryname){
					
					$subindustry[$i]=$subindustryname['subtype_name'];
					$i++;
				//	$cityNames = array_add($cityNames,$i,$cityName->city_name);
				//    $i++;
				}
				 //print_r($cityNames);
				echo json_encode($subindustry);
		
	   }
	public function getSubIndustryName()
	{
		$IndustryId = $this->input->post('IndustryId');
		
		$reviewgidlines = $this->new_company_model->getDetailsByID('sub_industry_type','industry_type',$IndustryId);
			$html = '';
			$html .='<label>Select SubIndustry:</label>';
			$html .='<select class="form-control needs" id="subindustry" name="subindustry" label="Subindustry">';
			//$html .='<option value="">Select SubIndustry</option>';
			foreach($reviewgidlines as $reviewgidlinesList)
			{
				$html .='<option value="'.$reviewgidlinesList->id.'">'.$reviewgidlinesList->subtype_name.'</option>';
			}
			$html .='</select>';
			echo $html;die;
		
		
		//echo json_encode($data['reviewgidlines']);die;
	}
	
	function add_company()    // add company details
	{
		$compName = $this->input->post('compName');
		$website = $this->input->post('website');
		//$country = $this->input->post('country');
		$country = 'India';
		$city = $this->input->post('city');
		$zip = $this->input->post('zip');
		$typeComp = $this->input->post('typeComp');
		$industry = $this->input->post('industry');
		$state=$this->input->post('state');
		$getStateName = $this->new_company_model->getDetailsParticularField('location','location_id',$this->input->post('state'),'name');
		$getCityName = $this->new_company_model->getDetailsParticularField('location','location_id',$this->input->post('city'),'name');
		
		$getCompanyID = $this->new_company_model->createUniqueCompanyID($compName,$getStateName,$zip,$typeComp,$industry,$this->input->post('subindustry'));
		//echo "<pre>";print_r($getCompanyID);die;
		$data_arr=array('company_name'=>$this->input->post('compName'),
						'address'=>$getCityName.",".$getStateName.",".$country.",".$this->input->post('zip'),
						'website'=>$this->input->post('website'),
						'country'=> $country,
						'state'=>$state,
						'city'=>$this->input->post('city'),
						'company_pin'=>$this->input->post('zip'),
						'company_type'=>$this->input->post('typeComp'),
						'industry_type'=>$this->input->post('industry'),
						'sub_industry_type'=>$this->input->post('subindustry'),
						'company_unique_id'=>$getCompanyID['createID'],
						'company_temp_name'=>$getCompanyID['newCompanyName'],
						'status'=>$this->input->post('status')
						);
		//print_r($data_arr);die();
		
		$data = $this->new_company_model->add_company('company_details',$data_arr);
		if($data)
		{
		$this->db->where('id',$data);
		 $this->db->update('company_details', array('active_id'=> $data));
		$elastickdata = $this->elastic_model->insert_data($data,$data_arr['company_name'],$data_arr['city']);   // add store data in the json for elastick search
		}
		if($data && $elastickdata)
			{
		//		$array=array("is_logged_in"=>false);
		//        $this->session->set_userdata($array);
				//redirect("company/index");
				$this->session->set_userdata('success_msg','Company successfully added.');	
				redirect(base_url().'index.php/new_comp');
					
			}
			else{
			  $this->session->set_userdata('error_msg', 'Please try again some thing went wrong.');
			  redirect(base_url().'index.php/new_comp');
			}
		
			
		
	}
	
	 //=============changin the status of company============//
	function change_status_to()
	{
		$stat_param= array(
			'status' => $this->uri->segment(3)
			);
		$id= $this->uri->segment(4);
		$updt_status = $this->new_company_model->change_status_to('company_details',$stat_param, $id);
		if($updt_status)
		{
			$this->session->set_userdata('success_msg', 'Status Updated successfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot update status.');
		}
		redirect(base_url().'index.php/complist_cont?');
	}
	function upload_sampledata()
	{
		if(isset($_FILES['userfile']['tmp_name']) && $_FILES['userfile']['tmp_name'] !='')
		{
			$fp = fopen($_FILES['userfile']['tmp_name'],'r') or die("can't open file");
	        $count=0;
			$forErrorDataArray = array();
			
			
				while($csv_line = fgetcsv($fp,'',";")) 
				{
					//echo count($csv_line);die;
					$chk = array();
					
					for ($i = 0, $j = count($csv_line); $i < $j; $i++) 
					{
						//for ($i = 0; $i < count($NoLines); $i++) 
						//{
						$insert_csv = array();
						
						$insert_csv['company_unique_id'] = $csv_line[0];
						$insert_csv['company_name'] = $csv_line[1];
						$insert_csv['website'] = $csv_line[3];
						//$insert_csv['address'] = $csv_line[4].' , '.$csv_line[5].' , '.$getCity[0]->name.' , '.$getState.', india , '.$csv_line[9];
						$insert_csv['contact_no'] = $csv_line[11];
						$insert_csv['company_pin'] = $csv_line[9];
						$insert_csv['company_type'] =  $csv_line[13];
						$insert_csv['industry_type'] = $csv_line[14];
						$insert_csv['sub_industry_type'] = $csv_line[15];
						$insert_csv['state'] = $csv_line[7];
						$insert_csv['city'] = $csv_line[8];
						
						$insert_csv['address_1']= $csv_line[4];
						$insert_csv['address_2']= $csv_line[5];
						
						$insert_csv['file']= $csv_line[2];
						$insert_csv['incorporation_date']= $csv_line[12];
						$insert_csv['annual_turnover']= $csv_line[16];
						$insert_csv['no_of_employee']= $csv_line[17];
						$insert_csv['debtor_day']= $csv_line[18];
						$insert_csv['credit_rating']= $csv_line[19];
						$insert_csv['company_comment']= $csv_line[20];
						//Key information
						$insert_csv['cin_no']= $csv_line[21];
						$insert_csv['pan_no']= $csv_line[22];
						$insert_csv['share_capital']= $csv_line[23];
						$insert_csv['paid_up_capital']= $csv_line[24];
						//Infrastructure information
						$insert_csv['business_premises']= $csv_line[25];
						$insert_csv['area_value']= $csv_line[26];
						$insert_csv['area_type_id']= $csv_line[27];
						$insert_csv['inf_year']= $csv_line[28];
						//Company sales tax information
						$insert_csv['vat_no']= $csv_line[29];
						$insert_csv['vat_date']= $csv_line[30];
						$insert_csv['cst_no']= $csv_line[31];
						$insert_csv['cst_date']= $csv_line[32];
							
						
					}
					
						if($count > 0)
						{
							if(!empty($insert_csv))
							{
								$com_id=0;
								$com_id= preg_replace('/\s+/', '', $insert_csv['company_unique_id']);
								$getCity = $this->flag_off_model->getDetailsByID('location','location_id',$insert_csv['city']);
								$getState = $this->flag_off_model->getDetailsByID('location','location_id',$insert_csv['state']);
								//$existing_comp= $this->new_company_model->getNumRow('company_details','company_unique_id',$com_id);
								$existing_StateCity = $this->new_company_model->getStateAndCityExistOrNot($com_id,$insert_csv['state'],$insert_csv['city'],$insert_csv['company_type'],$insert_csv['industry_type'],$insert_csv['sub_industry_type']);
								//echo "<pre>"; print_r($existing_StateCity['errorOccUnique']);die;
								$cityName = '';
								$stateName = '';
								$address1 = '';
								$address2 = '';
								$company_pin = '';
								$addressLineArray = array();
								
								if($insert_csv['address_1']!='')
								{
									//$address1 = $insert_csv['address_1'];
									array_push($addressLineArray,$insert_csv['address_1']);
									//$addressLineArray[0] = $insert_csv['address_1'];
								}
								if($insert_csv['address_2']!='')
								{
									//$address2 = $insert_csv['address_2'];
									array_push($addressLineArray,$insert_csv['address_2']);
								}
								if(isset($getCity[0]))
								{
									//$cityName = $getCity[0]->name;
									array_push($addressLineArray,$getCity[0]->name);
								}
								if(isset($getState[0]))
								{
									//$stateName = $getState[0]->name;
									array_push($addressLineArray,$getState[0]->name);
								}
								array_push($addressLineArray,'India');
								if($insert_csv['company_pin']!='')
								{
									//$company_pin = $insert_csv['company_pin'];
									
									array_push($addressLineArray,$insert_csv['company_pin']);
								}
								$AddressTOBE = implode(', ',$addressLineArray);
								//$AddressTOBE = $address1.', '.$address2.', '.$cityName.', '.$stateName.', india, '.$company_pin;
								
								
									$dataToCompanyDetails = array(
									'company_unique_id' => $com_id,
									'company_name' => $insert_csv['company_name'],
									'website' => trim($insert_csv['website']),
									'address' => $AddressTOBE,
									'country' => 'India',
									'contact_no' => trim($insert_csv['contact_no']),
									'company_pin' => trim($insert_csv['company_pin']),
									'company_type' => trim($insert_csv['company_type']),
									'industry_type' => trim($insert_csv['industry_type']),
									'sub_industry_type' => trim($insert_csv['sub_industry_type']),
									'state' => trim($insert_csv['state']),
									'city' => trim($insert_csv['city']),
									'show_it' => 1,
									'status' => 1,
									'uid' => 0
									
								 );
								$getOriginalID = $this->flag_off_model->getDetailsByID('company_details','company_unique_id',$com_id);
								if($existing_StateCity['errorOccUnique'] == '0')
								{
									
									$lastInserCompanyDetailsID = $this->new_company_model->add_company('company_details',$dataToCompanyDetails);
									$elastickdata = $this->elastic_model->insert_data($lastInserCompanyDetailsID,$dataToCompanyDetails['company_name'],$dataToCompanyDetails['city']);   // add store data in the json for elastick search
									$this->db->where('id',$lastInserCompanyDetailsID);
									$this->db->update('company_details', array('active_id'=> $lastInserCompanyDetailsID));
								}else if($existing_StateCity['errorOccUnique'] > 0 && $existing_StateCity['errorOccUnique'] !='companyIdError'){
									$lastInserCompanyDetailsID = $com_id;
									$this->new_company_model->update_company('company_details',$dataToCompanyDetails,$lastInserCompanyDetailsID,'company_unique_id');
									$elastickdata = $this->elastic_model->update_data($getOriginalID[0]->id,$dataToCompanyDetails['company_name'],$dataToCompanyDetails['city']);   // add store data in the json for elastick search
								}else if($existing_StateCity['errorOccUnique'] =='companyIdError'){
										$lastInserCompanyDetailsID = 0;
										array_push($forErrorDataArray,'Please check the Company ID field. This field should not be blank!');
								}
								//echo $existing_StateCity['allIssue'] .'&&'. $lastInserCompanyDetailsID;
								if($existing_StateCity['allIssue']==0 && $lastInserCompanyDetailsID != '0')
								{
									$getDetailsByIdForCompany = $this->new_company_model->getDetailsByID('company_details','company_unique_id',$com_id);
									$lastInsertTableID = $getDetailsByIdForCompany[0]->id;
									if(!empty($insert_csv))
									{
										$dataToCompanyAddress = array(
											'companyid' => $lastInsertTableID,
											'uid' => 0,
											'address_1' => $insert_csv['address_1'],
											'address_2' => $insert_csv['address_2'],
											'country' => 'India',
											'state_id' =>  trim($insert_csv['state']),
											'city_id' =>  trim($insert_csv['city']),
											'zipcode' =>  trim($insert_csv['company_pin']),
											'phone_number' => trim($insert_csv['contact_no']),
											'company_detail_id' => $lastInsertTableID
										);
										
										$dataToCompanyAdditional = array(
											'company_id' => $lastInsertTableID,
											'uid' => 0,
											'file' => $insert_csv['file'],
											'website' => $insert_csv['website'],
											'incorporation_date' => trim($insert_csv['incorporation_date']),
											'comapny_type_id' => trim($insert_csv['company_type']),
											'industry_type_id' =>  trim($insert_csv['industry_type']),
											'subindustry_type_id' =>  trim($insert_csv['sub_industry_type']),
											'annual_turnover' => trim($insert_csv['annual_turnover']),
											'no_of_employee' => trim($insert_csv['no_of_employee']),
											'debtor_day' => trim($insert_csv['debtor_day']),
											'credit_rating' => trim($insert_csv['credit_rating']),
											'company_comment' => $insert_csv['company_comment'],
											'company_detail_id' => $lastInsertTableID
										);
										
										$dataInsertKeyInformation = array(
											'company_id' => $lastInsertTableID,
											'uid' => 0,
											'cin_no' => $insert_csv['cin_no'],
											'pan_no' => $insert_csv['pan_no'],
											'share_capital' => $insert_csv['share_capital'],
											'paid_up_capital' => $insert_csv['paid_up_capital'],
											'company_detail_id' => $lastInsertTableID
										);
										
										$dataInsertInfrasturctureInformation = array(
											'company_id' => $lastInsertTableID,
											'uid' => 0,
											'business_premises' => $insert_csv['business_premises'],
											'area_value' => $insert_csv['area_value'],
											'area_type_id' => $insert_csv['area_type_id'],
											'inf_year' => $insert_csv['inf_year'],
											'company_detail_id' => $lastInsertTableID
										);
										$dataInsertSalestaxInfo = array(
											'company_id' => $lastInsertTableID,
											'uid' => 0,
											'vat_no' => $insert_csv['vat_no'],
											'vat_date' => $insert_csv['vat_date'],
											'cst_no' => $insert_csv['cst_no'],
											'cst_date' => $insert_csv['cst_date'],
											'company_detail_id' => $lastInsertTableID
										);
									}
									
									if($existing_StateCity['errorOccUnique'] == 0)
									{
										$lastInserCompanyAddress = $this->new_company_model->add_company('company_address',$dataToCompanyAddress);
										$lastInserCompanyAdditional = $this->new_company_model->add_company('company_additional',$dataToCompanyAdditional);
										$lastInserCompanyKeyInformation = $this->new_company_model->add_company('key_information',$dataInsertKeyInformation);
										$lastInserCompanyKeyInformation = $this->new_company_model->add_company('infrastructure_details',$dataInsertInfrasturctureInformation);
										$lastInserCompanySalesTaxinfo = $this->new_company_model->add_company('company_sales_tax_details',$dataInsertSalestaxInfo);
										
									}else if($existing_StateCity['errorOccUnique'] > 0 && $existing_StateCity['errorOccUnique'] !='companyIdError')
									{
										
										//echo "<pre>";print_r($dataInsertKeyInformation);die;
										$lastInserCompanyAddress = $this->new_company_model->update_company('company_address',$dataToCompanyAddress,$lastInsertTableID,'company_detail_id');
										$lastInserCompanyAdditional = $this->new_company_model->update_company('company_additional',$dataToCompanyAdditional,$lastInsertTableID,'company_detail_id');
										$lastInserCompanyKeyInformation = $this->new_company_model->update_company('key_information',$dataInsertKeyInformation,$lastInsertTableID,'company_detail_id');
										$lastInserCompanyKeyInformation = $this->new_company_model->update_company('infrastructure_details',$dataInsertInfrasturctureInformation,$lastInsertTableID,'company_detail_id');
										$lastInserCompanySalesTaxinfo = $this->new_company_model->update_company('company_sales_tax_details',$dataInsertSalestaxInfo,$lastInsertTableID,'company_detail_id');
									}
									else if($existing_StateCity['errorOccUnique'] =='companyIdError'){
										array_push($forErrorDataArray,'Please check the Company ID field. This field should not be blank!');
									}
								}
								else
								{
									if($existing_StateCity['errorOccState']!=0)
									{
										array_push($forErrorDataArray,'Please check the Company ID : '.$existing_StateCity['errorUniqueID'].' here either state id is missing or state id is wrong!');
									}
									else if($existing_StateCity['errorOccCity']!=0)
									{
										array_push($forErrorDataArray,'Please check the Company ID : '.$existing_StateCity['errorUniqueID'].' here either city id is missing or city id is wrong!');
									}
									else if($existing_StateCity['errorOccType']!=0)
									{
										array_push($forErrorDataArray,'Please check the Company ID : '.$existing_StateCity['errorUniqueID'].' here either company type id is missing or company type id is wrong!');
									}
									else if($existing_StateCity['errorOccIndustry']!=0)
									{
										array_push($forErrorDataArray,'Please check the Company ID : '.$existing_StateCity['errorUniqueID'].' here either Industry Type id is missing or Industry Type id is wrong!');
									}
									else if($existing_StateCity['errorOccSubIndustry']!=0)
									{
										array_push($forErrorDataArray,'Please check the Company ID : '.$existing_StateCity['errorUniqueID'].' here either Sub industry id is missing or sub industry id is wrong!');
									}
										
									//redirect('complist_cont');
									
								}
								
							}
							
							//print_r($forErrorDataArray);
						}
						$count++;
					
				} //while loop end
			$this->session->set_userdata('error_msg_custom',$forErrorDataArray);
			$this->session->set_userdata('success_msg','Data successfully added.');	
				redirect('complist_cont?');
	    }
		else
		{
		      $this->session->set_userdata('error_msg', 'No file selected.');
			  redirect('complist_cont?');
		}
	}
	function upload_banker()
	{
		if(isset($_FILES['bankerfile']['tmp_name']) && $_FILES['bankerfile']['tmp_name'] !='')
		{
		    $fp = fopen($_FILES['bankerfile']['tmp_name'],'r') or die("can't open file");
	        $count=0;
			$forErrorDataArray = array();
				while($csv_line = fgetcsv($fp,'',";")) 
				{
					//echo count($csv_line);die;
					$chk = array();
					
					for ($i = 0, $j = count($csv_line); $i < $j; $i++) 
					{
						$insert_csv = array();
						
						$insert_csv['company_unique_id'] = $csv_line[0];
						$insert_csv['bank_name'] = $csv_line[1];
						$insert_csv['branch'] = $csv_line[2];
						$insert_csv['account_no'] = $csv_line[3];
						$insert_csv['maintained_from'] =  $csv_line[4];
						$insert_csv['ifsc_no'] = $csv_line[5];
						$insert_csv['micr_code'] = $csv_line[6];
					}
					
						if($count > 0)
						{
							$com_id= preg_replace('/\s+/', '', $insert_csv['company_unique_id']);
							//$getCompanyDetails = $this->new_company_model->getUniqueIdExistORNot('company_details','company_unique_id',$com_id);
							if($insert_csv['company_unique_id'] !="")
							{
								if(!empty($insert_csv))
								{
									$getCompanyDetails = $this->flag_off_model->getDetailsByID('company_details','company_unique_id',$com_id);
									$comp_id=$getCompanyDetails[0]->id;
									$getBankersDetails = $this->flag_off_model->getDetailsByID('banker_details','company_detail_id',$comp_id);
									$dataToBankerDetails = array(
											'bank_name' => $insert_csv['bank_name'],
											'branch' => $insert_csv['branch'],
											'account_no' => trim($insert_csv['account_no']),
											'maintained_from' => $insert_csv['maintained_from'],
											'ifsc_no' => trim($insert_csv['ifsc_no']),
											'micr_code' => trim($insert_csv['micr_code']),
											'company_id' => $comp_id,
											'company_detail_id' =>$comp_id
									);
									if(!empty($getBankersDetails) && $getBankersDetails !=0)
									{
										$this->new_company_model->update_company('banker_details',$dataToBankerDetails,$comp_id,'company_detail_id');
									}else{
										$lastInsertBankerDetails = $this->new_company_model->add_company('banker_details',$dataToBankerDetails);
									}
								}
							}else{
								array_push($forErrorDataArray,'Please check the Company ID field should not be empty !');
							}
							
							//print_r($dataToCompanyDetails);
						}
						$count++;
					//print_r($dataToCompanyDetails);die;
				} //while loop end
				$this->session->set_userdata('error_msg_custom',$forErrorDataArray);
				$this->session->set_userdata('success_msg','Data successfully added.');	
				redirect('complist_cont?');
	    }
		else
		{
		      $this->session->set_userdata('error_msg', 'No file selected.');
			  redirect('complist_cont?');
		}
	}
	
	function kontak_master()
	{
		
		if(isset($_FILES['contactfile']['tmp_name']) && $_FILES['contactfile']['tmp_name'] !='')
		{
		    $fp = fopen($_FILES['contactfile']['tmp_name'],'r') or die("can't open file");
	        $count=0;
			$forErrorDataArray = array();
				while($csv_line = fgetcsv($fp,'',";")) 
				{
					
					$chk = array();
					for ($i = 0, $j = count($csv_line); $i < $j; $i++) 
					{
						$insert_csv = array();
						
						$insert_csv['company_unique_id'] = $csv_line[0];
						$insert_csv['designation'] = $csv_line[1];
						$insert_csv['name'] = $csv_line[2];
						$insert_csv['email'] = $csv_line[3];
						$insert_csv['telephone'] =  $csv_line[4];
						$insert_csv['mobile'] = $csv_line[5];
						$insert_csv['file'] = $csv_line[6];
					}
					
						if($count > 0)
						{
							$com_id= preg_replace('/\s+/', '', $insert_csv['company_unique_id']);
							//$getCompanyDetails = $this->flag_off_model->getDetailsByID('company_details','company_unique_id',$com_id);
								if($insert_csv['company_unique_id'] !="")
								{
									if(!empty($insert_csv))
									{
										$getCompanyDetails = $this->flag_off_model->getDetailsByID('company_details','company_unique_id',$com_id);
										$comp_id=$getCompanyDetails[0]->id;
										$getKeyExecDetails = $this->flag_off_model->getDetailsByID('company_key_exec','company_detail_id',$comp_id);
										$dataCompanyKeyExec = array(
												'uid' => 0,
												'company_id' => $comp_id,
												'designation' => $insert_csv['designation'],
												'name' => $insert_csv['name'],
												'email' => trim($insert_csv['email']),
												'telephone' => trim($insert_csv['telephone']),
												'mobile' => trim($insert_csv['mobile']),
												'file' => $insert_csv['file'],
												'company_detail_id' =>$comp_id
										);
										if(!empty($getKeyExecDetails) && $getKeyExecDetails !=0)
										{
											$this->new_company_model->update_company('company_key_exec',$dataCompanyKeyExec,$comp_id,'company_detail_id');
											
										}else{
											$insertKontakDetails = $this->new_company_model->add_company('company_key_exec',$dataCompanyKeyExec);
										}
										
									}
								}else{
									array_push($forErrorDataArray,'Please check the Company ID field should not be empty !');
								}
							//print_r($dataToCompanyDetails);
						}
						$count++;
					//print_r($dataToCompanyDetails);die;
				} //while loop end
				$this->session->set_userdata('error_msg_custom',$forErrorDataArray);
			    $this->session->set_userdata('success_msg','Data successfully added.');	
				redirect('complist_cont?');
		}
		else
		{
		      $this->session->set_userdata('error_msg', 'No file selected.');
			  redirect('complist_cont?');
		}
	}
	function branch_details()
	{
		if(isset($_FILES['branchfile']['tmp_name']) && $_FILES['branchfile']['tmp_name'] !='')
		{
		    $fp = fopen($_FILES['branchfile']['tmp_name'],'r') or die("can't open file");
	        $count=0;
			$forErrorDataArray = array();
				while($csv_line = fgetcsv($fp,'',";")) 
				{
					//echo count($csv_line);die;
					$chk = array();
					for ($i = 0, $j = count($csv_line); $i < $j; $i++) 
					{
						$insert_csv = array();
						
						$insert_csv['company_unique_id'] = $csv_line[0];
						$insert_csv['address_1'] = $csv_line[1];
						$insert_csv['address_2'] = $csv_line[2];
						$insert_csv['country'] = $csv_line[3];
						$insert_csv['state_id'] =  $csv_line[4];
						$insert_csv['city_id'] = $csv_line[5];
						$insert_csv['zipcode'] = $csv_line[6];
						$insert_csv['email'] = $csv_line[7];
						$insert_csv['phone_number'] = $csv_line[8];
					}
					
						if($count > 0)
						{
							$com_id= preg_replace('/\s+/', '', $insert_csv['company_unique_id']);
							//$getCompanyDetails = $this->flag_off_model->getDetailsByID('company_details','company_unique_id',$com_id);
							if($insert_csv['company_unique_id'] !="")
							{
								if(!empty($insert_csv))
								{
									$getCompanyDetails = $this->flag_off_model->getDetailsByID('company_details','company_unique_id',$com_id);
									$comp_id=$getCompanyDetails[0]->id;
									$dataBranchExec = array(
											'uid' => 0,
											'companyid' => $comp_id,
											'address_1' => $insert_csv['address_1'],
											'address_2' => $insert_csv['address_2'],
											'country' => trim($insert_csv['country']),
											'state_id' => trim($insert_csv['state_id']),
											'city_id' => trim($insert_csv['city_id']),
											'zipcode' => trim($insert_csv['zipcode']),
											'phone_number' => trim($insert_csv['phone_number']),
											'email' => trim($insert_csv['email']),
											'company_detail_id' =>$comp_id
									);
									$getCity = $this->flag_off_model->getDetailsByID('location','location_id',$insert_csv['city_id']);
									$getState = $this->flag_off_model->getDetailsByID('location','location_id',$insert_csv['state_id']);
									$cityName = 'N/A';
									$stateName = 'N/A';
									if(isset($getCity[0]))
									{
										$cityName = $getCity[0]->name;
									}
									if(isset($getState[0]))
									{
										$stateName = $getState[0]->name;
									}
									$AddressTOBE = $insert_csv['address_1'].', '.$insert_csv['address_2'].', '.$cityName.', '.$stateName.', India, '.$insert_csv['zipcode'];
									$addressArrayUpdate = array(
										'address' => $AddressTOBE
									);
									if(!empty($getCompanyDetails) && $getCompanyDetails !=0)
									{
										$this->new_company_model->update_company('company_address',$dataBranchExec,$comp_id,'company_detail_id');
										$this->new_company_model->update_company('company_details',$addressArrayUpdate,$comp_id,'id');
									}
									else{
										$insertBranchDetails = $this->new_company_model->add_company('company_address',$dataBranchExec);
										$this->new_company_model->update_company('company_details',$addressArrayUpdate,$comp_id,'id');
									}
									
								}
							}else{
									array_push($forErrorDataArray,'Please check the Company ID field should not be empty !');
							}
							//print_r($dataToCompanyDetails);
						}
						$count++;
					//print_r($dataToCompanyDetails);die;
				} //while loop end
				$this->session->set_userdata('error_msg_custom',$forErrorDataArray);
			    $this->session->set_userdata('success_msg','Data successfully added.');	
				redirect('complist_cont?');
		}
		else
		{
		      $this->session->set_userdata('error_msg', 'No file selected.');
			  redirect('complist_cont?');
		}
	}
	function competitor_details()
	{
		if(isset($_FILES['competitorfile']['tmp_name']) && $_FILES['competitorfile']['tmp_name'] !='')
		{
		    $fp = fopen($_FILES['competitorfile']['tmp_name'],'r') or die("can't open file");
	        $count=0;
			$forErrorDataArray = array();
				while($csv_line = fgetcsv($fp,'',";")) 
				{
					//echo count($csv_line);die;
					$chk = array();
					for ($i = 0, $j = count($csv_line); $i < $j; $i++) 
					{
						$insert_csv = array();
						
						$insert_csv['company_unique_id'] = $csv_line[0];
						$insert_csv['competitor_id'] = $csv_line[1];
						
					}
					
						if($count > 0)
						{
							$com_id= preg_replace('/\s+/', '', $insert_csv['company_unique_id']);
							$competitor_id= preg_replace('/\s+/', '', $insert_csv['competitor_id']);
							if($insert_csv['company_unique_id'] !="")
							{
								if(!empty($insert_csv))
								{
									$getCompanyDetails = $this->flag_off_model->getDetailsByID('company_details','company_unique_id',$com_id);
									$getCompetitorDetails = $this->flag_off_model->getDetailsByID('company_details','company_unique_id',$competitor_id);
									$comp_id=$getCompanyDetails[0]->id;
									
									$city=$getCompetitorDetails[0]->city;
									$get_city=$this->flag_off_model->getDetailsByID('location','location_id',$city);
									$comp_city = '';
									if(isset($get_city[0]))
									{
										$comp_city=$get_city[0]->name;
									}
									
										$dataCompetitor = array(
											'uid' => 0,
											'company_name' =>  $getCompetitorDetails[0]->id,
											'company_city' => $comp_city,
											'company_id' => $comp_id,
											'company_detail_id' => $comp_id,
										);
									
									$getExistCompetitor = $this->flag_off_model->getDetailsByID('company_competitors','company_detail_id',$comp_id);
									
									
									if(!empty($getExistCompetitor) && $getExistCompetitor !=0)
									{
										$this->new_company_model->update_company('company_competitors',$dataCompetitor,$comp_id,'company_detail_id');
									}else{
										$insertBranchDetails = $this->new_company_model->add_company('company_competitors',$dataCompetitor);
									}
									
								}
							}else{
									array_push($forErrorDataArray,'Please check the Company ID field should not be empty !');
							}
							//print_r($dataToCompanyDetails);
						}
						$count++;
					//print_r($dataToCompanyDetails);die;
				} //while loop end
				$this->session->set_userdata('error_msg_custom',$forErrorDataArray);
			    $this->session->set_userdata('success_msg','Data successfully added.');	
				redirect('complist_cont?');
		}
		else
		{
		      $this->session->set_userdata('error_msg', 'No file selected.');
			  redirect('complist_cont?');
		}
	}
	
	function sister_concern()
	{
		if(isset($_FILES['sisterfile']['tmp_name']) && $_FILES['sisterfile']['tmp_name'] !='')
		{
		    $fp = fopen($_FILES['sisterfile']['tmp_name'],'r') or die("can't open file");
	        $count=0;
			$forErrorDataArray = array();
			//$csv_line = fgetcsv($fp,1024);
			//echo count($csv_line);die;
				while($csv_line = fgetcsv($fp,'',";")) 
				{
					
					$chk = array();
					for ($i = 0, $j = count($csv_line); $i < $j; $i++) 
					{
						$insert_csv = array();
						
						$insert_csv['company_unique_id'] = $csv_line[0];
						$insert_csv['sister_company_unique_id'] = $csv_line[1];
						
					}
					//echo $csv_line[2];die;
						if($count > 0)
						{
							$com_id= preg_replace('/\s+/', '', $insert_csv['company_unique_id']);
							$sister_id= preg_replace('/\s+/', '', $insert_csv['sister_company_unique_id']);
							
							$getCompanyDetails = $this->flag_off_model->getDetailsByID('company_details','company_unique_id',$com_id);
							
							if($insert_csv['company_unique_id'] !="")
							{
								if(!empty($insert_csv))
								{
									
									$getCompanyDetails = $this->flag_off_model->getDetailsByID('company_details','company_unique_id',$com_id);
									$getSisterCompanyDetails = $this->flag_off_model->getDetailsByID('company_details','company_unique_id',$sister_id);
									$getSisterCity = $this->flag_off_model->getDetailsByID('location','location_id',$getSisterCompanyDetails[0]->city);
									
									$comp_id=$getCompanyDetails[0]->id;
									$Sisterid= $getSisterCompanyDetails[0]->id;
									$SistercityName = '';
									if(isset($getSisterCity[0]))
									{
										$SistercityName= $getSisterCity[0]->name;
									}
									$dataSisterInsert = array(
											'uid' => 0,
											'sister_concers_name' => $Sisterid,
											'sister_concers_city' => $SistercityName,
											'uid' => 0,
											'company_id' => $comp_id,
											'company_detail_id' => $comp_id
										);
										
									$getSisterConcernDetails = $this->flag_off_model->getDetailsByID('sister_concerns','company_detail_id',$comp_id);
									
									if(!empty($getSisterConcernDetails) && $getSisterConcernDetails !=0 )
									{
										
										$this->new_company_model->update_company('sister_concerns',$dataSisterInsert,$comp_id,'company_detail_id');
										
									}
									else{
										$insertSisterDetails = $this->new_company_model->add_company('sister_concerns',$dataSisterInsert);
									}
									
								}
							}else{
									array_push($forErrorDataArray,'Please check the Company ID field should not be empty !');
							}
							//print_r($dataToCompanyDetails);
						}
						$count++;
					//print_r($dataToCompanyDetails);die;
				} //while loop end
				$this->session->set_userdata('error_msg_custom',$forErrorDataArray);
			    $this->session->set_userdata('success_msg','Data successfully added.');	
				redirect('complist_cont?');
		}
		else
		{
		      $this->session->set_userdata('error_msg', 'No file selected.');
			  redirect('complist_cont?');
		}
	}
	function get_state()
	{
		$state=$this->input->post('state');
		$data=$this->new_company_model->get_state($state);
		//print_r($data);
		$val="";
		foreach($data as $datas)
		{
			$val.='<option value="'.$datas->location_id.'">'.$datas->name.'</option>';
		}
		echo $val;
	
	}
	
	
	public function getCityName()
	{
		
		 $stateId = $this->input->post('stateId');
		
		$reviewgidlines = $this->new_company_model->getCityByID('location','parent_id',$stateId);
		//print_r($reviewgidlines);
			$html = '';
			$html .='<label>Select City:</label>';
			$html .='<select class="form-control" id="city" name="city" label="City">';
			$html .='<option value="">Select a city</option>';
			foreach($reviewgidlines as $reviewgidlinesList)
			{
				$html .='<option value="'.$reviewgidlinesList->location_id.'">'.$reviewgidlinesList->name.'</option>';
			}
			$html .='</select>';
			echo $html;
		
		
		//echo json_encode($data['reviewgidlines']);die;
	}
	
}
?>