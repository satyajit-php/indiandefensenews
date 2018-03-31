<body>

    <div id="wrapper">
        <!---------------alert section------------>
            <?php
            if($this->session->userdata('error_msg')!='')
            {
            ?>
            <div class="alert alert-danger alert-dismissable" style="text-align: center;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <a href="javascript:vouid(0);" class="alert-link">Error!</a>
                <?php
                    echo $this->session->userdata('error_msg');
                    $this->session->unset_userdata('error_msg');
                ?>
            </div>
            <?php
            }
            if($this->session->userdata('success_msg')!='')
            {
            ?>
            <div class="alert alert-success alert-dismissable" style="text-align: center;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <a href="javascript:vouid(0);" class="alert-link">Success!</a>
                <?php
                    echo $this->session->userdata('success_msg');
                    $this->session->unset_userdata('success_msg');
                ?>
            </div>
            <?php
            }
            ?>
            <!---------------alert section------------>
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url();?>/dashboard_cont">
    <!--                    <img src="<?php echo base_url(); ?>images/logo-1.png" alt="" />-->
                </a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
            <!--------------------message section-------------------->
                <!--------------------message section-------------------->

                <!-------------not necessary at present------------->                            
                <!-------------------loader section----------------->
                <!-- /.dropdown -->
                <li class="dropdown hide">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
              
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php
                        $admin_arr = $this->left_panel_model->get_admin();
                        if($admin_arr[0]->image != '')
                        {
                        ?>
                        <img alt="Admin" src="<?php echo base_url();?>images/thumbnail/<?php echo $admin_arr[0]->image;?>" style="border: 2px solid;border-radius: 20px;width: 30px;">
                        <?php
                        }
                        else
                        {
                        ?>
                            <i class="fa fa-user fa-fw"></i>
                        <?php
                        }
                            echo 'Hi! '.ucfirst($admin_arr[0]->uname);
                        ?>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo site_url();?>/edit_profile_cont"><i class="fa fa-user fa-fw"></i>Edit Profile</a></li>
                        <li><a href="<?php echo base_url();?>index.php/edit_pass_cont"><i class="fa fa-unlock-alt fa-fw"></i> Change Password</a></li>
                        <!--<li><a href="<?php echo base_url();?>index.php/site_settings_cont"><i class="fa fa-gear fa-fw"></i> Settings</a></li>-->
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url();?>index.php/logout_cont"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
                <!-------------------New profile section-------------------->
                
                
            </ul>
            <!-- /.navbar-top-links -->
            