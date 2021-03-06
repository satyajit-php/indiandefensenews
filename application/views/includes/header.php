<!DOCTYPE html>
<?php
$google = $this->site_settings_model->google_seo();  // google plus seo
$twiter = $this->site_settings_model->twiter_seo();  // twiter seo
$controller = $this->uri->segment(1);
switch ($controller) {
    case category:
        $id = $this->uri->segment(2);
        $seo = $this->site_settings_model->get_blog_value($id);
        break;
    case writetous:
        $seo = $this->site_settings_model->seo($controller);
        break;
    case aboutus:
        $seo = $this->site_settings_model->seo($controller);
        break;
    case home:
        $seo = $this->site_settings_model->seo($controller);
        break;
    case article:
        $id = $this->uri->segment(3);
        $seo = $this->site_settings_model->get_blog_value($id);
        break;

    default:
        $seo = $this->site_settings_model->seo('home');
}

?>
<html>
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117998689-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-117998689-1');
        </script>
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
        <script>
            var OneSignal = window.OneSignal || [];
            OneSignal.push(function () {
                OneSignal.init({
                    appId: "5af69b47-c777-4155-9354-8509a7122d54",
                });
            });
        </script>
        <!-- Start Alexa Certify Javascript -->
        <script type="text/javascript">
            _atrk_opts = {atrk_acct: "MyPVq1Y1Mn20Io", domain: "indiandefensenews.org", dynamic: true};
            (function () {
                var as = document.createElement('script');
                as.type = 'text/javascript';
                as.async = true;
                as.src = "https://certify-js.alexametrics.com/atrk.js";
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(as, s);
            })();
        </script>
    <noscript><img src="https://certify.alexametrics.com/atrk.gif?account=MyPVq1Y1Mn20Io" style="display:none" height="1" width="1" alt="" /></noscript>
    <!-- End Alexa Certify Javascript -->  

    <!-- Document Settings -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <meta name="google-site-verification" content="-SmNg_82W0zFYBb_6Xpz0wiITBYsHL22K_8f_m3OLEo" />
    <meta name="msvalidate.01" content="920B375483CAFBB61B8FB651F76FF15E" />
    <?php
    if ($controller == "article") {
        ?>
        <!--        <meta name="keywords" content="">-->
    <?php } else {
        ?>
        <!--        <meta name="keywords" content="">-->
    <?php }
    ?>
    <meta name="description" content="<?= isset($seo[0]->details) ? preg_replace("/&#?[a-z0-9]+;/i", "", strip_tags($seo[0]->details)) : ''; ?> <?= isset($seo[0]->description) ? preg_replace("/&#?[a-z0-9]+;/i", "", strip_tags($seo[0]->description)) : ''; ?>">
    <link rel="shortcut icon" href="<?= base_url() ?>assets/images/favicon-32x32.png" type="image/x-icon">
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/images/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/images/favicon-16x16.png" sizes="16x16" />
    <!-- Schema.org markup for Google+ -->
    <?php
    if (!empty($google)) {
        ?>
        <meta itemprop="name" content="<?= isset($google[0]['name']) ? $google[0]['name'] : ''; ?>">
        <meta itemprop="description" content="<?= isset($google[0]['description']) ? $google[0]['description'] : ''; ?>">
        <?php
        if ($controller == "article") {
            ?>
            <meta name="image" content="<?= isset($seo[0]->images) ? base_url() . "admin/uploaded_image/normal/" . $seo[0]->images : ''; ?>">
        <?php } else {
            ?>
            <meta name="image" content="<?= isset($google[0]['image']) ? $google[0]['image'] : ''; ?>">
            <?php
        }
    }
    ?>
    <!-- Twitter Card data -->
    <?php
    if (!empty($twiter)) {
        ?>
        <meta name="twitter:card" content="<?= isset($twiter[0]['summary']) ? $twiter[0]['summary'] : ''; ?>">
        <meta name="twitter:site" content="<?= isset($twiter[0]['handle']) ? $twiter[0]['handle'] : ''; ?>"> <!-- @author_handle-->
        <meta name="twitter:title" content="<?= isset($twiter[0]['title']) ? $twiter[0]['title'] : ''; ?>">
        <meta name="twitter:description" content="<?= isset($twiter[0]['description']) ? $twiter[0]['description'] : ''; ?>">
        <meta name="twitter:creator" content="<?= isset($twiter[0]['creator']) ? $twiter[0]['creator'] : ''; ?>">
        <!--        <-- Twitter Summary card images must be at least 120x120px -->
        <meta name="twitter:image" content="<?= isset($twiter[0]['image_url']) ? $twiter[0]['image_url'] : ''; ?>">
    <?php }
    ?>
    <!-- Open Graph data -->
    <meta property="og:title" content="<?= isset($seo[0]->meta_title) ? $seo[0]->meta_title : ''; ?> <?= isset($seo[0]->title) ? $seo[0]->title : ''; ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?= current_url(); ?>" />
    <?php
    if ($controller == "article") {
        ?>
        <meta property="og:image" content="<?= isset($seo[0]->images) ? base_url() . "admin/uploaded_image/normal/" . $seo[0]->images : ''; ?>">
    <?php } else {
        ?>
        <meta property="og:image" content="<?= isset($google[0]['image']) ? $google[0]['image'] : ''; ?>">
        <?php
    }
    ?>
    <meta property="og:description" content="<?= isset($seo[0]->og_description) ? $seo[0]->og_description : ''; ?><?= isset($seo[0]->meta_description) ? $seo[0]->meta_description : '' ?>" />
    <meta property="og:site_name" content="indiandefensenews.org" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page Title -->
    <title><?= isset($seo[0]->blog_title) ? $seo[0]->blog_title : ''; ?> <?= isset($seo[0]->title) ? $seo[0]->title : '' ?></title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/mastercss.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
  
    <!-- Styles
	 <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
	 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.2/owl.carousel.min.css" />
    <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5ad2004922309d0013d4ebc6&product=social-ab' async='async'></script>
</head>
