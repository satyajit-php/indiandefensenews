
<body>
       
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Send Mail</h1>
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
                                <div class="col-lg-12">
                                    <form role="form" id="rules_frm" name="rules_frm" method="POST" action="<?php echo base_url();?>index.php/ind_email_cont/mail_send" enctype="multipart/form-data">
                                        <input type="hidden" id="mode_alert" name="mode_alert" value="insert_alert"/>
                                        
                                        <div class="form-group">
                                            <label>Email Address<span style="color: red;">*</span>:</label>
                                            <input type='email' id='e_address' name='e_address' class='form-control need' label='Email Address'>
                                            <span id="e_address_error" style="color: red;"></span>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Subject:</label>
                                            <input type='text' id='subject' name='subject' class='form-control' label='Email Subject'>
                                            <span id="subject_error" style="color: red;"></span>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Body<span style="color: red;">*</span>:</label><br>
                                             <textarea class="tinyeditor" cols="80" id="tinyeditor" label="Email_Body" name="email_body" rows="10"><?php echo $email_temp[0]->email_desc;?></textarea>
						<span id="editor4_error" style="color: red;"></span>
                                        </div>
                                        
                                        <button type="button" class="btn btn-success" onclick="validate_frm();">Send</button>
                                        <button type="button" class="btn btn-default" onclick="go_reset();">Cancel</button>
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
</body>
    
<script src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url(); ?>tinymce/js/tinymce/tinymce.dev.js"></script>
<script src="<?php echo base_url(); ?>tinymce/js/tinymce/plugins/table/plugin.dev.js"></script>
<script src="<?php echo base_url(); ?>tinymce/js/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="<?php echo base_url(); ?>tinymce/js/tinymce/plugins/spellchecker/plugin.dev.js"></script>
<script src="<?php echo base_url(); ?>tinymce/js/tinymce_script.js"></script>
<!------------validate form------------->
<script>
    
function validate_frm()
{
    //var ck_no=/^(0|[1-9][0-9]*)$/;
    //var rules_no=document.getElementById('rules_no').value;

    var re =/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

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
       if (element_value.search(/\S/)!=-1) {
            if (element_id=='e_address') {
                if (!(re.test(element_value))) {
                    has_error++;
             error_div.html('Enter a valid email address.');
                }
                else
                {
               error_div.html('');
                }
            }
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
        document.rules_frm.submit();
    }
}

function go_reset()
{
    window.location.href="<?php echo base_url();?>index.php/dashboard_cont";
}
</script>
<!------------validate form------------->