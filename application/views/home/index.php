<?php $this->load->view('includes/header'); ?>
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
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- start post -->
                    <article class="post">
                        <div class="post-thumb">
                            <a href="single-post.html"><img src="<?php echo base_url(); ?>assets/images/blog-1.jpg" alt=""></a>
                            <a href="" class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center"><i class="fa fa-search"></i></div>
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="post-header">
                                <h2><a href="">Winter Tour at Kasmir, Pakistan </a> <span
                                        class="pull-right">Sep 16</span></h2>
                            </div>
                            <div class="entry-content">
                                <p>Porem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumeirmod tempor
                                    invidunt ut labore et dolore magna aliquyam erat, sed diam volu vero eos et accusam et
                                    justo duo dolores et ea rebum. Stet clita kasd gubergreno takimata sanctus est Lorem
                                    ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                    nonumy eirmod tempor invidunt ut labore et domagna aliquyam erat, sed diam voluptua. At
                                    vero eos et accusam et justo duo ea rebum. Stet clita kasd gubergren, no sea takimata
                                    sanctus.</p>
                                <div class="continue-reading text-uppercase">
                                    <a href="single-post.html" class="more-link text-center">Continue reading</a>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- end post -->
                    <!-- start post -->
                    <article class="post">
                        <div class="post-thumb">
                            <a href="single-post.html"><img src="<?php echo base_url(); ?>assets/images/blog-2.jpg" alt=""></a>

                            <a href="single-post.html" class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center"><i class="fa fa-search"></i></div>
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="post-header">
                                <h2><a href="">Sea Beach Waves Surfing with Martin </a> <span
                                        class="pull-right">Sep 16</span></h2>
                            </div>
                            <div class="entry-content">
                                <p>Porem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumeirmod tempor
                                    invidunt ut labore et dolore magna aliquyam erat, sed diam volu vero eos et accusam et
                                    justo duo dolores et ea rebum. Stet clita kasd gubergreno takimata sanctus est Lorem
                                    ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                    nonumy eirmod tempor invidunt ut labore et domagna aliquyam erat, sed diam voluptua. At
                                    vero eos et accusam et justo duo ea rebum. Stet clita kasd gubergren, no sea takimata
                                    sanctus.</p>
                                <div class="continue-reading text-uppercase">
                                    <a href="single-post.html" class="more-link text-center">Continue reading</a>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- end post -->
                    <!-- start post -->
                    <article class="post">
                        <div class="post-thumb">
                            <a href="single-post.html"><img src="<?php echo base_url(); ?>assets/images/blog-3.jpg" alt=""></a>

                            <a href="single-post.html" class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center"><i class="fa fa-search"></i></div>
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="post-header">
                                <h2><a href="">Amazing Journey to South Africa </a> <span
                                        class="pull-right">Sep 16</span></h2>
                            </div>
                            <div class="entry-content">
                                <p>Porem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumeirmod tempor
                                    invidunt ut labore et dolore magna aliquyam erat, sed diam volu vero eos et accusam et
                                    justo duo dolores et ea rebum. Stet clita kasd gubergreno takimata sanctus est Lorem
                                    ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                    nonumy eirmod tempor invidunt ut labore et domagna aliquyam erat, sed diam voluptua. At
                                    vero eos et accusam et justo duo ea rebum. Stet clita kasd gubergren, no sea takimata
                                    sanctus.</p>
                                <div class="continue-reading text-uppercase">
                                    <a href="single-post.html" class="more-link text-center">Continue reading</a>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- end post -->
                    <!-- start post -->
                    <article class="post">
                        <div class="post-thumb">
                            <a href="single-post.html"><img src="<?php echo base_url(); ?>assets/images/blog-4.jpg" alt=""></a>

                            <a href="single-post.html" class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center"><i class="fa fa-search"></i></div>
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="post-header">
                                <h2><a href="">The Largest Sea beach in the World</a> <span
                                        class="pull-right">Sep 16</span></h2>
                            </div>
                            <div class="entry-content">
                                <p>Porem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumeirmod tempor
                                    invidunt ut labore et dolore magna aliquyam erat, sed diam volu vero eos et accusam et
                                    justo duo dolores et ea rebum. Stet clita kasd gubergreno takimata sanctus est Lorem
                                    ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                    nonumy eirmod tempor invidunt ut labore et domagna aliquyam erat, sed diam voluptua. At
                                    vero eos et accusam et justo duo ea rebum. Stet clita kasd gubergren, no sea takimata
                                    sanctus.</p>
                                <div class="continue-reading text-uppercase">
                                    <a href="single-post.html" class="more-link text-center">Continue reading</a>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- end post -->
                    <!-- start post -->
                    <article class="post">
                        <div class="post-thumb">
                            <a href="single-post.html"><img src="<?php echo base_url(); ?>assets/images/blog-5.jpg" alt=""></a>

                            <a href="single-post.html" class="post-thumb-overlay text-center">
                                <div class="text-uppercase text-center"><i class="fa fa-search"></i></div>
                            </a>
                        </div>
                        <div class="post-content">
                            <div class="post-header">
                                <h2><a href="">A Risky Place with Zero Risk</a> <span
                                        class="pull-right">Sep 16</span></h2>
                            </div>
                            <div class="entry-content">
                                <p>Porem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumeirmod tempor
                                    invidunt ut labore et dolore magna aliquyam erat, sed diam volu vero eos et accusam et
                                    justo duo dolores et ea rebum. Stet clita kasd gubergreno takimata sanctus est Lorem
                                    ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                    nonumy eirmod tempor invidunt ut labore et domagna aliquyam erat, sed diam voluptua. At
                                    vero eos et accusam et justo duo ea rebum. Stet clita kasd gubergren, no sea takimata
                                    sanctus.</p>
                                <div class="continue-reading text-uppercase">
                                    <a href="single-post.html" class="more-link text-center">Continue reading</a>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- end post -->
                    <!--pagination-->
                    <div class="post-pagination text-center">
                        <ul class="pagination">
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">Next</a></li>
                        </ul>
                    </div>

                </div>
                <div class="col-md-4">
                    <!-- start sidebar -->
                    <div class="sidebar">
                        <aside class="widget about-me-widget"><!-- start single widget -->

                            <a class="twitter-timeline" data-chrome="nofooter noborders transparent noscrollbar" data-width="360" data-height="300" data-link-color="#2B7BB9" href="https://twitter.com/poriseba?ref_src=twsrc%5Etfw">Tweets by poriseba</a> 
                            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

                        </aside><!-- end single widget -->
                        <aside class="widget"><!-- start single widget -->
                            <div class="social-share">
                                <h3 class="widget-title text-uppercase">Subscribe & Follow</h3>
                                <ul class="">
                                    <li><a class="s-facebook" href=""><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="s-twitter" href=""><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="s-google-plus" href=""><i class="fa fa-google-plus"></i></a></li>
                                    <li><a class="s-linkedin" href=""><i class="fa fa-linkedin"></i></a></li>
                                    <li><a class="s-instagram" href=""><i class="fa fa-instagram"></i></a></li>
                                    <li><a class="s-behance" href=""><i class="fa fa-behance"></i></a></li>
                                    <li><a class="s-tumblr" href=""><i class="fa fa-tumblr"></i></a></li>
                                </ul>
                            </div>
                        </aside><!-- end single widget -->
                        <aside class="widget news-letter"><!-- start single widget -->
                            <h3 class="widget-title text-uppercase">Stay updated</h3>
                            <p>Subscribe to anewsletter and stay updated with our special offers and the latest free themes
                                released.</p>
                            <form action="#">
                                <input type="email" placeholder="Your e-mail">
                                <input type="submit" value="Subscribe Now"
                                       class="text-uppercase text-center btn btn-subscribe">
                            </form>
                        </aside><!-- end single widget -->
                        <aside class="widget p-post-widget">
                            <h3 class="widget-title text-uppercase">Latest Posts</h3>

                            <div class="popular-post">
                                <a href="#" class="popular-img"><img src="<?php echo base_url(); ?>assets/images/blog-2.jpg" alt="">
                                    <div class="p-overlay"></div>
                                </a>
                                <div class="p-content">
                                    <a href="#">Amazing Journey to South Africa</a>
                                    <span class="p-date">February 15, 2016</span>
                                </div>
                            </div>
                            <div class="popular-post">
                                <a href="#" class="popular-img"><img src="<?php echo base_url(); ?>assets/images/blog-3.jpg" alt="">
                                    <div class="p-overlay"></div>
                                </a>
                                <div class="p-content">
                                    <a href="#">A Risky Place with Zero Risk</a>
                                    <span class="p-date">February 15, 2016</span>
                                </div>
                            </div>
                            <div class="popular-post">
                                <a href="#" class="popular-img"><img src="<?php echo base_url(); ?>assets/images/blog-4.jpg" alt="">
                                    <div class="p-overlay"></div>
                                </a>
                                <div class="p-content">
                                    <a href="#">Home is peaceful Place</a>
                                    <span class="p-date">February 15, 2016</span>
                                </div>
                            </div>
                        </aside>
                        <aside class="widget"><!-- start single widget -->
                            <h3 class="widget-title text-uppercase">Popular Posts</h3>
                            <div class="thumb-latest-posts">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#" class="popular-img"><img src="<?php echo base_url(); ?>assets/images/pl-post-1.jpg" alt="">
                                            <div class="p-overlay"></div>
                                        </a>
                                    </div>
                                    <div class="p-content">
                                        <h3><a href="#">An Edge of Ocean</a></h3>
                                        <span class="p-date">February 15, 2017</span>
                                    </div>
                                </div>
                            </div>
                            <div class="thumb-latest-posts">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#" class="popular-img"><img src="<?php echo base_url(); ?>assets/images/pl-post-2.jpg" alt="">
                                            <div class="p-overlay"></div>
                                        </a>
                                    </div>
                                    <div class="p-content">
                                        <h3><a href="#">Beauty Never Ends</a></h3>
                                        <span class="p-date">February 15, 2017</span>
                                    </div>
                                </div>
                            </div>
                            <div class="thumb-latest-posts">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#" class="popular-img"><img src="<?php echo base_url(); ?>assets/images/pl-post-3.jpg" alt="">
                                            <div class="p-overlay"></div>
                                        </a>
                                    </div>
                                    <div class="p-content">
                                        <h3><a href="#">AWSM Standard Post</a></h3>
                                        <span class="p-date">February 15, 2017</span>
                                    </div>
                                </div>
                            </div>
                            <div class="thumb-latest-posts">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#" class="popular-img"><img src="<?php echo base_url(); ?>assets/images/pl-post-4.jpg" alt="">
                                            <div class="p-overlay"></div>
                                        </a>
                                    </div>
                                    <div class="p-content">
                                        <h3><a href="#">Beside of Silent Place</a></h3>
                                        <span class="p-date">February 15, 2017</span>
                                    </div>
                                </div>
                            </div>
                        </aside><!-- end single widget -->
                        <aside class="widget category-post-no"><!-- start single widget -->
                            <h3 class="widget-title text-uppercase">Categories</h3>
                            <ul>
                                <li>
                                    <a href="">Food &amp; Drinks</a>
                                    <span class="post-count pull-right"> 2</span>
                                </li>
                                <li>
                                    <a href="">Travel</a>
                                    <span class="post-count pull-right"> 4</span>
                                </li>
                                <li>
                                    <a href="">Business</a>
                                    <span class="post-count pull-right"> 2</span>
                                </li>
                                <li>
                                    <a href="">Story</a>
                                    <span class="post-count pull-right"> 6</span>
                                </li>
                                <li>
                                    <a href="">DIY &amp; Tips</a>
                                    <span class="post-count pull-right"> 8</span>
                                </li>
                                <li>
                                    <a href="">Lifestyle</a>
                                    <span class="post-count pull-right"> 7</span>
                                </li>
                            </ul>
                        </aside><!-- end single widget -->
                        <aside class="widget widget-texty"><!-- start single widget -->
                            <h3 class="widget-title text-uppercase">Texty@Instagram</h3>
                            <ul>
                                <li><a href=""><img src="<?php echo base_url(); ?>assets/images/instra-1.jpg" alt="">
                                    </a></li>
                                <li><a href=""><img src="<?php echo base_url(); ?>assets/images/instra-2.jpg" alt=""></a></li>
                                <li><a href=""><img src="<?php echo base_url(); ?>assets/images/instra-3.jpg" alt=""></a></li>
                                <li><a href=""><img src="<?php echo base_url(); ?>assets/images/instra-4.jpg" alt=""></a></li>

                            </ul>
                        </aside><!-- end single widget -->
                        <aside class="widget widget-search">
                            <h3 class="widget-title text-uppercase">Search Widget</h3>
                            <form method="get" id="searchform" action="#">
                                <input type="text" placeholder="Search here..." name="s" id="s">
                                <button type="submit" class="submit-btn">Search</button>
                            </form>
                        </aside>
                    </div>
                    <!-- end sidebar -->
                </div>
            </div>
        </div>
    </div>
    <!-- end main content -->
    <!-- start footer area -->
    <?php $this->load->view('includes/footer'); ?>