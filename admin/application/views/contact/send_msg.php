	 	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Email Sending</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Email
							<a href="<?php echo site_url();?>/contact_list/edit_contact/<?php echo $result[0]->id; ?>" style="color: white;">
							<button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                              Back
                            </button>
							</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
				    <form role="form" id="email_template_form" name="email_template_form" method="POST" action="<?php echo site_url();?>/contact_list/send_msg">
				      
				     <input type="hidden" name="mode_addarticle" id="mode_addarticle" value="add_article">
					 <input type="hidden" name="con_id" id="con_id" value="<?php echo $result[0]->id;?>">
                    <div class="form-group">
									<label><span style="color: red;"></span>To</label>
									<input class="form-control" id="to" name="to" label="To" value="<?php echo $result[0]->contact_email;?>" readonly>
                                            
					              <!--<span id="email_title_error" style="color: red;"></span>-->
                     </div>
					 <div class="form-group">
									<label><span style="color: red;">*</span>Subject</label>
									<input class="form-control" id="subject" name="subject" label="Subject" value="">
                                            
					              <span id="subject_error" style="color: red;"></span>
                     </div>
					<div class="form-group">
					    <label><span style="color: red;">*</span>Email Body</label>
					
						<textarea  class="form-control" cols="80" id="email_body" label="Email Body" name="email_body" rows="10"></textarea>
						<span id="email_body_error" style="color: red;"></span>
					</div>	
                                        <!--<div class="form-group">
                                            <label>Text Input with Placeholder</label>
                                            <input class="form-control" placeholder="Enter text">
                                        </div>-->
                                       
									   
                                        
                                       <button type="button" class="btn btn-success" onclick="email_template_validation();">Send</button>
									   <button type="reset" class="btn btn-default" >Reset</button>
										<div id="loading_img" style="display:none; float: right; margin-top: 5px;margin-right: 180px;"><img src="<?php echo base_url();?>images/facebook_loader.gif" alt=""></div>
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


<!------------------------ck editor validation section--------------------->
	<script src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
	<!--<link href="<?php echo base_url(); ?>ckeditor/samples/sample.css" rel="stylesheet">-->
	
	<!--<style>

		.cke_focused,
		.cke_editable.cke_focused
		{
			outline: 3px dotted blue !important;
			*border: 3px dotted blue !important;	/* For IE7 */
		}

	</style>-->
	<!--<script>-->
	<!---->
	<!--	CKEDITOR.on( 'instanceReady', function( evt ) {-->
	<!--		var editor = evt.editor;-->
	<!--		editor.setData( 'This editor has it\'s tabIndex set to <strong>' + editor.tabIndex + '</strong>' );-->
	<!---->
	<!--		// Apply focus class name.-->
	<!--		editor.on( 'focus', function() {-->
	<!--			editor.container.addClass( 'cke_focused' );-->
	<!--		});-->
	<!--		editor.on( 'blur', function() {-->
	<!--			editor.container.removeClass( 'cke_focused' );-->
	<!--		});-->
	<!---->
	<!--		// Put startup focus on the first editor in tab order.-->
	<!--		if ( editor.tabIndex == 1 )-->
	<!--			editor.focus();-->
	<!--	});-->
	<!---->
	<!--</script>-->
<!------------------------ck editor validation section--------------------->


<!---------------------------email template validation section------------------------------>
<script type="text/javascript">
   function email_template_validation()
   {
      var error=0;
       //var editor4=$('#editor4').val();
    
       
//      $('.form-control').each(function(){
//	 element_id = $(this).attr('id');
//	 element_value = $(this).val();
//	 element_label = $(this).attr('label');
//	 error_div = $("#"+element_id+"_error")
//	  //alert(element_id);
//	 if (element_value.search(/\S/)==-1)
//	 {
//	   has_error++;
//	   error_div.html(element_label+' is required.');
//	 }
//	 else
//	 {
//	   error_div.html('');	  
//	 }
//    });

      
//	   if(editor4.search(/\S/)==-1 || editor4=='')
//	   {
//		has_error++;
//		document.getElementById('editor4_error').innerHTML='Email Template Content is required.';
//	   }
//	   else
//	   {
//		document.getElementById('editor4_error').innerHTML='';
//	   }
      var s=document.getElementById("subject").value;
	  var b=document.getElementById("email_body").value;
       
	    if (s.search(/\S/) == -1){
			
			   $('#subject_error').html("Subject is required");
			error++;
           
		 }
		else{
			   $('#subject_error').html('');
           
		 }
	    if (b.search(/\S/) == -1){
			
			$('#email_body_error').html("Email Body is required");
			error++;
          
		 }
		else{
			$('#email_body_error').html('');
           
		 }
	   
	   
      alert(error);
      if (error>0)
      {
	 	return false;
      }
      else
      {
		$('#overlay_main').show();
	    $('#loading_img').show();
      	document.email_template_form.submit();
      }
   }
   
//   function go_back()
//   {
//	  var id=$('#con_id').val();
//      window.location.href="<?php echo site_url();?>/contact_list/edit_contact/"+id;
//   }
</script>
<!--------------------------------------email template validation section----------------------------------->