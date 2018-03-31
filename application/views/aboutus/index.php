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
    <!-- start main content -->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- start post -->
                    <article class="post single-post about-me">
                        <div class="post-thumb">
                            <img class="img-responsive" src="<?= base_url() . 'admin/uploaded_image/normal/' ?><?= isset($aboutus['image']) ? $aboutus['image'] : ''; ?>" alt="<?= isset($aboutus['title']) ? ucfirst($aboutus['title']) : ''; ?>">

                        </div>
                        <div class="post-content">
                            <div class="post-header">
                                <h2><?= isset($aboutus['title']) ? ucfirst($aboutus['title']) : ''; ?> </h2>
                            </div>
                            <div class="entry-content">
                                <?= isset($aboutus['text']) ? ucfirst($aboutus['text']) : ''; ?>
                            </div>
                        </div>
                    </article>
                    <!-- end post -->
                </div>
                <div class="col-md-4">
                    <!-- start sidebar -->
                    <div class="sidebar">
                        <aside class="widget about-me-widget"><!-- start single widget -->

                            <div class="about-me-img">
                                <img src="assets/images/aboout-me.jpg" alt="" class="img-me">
                            </div>
                            <div class="about-me-content">
                                <h3>Md. Khalil Uddin <span>UX Engineer</span></h3>

                                <p>Meh synth Schlitz, tempor duis gin coffee ea next level ethnic fingerstache fanpack
                                    nostrud. Photo booth anim 8-bit hellpber 3 wolf moon beard Helvetica. </p>
                            </div>

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
                                <a href="#" class="popular-img"><img src="assets/images/blog-2.jpg" alt="">
                                    <div class="p-overlay"></div>
                                </a>
                                <div class="p-content">
                                    <a href="#">Amazing Journey to South Africa</a>
                                    <span class="p-date">February 15, 2016</span>
                                </div>
                            </div>
                            <div class="popular-post">
                                <a href="#" class="popular-img"><img src="assets/images/blog-3.jpg" alt="">
                                    <div class="p-overlay"></div>
                                </a>
                                <div class="p-content">
                                    <a href="#">A Risky Place with Zero Risk</a>
                                    <span class="p-date">February 15, 2016</span>
                                </div>
                            </div>
                            <div class="popular-post">
                                <a href="#" class="popular-img"><img src="assets/images/blog-4.jpg" alt="">
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
                                        <a href="#" class="popular-img"><img src="assets/images/pl-post-1.jpg" alt="">
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
                                        <a href="#" class="popular-img"><img src="assets/images/pl-post-2.jpg" alt="">
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
                                        <a href="#" class="popular-img"><img src="assets/images/pl-post-3.jpg" alt="">
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
                                        <a href="#" class="popular-img"><img src="assets/images/pl-post-4.jpg" alt="">
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
                                <li><a href=""><img src="assets/images/instra-1.jpg" alt="">
                                    </a></li>
                                <li><a href=""><img src="assets/images/instra-2.jpg" alt=""></a></li>
                                <li><a href=""><img src="assets/images/instra-3.jpg" alt=""></a></li>
                                <li><a href=""><img src="assets/images/instra-4.jpg" alt=""></a></li>

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