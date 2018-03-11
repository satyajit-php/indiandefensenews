<?php
        ini_set("display_errors", "1");
        error_reporting(E_ALL);
        ?>     
      <style>
        .pagination>li {
                float: left;
              }
        </style> 
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Location Management</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Show all countries
                             <input type="text" id="searchLoc" value="<?php echo $this->input->get('searchData');?>" placeholder="Search Here Location Name" style="width: 300px;">
							 <input type="button" id="searchbtn" value="Search" onclick="getSearchFromLoc();">
							 <input type="button" value="Show All" onclick="getShowFromLoc();">
                            <a href="<?php echo base_url();?>index.php/country_cont/add_country">
                            <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top:-5px;">
                                <span style="color: white;">Add New Location</span>
                            </button>
                            </a>    
                        </div>
                       
                         
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="dataTable_wrapper">
                                <?php
                                if(empty($result))
                                {
                                ?>
                                    <p>No Records Found..</p>
                                <?php
                                }
                                else
                                {
                                ?>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Country</th>
                                          <!--  <th>Country id</th>-->
                                            <th>State</th>
                                           <!-- <th>State id</th>-->
                                            <th>District</th>
                                           <!-- <th>District id</th>-->
                                            <th>City</th>
                                            <!--<th>City id</th>-->
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                            $i =1;
                                           
                                           // echo "<pre>";
                                           //  print_r($result);
                                           ////  die();
                                                        
                                           foreach($result as $row):
                                              //echo $row[$i++]."<br>";
                                                        $country="";
                                                        $country_id="";
                                                        $state="";
                                                        $state_id="";
                                                        $district="";
                                                        $district_id="";
                                                        $city="";
                                                        $city_id="";
                                                        $type=$row->location_type;
                                                        if($type==2)
                                                        {
                                                                  $city=$row->name.' ('.$row->location_id.')';
                                                                  $city_id= $row->location_id;
                                                                  $id1=$row->parent_id;
                                                                  
                                                                  $res_dis=$this->country_model->get_location_id($id1);
                                                                  if(!empty($res_dis))
                                                                  {
                                                                        $type1=$res_dis[0]->location_type;
                                                                        if($type1==3)
                                                                        {
                                                                            $district=$res_dis[0]->name.' ('.$res_dis[0]->location_id.')';
                                                                            $district_id= $res_dis[0]->location_id;
                                                                        }
                                                                        else if($type1==1)
                                                                        {
                                                                            $state=$res_dis[0]->name.' ('.$res_dis[0]->location_id.')';
                                                                            $state_id= $res_dis[0]->location_id;
                                                                        }
                                                                        else if($type1==0)
                                                                        {
                                                                             $country=$res_dis[0]->name .' ('.$res_dis[0]->location_id.')';
                                                                             $country_id= $res_dis[0]->location_id;
                                                                        }
                                                                        
                                                                        $sid= $res_dis[0]->parent_id;
                                                                     
                                                                  
                                                                       $res_state=$this->country_model->get_location_id($sid);
                                                                  }
                                                                   if(!empty($res_state))
                                                                   {
                                                                        $type2=$res_state[0]->location_type;
                                                                         
                                                                       if($type2==1)
                                                                        {
                                                                            $state=$res_state[0]->name.' ('.$res_state[0]->location_id.')';
                                                                            $state_id= $res_state[0]->location_id;
                                                                        }
                                                                        else if($type2==0)
                                                                        {
                                                                            $country=$res_state[0]->name.' ('.$res_state[0]->location_id.')';
                                                                            $country_id= $res_state[0]->location_id;
                                                                        }
                                                                   
                                                                      $cid= $res_state[0]->parent_id;
                                                                   
                                                                   
                                                                   $res_con=$this->country_model->get_location_id($cid);
                                                                   }
                                                                    if(!empty($res_con))
                                                                    {
                                                                       $country=$res_con[0]->name.' ('.$res_con[0]->location_id.')';
                                                                       $country_id= $res_con[0]->location_id;
                                                                    }
                                                              
                                                              
                                                              
                                                        }
                                                        
                                                        if($type==3)
                                                        {
                                                                 $district=$row->name.' ('.$row->location_id.')';
                                                                 $id2=$row->parent_id;
                                                                  
                                                                  $res2_state=$this->country_model->get_location_id($id2);
                                                                  if(!empty($res2_state))
                                                                  {
                                                                        $type3=$res2_state[0]->location_type;
                                                                         
                                                                       if($type3==1)
                                                                        {
                                                                             $state=$res2_state[0]->name.' ('.$res2_state[0]->location_id.')';
                                                                          
                                                                        }
                                                                        else if($type3==0)
                                                                        {
                                                                             $country=$res2_state[0]->name.' ('.$res2_state[0]->location_id.')';
                                                                        }
                                                                         
                                                                        $cid2= $res2_state[0]->parent_id;
                                                                   
                                                                  
                                                                   $res2_con=$this->country_model->get_location_id($cid2);
                                                                  }
                                                                    if(!empty($res2_con))
                                                                    {
                                                                
                                                                         $country=$res2_con[0]->name.' ('.$res2_con[0]->location_id.')';
                                                                    }
                                                            
                                                        }
                                                        if($type==1)
                                                        {
                                                                 $state=$row->name.' ('.$row->location_id.')';
                                                                 $id3=$row->parent_id;
                                                                 $res3_state=$this->country_model->get_location_id($id3);
                                                                  if(!empty($res3_state))
                                                                  {
                                                                        $type4=$res3_state[0]->location_type;
                                                                       if($type4==0)
                                                                        {
                                                                            $country=$res3_state[0]->name.' ('.$res3_state[0]->location_id.')';
                                                                        }
                                                                  }     
                                                        }
                                                      
                                                        if($type==0)
                                                        {
                                                              $country=$row->name.' ('.$row->location_id.')';
                                                        }
                                                       
                                                 
                                            ?>
                                                 <tr class="gradeA">
                                              
                                                          
                                                    <td><?php echo $i++; ?></td>
                                                    <td>
                                                    <?php
                                                       echo ucfirst($country);
                                                    ?>
                                                    </td>
                                                    <td>
                                                     <?php
                                                       echo ucfirst($state);
                                                    ?>
                                                    </td>
                                                     <td>
                                                    <?php
                                                       echo ucfirst($district);
                                                    ?>
                                                    </td>
                                                     <td>
                                                   <?php
                                                       echo ucfirst($city);
                                                    ?>
                                                    </td>
                                                    <td>
                                                    <p class="fa fa-gear" title="Update" style="cursor: pointer; font-size: 20px;" onclick="update_data('<?php echo $row->location_id;?>','<?php echo $row->location_type;?>')"></p>&nbsp;&nbsp;&nbsp;
                                                    <!--<p class="fa fa-times" title="Delete" style="cursor: pointer; font-size: 20px;" onclick="del_data('<?php //echo $row->location_id;?>')"></p>&nbsp;&nbsp;&nbsp;-->
                                                    <?php
                                                    if($row->is_visible== 0)
                                                    {
                                                    ?>
                                                    <p class="fa fa-check-circle" title="Active" style="cursor: pointer; font-size: 20px;" onclick="change_status_to(1, '<?php echo $row->location_id;?>')"></p>
                                                    <?php
                                                     }
                                                    else if($row->is_visible== 1)
                                                    {
                                                    ?>
                                                      <p class="fa fa-times-circle" title="Inactive" style="cursor: pointer; font-size: 20px;" onclick="change_status_to(0, '<?php echo $row->location_id;?>')"></p>
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
                                echo $pagi;
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
    window.location.href="<?php echo site_url();?>/country_cont/change_status_to/"+stat_param+"/"+id;
}

function del_data(id)
{
    var del=confirm('Are you sure you want to delete this Location?');
    if(del== true)
    {
        window.location.href="<?php echo site_url();?>/country_cont/del_data/"+id;        
    }
}
function update_data(id,type)
{
        window.location.href="<?php echo site_url();?>/country_cont/edit_location/"+id; 
}
function getSearchFromLoc() {
		var searchValue = $("#searchLoc").val();
		window.location.href="<?php echo site_url();?>/country_cont?&searchData="+searchValue;
}
function getShowFromLoc() {
		window.location.href="<?php echo site_url();?>/country_cont?";
}
</script>