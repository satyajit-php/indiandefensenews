        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit State</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Fields marked with <span style="color: red;">*</span> are mandatory
							 <a href="<?php echo site_url();?>/state_cont" style="color: white;">
							<button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                               Back
                            </button>
							</a>
                        </div>
                        <div class="panel-body">
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="state_frm" name="state_frm" method="POST" action="<?php echo base_url();?>index.php/state_cont/update_state" enctype="multipart/form-data">
					<div class="form-group">
                                            <label><span style="color: red;">*</span>Country:</label>
						<select class="form-control need" id="country_id" name="country_id" label="Country Name">
						<!--/**** Country Select Box ****/-->												
						<?php
						$res= $this->state_model->fetch_all_countries();
                                                foreach($res as $row):
						?>
						    <option value="<?php echo $row->location_id; ?>" <?php if($state_array[0]->country_id == $row->location_id){?>selected="selected"<?php } ?>><?php echo ucfirst($row->name);?></option>
						<?php
						endforeach; 
                                                ?>
						</select>
					</div>
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span>State Name:</label>
                                            <input class="form-control need" id="state" name="state" label="State Name" value="<?php echo $state_array[0]->state;?>">
                                            <span id="state_error" style="color: red;"></span>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span>Status:</label>
                                            <select class="form-control" id="state_status" name="status">
						<option value='0' <?php echo ($state_array[0]->status == 0)?'selected':''; ?>>Active</option>
						<option value='1' <?php echo ($state_array[0]->status == 1)?'selected':''; ?>>Inactive</option>
					    </select>
                                        </div>
                                        
                                        <button type="button" class="btn btn-success" onclick="validate_frm();">Submit</button>
                                        <input type="hidden" id="id" name="id" value="<?php echo $state_array[0]->id; ?>"/>
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

<!------------validate form------------->
<script>
function validate_frm()
{
    var has_error=0;
 
    //alert("Test");
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

function go_reset()
{
    window.location.href="<?php echo base_url();?>index.php/state_cont";
}
</script>
<!------------validate form------------->