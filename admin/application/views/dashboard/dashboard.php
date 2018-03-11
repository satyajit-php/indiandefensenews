<!-- Morris Charts JavaScript -->
<script src="<?php echo base_url(); ?>assets/bower_components/raphael/raphael-min.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/bower_components/morrisjs/morris.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/morris-data.js"></script>-->


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <div class="col-lg-6" style="float: right;margin-right: -250px;">
            <h3 class="page-header">Total Viewer:<b><?php echo $view ?></b><a href="<?php echo base_url(); ?>index.php/dashboard_cont/site_view">&nbsp;&nbsp;View</a></h>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $user; ?></div>
                            <div>Total Users!</div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo base_url(); ?>index.php/user_management_cont">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $feedback; ?></div>
                            <div>Total Feedback!</div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo base_url(); ?>index.php/feedback_cont">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

    </div><!---row--->

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
