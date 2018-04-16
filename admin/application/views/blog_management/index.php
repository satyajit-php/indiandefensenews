<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Blog Management</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Show all blog content
                    <a href="<?php echo base_url(); ?>blog_cont/add_blog" class="btn btn-primary btn-sm" style="float:right; margin-top:-6px;">Add New Blog Content</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="dataTable_wrapper">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Blog Title</th>
                                        <th>Added by</th>
                                        <!--<th>Added on</th>-->
                                        <th>Images</th>
                                        <th>Details</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if ($blog_data != '') {
                                        foreach ($blog_data as $blog):
                                            ?><tr class="gradeA">
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $blog->blog_title; ?></td>
                                                <td><?php echo $blog->added_by; ?></td>
                                               <!-- <td><?php echo $blog->added_on; ?></td>-->
                                                <td><img class="img-thumbnail" alt="Your uploaded image" src="<?php echo base_url() . 'uploaded_image/thumbnail/' . $blog->images; ?>"  height="50" width="50"/></td>
                                                <?php
                                                $string = $blog->details;
                                                $string = word_limiter($string, 4);
                                                ?>
                                                <td><?php echo $string; ?></td>
                                                <td>
                                                    <!--Edit Button-->
                                                    <p class="fa fa-gear" title="Update" style="cursor: pointer; font-size: 20px;" onclick="update_blog('<?php echo $blog->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
                                                    <!--Edit Button-->
                                                    <p class="fa fa-times" title="Delete" style="cursor: pointer;font-size: 20px;" onclick="del_data('<?php echo $blog->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    if ($blog->status == 1) {
                                                        ?>
                                                        <p class="fa fa-check-circle" title="Active" style="cursor: pointer; font-size: 20px;" onclick="change_status_to(0, '<?php echo $blog->id; ?>')"></p>
                                                        <?php
                                                    } else if ($blog->status == 0) {
                                                        ?>
                                                        <p class="fa fa-times-circle" title="Inactive" style="cursor: pointer; font-size: 20px;" onclick="change_status_to(1, '<?php echo $blog->id; ?>')"></p>
                                                        <?php
                                                    }
                                                    ?>
                                                    <p class="fa fa-eye" title="View" style="cursor: pointer; font-size: 20px;" onclick="view_data('<?php echo $blog->id; ?>')"></p>
                                                </td>
                                            </tr>
                                            <?php
                                        endforeach;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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

<script type="text/javascript">
    function change_status_to(stat_param, id)
    {
        window.location.href = "<?php echo site_url(); ?>blog_cont/change_status_to/" + stat_param + "/" + id;
    }

    function del_data(id)
    {
        var del = confirm('Are you sure you want to delete this content?');
        if (del == true)
        {
            window.location.href = "<?php echo site_url(); ?>blog_cont/del_data/" + id;
        }
    }
    function update_blog(id)
    {
        window.location.href = "<?php echo site_url(); ?>blog_cont/edit_blog/" + id; //Edit Article Redirection Link
    }
    function view_data(id)
    {
        window.location.href = "<?php echo site_url(); ?>blog_cont/viewcomm/" + id; //Edit Article Redirection Link
    }
</script>