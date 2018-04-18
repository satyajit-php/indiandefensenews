<!DOCTYPE html>
<?php
$google = $this->site_settings_model->google_seo();  // google plus seo
$twiter = $this->site_settings_model->twiter_seo();  // twiter seo
$controller = $this->uri->segment(1);


switch ($controller) {
    case category:

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

    default:
        $seo = $this->site_settings_model->seo('home');
}
?>
<html>
    <head>
        <!-- Document Settings -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
        <meta name="description" content="">


        <!-- Schema.org markup for Google+ -->
        <?php
        if (!empty($google)) {
            ?>
            <meta itemprop="name" content="<?= isset($google[0]['name']) ? $google[0]['name'] : ''; ?>">
            <meta itemprop="description" content="<?= isset($google[0]['description']) ? $google[0]['description'] : ''; ?>">
            <meta itemprop="image" content="<?= isset($google[0]['image']) ? $google[0]['image'] : ''; ?>">
        <?php }
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
        <meta property="og:title" content="Title Here" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="http://www.example.com/" />
        <meta property="og:image" content="http://example.com/image.jpg" />
        <meta property="og:description" content="Description Here" />
        <meta property="og:site_name" content="indiandefensenews.org" />

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Page Title -->
        <title>Textual - A Content base Handcrafted Bootstrap Template </title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
        <!-- Styles -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/magnific-popup.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/responsive.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.2/owl.carousel.min.css" />
        <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5ad2004922309d0013d4ebc6&product=social-ab' async='async'></script>
    </head>
