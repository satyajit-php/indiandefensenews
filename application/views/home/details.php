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
                    <article class="post single-post">
                        <div class="post-thumb">
                            <?php
                            if (!empty($details)) {
								if ($details[0]->media_type == 'I') {
									$imagecache = new ImageCache();
									$imagecache->cached_image_directory = '/var/www/html/admin/uploaded_image/cached';
									$image_type = exif_imagetype("/var/www/html/admin/uploaded_image/normal/".$details[0]->images);
								if (!$image_type)
									{
										$cached_src = base_url().'admin/uploaded_image/normal/'.$details[0]->images;
									}else
									{
										$cached_src = $imagecache->cache( "/var/www/html/admin/uploaded_image/normal/".$details[0]->images);
									}
                                    ?>
                                    <img src="<?= isset($cached_src) ? $cached_src : ''; ?>" alt="<?= isset($details[0]->meta_title) ? $details[0]->meta_title : ''; ?>">
                                <?php } else {
                                    ?>
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <?= isset($details[0]->youtube_url) ? $details[0]->youtube_url : ''; ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>

                        </div>
                        <div class="post-content">
                            <div class="post-header">
                                <h2><?= isset($details[0]->blog_title) ? $details[0]->blog_title : '' ?>  </h2>
                                <span class="pull-right"><strong><?= isset($details[0]->added_on) ? date("M d,Y", strtotime($details[0]->added_on)) : '' ?>
                                        SOURCE:  <?= isset($details[0]->short_name) ? $details[0]->short_name : '' ?>
                                    </strong></span>
                            </div>
                            <br>
                            <div class="entry-content">
                                <p>
                                    <?= isset($details[0]->details) ? $details[0]->details : ''; ?>
                                </p>
                            </div>
                            <div class="post-tag">
                                <a href="javascript:void(0)"><?= isset($details[0]->name) ? $details[0]->name : ''; ?></a>
                            </div>
                            <div class="single-post-meta">
                                <ul class="meta-profile pull-left">
                                    <li><a href=""><i class="fa fa-user"></i><?= isset($details[0]->added_by) ? "BY:" . $details[0]->added_by : '' ?></a></li>
                                    <li><a href=""><i class="fa fa-folder-open"></i><?= isset($details[0]->name) ? $details[0]->name : ''; ?></a></li>
                                </ul>
                                <!--                                <ul class="meta-social pull-right">
                                                                    <li class="s-facebook"><a href=""><i class="fa fa-facebook"></i></a></li>
                                                                    <li class="s-twitter"><a href=""><i class="fa fa-twitter"></i></a></li>
                                                                    <li class="s-google-plus"><a href=""><i class="fa fa-google-plus"></i></a></li>
                                                                    <li class="s-heart"><a href=""><i class="fa fa-heart"></i></a></li>
                                                                </ul>-->
                            </div>
                            <div class="single-post-me">
                                <div class="media">
                                    <div class="media-left text-center">
                                        <a href=""> <img class="media-object img-circle"
                                                         src="assets/images/single-blog-me.jpg" alt=""></a>
                                    </div>
                                    <div class="media-body">
<!--                                        <h4 class="media-heading"><a href="#">Khalil Uddin</a>
                                        </h4>
                                        <p class="comment-p">
                                            Nam liber tempor cum soluta nobis eleifend option congue nihil imoming id quod
                                            mazim placerat facer possim assum. Lorem ipsum dolor sit ctetuer adipiing elit,
                                            sed diam nonummy nibh.
                                        </p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- end post -->
                    <div class="comment-area">
                        <div class="comment-heading">
                            <h3><script id="dsq-count-scr" src="//http-indiandefensenews-org.disqus.com/count.js" async></script></h3>
                        </div>
                        <div class="single-comment">
                            <div class="media">
                                <div id="disqus_thread"></div>
                                <script>

                                    /**
                                     *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
                                     *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
                                    /*
                                     var disqus_config = function () {
                                     this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
                                     this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                                     };
                                     */
                                    (function () { // DON'T EDIT BELOW THIS LINE
                                        var d = document, s = d.createElement('script');
                                        s.src = 'https://http-indiandefensenews-org.disqus.com/embed.js';
                                        s.setAttribute('data-timestamp', +new Date());
                                        (d.head || d.body).appendChild(s);
                                    })();
                                </script>
                                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

                            </div>
                        </div>

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