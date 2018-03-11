    <style>
	 .star_style
	 {
	 	    float: right;
			display: inline-block;
			margin-right: 48%;
			margin-top: -13px;
	 }
	 .play {
			 position: absolute;
			 top: 20%;
			 width: 41px;
			 margin: 0 auto;
			 left: 0px;
			 right: 0px;
			 z-index: 100;
		   }
	 </style>
   <link rel="stylesheet" href="http://www.creditmonk.com/fancyBox-master/source/jquery.fancybox.css" type="text/css" media="screen" />
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">View Review Details</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
						 Review
							 <!--<a href="<?php echo site_url();?>/review_mang_cont" style="color: white;">
							<button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                               Back
                            </button>
							</a>-->
                        </div>
                        <div class="panel-body">
                            
                            <div class="row">
                                <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Review Title<span style="color: red;"></span>:</label>
                                            
                                            <span><?php echo $particularReview[0]->review_title ;?></span>
                                        </div>
										<div class="form-group">
                                            <label>Company Name<span style="color: red;"></span>:</label>
                                            
                                            <span><?php echo $particularReview[0]->company_name ;?></span>
                                        </div>
<!--										<div class="form-group">-->
<!--                                            <label>Company Name:<span style="color: red;">*</span>:</label>-->
<!--											 -->
<!--                                            <img alt="Your uploaded image" src="<?php echo base_url();?>uploaded_image/normal/abs.png"  height="200" width="200"/>-->
<!--                                        </div>-->
										<div class="form-group">
                                            <label>Month and Year of Transaction<span style="color: red;"></span>:</label>
                                            
                                            <span><?php echo $particularReview[0]->month;?> <?php echo $particularReview[0]->year;?></span>
                                        </div>
										<div class="form-group">
                                            <label>Overall Payment Experience<span style="color: red;"></span>:</label>
											<span class="rate-tating star_style">
												<input id="input-id-1" type="number" class="rating rating_reviewDetails" min=0 max=5 step=0.5 data-size="xs" value="<?php echo $particularReview[0]->overall_pay_exp;?>" >
											</span>
                                          
                                        </div>
										<div class="form-group">
                                            <label>How was the process to get payment?<span style="color: red;"></span>:</label>
                                             <!--<input id="input-id" type="number" class="rating" min=0 max=5 step=0.5 value="<?php echo $particularReview[0]->pay_process;?>"data-size="sm" >-->
                                            <span class="rate-tating star_style">
												<input id="input-id-1" type="number" class="rating rating_reviewDetails" min=0 max=5 step=0.5 data-size="xs" value="<?php echo $particularReview[0]->pay_process;?>" >
											</span>
											
                                        </div>
										<div class="form-group">
                                            <label>Was it easy to contact senior management?<span style="color: red;"></span>:</label>
                                            <span class="rate-tating star_style">
												<input id="input-id-1" type="number" class="rating rating_reviewDetails" min=0 max=5 step=0.5 data-size="xs" value="<?php echo $particularReview[0]->contact_senior_mgmt;?>" >
											</span>
                                          
                                        </div>
										<div class="form-group">
                                            <label>Did you find them ethical in your dealings?<span style="color: red;"></span>:</label>
                                            <span class="rate-tating star_style">
												<input id="input-id-1" type="number" class="rating rating_reviewDetails" min=0 max=5 step=0.5 data-size="xs" value="<?php echo $particularReview[0]->ethical_deal;?>" >
											</span>
                                            
                                        </div>
										<div class="form-group">
                                            <label>Would you deal with them again?<span style="color: red;"></span>:</label>
                                            <span class="rate-tating star_style">
												<input id="input-id-1" type="number" class="rating rating_reviewDetails" min=0 max=5 step=0.5 data-size="xs" value="<?php echo $particularReview[0]->deal_chk;?>" >
											</span>
                                           
                                        </div>
										<div class="form-group">
                                            <label>Usually Pays in ( Days )?<span style="color: red;"></span>:</label>
                                            
                                            <span><?php echo $particularReview[0]->usual_pay;?></span>
                                        </div>
										<div class="form-group">
                                            <label>Usual credit allowed?<span style="color: red;"></span>:</label>
                                            
                                            <span><?php echo $particularReview[0]->credit_allow;?></span>
                                        </div>
										<div class="form-group">
                                            <label>Usual payment method?<span style="color: red;"></span>:</label>
                                            
                                            <span><?php echo $particularReview[0]->pay_method; ?></span>
                                        </div>
										<div class="form-group">
                                            <label>Did they give advance with their order?<span style="color: red;"></span>:</label>
                                            
                                            <span><?php if($particularReview[0]->advance_chk== 1){echo "Yes";}else if($particularReview[0]->advance_chk==0){echo "No";}else {echo "Sometimes";}?></span>
                                        </div>
										<div class="form-group">
                                            <label>Do they pay interest on delayed payments?<span style="color: red;"></span>:</label>
                                            
                                            <span><?php if($particularReview[0]->delayed_chk== 1){echo "Yes";}else if($particularReview[0]->delayed_chk==0){echo "No";}else {echo "Sometimes";}?></span>
                                        </div>
										<div class="form-group">
                                            <label>Were there cheque return problems?<span style="color: red;"></span>:</label>
                                            
                                            <span><?php if($particularReview[0]->cheque_return_chk== 1){echo "Yes";}else if($particularReview[0]->cheque_return_chk==0){echo "No";}else {echo "Sometimes";}?></span>
                                        </div>
										<div class="form-group">
                                            <label>Did they ask you to hold checks given?<span style="color: red;"></span>:</label>
                                            
                                            <span><?php if($particularReview[0]->hold_checks== 1){echo "Yes";}else if($particularReview[0]->hold_checks==0){echo "No";}else {echo "Sometimes";}?></span>
                                        </div>
										<div class="form-group">
                                            <label>Did concessional forms (C forms etc) require follow up?<span style="color: red;"></span>:</label>
                                            
                                            <span><?php if($particularReview[0]->concessional_forms== 1){echo "Yes";}else if($particularReview[0]->concessional_forms==0){echo "No";}else {echo "Sometimes";}?></span>
                                        </div>
										<div class="form-group">
                                            <label>Did you ever list them as a bad debt?<span style="color: red;"></span>:</label>
                                            
                                            <span><?php if($particularReview[0]->bad_debt== 1){echo "Yes";}else if($particularReview[0]->bad_debt==0){echo "No";}else {echo "Planning To";}?></span>
                                        </div>
										<div class="form-group">
                                            <label>Did you initial legal proceedings?<span style="color: red;"></span>:</label>
                                            
                                            <span><?php if($particularReview[0]->legal_proceedings== 1){echo "Yes";}else if($particularReview[0]->legal_proceedings==0){echo "No";}else {echo "Planning To";}?></span>
                                        </div>
										<div class="form-group">
                                            <label>Have they commited fraud ? (sold fake items/misleading descriptions etc.)<span style="color: red;"></span>:</label>
                                            
                                            <span><?php if($particularReview[0]->commited_fraud== 1){echo "Yes";}else if($particularReview[0]->commited_fraud==0){echo "No";}else {echo "Possibly";}?></span>
                                        </div>
<!--										<div class="form-group">-->
<!--                                            <label>photo/video to support your reviews<span style="color: red;"></span>:</label>-->
<!--											<img alt="Your uploaded image" src="<?php echo base_url();?>uploaded_image/normal/abs.png"  height="200" width="200"/>-->
<!--                                        </div>-->
 
									 <?php
									  if(!empty($review_img_video))
									  {
									      foreach($review_img_video as $reviewImg) {
									      //echo $reviewImg->image_name;
										if($reviewImg->image_name!=''){
										$base_url=base_url();
										$my_image_url=str_replace("credit_monk/admin/","credit_monk/",$base_url);
										//echo $my_image_url;die();
										 
									    ?>
										
										
											<div class="col-sm-3 col-xs-6">		  
												<div class="white_box2">
												  <a href="<?php echo $my_image_url;?>images/review/thumbnail/<?php echo $reviewImg->image_name;?>"  class="fancybox" rel="gallery">
													<div class="bg-style" style="background: url('<?php echo $my_image_url;?>images/review/thumbnail/<?php echo $reviewImg->image_name;?>');background-repeat: no-repeat;background-position: center center;height: 82px;"></div>
												  </a>
												</div>
											</div>
										
										
									    <?php
										}
										if($reviewImg->video_url!=''){
									    ?>
										
										  <div class="col-sm-3 col-xs-6">		  
											  <div class="white_box2">
												<a class="more" href="https://www.youtube.com/watch?v=<?php echo $reviewImg->video_url;?>">
													<div class="bg-style" style="background: url('http://img.youtube.com/vi/<?php echo $reviewImg->video_url;?>/0.jpg');background-repeat: no-repeat;background-position: center center;height: 82px;"></div>
													<div class="play"><img src="<?php echo $my_image_url;?>assets/images/playIcon.png"/></div>
												</a>
											  </div>
										  </div>
										
									    <?php
										}
									    }
									  }
									  else{
									     echo "None";
									  }
									  ?>
										
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
						
						<div style="margin: 30px;">
						   <?php
						   if($particularReview[0]->disable=='0')
						   {
						   ?>	
							   <button type="button" class="btn btn-success" onclick="change_status_to('1','<?php echo $particularReview[0]->id; ?>','<?php echo $particularReview[0]->company_id; ?>','<?php echo $particularReview[0]->added_by; ?>')">Block</button>
						   <?php
						   }
						   else if($particularReview[0]->disable=='1')
						   {
						   ?>
							   <button type="button" class="btn btn-success" onclick="change_status_to('0','<?php echo $particularReview[0]->id; ?>','<?php echo $particularReview[0]->company_id; ?>','<?php echo $particularReview[0]->added_by; ?>')">UnBlock</button>
						   <?php
						   }
						   ?>
						   <button type="reset" class="btn btn-default">cancel</button><!-- onclick="go_reset();"-->
					   </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    
<script src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>
<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>bootstrap_star/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap_star/js/star-rating.min.js" type="text/javascript"></script>
<!-- optionally if you need translation for your language then include locale file as mentioned below -->
<script type="text/javascript" src="http://esolz.co.in/lab4/credit_monk/fancyBox-master/source/jquery.fancybox.js"></script>
<script src="<?php echo base_url(); ?>bootstrap_star/js/star-rating_locale_<lang>.js"></script>
<!------------validate form------------->
<script>
//-------------initialize with defaults of rating------------//

$(document).ready(function() {
	      $(".rating_reviewDetails").rating ("refresh",  {disabled: true,  showClear: false
	      });
});

</script>
 <!------end initializing of rating------------->
<script>

var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];   
function Validate(sFileName)
{
    //var arrInputs = oForm.getElementsByTagName("input");
     
	if (sFileName.length > 0)
	{
	    var blnValid = false;
	    for (var j = 0; j < _validFileExtensions.length; j++) {
		var sCurExtension = _validFileExtensions[j];
		if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
		    blnValid = true;
		    break;
		}
	    }
	    
	    if (!blnValid) {
		return 1;
		
	    }
	    else{
	     
	      return 0; 
	    }
	}
       
   
    
 }

//============script for change status of review===============//

function change_status_to(review_param,id,comp_id,added_by)
{
		//alert(added_by);
		if (review_param == 1)
		{
            var confirmvalue=confirm("Do You want to deactivate this review?");
        }
		if (review_param == 0)
		{
            var confirmvalue=confirm("Do You want to active this review?");
        }
		
		if (confirmvalue == true)
		{
				window.location.href="<?php echo site_url();?>/review_mang_cont/change_status_to/"+review_param+"/"+id+"/"+comp_id+"/"+added_by;
		}
   
    
}

//============ end script for change status of review===============//


function go_reset()
{
    window.location.href="<?php echo base_url();?>index.php/review_mang_cont";
}

	  $(document).ready(function(){
	 $('.fancybox').fancybox();
		$("a.more").click(function(){
            $.fancybox({
            'padding'       : 0,
            'autoScale'     : false,
            'transitionIn'  : 'none',
            'transitionOut' : 'none',
            'title'         : this.title,
            'width'     : 680,
            'height'        : 495,
            'href'          : this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
            'type'          : 'swf',
            'swf'           : {
                 'wmode'        : 'transparent',
                'allowfullscreen'   : 'true'
            }
			
        });
			return false;
        });
	  })
</script>



