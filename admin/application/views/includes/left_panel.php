<div class="navbar-default sidebar" role="navigation" style="margin-top: 70px;">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">


                <!-------------not necessary at present------------->                            
                <!-------------search section------------->                            
                <div class="input-group custom-search-form hide">
                    <input type="text" class="form-control" placeholder="Search..">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <!-------------search section------------->
                <!-------------not necessary at present------------->                            

                <!-- /input-group -->
            </li>
            <li>
                <a href="<?php echo base_url(); ?>dashboard_cont"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <?php
            $admin_val_arr = $this->left_panel_model->get_admin();
            if ($admin_val_arr[0]->its_superadmin != 1) {
                $page_arr = explode(',', $admin_val_arr[0]->page_access);
            }

            $parentnav_val_arr = $this->left_panel_model->get_nav_value();

            foreach ($parentnav_val_arr as $parentnav_val) {
                if ((!empty($page_arr) && in_array($parentnav_val->id, $page_arr)) || (empty($page_arr) && $admin_val_arr[0]->its_superadmin == 1)) {
                    $childnav_val_arr = $this->left_panel_model->get_childnav_value($parentnav_val->id);
                    ?>
                    <li>
                        <a <?php if ($parentnav_val->page_name != '') { ?>href="<?php echo base_url(); ?><?php echo $parentnav_val->page_name; ?>"<?php } else { ?> href="javascript:void(0);" <?php } ?>>
                            <i class="<?php echo $parentnav_val->icon_name; ?>"></i> <?php echo $parentnav_val->management_name; ?>
                            <?php
                            if (!empty($childnav_val_arr)) {
                                ?>
                                <span class="fa arrow"></span>
                                <?php
                            }
                            ?>
                        </a>
                        <?php
                        if (!empty($childnav_val_arr)) {
                            ?>
                            <ul class="nav nav-second-level">
                                <?php
                                foreach ($childnav_val_arr as $childnav_val) {
                                    if ((!empty($page_arr) && in_array($childnav_val->id, $page_arr)) || (empty($page_arr) && $admin_val_arr[0]->its_superadmin == 1)) {
                                        ?>                                
                                        <li>
                                            <a href="<?php echo base_url(); ?><?php echo $childnav_val->page_name; ?>"><?php echo $childnav_val->management_name; ?></a>
                                        </li>                                
                                        <?php
                                    }
                                }
                                ?>

                            </ul>
                            <?php
                        }
                        ?>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
</nav>

