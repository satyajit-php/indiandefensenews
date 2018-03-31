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
        <?php
        $attributes = array('class' => '', 'id' => 'subscription', 'data-toggle' => 'validator');
        echo form_open('home/subsciption', $attributes);
        ?>
        <input type="email"  name="subsciptionmail" placeholder="Your e-mail" required="required">
        <input type="submit" value="Subscribe Now" class="text-uppercase text-center btn btn-subscribe">
        <?php
        echo form_fieldset_close();
        ?>
        <input type="hidden" id="output1">
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