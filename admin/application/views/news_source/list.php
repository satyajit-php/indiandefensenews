
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">News source Management</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Show all  content
                    <a href="<?php echo base_url(); ?>index.php/news_source/add" class="btn btn-primary btn-sm" style="float:right; margin-top:-6px;">Add New Slider Image</a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Name</th>
                                    <th>Sort name</th>

                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                if (!empty($result_data) && isset($result_data)) {
                                    foreach ($result_data as $result):
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $i++; ?></td>
                                            <td><?= isset($result->name) ? $result->name : ''; ?></td>
                                            <td><?= isset($result->name) ? $result->short_name : ''; ?></td>

                                            <td>
                                                <!--Edit Button-->
                                                <p class="fa fa-gear" title="Update" style="cursor: pointer; font-size: 20px;" onclick="update_blog('<?php echo $result->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
                                                <!--Edit Button-->
                                                <p class="fa fa-times" title="Delete" style="cursor: pointer;font-size: 20px;" onclick="del_data('<?php echo $result->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
                                                <?php
                                                if ($result->status == 1) {
                                                    ?>
                                                    <p class="fa fa-check-circle" title="Active" style="cursor: pointer; font-size: 20px;" onclick="change_status_to(0, '<?php echo $result->id; ?>')"></p>
                                                    <?php
                                                } else if ($result->status == 0) {
                                                    ?>
                                                    <p class="fa fa-times-circle" title="Inactive" style="cursor: pointer; font-size: 20px;" onclick="change_status_to(1, '<?php echo $result->id; ?>')"></p>
                                                    <?php
                                                }
                                                ?>


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
        window.location.href = "<?php echo site_url(); ?>/news_source/change_status_to/" + stat_param + "/" + id;
    }

    function del_data(id)
    {
        var del = confirm('Are you sure you want to delete this content?');
        if (del == true)
        {
            window.location.href = "<?php echo site_url(); ?>/news_source/del_data/" + id;
        }
    }
    function update_blog(id)
    {
        window.location.href = "<?php echo site_url(); ?>/news_source/edit/" + id; //Edit Article Redirection Link
    }
</script>