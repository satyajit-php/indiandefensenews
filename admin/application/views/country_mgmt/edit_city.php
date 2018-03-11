  <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit City</h1>
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
                                    <form role="form" id="country_frm" name="country_frm" method="POST" action="<?php echo base_url();?>index.php/country_cont/update_city" enctype="multipart/form-data">
                                        
                                     <input type="hidden" name="id" id="id" value="<?php  if(isset($location_id) && $location_id!=""){  echo $location_id ;} ?>">
                                    
                                       <?php
                                         if(isset($country) && $country!="")
                                         {
                                        ?>
                                      <div class="form-group">
                                            <label>Country Name
                                            <span style="color: red;"></span>:</label>
                                            <input class="form-control need" id="country_name" name="country_name" label="Country Name" value="<?php echo $country ; ?>" readonly>
                                            <span id="country_name_error" style="color: red;"></span>
                                     </div>
                                      <?php
                                         }
                                        ?>
                                        <?php
                                        if(isset($state) && $state!="")
                                        {
                                         ?>
                                        <div class="form-group">
                                            <label>State Name
                                            <span style="color: red;"></span>:</label>
                                            <input class="form-control need" id="state" name="state" label="State Name" value="<?php echo $state ; ?>" readonly>
                                            <span id="state_error" style="color: red;"></span>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if(isset($district) && $district!="")
                                        {
                                        ?>
                                         <div class="form-group">
                                            <label>District Name
                                            <span style="color: red;"></span>:</label>
                                            <input class="form-control need" id="district" name="district" label="District Name" value="<?php echo $district ; ?>" readonly>
                                            <span id="district_error" style="color: red;"></span>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label>City Name
                                            <span style="color: red;">*</span>:</label>
                                            <input class="form-control need" id="city" name="city" label="City Name" value="<?php if(isset($city) && $city!=""){  echo $city ; } ?>">
                                            <span id="city_error" style="color: red;"></span>
                                        </div>
                                         <div class="form-group">
                                                  <label><span style="color: red;"></span>Pincode</label>
                                                  <input class="form-control " id="pin" name="pin" label="Pincode" value="<?php if(isset($zip) && $zip!=""){  echo $zip ; } ?>">
                                                    <span id="pin_error" style="color: red;"></span>
                                         </div>
                         
                                        <button type="button" class="btn btn-success" onclick="validate_frm();">Submit</button>
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
    
    
<script src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
<!------------validate form------------->
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
        
          if(element_value.search(/\S/) != -1)
			{
				//alert(element_value);
			    
					if (element_id == "pin")
					{
					    
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
    window.location.href="<?php echo base_url();?>index.php/country_cont";
}
</script>
<!------------validate form------------->