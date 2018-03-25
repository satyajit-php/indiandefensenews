<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Twitter Seo Management</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Show all Twitter Seo content

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
                                        <th>Handle</th>
                                        <th>Creator</th>
                                        <th>Description</th>
                                        <th>Summary</th>
                                        <th>Logo url</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if ($twiter_data != '') {
                                        foreach ($twiter_data as $twiter):
                                            ?><tr class="gradeA">
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $twiter->title; ?></td>
                                                <td><?php echo $twiter->handle; ?></td>
                                                <td><?php echo $twiter->creator; ?></td>
                                                <td><?php echo $twiter->description; ?></td>
                                                <td><?php echo $twiter->summary; ?></td>
                                                <td><img class="img-thumbnail" alt="Your uploaded image" src="<?php echo $twiter->image_url; ?>"  height="50" width="50"/></td>
                                                <td>
                                                    <p class="fa fa-gear" title="Update" style="cursor: pointer; font-size: 20px;" onclick="update_blog('<?php echo $twiter->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
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
        window.location.href = "<?php echo site_url(); ?>twiterseo/edit/" + id; //Edit Article Redirection Link
    }

</script>