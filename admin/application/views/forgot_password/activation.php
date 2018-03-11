<body>  
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Enter Security Code</h3>
                    </div>
                    <div class="panel-body">

                            <!---------------Loader section------------>
                            <div class="alert alert-success alert-dismissable class hide" id="loading_div">
                                <a href="javascript:vouid(0);" class="alert-link">Processing...</a>
                            </div>
                            <!---------------Loader section------------>
                            <!---------------alert section------------>
                            <?php
                            if($this->session->userdata('error_msg')!='')
                            {
                            ?>
                            <div class="alert alert-danger alert-dismissable" id="error_msg">
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
                            <div class="alert alert-success alert-dismissable" id="succs_msg">
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
                            
                        <div id="overlay_main" class="no_responce" style="display: none;"></div>
                        <form role="form" id="login_form" method="POST" action="<?php echo site_url();?>/login_cont/getpassword">
                            <input type="hidden" id="mode_login" name="mode_login" value="after_login">
                             <input type="hidden" id="" name="" value="">
                            <fieldset>
                                <div class="form-group">
                                    <label>Security Code </label> 
                                    <input class="form-control need"  label="Secutity Code" name="sec" id="sec" type="text" autofocus <?php if($this->input->cookie('cookie_value')=='checked'){?> value="<?php echo $this->input->cookie('cookie_email');?>"<?php } ?> onkeyup="get_keyval(event)">
                                    <span id="sec_error" style="color: red;"></span>
                                </div>
                               
                                <!-- Change this to a button or input when using this as a form -->
                                <a href="javascript:void(0);" class="btn btn-lg btn-success btn-block" onclick="login_form_validation();">Retrive Password</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/assets/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>/assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>/assets/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url(); ?>/assets/dist/js/sb-admin-2.js"></script>

</body>

</html>

<!----------------------valodation section-------------------->
<script type="text/javascript">
function get_keyval(event)
{
    if(event.keyCode==13)
    {
        login_form_validation();
    }
}

  function login_form_validation()
  {    
        var email=$('#email').val();
        var password=$('#password').val();
        var has_error=0;
        $('.need').each(function(){
            var elem_id = $(this).attr('id');
            var elem_val = $(this).val();
            var elem_label = $(this).attr('label');
            var error_div = $('#'+elem_id+"_error");
            if (elem_val.search(/\S/)==-1)
            {
                has_error++;
                error_div.html(elem_label+' is required.');
            }
            else
            {
                error_div.html('');                
            }
        });
        
            //
            //
            //if (email.search(/\S/)==-1)
            //{
            //    has_error++;
            //    $('#email_error').html('Please enter email id first.');
            //}           
            //if (password.search(/\S/)==-1)
            //{
            //    has_error++;
            //    $('#password_error').html('Please enter password first.');
            //}

            if(has_error > 0)
            {
                return false;
            }
            else
            {
                //$('#email_error').html('');
                //$('#password_error').html('');
                $('#overlay_main').css('display','block');
                $('#loading_div').removeClass('hide');
                $('#login_form').submit();
            }
  }
  
$(document).ready(function(){
    setTimeout(function() {
        $("#error_msg").fadeOut(900)
        $("#succs_msg").fadeOut(900)
    }, 4000);
});
</script>
<!----------------------valodation section-------------------->