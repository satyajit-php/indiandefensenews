<?php
//echo ("<pre>");
//print_r($rev_details);
//echo ("<pre>");
//print_r( $rev_comment);
//die();
?>
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Review Comment</h1>		 
                 </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          
                            <?php $company_details = $this->review_model->get_row_by_id('company_details', 'id', $rev_details[0]->company_id); ?>
                            <label>Company Name:&nbsp;</label><?php echo $company_details[0]->company_name;?>
                            <?php $user_details = $this->review_model->get_row_by_id('people', 'id', $rev_details[0]->added_by); ?>
                            &nbsp;&nbsp;<label>Review By:&nbsp;</label><?php echo $user_details[0]->first_name.' '.$user_details[0]->last_name;?>
                            &nbsp;&nbsp;<label>Review:&nbsp;</label><?php echo $rev_details[0]->review_title; ?>
			    
			    <a href="<?php echo site_url();?>/review_cont" style="color: white;">
				 <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -3px;"> Back</button>
				 </a>
                            
			            </div>
						
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Comment By</th>
                                            <th>Comment</th>
									        <th>Comment On</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
												
                                    <?php
									if(isset($rev_comment) && $rev_comment !=0 && $rev_comment !='' && $rev_comment != 'false' )
									{
									$i=0;
									foreach($rev_comment as $r_com)
									{
									    $user_details= $this->review_model->get_row_by_id('people', 'id', $r_com->comment_by);
										if($user_details[0]->first_name =='' && $user_details[0]->last_name == '')
									    {
									       $arr=  explode("@",$user_details[0]->email);
										   $name= $arr[0]; 
										}else{
												if(isset($user_details) &&  $user_details !='false')
												{
												  $name= $user_details[0]->first_name.' '.$user_details[0]->last_name;
												}
												else
												{
												  $name="NA";
												}
										}
									
                                    $i++;
                                    ?>
									<tr class="gradeA">
										<td><?php echo $i; ?></td>
										<td><?php echo $name; ?></td>
										<td>
										<?php
										if($r_com->comment !='')
										{
										   echo $r_com->comment;
										}else{
												echo "NA";
										}
									    ?>
										</td>
										<?php
										//$str=explore(' ', $r_com->comment_on);
										//echo $str[0]; 
										?>
										<td><?php echo "Date: ".date("d/m/Y", strtotime($r_com->comment_on))." Time: ".date('H:i', strtotime($r_com->comment_on));; ?></td>
										<td><p class="fa fa-times" title="Delete" style="cursor: pointer; font-size: 20px;" onclick="delete_data('<?php echo $r_com->id;?>')"></p>&nbsp;&nbsp;&nbsp;</td>
									</tr>
                                    <?php
                                    }
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


<!------------validate form------------->
<script>
function delete_data(id)
{
    if (confirm("Are you sure to delete?"))
    {
      window.location.href="<?php echo site_url();?>/review_cont/del_rev_comment/"+id;    
    }
    return false;
       
}    
function go_reset()
{
    window.location.href="<?php echo base_url();?>index.php/country_cont";
}
</script>
<!------------validate form------------->