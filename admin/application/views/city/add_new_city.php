<script type="text/javascript" src="<?php echo base_url();?>/jquery-1.7.2.min.js"></script>
<script type="text/javascript">

function Select_state(country_id)
{
     //alert(country_id);
     $('#state_div').removeClass('hide');
     $.ajax({
                    url: "<?php echo base_url(); ?>index.php/city_cont/Select_state",
                    async:false,
                    data: {
                     country_id:country_id
                    
                    },
                    
                    success: function(response) {
                      
                           $('#state').html(response);
                            
                           }
                          
                          
                    
                })
}
</script>
		
		
		<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add New City</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            City Form Elements
							 <a href="<?php echo site_url();?>/city_cont" style="color: white;">
							<button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                               Back
                            </button>
							</a>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-lg-6">
				    <form role="form" id="news_letter_form" name="news_letter_form" method="POST" action="<?php echo site_url();?>/city_cont/insert_city">
				      
				     <input type="hidden" name="mode_editcity" id="mode_editcity" value="add_city">
                                          <div class="form-group">
                                            <label><span style="color: red;">*</span>City</label>
                                            <input class="form-control need" id="city" name="city" label="City">
					    <span id="city_error" style="color: red;"></span>
                                        </div>
                                         
                                         
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span>Country</label>
					    <?php $getcountry = $this->city_model->fetch_country();?>
					       <select class="form-control" name="country" id="country" onChange="Select_state(this.value)">
					      <?php                          
						   if(count($getcountry)>0 || $getcountry !=0)
						   {
						       foreach($getcountry as $key=>$val)
						       {
						   ?>
						   <option value="<?php echo $val->id;?>"><?php echo $val->country_name;?></option>
						   <?php
						       }
						   }
						   ?>
					    </select>
                                        </div>
                                        
                                        
                                        <div class="form-group hide" id="state_div">
					    <label><span style="color: red;">*</span>State</label>
					    <?php $getcountry = $this->city_model->fetch_country();?>
					    <select class="form-control" name="state" id="state">                         
					    </select>
                                        </div>
                                        
					     <button type="button" class="btn btn-success" onclick="add_city_validation();">Submit</button>
					     <input type = 'hidden' name='id' value=""></td>
					     <button type="reset" class="btn btn-default">Reset</button>
					     <div id="loading_img" style="display:none; float: right; margin-top: 5px;margin-right: 272px;"><img src="<?php echo base_url();?>images/facebook_loader.gif" alt=""></div>
					     <div id="overlay_main" class="no_responce" style="display: none;"></div>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                               
                                <!-- /.col-lg-6 (nested) -->
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
   </div>
   
<!---------------------------add city validation section------------------------------>
<script type="text/javascript">
   function add_city_validation()
   {
      var has_error=0;
      $('.need').each(function(){
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
      	document.news_letter_form.submit();
      }
   }
   
   function go_reset()
   {
      window.location.href="<?php echo site_url();?>/city_cont";
   }
  
</script>
