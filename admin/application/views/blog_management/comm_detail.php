      
<?php
$this->load->helper('text');
$string = "Here is a nice text string consisting of eleven words.";

$string = word_limiter($string, 4);

?>
      
        <div id="page-wrapper">
            <div class="row">                
                <div class="col-lg-12">
                    <h1 class="page-header">Comment Details</h1>
                </div>
                <!-- /.col-lg-12 -->
               
                
            </div>
            <!-- /.row -->
            <?php
           //echo ("<pre>");
           //print_r($result);die();
            ?>
            
          <!--  <form action="<?php echo site_url();?>/contact_list/updatecontact" method="POST" id="csv_frm" name="csv_frm" class="hide">
                <!--<input type="hidden" id="csv_val" name="csv_val" value="<?php //echo $email_str;?>"/>
                <input type="hidden" id="csv_stat" name="csv_stat" value="<?php //echo $status_str;?>"/>
            </form>-->
               
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        
                        <div class="panel-heading">
                            Showing all Product
                           <!--  <form action="" class="exconvert"  method="post" name="csv">-->
                                 <a href="<?php echo site_url();?>/blog_cont"><button  type="button" class="btn btn-primary btn-sm" style="float: right" >BACK</button></a>
                                 &nbsp;&nbsp;&nbsp;&nbsp;
                               
                                
                               <!--  </form>-->
                            
                            
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="dataTable_wrapper" id="reportsummary">
                                <?php
                                $csvr="";
                                if(empty($result))
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
                                            <th>Posted By</th>
                                            <th>Posted On</th>
                                            <th>Comment</th>
                                             <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <?php
                                            $i =1;
                                            //print_r($result);
                                            foreach($result as $row): 
                                            ?>
                                                <tr class="gradeA">
                                                    <td><?php echo $i++; ?></td>
                                                    
                                                    <td>
                                                    <?php
                                                       If(!empty($row->name))
                                                       {
                                                        echo $row->name;
                                                       }
                                                       else
                                                       {
                                                        echo "-";
                                                       }
                                                     ?>
                                                    </td>
                                                     
                                                    <td>
                                                    <?php
                                                   
                                                       $d= $row->posted_on;
                                                       echo date('F j, Y',strtotime($d))."   ".date('h:i a',strtotime($d));
                                                     ?>
                                                    </td>
                                                    <td>
                                                    <?php
                                                         
                                                         $c= $row->comment;
                                                         $c=word_limiter($c, 2);
                                                         echo $c ."..";
                                                    ?>
                                                    </td>
                                                   
                                                   <td>
                                                     <p class="fa fa-times" title="Delete" style="cursor: pointer;font-size: 20px;" onclick="del_data('<?php echo $row->id;?>')"></p>
                                                   </td>
                                              
                                                </tr>
                                            <?php
                                               //$csvr .="\n";
                                            endforeach;
                                            
                                            ?>
                                            
                                    </tbody>
                                </table>
                                <input type="hidden" name="setval" id="setval" value="<?php echo $csvr; ?>"/>
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

function del_data(id)
{
    var del=confirm('Are you sure you want to delete this Comment?');
    if(del== true)
    {
        window.location.href="<?php echo site_url();?>/blog_cont/del_data/"+id;        
    }
}

function update_user(id)
{
        window.location.href="<?php echo site_url();?>/stock_con/edit_data/"+id; //Edit Article Redirection Link
}

</script>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>          
<!--<script type="text/javascript">
$(document).ready(function(){
$(document).on("submit", '.exconvert', function(event) { 
        $("#expo1").val( $("<div>").append( $("#reportsummary").eq(0).clone() ).html() )
     });          
  });
</script>-->


