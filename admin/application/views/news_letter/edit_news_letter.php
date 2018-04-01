<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Send Mail To Subscribers</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    News Letter Form Elements
                    <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                        <a href="<?php echo site_url(); ?>/news_letter_cont" style="color: white;">Back</a>
                    </button>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" id="news_letter_form" name="news_letter_form" method="POST" action="">

  <!--<input type="hidden" name="mode_addarticle" id="mode_addarticle" value="add_article">-->
                                <input type="hidden" name="nav_id" id="nav_id" value="">
                                <input type="hidden" name="check_val" id="check_val" value="">

                                <div class="form-group">
                                    <label>Choose Email Subject:</label>
                                    <select class="form-control" id="email_sub" name="email_sub" label="News_Letter">
                                        <?php
                                        foreach ($template as $template_val) {
                                            ?>
                                            <option value="<?php echo $template_val->id; ?>"><?php echo $template_val->email_title; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Send mail to:</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" value="all" onclick="show_emails('add');" checked="checked">All
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline2" value="selected" onclick="show_emails('rem');">Selected
                                    </label>
                                </div>

                                <div class="form-group hide" id="email_list" name="email_list">
                                    <label>Choose Email Id:</label>
                                    <?php $result = $this->news_letter_model->select_student_model(); ?>
                                    <?php foreach ($result as $row) { ?>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="nav_val[]" id="nav_val" value="<?php echo $row->id ?>" onclick="get_checkbox(this.value);"><?php echo $row->email ?>
                                            </label>
                                        </div>
                                    <?php } ?>

                                    <span id="email_list_error" style="color: red;"></span>
                                </div>

                                <button type="button" class="btn btn-success" onclick="news_template_validation();">Send</button>
                                <button type="reset" class="btn btn-default">Cancel</button>
                                <div id="loading_img" style="display:none; float: right; margin-top: 5px;margin-right: 272px;"><img src="<?php echo base_url(); ?>images/facebook_loader.gif" alt=""></div>
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


<!---------------------------email template validation section------------------------------>
<script type="text/javascript">
    $(document).ready(function () {
        $('#optionsRadiosInline1').click();
    });

    function get_checkbox(id)		//get all the ids of subscribers
    {
        var nav_arr = [];
        var nav_val = document.getElementsByName('nav_val[]');
        var len = nav_val.length;
        for (i = 0; i < len; i++)
        {
            if (nav_val.item(i).checked == true)
            {
                nav_arr.push(nav_val[i].value);
            }
        }
        nav_arr = nav_arr.toString();
        $('#nav_id').val(nav_arr);
    }

    function news_template_validation()
    {
        var nav_id = $('#nav_id').val();
        var email_sub = $('#email_sub').val();
        var email_type = $('#check_val').val();

        var has_error = 0;
        if (document.getElementById('optionsRadiosInline2').checked == true && nav_id == '')
        {
            has_error++;
            $('#email_list_error').html('Please choose email ids you want to send email..');
        }
        //alert(has_error);
        if (has_error > 0)
        {
            return false;
        } else
        {
            //alert(nav_id+'==='+email_sub+'==='+email_type);
            //exit();
            //document.news_letter_form.submit();
            $.ajax({
                url: "<?php echo site_url(); ?>/news_letter_cont/sendmail_to",
                type: "POST",
                data: {'nav_id': nav_id, 'email_sub': email_sub, 'email_type': email_type},
                success: function (data) {
                    //alert(data);
                }

            });
            $('#overlay_main').show();
            $('#loading_img').show();
            window.location.href = "<?php echo site_url(); ?>/news_letter_cont/index/mail_sent";
        }
    }

    function go_reset()
    {
        window.location.href = "<?php echo site_url(); ?>/news_letter_cont";
    }
    function select_student()
    {
        window.location.href = "<?php echo site_url(); ?>/news_letter_cont/select_student_cont";
    }
</script>

<!-------------------------------send mail jquery section------------------------------------------->
<script type="text/javascript">
    function show_emails(flag)
    {
        if (flag == 'add')
        {
            $('#email_list').addClass('hide');
            $('#email_list_error').html('');
            $('#check_val').val('all');
        } else if (flag == 'rem')
        {
            $('#email_list').removeClass('hide');
            $('#check_val').val('selected');
        }
    }
</script>