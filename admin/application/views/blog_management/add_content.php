<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add New Blog Content</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Fields marked with <span style="color: red;">*</span> are mandatory
                    <a href="<?php echo site_url(); ?>blog_cont" style="color: white;"><button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                            Back
                        </button></a>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" data-toggle="validator"  id="blog_frm" method="POST" action="<?php echo base_url(); ?>blog_cont/insert_blog_content" enctype="multipart/form-data">
                                <input type="hidden" id="mode_blog" name="mode_blog" value="insert_blog"/>
                                <?php
                                if (isset($guestpost_arr)) {
                                    ?>
                                    <input type="hidden" name="guest" value="<?= isset($guestpost_arr[0]->id) ? $guestpost_arr[0]->id : ''; ?>"/>
                                <?php }
                                ?>

                                <input type="hidden" id="get_tag" name="get_tag" value=""/>
                                <div class="form-group">
                                    <label>Blog Title <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="blog_title" name="blog_title" value="<?= isset($guestpost_arr[0]->subject) ? $guestpost_arr[0]->subject : ''; ?>" label="Blog Title" required>

                                </div>
                                <div class="form-group">
                                    <label>Blog Url <span style="color: red;">*</span>:</label>
                                    <input class="form-control need"  name="blog_url" label="Blog Url" required>

                                </div>
                                <div class="form-group">
                                    <label>Meta Title <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="blog_title" name="meta_title" label="Meta Title" required>

                                </div>
                                <div class="form-group">
                                    <label>Meta Description <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="blog_title" name="meta_description" label="Meta Description" required>

                                </div>
                                <div class="form-group">
                                    <label>Added by <span style="color: red;">*</span>:</label>
                                    <input class="form-control need" id="added_by" name="added_by" value="<?= isset($guestpost_arr[0]->name) ? $guestpost_arr[0]->name : ''; ?>" label="Added by" required>

                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Tag <span style="color: red;">*</span>:</label>

                                            <?php
                                            $all_tag = $this->navigation_model->fetch_data();
                                            ?>
                                            <select name="blog_tag" class="select2" id="blog_category" style="width: 100%;" label="Tag" required>
                                                <option value="">Select Tag</option>
                                                <?php
                                                foreach ($all_tag as $get_all) {
                                                    ?>
                                                    <option value="<?php echo $get_all->id; ?>"><?php echo $get_all->name; ?></option>

                                                    <?php
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-4" style="padding-top: 23px;">
                                        <a class="btn btn-primary btn-sm newtagcover" href="javascript:void(0)">ADD NEW TAG</a>
                                    </div>
                                </div>
                                <div class="form-group" id="newtag_cover" style="display: none;">
                                    <label>New Tag <span style="color: red;">*</span>:</label>
                                    <input class="form-control need"  name="new_tag" label="New Tag">


                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>News Source <span style="color: red;">*</span>:</label>

                                            <?php
                                            $all_news_source = $this->news_source_model->activelists("news_source");
                                            ?>
                                            <select name="blog_source" id="blog_source" class="select2" style="width: 100%;" label="Source" required>
                                                <option value="">Select Source</option>
                                                <?php
                                                foreach ($all_news_source as $get_all) {
                                                    ?>
                                                    <option value="<?php echo $get_all->id; ?>"><?php echo $get_all->short_name; ?></option>

                                                    <?php
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding-top: 23px;">
                                        <a class="btn btn-primary btn-sm newsourcer" href="javascript:void(0)">ADD NEW SOURCE</a>
                                    </div>
                                </div>
                                <div class="form-group" id="newsource_cover" style="display: none;">
                                    <label>New News Source <span style="color: red;">*</span>:</label>
                                    <input class="form-control need"  name="new_source" label="New Source">
                                </div>

                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Media :</label>
                                    <input type="file" class="form-control need file" id="featured-img" name="attachment_file" label="Attachment" style= "margin-top: 15px;">
                                </div>

                                <div class="form-group">
                                    <label>Youtube Embeded <span style="color: red;">*</span>:</label>
                                    <textarea class="form-control need"  id="youtube" name="youtube_url" label="Youtube Frame">
                                    </textarea>

                                </div>
                                <div class="form-group">
                                    <label>Blog Description <span style="color: red;">*</span>:</label>
                                    <textarea class="ckeditor" cols="80" id="blog_desc" label="Blog Description" name="blog_desc" rows="10" required><?= isset($guestpost_arr[0]->story) ? $guestpost_arr[0]->story : ''; ?></textarea>
                                    <span id="blog_desc_error" style="color: red;"></span>
                                </div>
                                <div class="form-group">
                                    <label>Status
                                        <span style="color: red;"></span>:</label>
                                       <!-- <input class="form-control need" id="faq_typ_name" name="faq_typ_name" label="FAQ Type Name">-->

                                    <select class="select2" style="width: 100%;" id="status" name="status" label="Status" required>
                                        <option value="">Select Status</option>   
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>


                                    <span id="status_error" style="color: red;"></span>
                                </div>

                                <!--<div class="form-group">
                                    <label>Image</label>
                                    <input type="file">
                                </div>-->

                                <button type="submit" class="btn btn-success">Submit</button>
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
    $(document).ready(function () {
        $("#blog_frm").submit(function () {
            youtube = $("#youtube").val();
            if (youtube != "") {
                $("#youtube").val(window.btoa(youtube));
            }
        })

        $(".newtagcover").click(function () {

            $("#newtag_cover").css('display', 'block');
            $('#blog_category').prop('required', false);

        })
        $(".newsourcer").click(function () {
            $("#newsource_cover").css('display', 'block');
            $('#blog_source').prop('required', false);

        })
    });
</script>
<!------------validate form------------->