<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Privacy Policy Management</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Show all privacy Policy content

                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="dataTable_wrapper">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>

                                        <th>Details</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if ($privacy_data != '') {
                                        foreach ($privacy_data as $privacy):
                                            ?><tr class="gradeA">
                                                <td><?php echo $i++; ?></td>
                                                <?php
                                                $string = $privacy->message;
                                                $string = word_limiter($string, 4);
                                                ?>
                                                <td><?php echo $string; ?></td>
                                                <td>
                                                    <p class="fa fa-gear" title="Update" style="cursor: pointer; font-size: 20px;" onclick="update_('<?php echo $privacy->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
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

    function update_(id)
    {
        window.location.href = "<?php echo site_url(); ?>privacypolicy/edit_privacypolicy/" + id; //Edit Article Redirection Link
    }

</script>