<div id="page-wrapper">
    <div class="row">                
        <div class="col-lg-12">
            <h1 class="page-header">News Letter Management</h1>
        </div>
        <!-- /.col-lg-12 -->


    </div>
    <!-- /.row -->
    <?php
    $email_arr = array();
    $status_arr = array();
    foreach ($result as $row1) {
        array_push($email_arr, $row1->email);
        array_push($status_arr, $row1->status);
    }
    $email_str = implode(',', $email_arr);
    $status_str = implode(',', $status_arr);
    ?>

    <form action="<?php echo site_url(); ?>news_letter_cont/export_news_letter" method="POST" id="csv_frm" name="csv_frm" class="hide">
        <input type="hidden" id="csv_val" name="csv_val" value="<?php echo $email_str; ?>"/>
        <input type="hidden" id="csv_stat" name="csv_stat" value="<?php echo $status_str; ?>"/>
    </form>

    <div style=" margin-bottom: 14px; float: right; ">
        <button type="button" class="btn btn-primary btn-sm" onclick="export_csv();"><a href="javascript:void(0);"><span style="color: white;">Export CSV</span></a></button>
        <button type="button" class="btn btn-primary btn-sm"><a href="<?php echo site_url(); ?>news_letter_cont/send_news_letter"><span style="color: white;">Send Mail</span></a></button>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    Show all Subscribers
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
                                            <th>Email_id</th>
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
                                                <td><?php echo ($row->email); ?></td>
                                                <td>
                                                   <!--<p class="fa fa-gear" title="Update" style="cursor: pointer;" onclick="update_data('<?php echo $row->id; ?>')"></p>-->
                                                    <p class="fa fa-times" title="Delete" style="cursor: pointer; font-size: 20px;" onclick="del_data('<?php echo $row->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    if ($row->status == 0) {
                                                        ?>
                                                        <p class="fa fa-check-circle" title="Active" style="cursor: pointer; font-size: 20px;" onclick="change_status_to(1, '<?php echo $row->id; ?>')"></p>
                                                        <?php
                                                    } else if ($row->status == 1) {
                                                        ?>
                                                        <p class="fa fa-times-circle" title="Inactive" style="cursor: pointer; font-size: 20px;" onclick="change_status_to(0, '<?php echo $row->id; ?>')"></p>
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
        window.location.href = "<?php echo site_url(); ?>news_letter_cont/change_status_to/" + stat_param + "/" + id;
    }

    function del_data(id)
    {
        var del = confirm('Are you sure you want to delete this template?');
        if (del == true)
        {
            window.location.href = "<?php echo site_url(); ?>news_letter_cont/del_data/" + id;
        }
    }

    function export_csv()
    {
        document.csv_frm.submit();
    }
</script>