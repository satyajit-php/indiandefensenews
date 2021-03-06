        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add New Blog Tag</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Fields marked with <span style="color: red;">*</span> are mandatory
							<a href="<?php echo site_url();?>/blog_tag" style="color: white;"><button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                                Back
                            </button></a>
                        </div>
                        <div class="panel-body">
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="blog_frm" name="blog_frm" method="POST" action="<?php echo base_url();?>index.php/blog_tag/insert_blog_content" enctype="multipart/form-data">
                                        <input type="hidden" id="mode_blog" name="mode_blog" value="insert_blog"/>
                                        <div class="form-group">
                                            <label>Tag Name <span style="color: red;">*</span>:</label>
                                            <input class="form-control need" id="blog" name="blog" label="Tag Name">
                                            <span id="blog_error" style="color: red;"></span>
                                        </div>
                                       
										<div class="form-group">
                                            <label>Status
                                            <span style="color: red;">*</span>:</label>
                                           <!-- <input class="form-control need" id="faq_typ_name" name="faq_typ_name" label="FAQ Type Name">-->
                                            
                                            <select class="form-control need" id="status" name="status" label="Status">
                                             <option value="">Select Status</option>   
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                            </select>
                                            
                                            
                                            <span id="status_error" style="color: red;"></span>
                                        </div>

                                        <!--<div class="form-group">
                                            <label>Image</label>
                                            <input type="file">
                                        </div>-->
                                        
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
  
    
    //alert(has_error);
    
    if (has_error>0)
    {
       return false;
    }
    else
    {
		$('#overlay_main').show();
		$('#loading_img').show();
        document.blog_frm.submit();
    }
}

function go_reset()
{
    window.location.href="<?php echo base_url();?>index.php/blog_tag";
}
</script>
<!------------validate form------------->