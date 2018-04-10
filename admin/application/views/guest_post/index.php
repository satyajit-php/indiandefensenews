<div id="page-wrapper">
    <div class="row">                
        <div class="col-lg-6">
            <h1 class="page-header">Guest Post Management</h1>
        </div>
        <div class="col-lg-6">
            <p class="btn  btn-primary page-header pull-right reset" title="RESET">RESET</p>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    Show all Post
                    <div class="pull-right">
                        <!--                        <div class="col-sm-2 col-md-2 col-xs-2">
                                                    Filter
                                                </div>-->
                        <div class="col-sm-10 col-md-10 col-xs-10">
                            <select class="select2" id="status" name="status" label="Status">
                                <option value="">Filter status</option>
                                <option value="S" <?php if ($this->input->get('status') == 'S') { ?> selected="selected" <?php } ?>>Submitted</option>
                                <option value="P" <?php if ($this->input->get('status') == 'P') { ?> selected="selected" <?php } ?>>Posted</option>
                                <option value="R" <?php if ($this->input->get('status') == 'R') { ?> selected="selected" <?php } ?>>Rejected</option>
                            </select>
                        </div>
                    </div>
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
                                            <th>Name</th>
                                            <th>Email_id</th>
                                            <th>Subject</th>
                                            <th>Posted Date</th>
                                            <th>Publish Date</th>
                                            <th>Status</th>
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
                                                <td><?= isset($row->name) ? $row->name : ''; ?></td>
                                                <td><?= isset($row->email) ? $row->email : ''; ?></td>
                                                <td><?= isset($row->subject) ? $row->subject : ''; ?></td>
                                                <td><?= isset($row->posted_on) ? date("d/m/Y", strtotime($row->posted_on)) : ''; ?></td>
                                                <td><?= (($row->released_on != '0000-00-00')) ? date("d/m/Y", strtotime($row->released_on)) : ''; ?></td>
                                                <td>
                                                    <?php
                                                    if ($row->status == 'S') {
                                                        ?>
                                                        <p class="btn  btn-info" title="Submited">Submitted</p>
                                                        <?php
                                                    } else if ($row->status == 'P') {
                                                        ?>
                                                        <p class="btn  btn-success" title="Posted">Posted</p>
                                                        <?php
                                                    } else if ($row->status == 'R') {
                                                        ?>
                                                        <p class="btn btn-danger" title="Rejected">Rejected</p>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td> <p class="fa fa-gear" title="Update" style="cursor: pointer;" onclick="update_data('<?php echo $row->id; ?>')"></p></td>
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

    function update_data(id, type)
    {
        window.location.href = "<?php echo site_url(); ?>guest_post_cont/edit/" + id;
    }

    $(document).ready(function () {
        $("#status").change(function () {
            status = $(this).val();
            if (status) {
                window.location.href = "<?php echo site_url(); ?>guest_post_cont?status=" + status;
            }
        })
        $(".reset").click(function () {
            window.location.href = "<?php echo site_url(); ?>guest_post_cont";
        })
    });
</script>