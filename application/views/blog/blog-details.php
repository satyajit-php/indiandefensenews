<!DOCTYPE html>
<html lang="en">
<head>
	
	<?php
		$this->load->view('includes/common-head');
	   
	?>
        
</head>

<body>
	<?php $this->load->view('includes/new-header'); ?>
	<div class="padding-top-sec"></div>
	
	<!-- search part starts -->
	<?php $this->load->view('includes/search-section'); ?>
	<!-- search part ends -->
	
<!-- blog page starts -->
<div class="monk-inner">
	<div class="container blog">
		<!--<h2>Blog</h2>-->
		
		<div class="row">
			<div class="col-sm-12">
			<button class="btn btn-primary" type="button" style="float:right;margin-bottom: 10px; margin-top: 10px" onclick="go_back()">Go Back To Blog List</button>
		</div>
			<div class="col-sm-8">
		<?php
				if($blog_data !='')
				{
					$i=0;
					foreach($blog_data as $blog):
                ?>
				<div class="blog-l">
					<div class="blog-l-head">
						<h3>
							<a href="javascript:void(0);">
								<?php echo $blog->blog_title;?>
							</a>
						</h3>
						<div class="blog-status">
							<div class="blog-name">
								<!--<div class="blog-user" style="display: none;">-->
								<!--	<img src="<?php echo base_url();?>assets/images/blog-user.jpg" alt="" />-->
								<!--</div>-->
								<!--<div class="blog-txt">-->
								<div>
									Added By
									<!--<a href="javascript:void(0);">--><?php echo $blog->added_by;?><!--</a>-->
								</div>
							</div>
							<ul class="blog-date list-unstyled">
								<li><a href="javascript:void(0);"><i class="fa fa-calendar"></i> <?php $d=$blog->added_on;echo date('F j, Y',strtotime($d))."   ".date('h:i a',strtotime($d));?></a></li>
								<li>
									<a href="<?php echo base_url();?>blog_cont/blogdetails/<?php echo $this->uri->segment(3);?>#goto_cmmnt">
										<i class="fa fa-comment"></i>&nbsp;
										<?php
										$blog_val = $this->blog_model->get_blogCommentAll($blog->id);
										if($blog_val['num'] > 1)
										{
											echo $blog_val['num'].' Comments';
										}
										else if($blog_val['num'] == 1)
										{
											echo $blog_val['num'].' Comment';
										}
										else if($blog_val['num'] == 0)
										{
											echo 'No Comment';
										}
										?>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="blog-pic">
						<!--<img src="<?php echo base_url();?>assets/images/blog-img-1.jpg" alt="" />-->
						<img alt="" src="<?php echo base_url(). 'admin/uploaded_image/normal/' .$blog->images;?>" height="" width="" />
					</div>
					<div class="blog-containt" id="b_con_more<?php echo $i ; ?>">
						<p>
						<?php
						$f='more';
						echo substr($blog->details,0,200);
						$d=strlen($blog->details);
				  
						if($d>200)
						{
						?>
						 <a href="javascript:void(0)" onclick="display_comm('<?php echo $i ; ?>','<?php echo $f; ?>')">[Show More]</a>
						<?php
						}
						 ?>
						</p>
						<!--<div  id="comm_more" style="display:none;"></div>
						<div></div>-->
					</div>
					<div class="blog-containt" id="b_con_full<?php echo $i ; ?>" style="display:none">
						<p><?php
						      $f='less';
						      echo $blog->details;
							  
						     ?>
						    
							<a href="javascript:void(0)" onclick="display_comm('<?php echo $i ; ?>','<?php echo $f; ?>')">[Show Less]</a>
							
						</p>
						<!--<div  id="comm_more" style="display:none;"></div>
						<div></div>-->
					</div>
					
					<!----------tag section------------>
					<div class="blog-containt tag-blog-sec">
						<span>Tags:</span>
						<div class="tags">
							<ul>
								<?php
								$tag_arr = explode(',', $blog->blog_tag);
								foreach($tag_arr as $tag)
								{
									$tag_val = $this->blog_model->get_blogTag($tag);
									?>
									<li>
										<a href="javascript:void(0);"><?php echo $tag_val['blog_tag_array'][0]->tag_name;?></a>
									</li>
								<?php
								}
								?>
							</ul>
						</div>
					</div>
					<!----------tag section------------>
						<?php
						$title= $blog->blog_title;
						$summary= $blog->blog_title;
						$titl_google = $blog->blog_title;
						$url = base_url().'blog_cont/blogdetails/'.$blog->id;
						?>
					<div class="blog-social clearfix">
						<ul class="list-unstyled blog-social-l" style="margin-left: 0px;">
							<?php
							if($this->session->userdata('uid')!="")
							{
							?>
							<li><a href="javascript:void(0);" onclick="show_commnt_box('<?php echo $blog->id;?>','show');"><i class="fa fa-reply"></i> Comment</a></li>
							<?php
							}else{
							?>
							<li><a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_login"><i class="fa fa-reply"></i> Reply</a></li>
							<?php
							}
							?>
						</ul>
						<ul class="list-unstyled blog-social-r">
							<li><a href="javascript:fbshareCurrentPage();" target="_blank" class="fb-share-button" id="fb_share_btn" data-href="<?php echo $url;?>"><i class="fa fa-facebook"></i></a> </li>
							<li><a href="https://twitter.com/intent/tweet?url=<?php echo $url;?>" target="_blank" data-counturl="https://dev.twitter.com/web/tweet-button"><i class="fa fa-twitter"></i></a></li>
							<li><a href="https://plus.google.com/share?url=<?php echo $url; ?>&title=<?php echo $titl_google;?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i></a></li>
							<li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $title;?>&summary=<?php echo $summary;?>&source=<?php echo $url;?>" target="_blank"><i class="fa fa-linkedin"></i></a> </li>
						</ul>
					</div>
					
					<!--<form role="form" id="comment_frm" name="comment_frm" method="POST" action="<?php echo base_url();?>index.php/blog_cont/insert_comment" enctype="multipart/form-data">-->
					<div class="comment-blog hide" id="comment_box_section_<?php echo $blog->id;?>">
						<div  id="comm_post<?php echo $blog->id ;?>" class="comment-blog" style="display:none;"></div>
						<label class="blog_cmnt_title">Comment here:</label>
						<textarea placeholder="Please add your valuable comments here.." class="txt-blog form-control" name="comm" id="comm<?php echo $blog->id ; ?>"></textarea>
						<input type="hidden" name="bid" id="bid<?php echo $blog->id ; ?>" value="<?php echo $blog->id ; ?>">
						<button class="btn btn-submit" type="button" onclick="insert_comment('<?php echo $blog->id ; ?>')">submit</button>
						<button class="btn btn-default" type="button" onclick="show_commnt_box('<?php echo $blog->id;?>', 'close')" style="margin-top: 10px; margin-left: 20px;">Cancel</button>
						<span class="hide" id="loader_img_<?php echo $blog->id ; ?>">
							<img src="<?php echo base_url();?>assets/images/facebook_loader.gif" style="margin-left: 10px;margin-top: 10px;">
						</span>
						<span id="comm_error<?php echo $blog->id ; ?>" style="color: red;"></span>
					</div>
					<!--</form>-->
				</div>
				
				
				<a name="goto_cmmnt"></a>
				
				<div class="comment-sec" id="getAjaxAllComment_<?php echo $blog->id?>" style="border-top: 1px solid #E7E7E7;" id="comment">				
				<?php
				$j=0;
				if(!empty($blog_cmnt_val['blog_cmnt']))
				{
					foreach($blog_cmnt_val['blog_cmnt'] as $val)
					{
						//echo "<pre>";
						//print_r($val);
					?>
					
					<div class="clearfix comment-blog">
						<div class="review-detail-pic">
						  <div class="review-detail-icon">
							<img alt="" src="<?php echo base_url();?>assets/images/profile_picture/thumbnail/<?php echo $val->profile_pic;?>">
						  </div>
						</div>
						<div class="commentArea">
						 
						  <p><a href="javascript:void(0);"><?php echo $val->first_name.' '.$val->last_name;?></a>
						  <u style="color: darkorange;">Date : <?php echo date("j M Y H:m:s",strtotime($val->posted_on));?></u></p>
						  <p class="comment-section"><?php echo $val->comment;?></p>
						</div>
					</div>
					
					<?php
					$j++;
					}
				}
					?>
				</div>
				
				<?php
					$i++;
					endforeach;
				}
				?>
			</div>
			<div class="col-sm-4">
				<div class="blog-r">
					<h3>Most Popular Posts</h3>
					<ul class="list-unstyled post-list clearfix">
							
							
						<?php
						if(!empty($blog_by_comment))
						{
							$count = 0;
							foreach($blog_by_comment as $blog_by_comment_val)
							{
								if($count < 5)
								{
									//echo $blog_by_comment_val['blog_id'];
							?>
							<li>
								<div class="post-pic">
									<img src="<?php echo base_url();?>admin/uploaded_image/thumbnail/<?php echo $blog_by_comment_val['images'];?>" alt="" />
								</div>
								<div class="post-text">
									<h2>
										<a href="<?php echo base_url();?>blog_cont/blogdetails/<?php echo $blog_by_comment_val['blog_id'];?>">
											<?php echo $blog_by_comment_val['blog_title'];?>
										</a>
									</h2>
									<p>
									<?php
									if(strlen($blog_by_comment_val['details']) > 100)
									{
										echo substr($blog_by_comment_val['details'], 0, 100).'.....';
									}
									else
									{
										echo $blog_by_comment_val['details'];
									}
									?></p>
									<a href="#" class="post-date">
										<i class="fa fa-calendar"></i>
										<?php echo date('j F, Y', strtotime($blog_by_comment_val['added_on']));?>
									</a>
								</div>
							</li>
							<?php
							$count++;
								}
							}
						}
						else
						{
						?>
							<li>
								<div class="post-text">
									<p>No results found..</p>
								</div>
							</li>
						<?php
						}
						?>
							
							
							
							
							<?php
//				              if($blog_pop !='')
//                                    {
//                                           foreach($blog_pop as $pop):
                                    ?>
									<!--<li>-->
									<!--	<div class="post-pic">-->
									<!--		<img src="<?php echo base_url(). 'admin/uploaded_image/thumbnail/' .$pop->images;?>" alt="" height="100" width="100"  />-->
									<!--	</div>-->
									<!--	<div class="post-text">-->
									<!--		<h2><?php echo $pop->blog_title ;?></h2>-->
									<!--		<p><?php echo substr($pop->details,0,30) ;?></p>-->
									<!--		<a href="#" class="post-date"><i class="fa fa-calendar"></i><?php $d=$pop->added_on;echo date('F j, Y',strtotime($d))."   ".date('h:i a',strtotime($d));?>  </a>-->
									<!--	</div>-->
									<!--</li>-->
						                  <?php
					                      //endforeach;
				                     //}
				                  ?>
						
					</ul>
				</div>
			<!--	<div class="blog-add">
					<img src="<?php echo base_url();?>assets/images/blog-add.jpg" alt="" />
					<div class="blog-add-txt text-center">
						<h2>perspiciatis aperiam <span> voluptas sit temp</span></h2>
						<a href="#" class="btn btn-learn">learn more</a>
					</div>
				</div>
				<div class="blog-add">
					<img src="<?php echo base_url();?>assets/images/blog-add-2.jpg" alt="" />
					<div class="blog-add-txt text-center">
						<h2>perspiciatis aperiam <span> voluptas sit temp</span></h2>
						<a href="#" class="btn btn-guide">learn more</a>
					</div>
				</div>-->
			</div>
		</div>
		<ul class="pagination-outer list-unstyled">
			<!--<li><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>-->
			<?php if(isset($links)){ echo $links; } ?> 
		</ul>
	</div>
</div>
<!-- body-sec review part ends -->
<?php $this->load->view('includes/new-footer'); ?>

<script>
	
	function insert_comment(id)
	{
		var com=$('#comm'+id).val();
		var post_on=$('#bid'+id).val();
		var has_error=0;
		if (com.search(/\S/)==-1)
		{
		    has_error++;
		    $('#comm_error'+id).html('Comment is required.');
		}
		else
		{
		    $('#comm_error'+id).html('');
		}
		
		if (has_error>0) {
			return false;
		}
		else
		{
			$('#loader_img_'+id).removeClass('hide');
		        //alert(com +' '+post_on);       
			$.ajax({
			        url: "<?php echo base_url(); ?>index.php/blog_cont/insert_comment",
					async : false,
					method : "POST",
					data : { post_on: post_on, com: com},
					success : function(data) {
						//alert(data);
						data = data.trim();
						data = data.split('@@@');
						$('#getAjaxAllComment_'+id).html(data[0]);
						$('#loader_img_'+id).addClass('hide');
						$('#comm'+id).val('');
						$('#getAjaxAllComment_'+id).animate({ scrollTop: $('#getAjaxAllComment_'+id).prop("scrollHeight")}, 1000);
                    }
			});
		  
		  //document.comment_frm.submit();
		 
		}
    }
	function display_comm(id,fl)
	{
		if (fl=='more') {
			
			$('#b_con_full'+id).show();
			$('#b_con_more'+id).hide();
			//code
		}
		else if (fl=='less') {
			$('#b_con_full'+id).hide();
			$('#b_con_more'+id).show();
		}
		
//		var post_on=$('#bid'+id).val();
//		 $.ajax({
//			              
//			             
//                               url: "<?php echo base_url(); ?>index.php/blog_cont/display_comment",
//                               async:false,
//                               method: "POST",
//                               data:{ post_on: post_on },
//							
//                               
//                               success: function(response) {
//                                         // alert(response);
//                                          console.log(response) ;
//                                        
//										  $('#comm_more'+id).html(response);
//										  $('#comm_more'+id).show();
//										 
//                                               
//                                          }
//                       });
		  
	}
function show_commnt_box(cmmnt_id, flag)
{
	if (flag == 'show')
	{
		$('#comment_box_section_'+cmmnt_id).removeClass('hide');
	}
	else
	{
		$('#comment_box_section_'+cmmnt_id).addClass('hide');
	}
}

function go_back() {
	window.location.href="<?php echo base_url();?>blog_cont";
}
function fbshareCurrentPage()
	{
		var link = $('#fb_share_btn').attr('data-href');
		window.open("https://www.facebook.com/sharer/sharer.php?u="+escape(link), '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
		return false;
	}
</script>

	</body>
</html>