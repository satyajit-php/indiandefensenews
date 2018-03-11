<?php
//$url= base_url();
//$url= (explode("/",$url));
//$nwurl= str_replace("admin","http://www.esolz.co.in/lab4/credit_monk/", $url[5]);
//echo $nwurl = ../base_url();die;
//echo ("<pre>");
//print_r($result);
//die();
?>

	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Review and Comment Management</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Showing all review content
			</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Company Name</th>
                                            <th>Review By</th>
                                            <th>Review</th>
                                            <th>Month-Year</th>
                                            <th>Show</th>
                                            <th>Option</th>
                                            <th>Goto Review</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i=1;
                                    if(!empty($result))
                                    {
                                    foreach($result as $row):
                                    $company_details = $this->review_model->get_row_by_id('company_details', 'id', $row->company_id);
                                    $user_details = $this->review_model->get_row_by_id('people', 'id', $row->added_by);
									if($company_details != 'false' && $user_details != 'false')
									{
                                    ?>
                                       <tr class="gradeA">
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $company_details[0]->company_name; ?></td>
                                            <td>
											<?php
											if($user_details[0]->first_name =='' && $user_details[0]->last_name == '')
											{
												$arr=  explode("@",$user_details[0]->email);
												echo $arr[0];
											}else {
											if($user_details != false || $user_details[0]->first_name !='' && $user_details[0]->last_name !='' ) {echo $user_details[0]->first_name.' '.$user_details[0]->last_name;} else {echo "NA";}
											//if(isset($user_details) && $user_details[0]->first_name !='' && $user_details[0]->last_name !='' ) {echo $user_details[0]->first_name.' '.$user_details[0]->last_name;} else {echo "NA";}
											}
											?>
											</td>
                                            <?php
                                            $this->load->helper('text');
                                            $string = $row->review_title;
                                            $string = word_limiter($string, 4);
                                            ?>
                                            <td><?php echo $string; ?></td>
                                            <td><?php echo $row->month.'-'.$row->year; ?></td>
                                            <td>
												<p class="fa fa-comments" title="Show Comment" style="cursor: pointer; font-size: 20px;" onclick="show_comm('<?php echo $row->id;?>')"></p>
											    <p class="fa fa-flag" title="Show Report" style="cursor: pointer; font-size: 20px;" onclick="show('<?php echo $row->id;?>')"></p>
											    &nbsp;&nbsp;&nbsp;
											</td>
                                            <td><p class="fa fa-times" title="Delete" style="cursor: pointer; font-size: 20px;" onclick="delete_data('<?php echo $row->id;?>')"></p>&nbsp;&nbsp;&nbsp;</td>
                                            <?php
											//$revurl="rating/index/".$row->id;
											$revurl="review/review_details/".$row->company_id."?detailID=".$row->id;
                                            $img= "images"
											?>
                                            <td><a target="_blank" href="<?php echo base_url().'../'.$revurl; ?>"><p class="fa fa-eye"></p> </a></td>
                                        </tr> 
                                    <?php
									}
                                        endforeach;
                                    }
                                    ?>
                                        
                                    </tbody>
                                </table>
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
function delete_data(id)
{
     if (confirm("Are you sure to delete?"))
    {
       window.location.href="<?php echo site_url();?>/review_cont/del_rev/"+id;   
    }
    return false;
       
}
function show(id)
{
        window.location.href="<?php echo site_url();?>/review_cont/show_report/"+id; 
}
function show_comm(id)
{
        window.location.href="<?php echo site_url();?>/review_cont/show_comment/"+id; 
}
</script>
