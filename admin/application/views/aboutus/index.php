<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">About us Management</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Show all about us content
                   
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="dataTable_wrapper">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Title</th>
                                        <th>Images</th>
                                        <th>Details</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if ($aboutus_data != '') {
                                        foreach ($aboutus_data as $aboutus):
                                            ?><tr class="gradeA">
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $aboutus->title; ?></td>
                                                <td><img class="img-thumbnail" alt="Your uploaded image" src="<?php echo base_url() . 'uploaded_image/thumbnail/' . $aboutus->image; ?>"  height="50" width="50"/></td>
                                                <?php
                                                $string = $aboutus->text;
                                                $string = word_limiter($string, 4);
                                                ?>
                                                <td><?php echo $string; ?></td>
                                                <td>
                                                    <p class="fa fa-gear" title="Update" style="cursor: pointer; font-size: 20px;" onclick="update_blog('<?php echo $aboutus->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
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

    function update_blog(id)
    {
        window.location.href = "<?php echo site_url(); ?>aboutus/edit_aboutus/" + id; //Edit Article Redirection Link
    }

</script>