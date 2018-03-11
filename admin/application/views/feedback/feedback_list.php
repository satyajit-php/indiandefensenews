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
                    <h1 class="page-header">Feedback Management</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Show all feedback details
			</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
												<th>Sl No.</th>
												<th>Feedback From</th>
                                                <th>Comment</th>
												<th>Contact Details</th>
												<th>Status</th>
												
												
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=1;
                                        if($feedback_details != false)
                                        {
												
												foreach($feedback_details as $row):
												
												//$user_details = $this->review_company_model->user_details($row->company_id, $row->added_by);
												?>
												<tr class="gradeA">
														<td><?php echo $i++; ?></td>
														<td><?php echo $row->email; ?></td>
                                                        <td><?php echo substr($row->comment,0,100); ?></td>
														<td><?php echo $row->contact; ?></td>
														
														<td>	
                                                            <p class="fa fa-gear" title="Edit" style="cursor: pointer; font-size: 20px;" onclick="edit_data('<?php echo $row->id;?>')"></p>&nbsp;&nbsp;&nbsp;
                                                            <p class="fa fa-times" title="Delete" style="cursor: pointer; font-size: 20px;" onclick="del_data('<?php echo $row->id;?>')"></p>&nbsp;&nbsp;&nbsp;
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
		
//============script for delete feedback===============//

function del_data(id)
{
    var del=confirm('Are you sure you want to delete this feedback?');
    if(del== true)
    {
        window.location.href="<?php echo site_url();?>/feedback_cont/del_data/"+id;        
    }
}
//============ end script for delete feedback===============//

//==================script for edit feedback=================//

function edit_data(id)
{
    window.location.href="<?php echo site_url();?>/feedback_cont/update_feedback/"+id;        
}

//============ end script for edit feedback===============//
</script>