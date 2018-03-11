        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Upload CSV</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Fields marked with <span style="color: red;">*</span> are mandatory
							<a href="<?php echo site_url();?>/badlang_cont" style="color: white;"><button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                                Back
                            </button></a>
                        </div>
                        <div class="panel-body">
                            
                            <div class="row">
                                <div class="col-lg-6">
									    <form action="<?php echo site_url();?>/badlang_cont/upload_sampledata" method="post" enctype="multipart/form-data" name="blog_frm" id="blog_frm"> 
											<label style="margin-left: 18px;"> Upload CSV: </label>
											  <input type="file" class="form-control" name="userfile" id="userfile" />
											  <span id="userfile_error" style="color: red;"></span>  
											  <br><br>
											  <button type="button" class="btn btn-success" onclick="validate_frm();">Submit</button>
                                              <button type="reset" class="btn btn-default" >Reset</button>
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
    var upl= $('#userfile').val();
	if(upl.search(/\S/)==-1) 
		{
			   // alert(element_id +" "+element_value+"  "+has_error );
			
				has_error++;
				$('#userfile_error').html('Please Upload a CSV file');
			
		}
	
	
	else if((upl.search(/\S/)!=-1) && (!upl.match(/(?:csv)$/)))
		{
			   // alert(element_id +" "+element_value+"  "+has_error );
			
				has_error++;
				$('#userfile_error').html('Please upload CSV file only');
			
		}
	else
		{
			$('#userfile_error').html(' ');
		}	 
	
    
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
    window.location.href="<?php echo base_url();?>index.php/badlang_cont";
}
</script>
<!------------validate form------------->