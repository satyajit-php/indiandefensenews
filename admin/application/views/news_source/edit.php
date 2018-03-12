<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit News source</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php
    //print_r($data_arr);
    ?>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    News source Form Elements
                    <a href="<?php echo site_url(); ?>/news_source" style="color: white;">
                        <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                            Back
                        </button>
                    </a>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form"  data-toggle="validator"  method="POST" action="<?php echo site_url(); ?>/news_source/update">
                                <input type="hidden"  name="source[id]" value="<?= isset($data_arr) ? $data_arr->id : '' ?>">

                                <div class="form-group">
                                    <label><span style="color: red;">*</span>Source Title</label>
                                    <input class="form-control need"  type="text" name="source[name]" label="Source Title" value="<?= isset($data_arr) ? $data_arr->name : '' ?>" required>

                                </div>
                                <div class="form-group">
                                    <label><span style="color: red;">*</span>Source sort name</label>
                                    <input class="form-control need"  type="text" name="source[short_name]" label="Source sort name" value="<?= isset($data_arr) ? $data_arr->short_name : '' ?>"required>

                                </div>
                                <div class="form-group">
                                    <label>
                                        <span style="color: red;">*</span>Status :</label>
                                    <select class="form-control need" id="status" name="source[status]" label="Status" required>
                                        <option value="">Select Status</option>   
                                        <option value="1" <?= isset($data_arr) ? ($data_arr->status == '1') ? 'selected' : '' : '' ?>>Active</option>
                                        <option value="0" <?= isset($data_arr) ? ($data_arr->status == '0') ? 'selected' : '' : '' ?>>Inactive</option>
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                                <div id="loading_img" style="display:none; float: right;top: -27px;margin-right: 180px;"><img src="<?php echo base_url(); ?>images/facebook_loader.gif" alt=""></div>
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
 


    function go_reset()
    {
        window.location.href = "<?php echo site_url(); ?>/news_source";
    }
</script>
<!--------------------------------------email template validation section----------------------------------->