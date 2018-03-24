<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Navbar Management</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <!-- <button type="button" class="btn btn-primary" style="float: right; margin-bottom: 10px; margin-right: 18px;">
             <a href="javascript:void(0);" style="color: white;">Add New States</a>
         </button>-->
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Show All Navbar
                    <a href="<?php echo base_url(); ?>navigation/add_navigation">
                        <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top:-5px;">
                            <span style="color: white;">
                                Add New Navigation
                            </span>
                        </button>
                    </a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="dataTable_wrapper">
                        <?php
                        if (empty($nav_arr)) {
                            ?>
                            <p>No Records Found..</p>
                            <?php
                        } else {
                            ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Name</th>
                                            <th>Parent name</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $i = 1;
                                        foreach ($nav_arr as $row):
                                            ?>
                                            <tr class="gradeA">
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo ucfirst($row->name); ?></td>

                                                <?php
                                                $res = $this->navigation_model->fetch_nav($row->parent_id);
                                                ?>
                                                <td><?php
                                                    if (isset($res[0]->name)) {
                                                        echo ucfirst($res[0]->name);
                                                    }
                                                    ?></td>
                                                <td>
                                                    <p class="fa fa-gear" title="Update" style="cursor: pointer; font-size: 20px;" onclick="update_data('<?php echo $row->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
                                                    <p class="fa fa-times" title="Delete" style="cursor: pointer; font-size: 20px;" onclick="del_data('<?php echo $row->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    if ($row->status == '0') {
                                                        ?>
                                                        <p class="fa fa-check-circle" title="Active" style="cursor: pointer; font-size: 20px;" onclick="change_status_to('1', '<?php echo $row->id; ?>')"></p>
                                                        <?php
                                                    } else if ($row->status == '1') {
                                                        ?>
                                                        <p class="fa fa-times-circle" title="Inactive" style="cursor: pointer; font-size: 20px;" onclick="change_status_to('0', '<?php echo $row->id; ?>')"></p>
                                                        <?php
                                                    }
                                                    ?>
                                                </td> 
                                            </tr>
                                            <?php
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <!-- /.row -->
    <!-- /.row -->
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<script type="text/javascript">
    function change_status_to(stat_param, id)
    {
        window.location.href = "<?php echo site_url(); ?>navigation/change_status_to/" + stat_param + "/" + id;
    }

    function del_data(id)
    {
        var del = confirm('Are you sure you want to delete this template?');
        if (del == true)
        {
            window.location.href = "<?php echo site_url(); ?>navigation/del_data/" + id;
        }
    }
    function update_data(id)
    {
        window.location.href = "<?php echo site_url(); ?>navigation/edit_navigation/" + id;
    }
</script>