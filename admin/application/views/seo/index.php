<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"> Seo Management</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Show all  Seo content
                    <a href="<?php echo base_url(); ?>seo/add">
                        <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top:-5px;">
                            <span style="color: white;">Add New seo</span>
                        </button>
                    </a>   
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
                                        <th>Routes</th>
                                        <th>Description</th>
                                        <th>Keyword</th>
                                        <th>Logo url</th>
                                        <th>OG Description</th>
                                        <th>Type</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (!empty($seo_data)) {
                                        foreach ($seo_data as $seo):
                                            ?><tr class="gradeA">
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $seo->title; ?></td>
                                                <td><?php echo $seo->routes; ?></td>
                                                <td><?php echo $seo->description; ?></td>
                                                <td><?php echo $seo->keyword; ?></td>
                                                <td><?php echo $seo->url; ?></td>
                                                <td><?php echo $seo->og_description; ?></td>
                                                <td><?php echo $seo->og_type; ?></td>
                                                <td>
                                                    <p class="fa fa-gear" title="Update" style="cursor: pointer; font-size: 20px;" onclick="update_blog('<?php echo $seo->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
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
        window.location.href = "<?php echo site_url(); ?>seo/edit/" + id; //Edit Article Redirection Link
    }

</script>