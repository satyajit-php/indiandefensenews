<?php $this->load->view('includes/header'); ?>
<body class="home-2 home-5">
    <!-- pre-loader -->
    <div id="st-preloader">
        <div class="st-preloader-circle"></div>
    </div>
    <!-- start main menu -->
    <?php $this->load->view('includes/navbar'); ?>
    <!-- start main content -->
    <!-- start main content -->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- start post -->
                    <article class="post single-post about-me contact">
                        <div class="post-thumb">
                            <img src="<?php echo base_url(); ?>assets/images/contact-img.jpg" alt="">

                        </div>
                        <div class="post-content">
                            <div class="post-header">
                                <h2>Get In Touch</h2>
                            </div>
                            <div class="entry-content">
                                <p>I’m Available Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam
                                    nonumeirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam volu vero
                                    eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergreno takimata
                                    sanctus est Lorem ipsum dolor sit ame
                                </p>
                                <div class="contact-form">
                                    <h3>Send your Query</h3>
                                    <form class="form-horizontal" role="form" method="post" action="sendemail.php">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <textarea class="form-control" rows="5" name="message"
                                                          placeholder="Write your message"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" id="name" name="name"
                                                       placeholder="Name *">
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" id="email" name="email"
                                                       placeholder="E-mail *">
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" id="subject" name="subject"
                                                       placeholder="Subject">
                                            </div>

                                        </div>
                                        <button type="button" class="btn send-btn">Send your Message</button>
                                    </form>
                                </div>
                                <h3 class="ex-contact-info">Additional Contact Info</h3>
                                <h3>+1 (302) 444.019.1, +1 (302) 222.522.3 (MON–FRI 9AM–6PM)</h3>
                                <a href="mailto:hello@texty.com">hello@texty.com</a>
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
                                <img src="<?php echo base_url(); ?>assets/images/aboout-me.jpg" alt="" class="img-me">
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