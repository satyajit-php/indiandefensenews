  
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Twitter Seo Content</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Fields marked with <span style="color: red;">*</span> are mandatory
                    <a href="<?php echo site_url(); ?>aboutus" style="color: white;">
                        <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                            Back
                        </button>
                    </a>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" data-toggle="validator"  method="POST" action="<?php echo base_url(); ?>twiterseo/update" enctype="multipart/form-data">
                                <input type ='hidden' name='id' value="<?php echo $twiter_data[0]->id; ?>"></td>
                                <input type="hidden" id="mode_blog" name="mode" value="update"/>
                                <div class="form-group">
                                    <label>Title <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="title" name="title" label="Title" value="<?php echo $twiter_data[0]->title; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Handle <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="handle" name="handle" label="Handle" value="<?php echo $twiter_data[0]->handle; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Creator <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="creator" name="creator" label="Creator" value="<?php echo $twiter_data[0]->creator; ?>">
                                </div>
                                <div class="form-group">
                                    <label>logo url <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="image_url" name="image_url" label="Image url" value="<?php echo $twiter_data[0]->image_url; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Description <span style="color: red;">*</span>:</label>
                                    <textarea  cols="80" id="description" label="Description" name="description" rows="10"><?php echo $twiter_data[0]->description; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Summary <span style="color: red;">*</span>:</label>
                                    <textarea  cols="80" id="summary" label="Summary" name="summary" rows="10"><?php echo $twiter_data[0]->summary; ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-success" >Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                                <div id="loading_img" style="display:none; float: right; margin-top: 5px;margin-right: 272px;"><img src="<?php echo base_url(); ?>images/facebook_loader.gif" alt=""></div>
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


    function go_reset()
    {
        window.location.href = "<?php echo base_url(); ?>index.php/blog_cont";
    }
</script>
<!------------validate form------------->