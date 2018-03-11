	 	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add Email Template</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Email Templates Form Elements
							<a href="<?php echo site_url();?>/email_template_cont" style="color: white;">
							<button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                                Back
                            </button>
							</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
				    <form role="form" id="email_template_form" name="email_template_form" method="POST" action="<?php echo site_url();?>/email_template_cont/insert_email_template">
				     <input type="hidden" name="mode_addarticle" id="mode_addarticle" value="add_article">
					 <div class="form-group">
                                            <label><span style="color: red;">*</span>Email Type</label>
                                            <select class="form-control need" id="email_type" name="email_type" label="Email Type">
						<option value="">Select Email Type</option>
                                                <option value="0">Default</option>
                                                <option value="1">Newsletter</option>
                                            </select>
					     <span id="email_type_error" style="color: red;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span>Email Title</label>
                                            <input class="form-control need" id="email_title" name="email_title" label="Email Title">
                                            <!--<p class="help-block">Example block-level help text here.</p>-->
					    <span id="email_title_error" style="color: red;"></span>
                                        </div>
					<!--<div class="form-group">
                                            <label>Email Body</label>
                                            <textarea class="form-control need" rows="3"  id="email_body" label="Email_Body"></textarea>
					     <span id="email_body_error" style="color: red;"></span>
                                        </div>-->
					<div class="form-group">
					    <label><span style="color: red;">*</span>Email Body</label>
					
						<textarea class="tinymce" cols="80" id="tinyeditor" label="Email_Body" name="email_body" rows="10"></textarea>
						<span id="editor4_error" style="color: red;"></span>
					</div>	
                                        <!--<div class="form-group">
                                            <label>Text Input with Placeholder</label>
                                            <input class="form-control" placeholder="Enter text">
                                        </div>-->
				       <div class="form-group">
						  <table border="1" cellpadding="0" cellspacing="0" width="100%">
						     <tr>
							     <th>Placeholder <span style="font-size: 10px;">(Use these placeholders for email body)</span></th>
							     <th>Details</th>
						     </tr>
						   
						     <tr>
							     <td>
								     [RECEIVER]
							     </td>
							     <td>
								     Email receiver name
							     </td>
						     </tr>
						     <tr>
							     <td>
								     [SENDER]
							     </td>
							     <td>
								     Email sender name
							     </td>
						     </tr>
						     <tr>
							     <td>
								     [RECEIVER_EMAIL]
							     </td>
							     <td>
								     Email id of the receiver
							     </td>
						     </tr>
						     <tr>
							     <td>
								     [SENDER_EMAIL]
							     </td>
							     <td>
								     Email id of sender
							     </td>
						     </tr>
						     <tr>
							     <td>
								     [DATE]
							     </td>
							     <td>
								     Date
							     </td>
						     </tr>
						     <tr>
							     <td>
								     [PRICE]
							     </td>
							     <td>
								     Price
							     </td>
						     </tr>
						     <tr>
							     <td>
								     [SITENAME]
							     </td>
							     <td>
								     Site Name
							     </td>
						     </tr>
						     <tr>
							     <td>
								     [LINK]
							     </td>
							     <td>
								     Any Links
							     </td>
						     </tr>
						     <tr>
							     <td>
								     [LOGO]
							     </td>
							     <td>
								     Logo of the site
							     </td>
						     </tr>
							  <tr>
							     <td>
								     [BODY]
							     </td>
							     <td>
								     Email body
							     </td>
						     </tr>
						  </table>
				       </div>
                                        <!--<div class="form-group">
                                            <label>Selects</label>
                                            <select class="form-control">
                                                <option>1</option>
                                                <option>2</option>
                                            </select>
                                        </div>-->
                                        
                                        <button type="button" class="btn btn-success" onclick="email_template_validation();">Submit</button>
                                        <button type="reset" class="btn btn-default">Reset</button>
										<div id="loading_img" style="display:none; float: right;top: -27px;margin-right: 180px;"><img src="<?php echo base_url();?>images/facebook_loader.gif" alt=""></div>
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

	<!--<script src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>-->
<script src="<?php echo base_url(); ?>tinymce/js/tinymce/tinymce.dev.js"></script>
<script src="<?php echo base_url(); ?>tinymce/js/tinymce/plugins/table/plugin.dev.js"></script>
<script src="<?php echo base_url(); ?>tinymce/js/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="<?php echo base_url(); ?>tinymce/js/tinymce/plugins/spellchecker/plugin.dev.js"></script>
<script src="<?php echo base_url(); ?>tinymce/js/tinymce_script.js"></script>
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
      var has_error=0;
       //var editor4=$('#editor4').val();
       var editor4 = tinyMCE.get('tinyeditor').getContent();
       
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
//
      
	   if(editor4.search(/\S/)==-1 || editor4=='')
	   {
		has_error++;
		document.getElementById('editor4_error').innerHTML='Email Template Content is required.';
	   }
	   else
	   {
		document.getElementById('editor4_error').innerHTML='';
	   }
      //alert(has_error);
      if (has_error>0)
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
   
   function go_reset()
   {
      window.location.href="<?php echo site_url();?>/email_template_cont";
   }
</script>
<!--------------------------------------email template validation section----------------------------------->