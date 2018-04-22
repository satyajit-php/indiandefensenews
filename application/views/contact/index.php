<?php $this->load->view('includes/header'); ?>
<body class="home-2 home-5">
    <!-- pre-loader -->
    <div id="st-preloader">
        <div class="st-preloader-circle"></div>
    </div>
    <!-- start main menu -->
    <?php $this->load->view('includes/navbar');?>
    <!-- start main content -->
    <!-- start main content -->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- start post -->
                    <article class="post single-post about-me contact">
                        <div class="post-thumb">
                            <img src="<?php echo base_url(); ?>admin/uploaded_image/normal/<?= isset($htmlcontent[0]->image) ? $htmlcontent[0]->image : ''; ?>" alt="indiandefensenews">

                        </div>
                        <div class="post-content">
                            <div class="post-header">
                                <h2>Get In Touch</h2>
                            </div>
                            <div class="entry-content">
                                <p><?= isset($htmlcontent[0]->text) ? $htmlcontent[0]->text : ''; ?>
                                </p>
                                <div class="contact-form">
                                    <h3>Send your article </h3>
                                    <?php
                                    $attributes = array('class' => 'form-horizontal', 'id' => 'contactForm', 'data-toggle' => 'validator');
                                    echo form_open('contact/index', $attributes);
                                    ?>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="autocompletes" placeholder="Type your location">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="name" name="writeus[name]" placeholder="Full Name" required data-error="Please enter your name">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="email" name="writeus[email]" placeholder="you@yoursite.com" required data-error="Please enter your email">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="subject" name="writeus[subject]" placeholder="Subject" required data-error="Please enter your subject">
                                            <div class="help-block with-errors"></div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <textarea class="form-control" rows="5" name="writeus[message]" placeholder="Write Your story" data-error="Write your message" required></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <input type="hidden"  id="location" name="writeus[location]">
                                    <button type="submit" id="submit" class="btn send-btn">Send your Message</button>
                                    <?php
                                    echo form_fieldset_close();
                                    ?>
                                </div>
                                <?= isset($htmlcontent[0]->contact) ? $htmlcontent[0]->contact : ''; ?>

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