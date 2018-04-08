<?php
$nav = $this->site_settings_model->nav_menu();
$parent = [];
$child_arr = [];
if (!empty($nav)) {
    foreach ($nav as $key => $value) {
        if ($value['parent_id'] == '0') {
            $parent[$value['id']] = $nav[$key];
        } else {
            $child_arr[] = $nav[$key];
        }
    }
    foreach ($child_arr as $key => $value) {
        if ($value['parent_id'] != '0') {
            $parent[$value['parent_id']]['child'][] = $child_arr[$key];
        }
    }
}
//echo "<pre>";
//print_r($parent);
?>

<nav class="navbar main-menu">
    <div class="container">
        <div class="navbar-header">
            <div class="top-social-icons pull-left">images
                <a href="index.html"> <img class="img-responsive" src="<?= base_url();?>assets/images/logo.png" alt="Textual"></a>
            </div>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar"
                    aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div id="myNavbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav pull-right">
                <?php
                if (!empty($parent)) {
                    $method = $this->uri->segment(1);
                    if ($method == '') {
                        $method = 'home';
                    }
                    foreach ($parent as $key => $value) {
                        ?>
                        <li class="dropdown  <?= (($method == 'home') && ($value['name'] == 'home')) ? 'active' : ($value['url'] == $method) ? 'active' : '' ?>">
                            <a href="<?= base_url(); ?><?= isset($value['url']) ? $value['url'] : ''; ?>" class="dropdown-toggle" role="button" aria-haspopup="true" aria-expanded="false"><?= isset($value['name']) ? $value['name'] : '' ?></a>
                            <?php
                            if (isset($value['child'])) {
                                ?>
                                <ul class="dropdown-menu">
                                    <?php
                                    foreach ($value['child'] as $index => $child) {
                                        ?>  
                                        <li><a href="<?= base_url() ?><?= isset($child['url']) ? $child['url'] : ''; ?>"><?= isset($child['name']) ? $child['name'] : '' ?> </a></li>
                                    <?php }
                                    ?>
                                </ul>
                                <?php
                            }
                        }
                    }
                    ?>
            </ul>

            <div class="show-search">
                <form  method="get" id="search-form" action="#">
                    <input type="text" placeholder="Search and hit enter..." name="s">
                </form>
            </div>
        </div>
    </div>
</nav>