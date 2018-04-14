<!-- start footer area -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <aside class="footer-widget">
                    <h3 class="footer-title text-uppercase">About Us</h3>
                    <div class="about-content">
                        <?php
                        $aboutus = $this->site_settings_model->footer_aboutus();
                        if (!empty($aboutus)) {
                            $string = $aboutus[0]['text'];
                            // strip tags to avoid breaking any html
                            $string = strip_tags($string);
                            if (strlen($string) > 500) {

                                // truncate string
                                $stringCut = substr($string, 0, 500);
                                $endPoint = strrpos($stringCut, ' ');

                                //if the string doesn't contain any space then it will cut without word basis.
                                $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                $string .= '... <a href="' . base_url('aboutus') . '">Read More</a>';
                            }
                            echo $string;
                        }
                        ?>
                    </div>
                    <div class="address">
                        <h4 class="text-uppercase">contact Info</h4>
                        <?php
                        $sitesettings_data = $this->site_settings_model->site_settings_data();
                        if (!empty($sitesettings_data)) {
                            ?>
                            <p><i class="fa fa-envelope"></i><?= isset($sitesettings_data[0]['notificationemail']) ? $sitesettings_data[0]['notificationemail'] : ''; ?></p>
                        <?php }
                        ?>
                    </div>
                </aside>
            </div>
            <div class="col-md-4">
                <aside class="footer-tag">
                    <h3 class="footer-title text-uppercase">Tag Clouds</h3>
                    <?php
                    $tag_data = $this->site_settings_model->site_settings_tag();
                    if (!empty($tag_data)) {
                        $notshow = array('HOME', 'WRITE TO US', 'ABOUT US');
                        foreach ($tag_data as $key => $value) {
                            if (!in_array(strtoupper($value['name']), $notshow)) {
                                ?>
                                <a href="<?= base_url() . $value['url']; ?>?>"><?= strtoupper($value['name']); ?></a>
                                <?php
                            }
                        }
                    }
                    ?>
                </aside>
            </div>
            <div class="col-md-4">
                <aside class="tweet-post">
                    <h3 class="footer-title text-uppercase">Latest Tweets</h3>
                    <div class="latest-tweet">
                        <p>Check our new theme 'Textual - Personal WordPress Blog Theme' on #themeforest #Envato

                        </p>
                        <a href="">http://t.co/I91Wh7cRh1</a>
                        <p class="tweet-date"><i class="fa fa-twitter"></i>Tweeted on 02:59 AM Sep 22</p>
                    </div>
                    <div class="latest-tweet">
                        <p>Check our new theme 'Textual - Personal WordPress Blog Theme' on #themeforest #Envato
                        </p>
                        <a href="">http://t.co/I91Wh7cRh1</a>
                        <p class="tweet-date"><i class="fa fa-twitter"></i>Tweeted on 02:59 AM Sep 22</p>
                    </div>
                </aside>
            </div>
            <div class="col-md-12">
                <div class="copyright-area">
                    <div class="copy-text pull-left">
                        <p>Copyright &copy; <?= date('Y'); ?> all rights reserved to <a href="<?= base_url(); ?>">indiandefencenews.org</a></p>
                    </div>
                    <div class="pull-right social-share footer-social-icon">
                        <span>Follow Us: </span>
                        <ul class="">
                            <li><a class="s-facebook" href="<?= isset($sitesettings_data[0]['facebook']) ? $sitesettings_data[0]['facebook'] : '' ?>"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="s-twitter" href="<?= isset($sitesettings_data[0]['twitter']) ? $sitesettings_data[0]['twitter'] : '' ?>"><i class="fa fa-twitter"></i></a></li>
                            <li><a class="s-google-plus" href="<?= isset($sitesettings_data[0]['google_plus']) ? $sitesettings_data[0]['google_plus'] : '' ?>"><i class="fa fa-google-plus"></i></a></li>
                            <li><a class="s-instagram" href="<?= isset($sitesettings_data[0]['instagram']) ? $sitesettings_data[0]['instagram'] : '' ?>"><i class="fa fa-instagram"></i></a></li>
                            <li><a class="s-youtube" href="<?= isset($sitesettings_data[0]['youtube']) ? $sitesettings_data[0]['youtube'] : '' ?>"><i class="fa fa-youtube"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="info message text-center text-uppercase" id="notify_info">

    </div>

    <div class="error message text-center text-uppercase" id="notify_error">

    </div>

    <div class="warning message text-center text-uppercase" id="notify_warning">

    </div>

    <div class="success message text-center text-uppercase" id="notify_success">


    </div>
</footer>
<!-- end footer area -->
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.scrollUp.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
<script src="<?php echo base_url(); ?>assets/js/notify.js"></script>
<!--<script src="<?php echo base_url(); ?>assets/js/contact-form-script.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.2/owl.carousel.min.js"></script>



<script type="text/javascript">
    if (self == top) {
        var theBody = document.getElementsByTagName('body')[0]
        theBody.style.display = "block"
    } else {
        top.location = self.location
    }
    $(document).ready(function () {
        var options = {
            target: '#output1', // target element(s) to be updated with server response 
            //beforeSubmit: showRequest, // pre-submit callback 
            success: showResponse  // post-submit callback 
        };
        $('#subscription').ajaxForm(options);
        $('#contactForm').ajaxForm(options);

        $("#owl-demo").owlCarousel({
            autoPlay: 3000, //Set AutoPlay to 3 seconds
            items: <?= isset($slider) ? count($slider) : 0; ?>,

        });
        setTimeout(function () {
            initialize();
        }, 100);

    });

    function showResponse(responseText, statusText, xhr, $form) {
        // alert(responseText);
        if (responseText == 2) {
            $("#notify_warning").html("You already subscribe to our newsletter.");
            $("#notify_warning").notify();
            setTimeout(function () {
                $('#notify_warning').fadeOut('slow');
            }, 2000);
            return false;
        } else if (responseText == 1) {
            $("#notify_success").html("Thank you for subscribe to our newsletter.");
            $("#notify_success").notify();
            setTimeout(function () {
                $('#notify_success').fadeOut('slow');
            }, 2000);
        } else if (responseText == 3) {
            $("#notify_success").html("Your post successfully submited.");
            $("#notify_success").notify();
            setTimeout(function () {
                $('#notify_success').fadeOut('slow');
                location.reload();
            }, 2000);
        } else if (responseText == 4) {
            $("#notify_success").html("Some thing went wrong try again.");
            $("#notify_success").notify();
            setTimeout(function () {
                $('#notify_error').fadeOut('slow');
            }, 2000);
        }
    }
    function initialize() {

        var ac = new google.maps.places.Autocomplete(
                (document.getElementById('autocompletes')), {
            types: ['geocode']
        });

        ac.addListener('place_changed', function () {

            var place = ac.getPlace();

            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }
            $("#location").val(place.geometry.location.lat() + ',' + place.geometry.location.lng());

        });
    }


</script>
<script src="http://maps.google.com/maps/api/js?v=3.30&key=AIzaSyCsUUI8b0nCjil4iSW6CJ4IjCdhSMp8iEM&libraries=places&region=in&language=en"></script>
</body>
</html>