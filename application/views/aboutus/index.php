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
                    <?php $this->load->view('includes/rightslider'); ?>
                    <!-- end sidebar -->
                </div>
            </div>
        </div>
    </div>
    <!-- end main content -->
    <!-- start footer area -->
    <?php $this->load->view('includes/footer'); ?>