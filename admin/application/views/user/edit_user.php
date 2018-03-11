  <?php
    //echo ("<pre>");
    //print_r($user_data);die();
	    
  ?>
	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">User Details</h2>
<!--		   <a href="<?php echo site_url();?>/doctor_cont" class="btn btn-primary btn-sm" style="float:right; margin-top:-6px;" >Back</a>-->
		   <a href="<?php echo site_url();?>/user_management_cont" class="btn btn-primary btn-sm" style="float:right; margin-bottom:-10px;" onclick = "go_back();">Back</a>
                </div>
		       <div class="panel-body">
			<!--				<!-- Nav tabs -->
<!--                            <ul class="nav nav-pills">
			        <li class="active"><a href="<?php echo site_url();?>/doctor_cont/edit_doctor/<?php echo $doctor_id; ?>">General Details</a>
                                </li>
                                <li class="active"><a href="<?php echo site_url();?>/doctor_cont/show_clinic/<?php echo $doctor_id; ?>" >Clinic Details</a>
                                </li>
                                <li class="active"><a href="<?php echo site_url();?>/doctor_cont/show_achievement/<?php echo $doctor_id; ?>" >Achievement Details</a>
                                </li>
                               
                            </ul>-->
		       </div>
                <!-- /.col-lg-12 -->
            </div>
	    
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Fields marked with <span style="color: red;">*</span> are mandatory
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-sm-8">
                                    <form role="form" id="sitesetting_form" name="sitesetting_form" method="POST" action="<?php echo site_url();?>/user_management_cont/update_user" enctype="multipart/form-data">
                                       
					                    <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_data[0]->id; ?>">
					                    <div class="form-group">
                                            <!--<label><span style="color: red;">*-->
											</span> First name:</label>
                                            <input class="form-control need" id="fname" name="fname" label="First name" value="<?php echo $user_data[0]->first_name; ?>">
                                            <div id="fname_error" style="display: none; color: red;"></div>
                                        </div>
										<div class="form-group">
                                          <!--  <label><span style="color: red;">*-->
											</span> Second name:</label>
                                            <input class="form-control need" id="lname" name="lname" label="Last name" value="<?php echo $user_data[0]->last_name; ?>">
                                            <div id="lname_error" style="display: none; color: red;"></div>
                                        </div>
										<div class="form-group">
                                         <!--   <label><span style="color: red;">*-->
											</span> Display name:</label>
                                            <input class="form-control need" id="dname" name="dname" label="Display name" value="<?php echo $user_data[0]->display_name; ?>">
                                            <div id="dname_error" style="display: none; color: red;"></div>
                                        </div>
										<div class="form-group">
                                        <!--    <label><span style="color: red;">*-->
											</span> Company name:</label>
                                            <input class="form-control need" id="compname" name="compname" label="Company name" value="<?php echo $user_data[0]->company_name; ?>">
                                            <div id="compname_error" style="display: none; color: red;"></div>
                                        </div>
										<div class="form-group">
                                         <!--   <label><span style="color: red;">*-->
											</span> Job Title:</label>
                                            <input class="form-control need" id="jobtitle" name="jobtitle" label="Job Title" value="<?php echo $user_data[0]->job_title; ?>">
                                            <div id="jobtitle_error" style="display: none; color: red;"></div>
                                        </div>
										<div class="form-group">
                                           <!-- <label><span style="color: red;">*-->
											</span> Work Email:</label>
                                            <input class="form-control need" id="workEmail" name="workEmail" label="Work Email" value="<?php echo $user_data[0]->work_email; ?>">
                                            <div id="workEmail_error" style="display: none; color: red;"></div>
                                        </div>
										<div class="form-group">
                                         <!--   <label><span style="color: red;">*-->
											</span> Address:</label>
                                            <input class="form-control need" id="address" name="address" label="Address" value="<?php echo $user_data[0]->address; ?>">
                                            <div id="address_error" style="display: none; color: red;"></div>
                                        </div>
										<div class="form-group">
                                          <!--  <label><span style="color: red;">*-->
											</span> Pincode:</label>
                                            <input class="form-control need" id="Pincode" name="Pincode" label="Pincode" value="<?php echo $user_data[0]->zip; ?>">
                                            <div id="Pincode_error" style="display: none; color: red;"></div>
                                        </div>
										<div class="form-group">
                                          <!--  <label><span style="color: red;">*-->
											</span> Security Pin:</label>
                                            <input class="form-control need" id="secPin" name="secPin" label="Security Pin" value="<?php echo $user_data[0]->security_pin; ?>">
                                            <div id="secPin_error" style="display: none; color: red;"></div>
                                        </div>
										<div class="form-group">
                                           <!-- <label><span style="color: red;">*-->
											</span> Sex:</label>
                                            <span class="radio-box">
												<?php
												$female="";
												$male="";
												if($user_data[0]->gender=='1')
												{
												  $male="checked";
												}
												elseif($user_data[0]->gender=='0')
												{
													$female="checked";
												}
												
												?>
											  <input type="radio" id="radio01" name="radio" value="1" <?php echo $male;?>/>
											  <label for="radio01"><span></span>Male</label>
											</span>
											<span class="radio-box">
											  <input type="radio" id="radio02" name="radio" value="0" <?php echo $female;?>/>
											  <label for="radio02"><span></span>Female</label>
											</span>
                                        </div>
										
										


			                        <div class="form-group">
                                        <!--    <label><span style="color: red;">*-->
											</span> Email:</label>
                                            <input class="form-control" id="docemail" name="docemail" label="Email" readonly value="<?php echo $user_data[0]->email; ?>">
                                            <div id="docemail_error" style="display: none; color: red;"></div>
                                        </div>
                                        <div class="form-group">
                                            <!--<label><span style="color: red;">*-->
											</span> Phone:</label>
                                            <input class="form-control need" placeholder="Enter phone number" id="phone" name="phone" label="Phone number" value="<?php echo $user_data[0]->phone; ?>">
                                            <div id="phone_error" style="display: none; color: red;"></div>
                                        </div>
										
										<div class="form-group">
											  <label>Country</label>
												<select class="selectpicker need" name="country" id="country" label="Country">
												    <option value=''>Select country</option>
													<?php
													 foreach($country as $row)
													 {
														?>
													<option value="<?php echo $row->location_id;?>" <?php if($row->location_id==$user_data[0]->country_id){echo "selected";}?>><?php echo $row->name;?></option>	
													<?php
													}
													?>
												</select>
										</div>
										<!--<div id="country_error" style="display: none; color: red;"></div>-->
										<div class="form-group">
												<label>State</label>
												<select class="selectpicker need" name="city" id="city" country="city" label="City">
												<option value=''>Select state</option>
												</select>
										</div>
										<div id="city_error" style="display: none; color: red;"></div>
										 <div class="form-group">
										 <label>Date of Birth</label>
												<div class="row">
													<div class="col-sm-4">
														<div class="form-input">
															<select class="selectpicker need" name="day" id="day" label="Day">
															<option value=''>Select day</option>
															<?php
															   for($i=1;$i<32;$i++)
															   {?>
															<option value="<?php echo $i;?>"
															<?php
															if($user_data[0]->date_of_birth_day==$i)
															{ echo "selected";}
															?>><?php if($i<10){echo "0".$i;}else{ echo $i;}?></option>	
															  <?php }
															?>
															</select>
														</div>
														<div id="day_error" style="display: none; color: red;"></div>
													</div>
													<div class="col-sm-4">
														<div class="form-input">
															<select class="selectpicker need" name="month" id="month" label="Month">
																<option value=''>Select month</option>
																<?php
																for($m=1; $m<=12; $m++)
																{
																$month = date('F', mktime(0,0,0,$m, 1, date('Y')));
																										?>
																<option value="<?php echo $m;?>"<?php
															if($user_data[0]->date_of_birth_month==$m)
															{ echo "selected";}
															?>><?php echo $month; ?></option>
																<?php
														        }
																?>
															</select>
														</div>
														<div id="month_error" style="display: none; color: red;"></div>
													</div>
													<div class="col-sm-4">
														<div class="form-input">
															<select class="selectpicker need" name="year" id="year" label="Year">
															<option value=''>Select year</option>
																	 <?php
																	 $currentYear=date('Y');
															 for($k=1943;$k<=$currentYear;$k++)
															 {
															?>
															<option value="<?php echo $k;?>"<?php
															if($user_data[0]->date_of_birth_year==$k)
															{ echo "selected";}
															?>><?php echo $k; ?></option>
															<?php
															 }
															 ?>
															</select>
														</div>
														<div id="year_error" style="display: none; color: red;"></div>
													</div>
													
												</div>
												<div class="form-group">
												  <!-- <label><span style="color: red;">*-->
												   </span> User status:</label>
													   <select class="form-control need" name="status" id="status">
													   <option value="0" <?php if($user_data[0]->status == 0){echo "selected";}?>>Inactive user</option>
													   <option value="1" <?php if($user_data[0]->status == 1){echo "selected";}?>>Active user</option>
													   <option value="3" <?php if($user_data[0]->status == 3){echo "selected";}?>>Blocked user</option>
													   <option value="4" <?php if($user_data[0]->status == 4){echo "selected";}?>>Delete user</option>
													   </select>
											   <div id="status_error" style="display: none; color: red;"></div>
											   </div>
										</div>
										
										
										
                                        <button type="button" class="btn btn-success" onclick="doctor_validation();">Submit</button>
                                        <button type="reset" class="btn btn-default">Reset</button>
                                        <div id="loading_img" style="display:none; float: right; margin-top: 5px;margin-right: 272px;"><img src="<?php echo base_url();?>images/facebook_loader.gif" alt=""></div>
										<div id="overlay_main" class="no_responce" style="display: none;"></div>
                                    </form>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<!--Script To validate site settings form -->
 <script type="text/javascript">
$(document).ready(function(){
		var uid = '<?php echo $user_data[0]->id;?>';
     parent_id=$("#country").val();
	 //alert(uid);
	 //alert(parent_id);
	 if (parent_id != '') {
		
     $.ajax({
		type: "POST",
		url: "<?php echo base_url();?>index.php/user_management_cont/get_state",
		cache: false,
		data :{ id: parent_id,uid:uid},
		async: false,
		success: function(data)
		{
		   $("#city").html(data);
		   $('#city').selectpicker('refresh');
		}
	});
    }
    $("#country").change(function(){
      parent_id=$("#country").val();
	  //alert(parent_id);
    //if (parent_id != '')
    //{
                   	$.ajax({
					type: "POST",
					url: "<?php echo base_url();?>index.php/user_management_cont/get_state",
					cache: false,
					data :{ id: parent_id,uid:uid},
					success: function(data)
					{
						//alert(data);
					    $('#city').selectpicker('refresh');
					    
					    $("#city").html(data);
					    $('#city').selectpicker('refresh');
					    		
					    
				    }
			  });  
       
       
    //}
	
});
		
})
function doctor_validation()
{
	//var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
//	var has_error=0;
//    $('.need').each(function(){
//	
//        element_id = $(this).attr('id');
//	    element_value = $(this).val();
//        element_label = $(this).attr('label');
//        error_div = $("#"+element_id+"_error")
//		
//        if (element_value.search(/\S/)==-1)
//        {           
//            has_error++;
//            error_div.html(element_label+' is required.');
//            error_div.show();
//        }
//		if (element_value.search(/\S/) != -1)
//		{
//				if(element_id == 'workEmail' )
//				{					
//					    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
//						if(!re.test(element_value))
//						{
//							has_error++;
//							error_div.html('Please give correct email format.');
//						}
//						else
//						{
//							error_div.html('');
//							$('#overlay_main').show();
//			                $('#loading_img').show();
//			                $('#sitesetting_form').submit();
//						}
//						//alert(has_error);
//				}
//		}
//		//alert(has_error);
//		if (has_error>0)
//		{
//			return false;
//		}
//		else
//		{
//			error_div.html('');
//			
//		}
//	});
//	if (has_error>0)
//		{
//			return false;
//		}
//	else
//		{
//			//alert(has_error);
//			$('#overlay_main').show();
//			$('#loading_img').show();
//			$('#sitesetting_form').submit();
//		}	
		
		$('#overlay_main').show();
		$('#loading_img').show();
		$('#sitesetting_form').submit();
   
}
function update_doctor(id)
{
        window.location.href="<?php echo site_url();?>/user_management_cont/edit_user/"+id; //Edit Article Redirection Link
}
 function go_back()
   {
    window.location.href="<?php echo site_url();?>/user_management_cont/";
   }
function go_reset()
{
    window.location="<?php echo site_url();?>/user_management_cont";
}
</script>