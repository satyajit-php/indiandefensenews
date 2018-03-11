        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Contact List</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Fields marked with <span style="color: red;">*</span> are mandatory
                             <a href="<?php echo site_url();?>/contact_list" style="color: white;">
                            <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                               Back
                            </button>
                            </a>
                        </div>
                        <div class="panel-body">
                          
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="contact_frm" name="contact_frm" method="POST" action="<?php echo base_url();?>index.php/contact_list/updatecontact/<?php echo $result[0]->id;?>" enctype="multipart/form-data">
                                         <input type="hidden" id="mode_contact" name="mode_contact" value="contact">
                                          <input type="hidden" id="contact_id" name="contact_id" value="<?php echo $result[0]->id;?>">
                                        <div class="form-group" id="conby">
                                            <label>Contacted By
                                            <span style="color: red;"></span>:</label>
                                            <input class="form-control need" id="contacted_by" name="contacted_by" label="Contacted_by" value="<?php echo $result[0]->contacted_by;?>">
                                            <span id="contacted_by_error" style="color: red;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Contact Email
                                            <span style="color: red;">*</span>:</label>
                                            <input class="form-control need" id="contact_email" name="contact_email" label="contact_email" value="<?php echo $result[0]->contact_email;?>">
                                            <span id="contact_email_error" style="color: red;"></span>
                                        </div>
                                        <div class="form-group" id="compnm">
                                            <label>Company Name
                                            <span style="color: red;"></span>:</label>
                                            <input class="form-control need" id="company_name" name="company_name" label="company_name" value="<?php echo $result[0]->company_name;?>">
                                            <span id="company_name_error" style="color: red;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Message
                                            <span style="color: red;">*</span>:</label>
                                            <input class="form-control need" id="message" name="message" label="Symbol" value="<?php echo $result[0]->message;?>">
                                            <span id="message_error" style="color: red;"></span>
                                        </div>
                                         <div class="form-group">
                                            <label>Contacted On
                                            <span style="color: red;"></span>:</label>
                                            <input class="form-control need" id="contacted_on" name="contacted_on" label="contacted_on" value="<?php echo $result[0]->contacted_on ;?>" readonly>
                                            <span id="contacted_on_error" style="color: red;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Status<span style="color: red;">*</span>:</label>
                                            <select class="form-control" id="status" name="status">
                                            <option value="0" <?php if($result[0]->status=='0'){?> selected="selected" <?php } ?>>Active</option>
                                            <option value="1" <?php if($result[0]->status=='1'){?> selected="selected" <?php } ?>>Inactive</option>
                                            </select>
                                        </div>
                                        
                                        <button type="button" class="btn btn-success" onclick="validate_frm();">Submit</button>
                                        <button type="reset" class="btn btn-default" onclick= "go_reset();">Reset</button>
                                         <button type="button" class="btn btn-default" onclick= "go_reply();">Reply</button>
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
$(document).ready(function(){
    var cby=$('#contacted_by').val();
    var conm=$('#company_name').val();
   // alert(cby+""+conm);
   if (cby=="") {
                   $('#conby').hide();
   }
    if (conm=="") {
                   $('#compnm').hide();
   }
});  
    
    
function validate_frm()
{
    var error=0;
    //var editor4 = CKEDITOR.instances.article_desc.getData();
    //alert("Test");
        //$('.need').each(function(){
        //    element_id = $(this).attr('id');
        //    element_value = $(this).val();
        //    element_label = $(this).attr('label');
        //    error_div = $("#"+element_id+"_error")
        //    //alert(element_id);
        //    if (element_value.search(/\S/)==-1)
        //    {
        //      has_error++;
        //      error_div.html(element_label+' is required.');
        //    }
        //    else
        //    {
        //        error_div.html('');
        //    }
        //});
        //
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
    
    var em=document.getElementById("contact_email").value;
	var msg=document.getElementById("message").value;
    var filter= /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (em.search(/\S/) == -1) {
          
              $('#contact_email_error').html("Email is required");
              error++;
               $('#contact_email_error').show();
          
      }
      else if (em.search(/\S/) != -1 && (!filter.test(em)))
      {
              $('#contact_email_error').html("Correct Email format is required");
              error++;
               $('#contact_email_error').show();
      }
      else{
              $('#contact_email_error').html("");
              
               $('#contact_email_error').hide();
      }
    if (msg.search(/\S/) == -1){
          
          $('#message_error').html("Message is required");
          error++;
          $('#message_error').show();
       }
    else{
			$('#message_error').html('');
            $('#message_error').hide();
		 }
  
    if (error>0)
    {
       return false;
    }
    else
    {
        $('#overlay_main').show();
        $('#loading_img').show();
        document.contact_frm.submit();
    }
}

function go_reset()
{
    var id=$('#contact_id').val();
    window.location.href="<?php echo base_url();?>index.php/contact_list/edit_contact/"+id;
}
function go_reply()
{
    var id=$('#contact_id').val();
    window.location.href="<?php echo base_url();?>index.php/contact_list/go_reply/"+id;
}

</script>
<!------------validate form------------->