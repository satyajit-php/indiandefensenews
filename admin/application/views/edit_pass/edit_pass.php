         <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Password Settings</h1>
                </div>
                <?php
                $session_id = $this->session->userdata('admin_uid');
                $get_user_val = $this->edit_pass_model->get_row_by_id('admin' ,'id' , $session_id);
               // print_r($get_user_val);die;
                ?>
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

                            <!---------------alert section------------>
                            <?php
                            if($this->session->userdata('error_msg')!='')
                            {
                            ?>
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <a href="javascript:vouid(0);" class="alert-link">Error!</a>
                                <?php
                                    echo $this->session->userdata('error_msg');
                                    $this->session->unset_userdata('error_msg');
                                ?>
                            </div>
                            <?php
                            }
                            if($this->session->userdata('success_msg')!='')
                            {
                            ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <a href="javascript:vouid(0);" class="alert-link">Success!</a>
                                <?php
                                    echo $this->session->userdata('success_msg');
                                    $this->session->unset_userdata('success_msg');
                                ?>
                            </div>
                            <?php
                            }
                            ?>
                            <!---------------alert section------------>
                              <?php
                               //echo "<pre>";
                              // print_r($get_user_val);
                              ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="sitesetting_form" name="sitesetting_form" method="POST" action="<?php echo site_url();?>/edit_pass_cont/update_pass">
                                        <input type="hidden" id="mode_settings" name="mode_settings" value="site_settings">
                                        <input type="hidden" id="user_id" name="user_id" value="<?php echo $session_id; ?>">
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Old Password:</label>
                                            <input type="password" class="form-control need" id="old_pass" name="old_pass" label="Old password" placeholder="Old password..">
                                             <div id="old_pass_error" style="display: none; color: red;"></div>
                                            <input class="hidden" id="old_exist_pass" name="old_exist_pass" value="<?php echo  $this->encrypt->decode($get_user_val[0]->password); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> New Password:</label>
                                            <input type="password" class="form-control need" placeholder="Enter new password" id="new_pass" name="new_pass" label="New password">
                                            <div id="new_pass_error" style="display: none; color: red;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Retype New Password:</label>
                                            <input type="password" class="form-control need" placeholder="Enter new password" id="new_rpass" name="new_rpass" label="New retype password">
                                            <div id="new_rpass_error" style="display: none; color: red;"></div>
                                        </div>
                                       
                                        
                                        <button type="button" class="btn btn-success" onclick="site_settings_validation();">Submit</button>
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

<!--Script To validate site settings form -->
<script type="text/javascript">

function site_settings_validation()
{
    var has_error=0;
    var old_pass = $( "#old_exist_pass" ).val();
    //alert(old_pass);
    $('.need').each(function(){
        element_id = $(this).attr('id');
        element_value = $(this).val();
        element_label = $(this).attr('label');
        error_div = $("#"+element_id+"_error")
        if (element_value.search(/\S/)==-1)
        {           
            has_error++;
            error_div.html(element_label+' is required.');
            error_div.show();
        }
        else if(element_value.search(/\S/) != -1)
        {
          //alert(element_value);
          if ($( "#old_pass" ).val() == '' )
          {
             //alert($("#old_pass").val());
             has_error++;
             $("#old_pass_error").show();
             $("#old_pass_error").html('Please put old password.');            
          }
          if ($( "#old_pass" ).val() != old_pass )
          {
             //alert($("#old_pass").val());
             has_error++;
             $("#old_pass_error").show();
             $("#old_pass_error").html('Old password is not matching.');            
          }
          else
          {
              error_div.html('');
          }      
          if ($( "#new_pass" ).val() != $( "#new_rpass" ).val() )
          {             
             has_error++;
             $("#new_pass_error").html(' Both value must be same.');
             $("#new_rpass_error").html(' Both value must be same.');
          }
          else
          {
             error_div.html('');
          }
        }
        else
        {        	
        	error_div.hide();
        }
    });
   
    if (has_error>0)
    {
        return false;
    }
    else
    {
        document.sitesetting_form.submit();
    }
}

function go_reset()
{
    window.location="<?php echo site_url();?>/edit_pass_cont";
}
</script>