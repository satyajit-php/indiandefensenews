  
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All  Posted   <span style="color: red;"></span> Details are here
                    <a href="<?php echo site_url(); ?>aboutus" style="color: white;">
                        <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                            Back
                        </button>
                    </a>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" data-toggle="validator"  method="POST" action="<?php echo base_url(); ?>guest_post_cont/edit" enctype="multipart/form-data">
                                <input type ='hidden' name='id' value="<?php echo $data_arr[0]->id; ?>">
                               

                                <div class="form-group">
                                    <label>Name :</label>
                                    <p><?= isset($data_arr[0]->name) ? $data_arr[0]->name : ''; ?></p>

                                </div> 
                                <div class="form-group">
                                    <label>Email :</label>
                                    <p><?= isset($data_arr[0]->email) ? $data_arr[0]->email : ''; ?></p>

                                </div>
                                <div class="form-group">
                                    <label>Subject :</label>
                                    <p><?= isset($data_arr[0]->subject) ? $data_arr[0]->subject : ''; ?></p>

                                </div>
                                <div class="form-group">
                                    <label>Location :</label>
                                    <p><?= isset($data_arr[0]->location) ? $data_arr[0]->location : ''; ?></p>

                                </div>

                                <div class="form-group">
                                    <label>Story:</label>
                                    <p><?= isset($data_arr[0]->story) ? $data_arr[0]->story : ''; ?></p>

                                </div>
                                <div class="form-group">
                                    <label>Status
                                        <span style="color: red;"></span>:</label>
                                       <!-- <input class="form-control need" id="faq_typ_name" name="faq_typ_name" label="FAQ Type Name">-->

                                    <select class="select2" id="status" name="status" label="Status" style="width: 100%;">
                                        <option value="S" <?php if ($data_arr[0]->status == 'S') { ?> selected="selected" <?php } ?>>Submitted</option>
                                        <option value="P" <?php if ($data_arr[0]->status == 'P') { ?> selected="selected" <?php } ?>>Posted</option>
                                        <option value="R" <?php if ($data_arr[0]->status == 'R') { ?> selected="selected" <?php } ?>>Rejected</option>
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