  <!--<div class="panel-body" id='visitor'>-->
<input type='hidden' value='<?php echo $viewer['num'];?>' id='total'>

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
                            <!-- /.table-responsive -->
                        <!--</div>-->
                        <!-- /.panel-body -->