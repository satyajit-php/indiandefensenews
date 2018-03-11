  <?php
    //echo ("<pre>");
    //print_r($user_data);die();
	    
  ?>
	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="page-header">Feedback Details</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="height: 41px;">
                            <!--Fields marked with <span style="color: red;">*</span> are mandatory-->
							<a href="<?php echo site_url();?>/feedback_cont" style="color: white;">
							<button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                               Back
                            </button>
							</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-8">
										<?php
										//$reviewedName = $this->flag_off_model->reviewedByFlag($particular_notification[0]->review_id);
										 ?>
										<div class="form-group">
												<label>Feedback From:</label>
												<?php echo $particular_feedback->email; ?>
										</div>
										<div class="form-group">
												<label>comment:</label>
												<?php echo $particular_feedback->comment; ?>
										</div>
										<div class="form-group">
												<label> Contact Details:</label>
												<?php echo $particular_feedback->contact; ?>
										</div>
										<div class="form-group">
												<label> Contact Details:</label>
												<?php echo date("F j, Y",strtotime($particular_feedback->date));?>
										</div>
								</div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
						

                        <!-- /.panel-body -->
                    </div>
						<button type="button" class="btn btn-primary btn-sm send-mail" style="margin-top: -5px;" onclick="email_modal_open(<?php echo $particular_feedback->id; ?>,'<?php echo $particular_feedback->email; ?>')">
                               Send Mail
                        </button>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    <!-- Modal -->
    <div id="emailBody" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
    
	<!-- Modal content-->
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Write your Email here</h4>
	    </div>
	    <form name="email_form" id="email_form" method="POST" action="<?php echo site_url(); ?>/feedback_cont/sendMessage" enctype="multipart/form-data">
		<input type="hidden" name="feedback_id" id="feedback_id" value="">
		<input type="hidden" name="receiver_mail" id="receiver_mail" value="">
		
		<input class="form-control" id="message_to" type="hidden" name="message_to"value="" />
		<div class="modal-body">
		    <div class="form-group">
			<label>Subject<span style="color: red;">*</span>:</label>
			<input class="form-control" type="text" id="message_subject" name="message_subject" value="" />
		    </div>
			<div id="message_subject_error" style="color: red;"></div>
			
		    <div class="form-group">
			<label>Body<span style="color: red;">*</span>:</label>
			<textarea class="form-control" required="required" id="message_desc" name="message_desc" rows="10"></textarea>
		    </div>
			<div id="message_desc_error" style="color: red;"></div>
		</div>
		
		<div class="modal-footer">
				<span id="mailsending"></span>
				<button type="button" id="submit-message-form" class="btn btn-success" onclick="validate_email_body();">Submit</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
	    </form>
	</div>
    
      </div>
    </div>
<script>
		//===============function for email mpdal open===================//
           
        
		function email_modal_open(id,receiver_mail)
		{
				document.getElementById('feedback_id').value=id;
				document.getElementById('receiver_mail').value=receiver_mail;
				//alert(document.getElementById('receiver_mail').value=receiver_mail);
				
				$('#emailBody').modal('show');
				
        }
		
		//==================end function for modal open=====================//
		
		//=======================validate email modal========================//
		
		function validate_email_body()
		{
				var has_error=0;
				
				if(document.getElementById('message_subject').value.search(/\S/)==-1)
				{
						has_error++;
						$('#message_subject_error').html('Subject is required.');
				}
				else
				{
						$('#message_subject_error').html('');
				}
				if(document.getElementById('message_desc').value.search(/\S/)==-1)
				{
						has_error++;
						$('#message_desc_error').html('Email body is required.');
				}
				else
				{
						$('#message_desc_error').html('');
				}
				if (has_error > 0)
				{
                    return false;
                }
				else
				{	
					$('#email_form').submit();	
				}
				
				
		}
		
		//===================end validation for email modal============================//

</script>