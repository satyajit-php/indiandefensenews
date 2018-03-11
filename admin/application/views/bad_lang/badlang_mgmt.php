<?php
$this->load->helper('text');
$string = "Here is a nice text string consisting of eleven words.";

$string = word_limiter($string, 4);

?>
	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Bad Language Management</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Show all blog content
			    <a href="<?php echo base_url();?>index.php/badlang_cont/add_csv" class="btn btn-primary btn-sm" style="float:right; margin-top:-6px;margin-left: 5px;">CSV upload</a>		
			   
			    <a href="<?php echo base_url();?>index.php/badlang_cont/add_badlang" class="btn btn-primary btn-sm" style="float:right; margin-top:-6px;">Add New Bad Language</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Sl No.</th>
                                            <th>Word</th>
                                           
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=1;
										//print_r($blog_data);
                                        if($blog_data !='')
                                        {
                                        foreach($blog_data as $blog):
                                        ?><tr class="gradeA">
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $blog->word;?></td>
                                           
                                            <td>
                                                <!--Edit Button-->
                                                <p class="fa fa-gear" title="Update" style="cursor: pointer; font-size: 20px;" onclick="update_blog('<?php echo $blog->id;?>')"></p>&nbsp;&nbsp;&nbsp;
                                                <!--Edit Button-->
                                                <p class="fa fa-times" title="Delete" style="cursor: pointer;font-size: 20px;" onclick="del_data('<?php echo $blog->id;?>')"></p>&nbsp;&nbsp;&nbsp;
												<?php
												  if($blog->status== 1)
												  {
												  ?>
												  <p class="fa fa-check-circle" title="Active" style="cursor: pointer; font-size: 20px;" onclick="change_status_to(0, '<?php echo $blog->id;?>')"></p>
												  <?php
												  }
												  else if($blog->status== 0)
												  {
												  ?>
												  <p class="fa fa-times-circle" title="Inactive" style="cursor: pointer; font-size: 20px;" onclick="change_status_to(1, '<?php echo $blog->id;?>')"></p>
												  <?php
												  }
												  ?>
												
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
function change_status_to(stat_param, id)
{
    window.location.href="<?php echo site_url();?>/badlang_cont/change_status_to/"+stat_param+"/"+id;
}

function del_data(id)
{
    var del=confirm('Are you sure you want to delete this content?');
    if(del== true)
    {
        window.location.href="<?php echo site_url();?>/badlang_cont/del_data/"+id;
    }
}
function update_blog(id)
{
        window.location.href="<?php echo site_url();?>/badlang_cont/edit_blog/"+id; //Edit Article Redirection Link
}

</script>