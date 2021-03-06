        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">City Management</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
             <div class="row">
                
             </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Show all cities
                            <a href="<?php echo base_url();?>index.php/city_cont/add_new_city">
                                <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                                   <span style="color: white;">Add New City</span>
                                </button>
                           </a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <?php
                                if(empty($city_arr))
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
                                            <th>City</th>
                                            <th>Country</th>
                                            <th>State</th>
                                            <th>Last Modified By</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                            $i=1;
                                            foreach($city_arr as $row)
                                            {
                                            ?>
                                                <tr class="gradeA">
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo ucfirst($row->city); ?></td>
                                                    <td>
                                                    <?php
                                                    foreach($country_arr as $row1)
                                                    {
                                                        if($row->country_id == $row1->id)
                                                        {
                                                            echo ucfirst($row1->country_name);
                                                        }
                                                    }
                                                    ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                    foreach($state_arr as $row2)
                                                    {
                                                         if($row->state_id == $row2->id)
                                                        {
                                                            echo ucfirst($row2->state);
                                                        }
                                                    }
                                                    ?>
                                                    </td>
                                                    <?php
                                                    $uname = $this->left_panel_model->get_admin_by_id($row->modified_by);
                                                    ?>
                                                    <td><?php echo ucfirst($uname[0]->uname);?></td>
                                                    <td>
                                                    <p class="fa fa-gear" title="Update" style="cursor: pointer; font-size: 20px;" onclick="update_data('<?php echo $row->id;?>')"></p>&nbsp;&nbsp;&nbsp;
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
                                            }
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
    window.location.href="<?php echo site_url();?>/city_cont/change_status_to/"+stat_param+"/"+id;
}

function del_data(id)
{
    var del=confirm('Are you sure you want to delete this template?');
    if(del== true)
    {
        window.location.href="<?php echo site_url();?>/city_cont/del_data/"+id;        
    }
}
function update_data(id)
{
    //alert('abc');
        window.location.href="<?php echo site_url();?>/city_cont/edit_city/"+id; 
}
 
   
    </script>
</script>