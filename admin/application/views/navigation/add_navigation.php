<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add New Navigation</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Fields marked with <span style="color: red;">*</span> are mandatory
                    <a href="<?php echo site_url(); ?>navigation" style="color: white;">
                        <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                            Back
                        </button>
                    </a>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" id="nav_frm" name="nav_frm" method="POST" action="<?php echo base_url(); ?>navigation/insert_nav" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label><span style="color: red;">*</span>Parent Navigation</label>
                                    <select class=" need select2" id="parent_id" name="parent_id" label="Parent Navigation" style="width: 100%;">
                                        <option value="0">None</option>
                                        <!--/**** Country Select Box ****/-->
                                        <?php
                                        $res = $this->navigation_model->fetch_all_navigation();
                                        foreach ($res as $row):
                                            ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo ucfirst($row->name); ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><span style="color: red;">*</span>Navigation Name:</label>
                                    <input class="form-control need" id="name" name="name" label="Navigation Name" required="required">
                                    <span id="state_error" style="color: red;"></span>
                                </div>
                                <div class="form-group">
                                    <label><span style="color: red;">*</span>Navigation Url:</label>
                                    <input class="form-control need" id="url" name="url" label="Navigation Url">
                                    <span id="state_error" style="color: red;"></span>
                                </div>

                                <div class="form-group">
                                    <label><span style="color: red;">*</span>Status:</label>
                                    <select class="select2" id="state_status" name="status" required="required" style="width: 100%;">
                                        <option value='1'>Active</option>
                                        <option value='0'>Inactive</option>
                                    </select>
                                </div>

                                <button type="button" class="btn btn-success" onclick="validate_frm();">Submit</button>
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
                                    function validate_frm()
                                    {
                                        $('#overlay_main').show();
                                        $('#loading_img').show();
                                        $("#nav_frm").submit();
                                    }

                                    function go_reset()
                                    {
                                        window.location.href = "<?php echo base_url(); ?>navigation";
                                    }
</script>
<!------------validate form------------->