<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Write us Management Page</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Show all Write us content

                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="dataTable_wrapper">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sl No.</th>
                                        <th>Message</th>
                                        <th>Images</th>
                                        <th>Contact</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if ($contactpage_data != '') {
                                        foreach ($contactpage_data as $contactpage):
                                            ?><tr class="gradeA">
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $contactpage->text; ?></td>
                                                <td><img class="img-thumbnail" alt="Your uploaded image" src="<?php echo base_url() . 'uploaded_image/thumbnail/' . $contactpage->image; ?>"  height="50" width="50"/></td>
                                                <?php
                                                $string = $contactpage->contact;
                                                ?>
                                                <td><?php echo $string; ?></td>
                                                <td>
                                                    <p class="fa fa-gear" title="Update" style="cursor: pointer; font-size: 20px;" onclick="update_blog('<?php echo $contactpage->id; ?>')"></p>&nbsp;&nbsp;&nbsp;
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
        window.location.href = "<?php echo site_url(); ?>contact_page/edit_contactpage/" + id; //Edit Article Redirection Link
    }

</script>