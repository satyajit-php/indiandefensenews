        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Sub-admin Management</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Show all Sub-admins
                             <a href="<?php echo base_url();?>index.php/subadmin_cont/add_subadmin" style="color: white;">
                             <button type="button" class="btn btn-primary btn-sm"  style="float: right; margin-top: -5px;">
                               Add New Sub-admin
                            </button>
                             </a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <?php
                                if(empty($subadmin_arr))
                                {
                                ?>
                                    <p>No Records Found..</p>
                                <?php
                                }
                                else
                                {
                                ?>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>                                            
                                            <th>Email Id</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                            $i =1;
                                            foreach($subadmin_arr as $row): 
                                            ?>
                                                <tr class="gradeA">
                                                    <td><?php echo $i++; ?></td>                                                    
                                                    <td><?php echo $row->email;?></td>
                                                    <td>
                                                    <p class="fa fa-gear" title="Edit" style="cursor: pointer; font-size: 20px;" onclick="edit_data('<?php echo $row->id;?>')"></p>&nbsp;&nbsp;&nbsp;
                                                    <p class="fa fa-times" title="Delete" style="cursor: pointer; font-size: 20px;" onclick="del_data('<?php echo $row->id;?>')"></p>&nbsp;&nbsp;&nbsp;
                                                    <?php
                                                    if($row->status=='0')
                                                    {
                                                    ?>
                                                    <p class="fa fa-check-circle" title="Active" style="cursor: pointer; font-size: 20px;" onclick="change_status_to('1', '<?php echo $row->id;?>')"></p>
                                                    <?php
                                                    }
                                                    else if($row->status=='1')
                                                    {
                                                    ?>
                                                    <p class="fa fa-times-circle" title="Inactive" style="cursor: pointer; font-size: 20px;" onclick="change_status_to('0', '<?php echo $row->id;?>')"></p>
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
    window.location.href="<?php echo site_url();?>/subadmin_cont/change_status_to/"+stat_param+"/"+id;
}

function del_data(id)
{
    var del=confirm('Are you sure you want to delete this template?');
    if(del== true)
    {
        window.location.href="<?php echo site_url();?>/subadmin_cont/del_data/"+id;        
    }
}

function edit_data(id)
{
    window.location.href="<?php echo site_url();?>/subadmin_cont/edit_subadmin/"+id;        
}
</script>