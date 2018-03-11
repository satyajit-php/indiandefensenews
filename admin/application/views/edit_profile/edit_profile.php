<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Your Profile</h1>
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
                                <div class="col-lg-6">
                                    <form role="form" id="feature_frm" name="feature_frm" method="POST" action="<?php echo base_url();?>index.php/edit_profile_cont/update/<?php echo $features[0]->id ; ?>" enctype="multipart/form-data">
                                        <input type="hidden" id="mode_product" name="mode_product" value="insert_product"/>
										<input type = 'hidden' name='last_img' value="<?php echo $features[0]->image; ?>">
                                        <div class="form-group">
                                            <label>First Name <span style="color: red;">*</span>:</label>                                            
											 <input type="text" class="form-control need" id="fname" name="fname" label="First Name" value="<?php echo $features[0]->first_name ; ?>">
											 <span id="fname_error" style="color: red;"></span>
                                        </div>
										<div class="form-group">
                                            <label>Last Name <span style="color: red;">*</span>:</label>                                            
											 <input type="text" class="form-control need" id="lname" name="lname" label="Last Name" value="<?php echo $features[0]->last_name ; ?>">
											 <span id="lname_error" style="color: red;"></span>
                                        </div>
										<div class="form-group">
                                            <label>Email<span style="color: red;">*</span>:</label>                                            
											 <input type="text" class="form-control need" id="email" name="email" label="Email" value="<?php echo $features[0]->email ; ?>" readonly>
											 <span id="email_error" style="color: red;"></span>
                                        </div>
										<div class="form-group">
                                            <label>User Name<span style="color: red;">*</span>:</label>                                            
											 <input type="text" class="form-control need" id="uname" name="uname" label="User Name" value="<?php echo $features[0]->uname ; ?>">
											 <span id="uname_error" style="color: red;"></span>
                                        </div>
									    <?php
						                 if(isset($features[0]->image) && $features[0]->image!='')
                                           {
                                          ?>
										<div class="form-group">
                                            <label>Profile Image <span style="color: red;">*</span>:</label>
											 
                                                    <img alt="Your uploaded image" src="<?php echo base_url(). 'images/normal/' .$features[0]->image;?>"  height="200" width="200"/></td>
                                        </div>
										<?php
									       }
									     
									     ?>
											  
										<div class="form-group">
                                            <label>Upload Image<span style="color: red;"></span>:</label>                                            
											 <input type="file"  id="attachment_file" name="attachment_file" label="Image" style= "margin-top: 15px;" >
											 <span id="attachment_file_error" style="color: red;"></span>
                                        </div>
										
										<button type="button" class="btn btn-success" onclick="validate_frm();">Submit</button>
                                        <button type="reset" class="btn btn-default" onclick="redirect();" >Reset</button>
										
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
    
<!------------validate form------------->
<script src="<?php echo base_url();?>ckeditor/ckeditor.js"></script>
<script>
function redirect()
{
   window.location.href="<?php echo base_url();?>index.php/dashboard_cont";	    
}
function validate_frm()
{
	
    //var editor4 = CKEDITOR.instances.feature_desc.getData();
    var attachment_file=$("#attachment_file").val();
    var fileInput = document.getElementById('attachment_file');
   
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
  
        if (attachment_file.search(/\S/)!=-1 && !fileInput.files[0].name.match(/\.(jpg|jpeg|png|gif)$/))
	{
	     
	     has_error++;
	     $("#attachment_file_error").html('Please upload a valid image');
	}
    
    if (has_error>0)
    {
       return false;
    }
    else
    {
		//alert('page submit' );
		$('#overlay_main').show();
		$('#loading_img').show();
        document.feature_frm.submit();
    }
}

function go_reset()
{
    window.location.href="<?php echo base_url();?>index.php/features_cont";
}
</script>
<!------------validate form------------->