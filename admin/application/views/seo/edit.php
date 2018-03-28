  
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit  Seo Content</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Fields marked with <span style="color: red;">*</span> are mandatory
                    <a href="<?php echo site_url(); ?>seo" style="color: white;">
                        <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                            Back
                        </button>
                    </a>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" data-toggle="validator"  method="POST" action="<?php echo base_url(); ?>seo/update" enctype="multipart/form-data">
                                <input type ='hidden' name='id' value="<?php echo $seo_data[0]->id; ?>"></td>
                                <input type="hidden" id="mode_blog" name="mode" value="update"/>
                                <div class="form-group">
                                    <label>Title <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="title" name="title" label="Title" value="<?php echo $seo_data[0]->title; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label>Routes <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="routes" name="routes" label="Routes" value="<?php echo $seo_data[0]->routes; ?>"required>
                                </div>

                                <div class="form-group">
                                    <label> Url <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="url" name="url" label="Url" value="<?php echo $seo_data[0]->url; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Description <span style="color: red;">*</span>:</label>
                                    <textarea  cols="80" id="description" label="Description" name="description" rows="10" required><?php echo $seo_data[0]->description; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>OG-Description <span style="color: red;">*</span>:</label>
                                    <textarea  cols="80" id="og_description" label="Description" name="og_description" rows="10" required><?php echo $seo_data[0]->og_description; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Keyword <span style="color: red;">*</span>:</label>
                                    <textarea  cols="80" id="keyword" label="Keyword" name="keyword" rows="10" required><?php echo $seo_data[0]->keyword; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Type <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="og_type" name="og_type" label="OGType" value="<?php echo $seo_data[0]->og_type; ?>">
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
        window.location.href = "<?php echo base_url(); ?>googleseo";
    }
</script>
<!------------validate form------------->