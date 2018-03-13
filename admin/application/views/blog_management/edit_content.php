  
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Blog Content</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Fields marked with <span style="color: red;">*</span> are mandatory
                    <a href="<?php echo site_url(); ?>/blog_cont" style="color: white;">
                        <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                            Back
                        </button>
                    </a>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" data-toggle="validator" name="blog_frm" method="POST" action="<?php echo base_url(); ?>index.php/blog_cont/update_blog" enctype="multipart/form-data">
                                <input type="hidden" id="get_tag" name="get_tag" value="<?php echo $blog_data[0]->blog_category; ?>"/>
                                <input type = 'hidden' name='id' value="<?php echo $blog_data[0]->id; ?>"></td>
                                <input type = 'hidden' name='last_img' value="<?php echo $blog_data[0]->images; ?>"></td>
                                <input type="hidden" id="mode_blog" name="mode_blog" value="update_blog"/>
                                <div class="form-group">
                                    <label>Blog Title <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="blog_title" name="blog_title" label="Blog Title" value="<?php echo $blog_data[0]->blog_title; ?>">

                                </div>
                                <div class="form-group">
                                    <label>Added by<span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="added_by" name="added_by" label="Added By" value="<?php echo $blog_data[0]->added_by; ?>">

                                </div>

                                <div class="form-group">
                                    <label>Tag <span style="color: red;">*</span>:</label>

                                    <?php
                                    $all_tag = $this->blog_tag_model->get_all_tag();
                                    ?>
                                    <select name="tag_name" class="select2" style="width: 100%;" label="Tag" required>
                                        <option value="">Select Tag</option>
                                        <?php
                                        foreach ($all_tag as $get_all) {
                                            ?>
                                            <option value="<?php echo $get_all->id; ?>"<?= ($blog_data[0]->blog_category == $get_all->id) ? 'selected' : ''; ?>><?php echo $get_all->tag_name; ?></option>

                                            <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label>News Source <span style="color: red;">*</span>:</label>

                                    <?php
                                    $all_news_source = $this->news_source_model->activelists("news_source");
                                    ?>
                                    <select name="blog_source" class="select2" style="width: 100%;" label="Tag" required>
                                        <option value="">Select Source</option>
                                        <?php
                                        foreach ($all_news_source as $get_all) {
                                            ?>
                                            <option value="<?php echo $get_all->id; ?>" <?= ($blog_data[0]->blog_source == $get_all->id) ? 'selected' : ''; ?>><?php echo $get_all->short_name; ?></option>

                                            <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Image :</label>
                                    <?php
                                    if (isset($blog_data[0]->images) && $blog_data[0]->images != '') {
                                        ?>
                                        <img alt="Your uploaded image" src="<?php echo base_url() . 'uploaded_image/normal/' . $blog_data[0]->images; ?>"  height="100" width="100" required/></td>
                                        <input type="file" class="form-control" id="attachment_file" name="attachment_file" label="Attachment" style= "margin-top: 15px;" >

                                        <?php
                                    } else {
                                        ?>
                                        <img alt="Your uploaded image" src="<?php echo base_url() . 'uploaded_image/thumbnail/noimage.jpg'; ?>"  height="100" width="100"/></td>
                                        <input type="file" class="form-control" id="attachment_file" name="attachment_file" label="Attachment" style= "margin-top: 15px;" >
                                        <?php
                                    }
                                    ?>

                                </div>
                                <div class="form-group">
                                    <label>Blog Description <span style="color: red;">*</span>:</label>
                                    <textarea class="ckeditor" cols="80" id="blog_desc" label="Blog Description" name="blog_desc" rows="10"><?php echo $blog_data[0]->details; ?></textarea>

                                </div>
                                <div class="form-group">
                                    <label>Status
                                        <span style="color: red;"></span>:</label>
                                       <!-- <input class="form-control need" id="faq_typ_name" name="faq_typ_name" label="FAQ Type Name">-->

                                    <select class="select2" id="status" name="status" label="Status" style="width: 100%;">
                                        <option value="1" <?php if ($blog_data[0]->status == '1') { ?> selected="selected" <?php } ?>>Active</option>
                                        <option value="0" <?php if ($blog_data[0]->status == '0') { ?> selected="selected" <?php } ?>>Inactive</option>
                                    </select>



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