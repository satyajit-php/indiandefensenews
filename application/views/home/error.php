<!DOCTYPE html>
<html lang="en">
  <head>
	
	<?php $this->load->view('includes/common-head');
	   //echo "<pre>";
	   //print_r($company_details);
	   ////die();
	?>
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/star-rating.css">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.mCustomScrollbar.css">
		<script src="<?php echo base_url();?>assets/js/star-rating.js"></script>
  </head>

  <body>
	<?php $this->load->view('includes/new-header'); ?>
	
	<div class="padding-top-sec"></div>
	
	<!-- search part starts -->
	<?php $this->load->view('includes/search-section'); ?>
	<h2>Oops ! There is an Error.</h2>
	
	<?php $this->load->view('includes/new-footer'); ?>