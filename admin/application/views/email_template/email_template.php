 
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Email Template Management</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Show all templates
                    <!--<a href="<?php echo base_url(); ?>index.php/email_template_cont/add_email_template">-->
                    <!--<span style="color: white;">-->
                    <!-- <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top:-5px;">-->
                    <!--    Add New Templates</span>-->
                    <!-- </button>-->
                    <!-- </a>-->
                </div>


                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <div class="table-responsive">
                            <?php
                            if (empty($result)) {
                                ?>
                                <p>No Records Found..</p>
                                <?php
                            } else {
                                ?>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Email Type</th>
                                            <th>Email Subject</th>
                                            <th>Last Modified By</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($result as $row):
                                            ?>
                                            <tr class="gradeA">
                                                <td><?php echo $i++; ?></td>
                                                <td>
                                                    <?php
                                                    if ($row->email_type == 0) {
                                                        echo 'Default';
                                                    } else {
                                                        echo 'Newsletter';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo ucfirst($row->email_title); ?></td>
                                                <?php
                                                $uname = $this->left_panel_model->get_admin_by_id($row->modified_by);
                                                ?>
                                                <td><?php echo ucfirst($uname[0]->uname); ?></td>
                                                <td>
                                                    <p class="fa fa-gear" title="Update" style="cursor: pointer; font-size: 20px;" onclick="update_data('<?php echo $row->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
                                                    <!--<p class="fa fa-times" title="Delete" style="cursor: pointer;font-size: 20px;" onclick="del_data('<?php echo $row->id; ?>')"></p>&nbsp;&nbsp;&nbsp;-->
                                                    <?php
                                                    if ($row->status == 'Y') {
                                                        ?>
                                                        <p class="fa fa-check-circle" title="Active" style="cursor: pointer;font-size: 20px;" onclick="change_status_to('N', '<?php echo $row->id; ?>')"></p>
                                                        <?php
                                                    } else if ($row->status == 'N') {
                                                        ?>
                                                        <p class="fa fa-times-circle" title="Inactive" style="cursor: pointer;font-size: 20px;" onclick="change_status_to('Y', '<?php echo $row->id; ?>')"></p>
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
                                <?php
                            }
                            ?>
                        </div>

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
        window.location.href = "<?php echo site_url(); ?>email_template_cont/change_status_to/" + stat_param + "/" + id;
    }

    function del_data(id)
    {
        var del = confirm('Are you sure you want to delete this template?');
        if (del == true)
        {
            window.location.href = "<?php echo site_url(); ?>email_template_cont/del_data/" + id;
        }
    }
    function update_data(id)
    {
        window.location.href = "<?php echo site_url(); ?>email_template_cont/edit_email_template/" + id;
    }
</script>