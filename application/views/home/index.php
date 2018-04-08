<?php
$this->load->view('includes/header');
?>
<body class="home-2 home-5">
    <!-- pre-loader -->
    <div id="st-preloader">
        <div class="st-preloader-circle"></div>
    </div>
    <!-- start main menu -->
    <?php
    $this->load->view('includes/navbar');
    ?>
    <!-- end main menu -->
    <div class="home">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="carousel-example-generic" class="carousel slide carousel-fadecarousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php
                            if (!empty($slider)) {
                                foreach ($slider as $key => $value) {
                                    $class = "";
                                    if ($key == 0) {
                                        $class = "active";
                                    }
                                    ?>
                                    <li data-target="#carousel-example-generic" data-slide-to="<?= isset($key) ? $key : '0' ?>" class="<?= ($class != '') ? $class : '' ?>"></li>
                                    <?php
                                }
                            }
                            ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php
                            if (!empty($slider)) {
                                foreach ($slider as $key => $value) {
                                    $class = "";
                                    if ($key == 0) {
                                        $class = "active";
                                    }
                                    ?>
                                    <div class="item <?= ($class != '') ? $class : '' ?>">
                                        <img class="img-responsive" src="<?php echo base_url() . 'admin/uploaded_image/slider_normal/' ?><?= isset($value->images) ? $value->images : '' ?>" alt="<?= isset($value->tagline) ? $value->tagline : 'indiandefencenews'; ?>" style="width:1200px; height:800px;  ">
                                        <div class="carousel-caption">
                                            <?= isset($value->tagline) ? $value->tagline : 'Indian defence news'; ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                        </div>
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span></a>
                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right">
                            </span>
                        </a>
                    </div>
                    <div class="main-text hidden-xs">
                        <div class="col-md-12 text-center">
                            <div class="logo text-center">
                                <h1></h1>
                                <p>A Content base Handcrafted Bootstrap Theme</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Left and right controls -->
        <a class="left carousel-control" href="#home-carousel" role="button" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="right carousel-control" href="#home-carousel" role="button" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
    <!-- start main content -->
    <?php
//    echo "<pre>";
//    print_r($blog_data);
    ?>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- start post -->
                    <?php

                    function seoUrl($string) {
                        //Lower case everything
                        $string = strtolower($string);
                        //Make alphanumeric (removes all other characters)
                        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
                        //Clean up multiple dashes or whitespaces
                        $string = preg_replace("/[\s-]+/", " ", $string);
                        //Convert whitespaces and underscore to dash
                        $string = preg_replace("/[\s_]/", "-", $string);
                        return $string;
                    }

                    if (!empty($blog_data)) {
                        foreach ($blog_data as $key => $value) {
                            ?>

                            <article class="post">
                                <div class="post-thumb">
                                    <a href="<?= base_url(); ?><?= isset($value->id) ? $value->id : '0' ?>/<?= isset($value->blog_title) ? $value->blog_title : 'Indian defense news' ?>">
                                        <?php
                                        if ($value->media_type == 'I') {
                                            ?>
                                            <img src="<?php echo base_url(); ?>admin/uploaded_image/normal/<?= isset($value->images) ? $value->images : ''; ?>" alt="<?= isset($value->meta_title) ? $value->meta_title : ''; ?>">
                                        <?php } else {
                                            ?>
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <?= isset($value->youtube_url) ? $value->youtube_url : ''; ?>
                                            </div>
                                        <?php }
                                        ?>

                                    </a>
                                    <a href="" class="post-thumb-overlay text-center">
                                        <div class="text-uppercase text-center"><i class="fa fa-search"></i></div>
                                    </a>
                                </div>
                                <div class="post-content">
                                    <div class="post-header">
                                        <h2><a href=""><?= isset($value->blog_title) ? $value->blog_title : 'Indian defense news' ?></a> 
                                            <span class="pull-right"><?= isset($value->added_on) ? date("M d,Y", strtotime($value->added_on)) : '' ?></span></h2>
                                    </div>
                                    <div class="entry-content">
                                        <?php
                                        $url = isset($value->blog_title) ? seoUrl($value->blog_title) : 'Indian defense news';
                                        $string = isset($value->details) ? $value->details : 'No Details is available';
                                        // strip tags to avoid breaking any html
                                        $string = strip_tags($string);
                                        if (strlen($string) > 500) {

                                            // truncate string
                                            $stringCut = substr($string, 0, 500);
                                            $endPoint = strrpos($stringCut, ' ');

                                            //if the string doesn't contain any space then it will cut without word basis.
                                            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                        }
                                        ?>
                                        <p><?= isset($string) ? $string : ''; ?></p>
                                        <div class="continue-reading text-uppercase">
                                            <a href="<?= base_url('article'); ?><?= '/' . $url . '/' . $value->id ?>" class="more-link text-center">Continue reading</a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <?php
                        }
                    }
                    ?>

                    <!-- end post -->
                    <!--pagination-->
                    <div class="post-pagination text-center">
                        <?= isset($pagi) ? $pagi : ''; ?>
                    </div>

                </div>
                <div class="col-md-4">
                    <!-- start sidebar -->
                    <?php $this->load->view('includes/rightslider'); ?>  
                    <!-- end sidebar -->
                </div>
            </div>
        </div>
    </div>
    <!-- end main content -->
    <!-- start footer area -->
    <?php $this->load->view('includes/footer'); ?>