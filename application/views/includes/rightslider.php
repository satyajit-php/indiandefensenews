<div class="sidebar">
    <aside class="widget about-me-widget"><!-- start single widget -->

        <a class="twitter-timeline" data-chrome="nofooter noborders transparent noscrollbar" data-width="360" data-height="300" data-link-color="#2B7BB9" href="https://twitter.com/indiandefensene?ref_src=twsrc%5Etfw">Tweets by indiandefensenews</a> 
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

    </aside><!-- end single widget -->
    <aside class="widget"><!-- start single widget -->
        <div class="social-share">

            <div class="sharethis-inline-follow-buttons"></div>
        </div>
    </aside><!-- end single widget -->
    <aside class="widget news-letter"><!-- start single widget -->
        <h3 class="widget-title text-uppercase">Stay updated</h3>
        <p>Subscribe to anewsletter and stay updated with our special offers and the latest free themes
            released.</p>
        <?php
        $recent = $this->site_settings_model->get_blog_value_latest();
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
        <?php
        if (!empty($recent)) {
            foreach ($recent as $key => $value) {
                $url = isset($value->blog_title) ? seoUrl($value->blog_title) : 'Indian defense news';
                ?>
                <div class="popular-post">
                    <a class="popular-img" href="<?= base_url('article'); ?><?= isset($value->id) ? '/' . $url . '/' . $value->id : '0'; ?>">
                        <?php
                        if ($value->media_type == 'I') {
							$imagecache = new ImageCache();
							   $imagecache->cached_image_directory = '/var/www/html/admin/uploaded_image/cached';
							   $image_type = exif_imagetype("/var/www/html/admin/uploaded_image/normal/".$value->images);
								if (!$image_type)
									{
										$cached_src = base_url().'admin/uploaded_image/normal/'.$value->images;
									}else
									{
										$cached_src = $imagecache->cache( "/var/www/html/admin/uploaded_image/normal/".$value->images);
									}
                            ?>
                            <img src="<?= ($cached_src!=false) ? $cached_src :  ''; ?>" alt="<?= isset($value->meta_title) ? $value->meta_title : ''; ?>">
                        <?php } else {
                            ?>
                            <div class="embed-responsive embed-responsive-16by9">
                                <?= isset($value->youtube_url) ? $value->youtube_url : ''; ?>
                            </div>
                        <?php }
                        ?>
                        <div class="p-overlay"></div>
                    </a>
                    <div class="p-content">
                        <a href="<?= base_url('article'); ?><?= isset($value->id) ? '/' . $url . '/' . $value->id : '0'; ?>"><?= isset($value->blog_title) ? $value->blog_title : 'Indian defense news' ?></a>
                        <span class="p-date"><?= isset($value->added_on) ? date("M d,Y", strtotime($value->added_on)) : '' ?></span>
                    </div>
                </div>
                <?php
            }
        }
        ?>

    </aside>

    <aside class="widget widget-search">
        <h3 class="widget-title text-uppercase">Search Widget</h3>
        <form method="get" id="searchform" action="#">
            <input type="text" placeholder="Search here..." name="s" id="s">
            <button type="submit" class="submit-btn">Search</button>
        </form>
    </aside>
    <aside class="widget category-post-no"><!-- start single widget -->
        <h3 class="widget-title text-uppercase">Categories</h3>
        <?php
        $category = $this->site_settings_model->getcategoryDetails();
        ?>
        <ul>
            <?php
            if (!empty($category)) {
                foreach ($category as $key => $value) {
                    ?>
                    <li>
                        <a href="javascript:void(0);"><?= isset($value->name) ? strtoupper($value->name) : ''; ?></a>
                        <span class="post-count pull-right"> <?= isset($value->total) ? $value->total : '0'; ?></span>
                    </li>
                    <?php
                }
            }
            ?>

        </ul>
    </aside><!-- end single widget -->
    <aside class="widget p-post-widget">
        <h3 class="widget-title text-uppercase">Latest News</h3>
        <div class="containers">
            <div class="texts">
                <?php
                $content = $this->site_settings_model->get_latestnews();
                if (!empty($content)) {
                    foreach ($content as $key => $value) {
                        ?>
                        <div class="popular-post">

                            <a class="popular-img" href="<?= isset($value['url']) ? $value['url'] : ''; ?>">
                                <img src="<?= isset($value['urlToImage']) ? $value['urlToImage'] : ''; ?>" alt="<?= isset($value['title']) ? $value['title'] : ''; ?>">
                                <div class="p-overlay"></div>
                            </a>
                            <div class="p-content">
                                <a href="<?= isset($value['url']) ? $value['url'] : ''; ?>"> <?= isset($value['title']) ? $value['title'] : ''; ?></a>
                                <span class="p-date"><?= isset($value['publishedAt']) ? $value['publishedAt'] : ''; ?></span>
                                <span class="p-date"><?= isset($value['source']) ? $value['source'] : ''; ?></span>
                            </div>

                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

    </aside><!-- end single widget -->

</div>