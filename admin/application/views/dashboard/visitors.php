<?php
$this->load->helper('text');
$string = "Here is a nice text string consisting of eleven words.";

$string = word_limiter($string, 4);

?>
	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Visitors Management</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Show all visitor's details&nbsp;&nbsp;<b>Total Visitors:</b>&nbsp;<span id='tot'><?php echo $viewer['num'];?></span>
                            <select class='form-control' style="margin-top:-6px;float:right;width: 140px" onchange='get_selected_visitor(this.value);'>
                                <option value='1'>Today</option>
                                <option value='2'>Yesterday</option>
                                <option value='3'>Last 7 days</option>
                                <option value='4'>Last 1 Month</option>
                                <option value='5'>Last 1 Year</option>
                            </select>
			</div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" id='visitor'>

                            <div class="dataTable_wrapper">
                                <?php
                                if(empty($viewer))
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
                                            <th>SL. No</th>
                                            <th>IP Address</th>
                                            <th>Visited On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                             $i=1;
                                            foreach($viewer['result'] as $row): 
                                            ?>
                                                <tr class="gradeA">
                                                    <td><?php echo $i++;?></td>
                                                    <td><?php echo $row->ip_address;?></td>
                                                    <td><?php echo $row->date;?></td>
                                                                                                        
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
 function get_selected_visitor(day)
    {
        //alert(day);
        $.ajax({
            url: "<?php echo base_url();?>index.php/dashboard_cont/visitor_ajax",
            async: false,
            method:'post',
            data:{'day':day},
            success: function(result){
            
            $("#visitor").html(result);
            var total=$('#total').val();
            $('#tot').html(total);
            //alert(result);
	    
	    
	$('#dataTables-example').dataTable( {
	   "destroy": true,
	   responsive: true
	});
        }
            
        });
       
    }
</script>