        <?php
        ini_set("display_errors", "1");
        error_reporting(E_ALL);
        ?>
        
<script type="text/javascript" src="<?php echo base_url();?>/jquery-1.7.2.min.js"></script>
<script type="text/javascript">

function Select_state(country_id ,type)
{
  
          //code
   //  alert(type);
    // alert('<?php echo base_url(); ?>index.php/country_cont/Select_state');
     if (type==1) {
           $('#state_div').removeClass('hide');
     }
     else if (type==2) {
            $('#state_div2').removeClass('hide');
     }
     $.ajax({
                    url: "<?php echo base_url(); ?>index.php/country_cont/Select_state",
                    async:false,
                    data: {
                     country_id:country_id
                    
                    },
                    
                    success: function(response) {
                         
                         if (type==1) {
                              //code
                         
                                   
                                 // alert(response);
                                  if (response == 0)
                                  {
                                      //alert('no response');
                                      $('#state_div').hide();
                                      
                                  }
                                  else
                                  {
                                       $('#state_div').show();
                                       $('#state1').html(response);
                                  }
                         }
                         if(type==2)
                         {
                              
                                 //alert(response);
                                  if (response == 0)
                                  {
                                      //alert('no response');
                                      $('#state_div2').hide();
                                      
                                  }
                                  else
                                  {
                                       $('#state_div2').show();
                                       $('#state2').html(response);
                                  }
                              
                         }
                               
                                //$('.selectpicker').selectpicker('refresh');
                           
                      
                          
                            
                    }
                          
                          
                    
                })
      
      
      
      
}


function  Select_district(state_id)
{
   //  alert("select district");
    // alert(state_id);
     $('#district_div').removeClass('hide');
     $.ajax({
                    url: "<?php echo base_url(); ?>index.php/country_cont/Select_dist",
                    async:false,
                    data: {
                     state_id:state_id
                    
                    },
                    
                    success: function(response) {
                       /// alert(response);
                        if (response == 0)
                        {
                            //alert('no response');
                            $('#district_div').hide();
                            
                        }
                        else
                        {
                             $('#district_div').show();
                             $('#district1').html(response);
                        }
                            
                               
                                //$('.selectpicker').selectpicker('refresh');
                           
                      
                          
                            
                    }
                          
                          
                    
                })
}
</script>
        
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add New Location</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Fields marked with <span style="color: red;">*</span> are mandatory
                            <a href="<?php echo site_url();?>/country_cont" style="color: white;">
                            <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                                Back
                            </button>
                            </a>
                        </div>
                        

                        
                        <div class="panel-body">
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label><span style="color: red;">*</span>Location Type:</label>
                                            <select class="form-control" id="country_id" name="country_id" label="Country Name" onChange="Select_location_type(this.value)">
                                                <!--/**** Country Select Box ****/-->
                                                    <option value="">Select Location</option>
                                                    <option value="country">Country</option>
                                                    <option value="state">State</option>
                                                    <option value="dist">District</option>
                                                    <option value="city">City</option>
                                            </select>
                                    </div>
                                    <!--------------------------------start country management------------------------------>
                                    
                                    <div id="country_managemnt">
                                        
                                        <form role="form" id="country_frm" name="country_frm" method="POST" action="<?php echo base_url();?>index.php/country_cont/insert_country" enctype="multipart/form-data">
                                        <input type="hidden" id="mode_article" name="mode_article" value="insert_country"/>

                                        <div class="form-group">
                                            <label>Country Name
                                            <span style="color: red;">*</span>:</label>
                                            <input class="form-control need" id="country_name" name="country_name" label="Country Name">
                                            <span id="country_name_error" style="color: red;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Currency
                                            <span style="color: red;">*</span>:</label>
                                            <input class="form-control need" id="currency" name="currency" label="Currency">
                                            <span id="currency_error" style="color: red;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Country Code
                                            <span style="color: red;">*</span>:</label>
                                            <input class="form-control need" id="country_code" name="country_code" label="Country Code">
                                            <span id="country_code_error" style="color: red;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Currency Code
                                            <span style="color: red;">*</span>:</label>
                                            <input class="form-control need" id="currency_code" name="currency_code" label="Currency Code">
                                            <span id="currency_code_error" style="color: red;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Currency Symbol
                                            <span style="color: red;">*</span>:</label>
                                            <input class="form-control need" id="symbol" name="symbol" label="Symbol">
                                            <span id="symbol_error" style="color: red;"></span>
                                        </div>
                                        
                                        <button type="button" class="btn btn-success" onclick="validate_frm();">Submit</button>
                                        <button type="button" class="btn btn-default" onclick="go_reset();">Reset</button>
                                        <div id="loading_img" style="display:none; float: right; margin-top: 5px;margin-right: 272px;"><img src="<?php echo base_url();?>images/facebook_loader.gif" alt=""></div>
                                        <div id="overlay_main" class="no_responce" style="display: none;"></div>
                                        </form>
                                    </div>
                                    
                                    <!--------------------------------end country management------------------------------>
                                    
                                    <!--------------------------------start state managemnt------------------------------->
                                    <div id="state_managemnt" style="display: none;">
                                        
                                        <form role="form" id="state_frm" name="state_frm" method="POST" action="<?php echo base_url();?>index.php/country_cont/insert_state" enctype="multipart/form-data">
                                        <input type="hidden" id="mode_state" name="mode_state" value="insert_state"/>                                        
					    <div class="form-group">
						<label><span style="color: red;">*</span>Country</label>
                                                <?php
                                                $res= $this->state_model->fetch_all_countries();
                                                 
                                                ?>
						    <select class="form-control need1" id="country_id" name="country_id" label="Country Name">
                                   <option value="">Select Country</option>
							<!--/**** Country Select Box ****/-->
							<?php
							
                                                       foreach($res as $row)
                                                        {
							?>
							    <option value="<?php echo $row->location_id; ?>"><?php echo ucfirst($row->name);?></option>
							<?php
							} 
							
							?>
						    </select>
					    </div>
					    <div class="form-group">
						<label><span style="color: red;">*</span>State Name:</label>
						<input class="form-control need1" id="state" name="state" label="State Name">
						<span id="state_error" style="color: red;"></span>
					    </div>
                                        
                                        <button type="button" class="btn btn-success" onclick="validate_frm_state();">Submit</button>
                                        <button type="reset" class="btn btn-default" onclick="go_reset();">Reset</button>
					<div id="loading_img" style="display:none; float: right; margin-top: 5px;margin-right: 272px;"><img src="<?php echo base_url();?>images/facebook_loader.gif" alt=""></div>
					<div id="overlay_main" class="no_responce" style="display: none;"></div>
                                        </form>
                                        
                                    </div>
                                    
                                    <!--------------------------------end state management-------------------------------->
                                    
                                     <!-------------------------------start district managemnt----------------------------->
                                    <div id="district_managemnt" style="display: none;">
                                        
                                        <form role="form" id="district_form" name="district_form" method="POST" action="<?php echo site_url();?>/country_cont/insert_dist">
				      
                                        <input type="hidden" name="mode_editcity" id="mode_editcity" value="add_dist">
                                         
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span>Country</label>
					    <?php
                                            $getcountry = $this->state_model->fetch_all_countries();
                                            //print_r($getcountry);
                                            //die();
                                            ?>
                                             <select class="form-control" name="country" id="country" onChange="Select_state(this.value,1)">
                                                                  <option value="select_country">Select Country</option>
                                            <?php                          
                                             if(count($getcountry)>0 || $getcountry !=0)
                                             {
                                                 foreach($getcountry as $key=>$val)
                                                 {
                                             ?>
                                             <option value="<?php echo $val->location_id; ?>"><?php echo ucfirst($val->name);?></option>
                                             <?php
                                                 }
                                             }
                                             ?>
                                          </select>
                                       </div>
                                                          
                                                          
                                      <div class="form-group hide" id="state_div">
                                          <label><span style="color: red;">*</span>State</label>
                                          <?php
                                                              //$getcountry = $this->city_model->fetch_country();
                                                              ?>
                                          <select class="form-control" name="state1" id="state1">                         
                                          </select>
                                                          </div>
                                                          <div class="form-group">
                                                              <label><span style="color: red;">*</span>District</label>
                                                              <input class="form-control need2" id="dist" name="dist" label="District">
                                          <span id="dist_error" style="color: red;"></span>
                                                          </div>
                                                          
                                          <!--                <div class="form-group">-->
                                          <!--                    <label><span style="color: red;"></span>Pincode</label>-->
                                          <!--                    <input class="form-control" id="pincode" name="pincode" label="Pincode">-->
                                          <!--<span id="pincode_error" style="color: red;"></span>-->
                                          <!--                </div>-->
                  
                                                          <button type="button" class="btn btn-success" onclick="add_district_validation();">Submit</button>
                                                          <button type="reset" class="btn btn-default" onclick="go_reset();">Reset</button>
                                           <input type = 'hidden' name='id' value=""></td>

                                        </form>
                                    </div>
                                    <!--------------------------------end district managemnt------------------------------>
                                    
 <!-------------------------------start city managemnt----------------------------->
               <div id="city_managemnt" style="display: none;">
                   
               <form role="form" id="city_form" name="city_form" method="POST" action="<?php echo site_url();?>/country_cont/insert_city">
 
				     <input type="hidden" name="mode_editcity" id="mode_editcity" value="add_city">
                                        
                                         
                                         
                    <div class="form-group">
                    <label><span style="color: red;"></span>Country</label>
					    <?php
                         $getcountry_city = $this->city_model->fetch_all_countries();
                         ?>
					       <select class="form-control" name="country11" id="country11" onChange="Select_state(this.value,2)">
                             <option>Select Country</option>
					      <?php                          
						   if(count($getcountry_city)>0 || $getcountry_city !=0)
						   {
						       foreach($getcountry_city as $key=>$con)
						       {
						   ?>
						  <option value="<?php echo $con->location_id; ?>"><?php echo ucfirst($con->name);?></option>
						   <?php
						       }
						   }
						   ?>
					    </select>
                    </div>
                               
                         <div class="form-group hide" id="state_div2">
                                          <label><span style="color: red;"></span>State</label>
                                          <?php
                                                              //$getcountry = $this->city_model->fetch_country();
                                                              ?>
                                          <select class="form-control" name="state2" id="state2" onChange="Select_district(this.value)">                         
                                            <option></option>
                                          
                                          </select>
                          </div>     
                               
                                        
                         <div class="form-group hide" id="district_div">
                                          <label><span style="color: red;"></span>District</label>
                                          <?php
                                                              //$getcountry = $this->city_model->fetch_country();
                                                              ?>
                                          <select class="form-control" name="district1" id="district1">
                                            
                                          </select>
                          </div>     
                                             
                     
                      
                         <div class="form-group">
                              <label><span style="color: red;">*</span>City</label>
                                            <input class="form-control need3" id="city" name="city" label="City">
					                       <span id="city_error" style="color: red;"></span>
                         </div>
                         
                          <div class="form-group">
                                        <label><span style="color: red;"></span>Pincode</label>
                                        <input class="form-control" id="pin" name="pin" label="Pincode">
                                          <span id="pin_error" style="color: red;"></span>
                          </div>
                         
					     <button type="button" class="btn btn-success" onclick="add_city_validation();">Submit</button>
                                             <button type="reset" class="btn btn-default" onclick="go_reset();">Reset</button>
					     <input type = 'hidden' name='id' value=""></td>
                         </form>
                                        
                                    </div>
                                    <!--------------------------------end city managemnt------------------------------>
                                    
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
    
    
<script src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
<!----- start script for select location type------>

<script>
    function Select_location_type(location_type)
    {
       // alert(location_type);
        if (location_type == 'country')
        {
            $('#country_managemnt').show();
            $('#state_managemnt').hide();
            $('#district_managemnt').hide();
            $('#city_managemnt').hide();
        }
        if (location_type == 'state')
        {
            $('#country_managemnt').hide();
            $('#state_managemnt').show();
            $('#district_managemnt').hide();
            $('#city_managemnt').hide();
        }
        if (location_type == 'dist')
        {
            $('#country_managemnt').hide();
            $('#state_managemnt').hide();
            $('#district_managemnt').show();
            $('#city_managemnt').hide();
        }
        if (location_type == 'city')
        {
            $('#country_managemnt').hide();
            $('#state_managemnt').hide();
            $('#district_managemnt').hide();
            $('#city_managemnt').show();
        }
    }
    
</script>

<!----- end script for select location type------>

<!------------validate form country------------->
<script>
function validate_frm()
{
    var has_error=0;
    //var editor4 = CKEDITOR.instances.article_desc.getData();
    //alert("Test");
    $('.need').each(function(){
        element_id = $(this).attr('id');
        element_value = $(this).val();
        element_label = $(this).attr('label');
        error_div = $("#"+element_id+"_error")
        //alert(element_id);
        //alert(element_value);
       
        if (element_value.search(/\S/)==-1)
        {
          has_error++;
          error_div.html(element_label+' is required.');
        }
        else
        {
            error_div.html('');
        }
    });
    
    //alert(has_error);
    //if(editor4.search(/\S/)==-1)
    //{
    //    has_error++;
    //    document.getElementById('article_desc_error').innerHTML='Article Description is required.';
    //}
    //else
    //{
    //    document.getElementById('article_desc_error').innerHTML='';
    //}
    //
    //alert(has_error);
    
    if (has_error>0)
    {
       return false;
    }
    else
    {
        $('#overlay_main').show();
        $('#loading_img').show();
        document.country_frm.submit();
    }
}


function go_reset()
{
    window.location.href="<?php echo base_url();?>index.php/country_cont/add_country";
}

</script>
<!------------validate form country end------------->

<!--------------validate form state------------->
<script>
function validate_frm_state()
{
    var has_error=0;
 
    //alert("Test");
    $('.need1').each(function(){
		//alert("Test");
        element_id = $(this).attr('id');
        element_value = $(this).val();
        element_label = $(this).attr('label');
        error_div = $("#"+element_id+"_error")
       // alert(element_id);
        if (element_value.search(/\S/)==-1)
        {
          has_error++;
          error_div.html(element_label+' is required.');
        }
        else
        {
            error_div.html('');
        }
    });
    
    if (has_error>0)
    {
       return false;
    }
    else
    {
	$('#overlay_main').show();
	$('#loading_img').show();
        document.state_frm.submit();
    }
}


</script>
<!------------validate form state end------------->

<!---------------validation for district----------->

<script type="text/javascript">
   function add_district_validation()
   {
      var has_error=0;
      $('.need2').each(function(){
	 element_id = $(this).attr('id');
	 element_value = $(this).val();
	 element_label = $(this).attr('label');
	 error_div = $("#"+element_id+"_error")
	  //alert(element_id);
	 if (element_value.search(/\S/)==-1)
	 {
	   has_error++;
	   error_div.html(element_label+' is required.');
	 }
	 else
	 {
	   error_div.html('');	  
	 }
    });
	  
      //alert(has_error);
      if (has_error>0)
      {
	 	return false;
      }
      else
      {
        $('#overlay_main').show();
	    $('#loading_img').show();
      	document.district_form.submit();
      }
   }
</script>


<!----------------validation end for district------>

<!----------add city validation section------------->
<script type="text/javascript">
   function add_city_validation()
   {
      var has_error=0;
      $('.need3').each(function(){
	 element_id = $(this).attr('id');
	 element_value = $(this).val();
	 element_label = $(this).attr('label');
	 error_div = $("#"+element_id+"_error")
	  //alert(element_id);
     if(element_value.search(/\S/) != -1)
			{
				//alert(element_value);
			    
					if (element_id == "pin")
					{
					   // alert(element_value)
						if (isNaN(element_value))
						{
							has_error++;
							error_div.html(element_id+'Zipcode should be in number');
						}
					
					
					}
            }     
	 if (element_value.search(/\S/)==-1)
	 {
	   has_error++;
	   error_div.html(element_label+' is required.');
	 }
	 else
	 {
	   error_div.html('');	  
	 }
    });
	  
      //alert(has_error);
      if (has_error>0)
      {
	 	return false;
      }
      else
      {
        $('#overlay_main').show();
	    $('#loading_img').show();
      	document.city_form.submit();
      }
   }
</script>

<!------------end city validation------------------>
