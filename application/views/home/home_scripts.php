<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    	<script type="text/javascript">
			var windowWidth = $(window).width();
                        if (windowWidth >= 1199) {
	                  document.write("<script type=\"text/JavaScript\" src=\"http://esolz.co.in/lab4/credit_monk/assets/js/require.js\"></"+"script>");
	                  document.write("<script type=\"text/JavaScript\" src=\"http://esolz.co.in/lab4/credit_monk/assets/js/main.js\"></"+"script>");
                        }
			
		</script>
<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <!-- custom js goes here -->
<script src="<?php echo base_url();?>assets/js/owl.carousel.js"></script>
<script src="<?php echo base_url();?>assets/js/custom.js"></script>
<?php
if($show_login_popup)
{
	?>
      <script>
	    $(document).ready(function() {
			
			$('#myModal_login').modal('show');
			});
	  </script>
	<?php
}

?>
      <script>
	    $(document).ready(function() {
	     
	      $(".owl-carousel").owlCarousel({
	     
	          navigation : false, // Show next and prev buttons
	          paginationSpeed : 400,
	          singleItem:true,
	          items : 1,
	          loop: true,
	          autoplay: true
	        });
	      
	      $(".owl-footer, .owl-blog").owlCarousel({
	     
	          navigation : true, // Show next and prev buttons
	          paginationSpeed : 400,
	          singleItem:true,
	          items : 1,
	          loop: true,
	          autoplay: true
	         
	     	
	       
	      });
	    });
    </script>