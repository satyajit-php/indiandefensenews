<!-- start footer area -->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <aside class="footer-widget">
                    <h3 class="footer-title text-uppercase">About Textual</h3>
                    <div class="about-content">Textual is an awesome WordPress Theme , consetetur sadipscing elitr, sed
                        diam no eirminvidulabore et dolore magna aliquyam erat, sed diam volAt vero eos sit amet,
                        conseteturet.
                    </div>
                    <div class="address">
                        <h4 class="text-uppercase">contact Info</h4>
                        <p><i class="fa fa-home"></i> 239/2 NK Street, DC, USA</p>
                        <p><i class="fa fa-phone"></i> Phone: +123 456 78900</p>
                        <p><i class="fa fa-envelope"></i>theme@textual.com</p>
                    </div>
                </aside>
            </div>
            <div class="col-md-4">
                <aside class="footer-tag">
                    <h3 class="footer-title text-uppercase">Tag Clouds</h3>
                    <a href="">Lifestyle</a>
                    <a href="">Travel</a>
                    <a href="">Journey</a>
                    <a href="">Technology</a>
                    <a href="">Latest</a>
                    <a href="">Lifestyle</a>
                    <a href="">Work</a>
                    <a href="">Mobile</a>
                    <a href="">Programing</a>
                    <a href="">Computer</a>
                    <a href="">Cafe house</a>
                    <a href="">Office</a>
                    <a href="">World</a>
                    <a href="">International</a>
                    <a href="">Others</a>
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
                        <p>&copy; 2016 <a href="#">Textual</a>, Designed by <a href="#">ShapedTheme </a> in Dhaka</p>
                    </div>
                    <div class="pull-right social-share footer-social-icon">
                        <span>Follow Us: </span>
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
                </div>
            </div>
        </div>
    </div>
    <div class="info message" id="notify_autopop">
        <h3>FYI, I only show up when the page loads!</h3>
        <p>This is just info notification message.</p>
    </div>

    <div class="info message" id="notify_info">
        <h3>FYI, something just happened!</h3>
        <p>This is just an info notification message.</p>
    </div>

    <div class="error message" id="notify_error">
        <h3>Oops, an error ocurred</h3>
        <p>This is just an error notification message.</p>

    </div>

    <div class="warning message" id="notify_warning">
        <h3>Wait, I must warn you!</h3>
        <p>This is just a warning notification message.</p>
    </div>

    <div class="success message" id="notify_success">
        <h3>Congrats, you did it!</h3>
        <p>This is just a success notification message.</p>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
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

    });
    $(document).ready(function () {

        $("a.info_trigger").click(function () {
            $("#notify_info").notify({
                placement: "bottom"
            });
            return false;
        });

//        $("a.warning_trigger").click(function () {
//            $("#notify_warning").notify();
//            return false;
//        });
//        $("a.error_trigger").click(function () {
//            $("#notify_error").notify();
//            return false;
//        });
//        $("a.success_trigger").click(function () {
//            $("#notify_success").notify();
//            return false;
//        });
//
//        $("#notify_autopop").notify({
//            delay: 500
//        });
    });
    function showResponse(responseText, statusText, xhr, $form) {
        if (responseText == '0') {
            $("#notify_error").notify();
            return false;
        } else {
            $("#notify_success").notify();
        }
    }


</script>
</body>
</html>