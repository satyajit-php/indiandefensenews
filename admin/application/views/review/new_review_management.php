<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);

$this->load->helper('text');
$string = "Here is a nice text string consisting of eleven words.";

$string = word_limiter($string, 4);

?>
	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Review Management</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Show all review details
			</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
												<th>Sl No.</th>
												<th>Company Name</th>
												<th>Review Title</th>
												<th>Posted By</th>
												<th>Post Date</th>
												<th>Status</th>
												<th>View Details</th>
												
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=1;
                                        if($review_details != false)
                                        {
												$claimed=0;
												foreach($review_details as $row):
												
												//$user_details = $this->review_company_model->user_details($row->company_id, $row->added_by);
												
												
												?>
												<tr class="gradeA">
														<td><?php echo $i++; ?></td>
														<td><?php echo $row->company_name; ?></td>
														<td><?php echo $row->review_title; ?></td>
														<td><?php echo $row->first_name; ?> <?php echo $row->last_name; ?></td>
														<td><?php echo $row->added_on; ?></td>
														
														<td>
																
														<?php
														if($row->disable=='1')
														{
														?>
																<p class="fa fa-times-circle" title="Inactive" style="cursor: pointer; font-size: 20px;"></p>
																<!--onclick="change_status_to('1','<?php echo $row->rid; ?>','<?php echo $row->company_id; ?>')"-->
														<?php
														}
														else if($row->disable=='0')
														{
														?>
																<p class="fa fa-check-circle" title="Active" style="cursor: pointer; font-size: 20px;"></p>
																<!--onclick="change_status_to('0', '<?php echo $row->rid; ?>','<?php echo $row->company_id; ?>')"-->
														<?php
														}
														?>
														</td>
														<td><a href="<?php echo site_url();?>/review_mang_cont/review_details/<?php echo $row->rid;?>/<?php echo $row->company_id;?>">View Details</a></td>
														<!--<td><a href="javascript:void(0)">View Details</a></td>-->

														
												</tr>
												<?php
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
		
//============script for change status of review===============//

function change_status_to(review_param,id,comp_id)
{
		//alert(id);
		if (review_param == 1)
		{
            var confirmvalue=confirm("Do You want to activate this review?");
        }
		if (review_param == 0)
		{
            var confirmvalue=confirm("Do You want to deactivate this review?");
        }
		
		if (confirmvalue == true)
		{
				window.location.href="<?php echo site_url();?>/review_mang_cont/change_status_to/"+review_param+"/"+id+"/"+comp_id;
		}
   
    
}

//============ end script for change status of review===============//
</script>