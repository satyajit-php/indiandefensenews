        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Website Settings</h1>
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
                                <div class="col-lg-6">
                                    <form role="form" id="sitesetting_form" name="sitesetting_form" method="POST" action="<?php echo site_url();?>/site_settings_cont/update_site">
                                        <input type="hidden" id="mode_settings" name="mode_settings" value="site_settings">
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Website name:</label>
                                            <input class="form-control need" id="webname" name="webname" label="Website name" value="<?php echo $rows[0]->site_name; ?>">
                                            <div id="webname_error" style="display: none; color: red;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Website URL:</label>
                                            <input class="form-control need" placeholder="Enter text" id="weburl" name="weburl" label="Website URL" value="<?php echo $rows[0]->website_url; ?>">
                                            <div id="weburl_error" style="display: none; color: red;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Admin Email:</label>
                                            <input class="form-control need" placeholder="Enter text" id="adminEmail" name="adminEmail" label="Admin Email" value="<?php echo $rows[0]->admin_email; ?>">
                                            <div id="adminEmail_error" style="display: none; color: red;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Add company notification Email:</label>
                                            <input class="form-control need" placeholder="Enter text" id="notificationEmail" name="notificationEmail" label="Notification Email" value="<?php echo $rows[0]->notificationemail; ?>">
                                            <div id="notificationEmail_error" style="display: none; color: red;"></div>
                                        </div>

                                        <div class="form-group">
                                            <label>Meta Keyword :</label>
                                            <input class="form-control" placeholder="Enter text" id="metakey" name="metakey" label="Meta Keyword" value="<?php echo $rows[0]->meta_key; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Meta Title :</label>
                                            <input class="form-control" placeholder="Enter text" id="metatitle" name="metatitle" label="Meta Title" value="<?php echo $rows[0]->meta_title; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Meta Description :</label>
                                            <input class="form-control" placeholder="Enter text" id="metadesc" name="metadesc" label="Meta Description" value="<?php echo $rows[0]->meta_desc; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Follow Us :</label>
                                        </div>
                                        <div class="form-group">
                                            <label>Facebook :</label>
                                            <input class="form-control" placeholder="Enter text" id="fb" name="fb" label="Facebook" value="<?php echo $rows[0]->facebook; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Twitter :</label>
                                            <input class="form-control" placeholder="Enter text" id="twit" name="twit" label="Twitter" value="<?php echo $rows[0]->twitter; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Rss :</label>
                                            <input class="form-control" placeholder="Enter text" id="rss" name="rss" label="Rss" value="<?php echo $rows[0]->rss; ?>">
                                         </div>
                                        <div class="form-group">
                                            <label>Linkedin :</label>
                                            <input class="form-control" placeholder="Enter text" id="linkedin" name="linkedin" label="Linkedin" value="<?php echo $rows[0]->linkedin; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Instagram :</label>
                                            <input class="form-control" placeholder="Enter text" id="instagram" name="instagram" label="Instagram" value="<?php echo $rows[0]->instagram; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Google+ :</label>
                                            <input class="form-control" placeholder="Enter text" id="google" name="google" label="Google Plus" value="<?php echo $rows[0]->google_plus; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Youtube :</label>
                                            <input class="form-control" placeholder="Enter text" id="youtube" name="youtube" label="Youtube" value="<?php echo $rows[0]->youtube; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Pinterest :</label>
                                            <input class="form-control" placeholder="Enter text" id="pinterest" name="pinterest" label="Pinterest" value="<?php echo $rows[0]->pinterest; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Reddit :</label>
                                            <input class="form-control" placeholder="Enter text" id="reditt" name="reditt" label="Reddit" value="<?php echo $rows[0]->reditt; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Vimeo :</label>
                                            <input class="form-control" placeholder="Enter text" id="vimeo" name="vimeo" label="Vimeo" value="<?php echo $rows[0]->vimeo; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Elastick :</label>
                                            <input class="form-control" placeholder="Enter text" id="elastick" name="elastick" label="Elastick" value="<?php echo $rows[0]->elastick; ?>">
                                        </div>

                                        <?php //} ?>
                                        <button type="button" class="btn btn-success" onclick="site_settings_validation();">Submit</button>
                                        <button type="reset" class="btn btn-default" onclick= "go_reset();">Reset</button>
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

<!--Script To validate site settings form -->
 <script type="text/javascript">

function site_settings_validation()
{
    var has_error=0;
    $('.need').each(function(){
        element_id = $(this).attr('id');
        element_value = $(this).val();
        element_label = $(this).attr('label');
        error_div = $("#"+element_id+"_error")
        if (element_value.search(/\S/)=='-1')
        {           
            has_error++;
            error_div.html(element_label+' is required.');
            error_div.show();
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
        $('#overlay_main').show();
		$('#loading_img').show();
        document.sitesetting_form.submit();
    }
}

function go_reset()
{
    window.location="<?php echo site_url();?>/site_settings_cont";
}
</script>