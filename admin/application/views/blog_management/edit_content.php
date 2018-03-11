  <script>
    function go_select_tag()
    {
	var frm=document.blog_frm;

	//alert(frm.scripts.length);
	var total="";

	for(var i=0; i < frm.tag_name.length; i++)
	{
		if(frm.tag_name[i].checked)
		{
				if(total=="")
				{
					total +=frm.tag_name[i].value;
				}
				else
				{
					total +=","+frm.tag_name[i].value;
				}
		}
		
	}
	
		
	document.getElementById('get_tag').value=total;
	
	
    }
</script>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Blog Content</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Fields marked with <span style="color: red;">*</span> are mandatory
							 <a href="<?php echo site_url();?>/blog_cont" style="color: white;">
							<button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                               Back
                            </button>
							</a>
                        </div>
                        <div class="panel-body">
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="blog_frm" name="blog_frm" method="POST" action="<?php echo base_url();?>index.php/blog_cont/update_blog" enctype="multipart/form-data">
				     <input type="hidden" id="get_tag" name="get_tag" value="<?php echo $blog_data[0]->blog_tag; ?>"/>
                                        <input type = 'hidden' name='id' value="<?php echo $blog_data[0]->id; ?>"></td>
                                         <input type = 'hidden' name='last_img' value="<?php echo $blog_data[0]->images; ?>"></td>
					                    <input type="hidden" id="mode_blog" name="mode_blog" value="update_blog"/>
                                        <div class="form-group">
                                            <label>Blog Title <span style="color: red;">*</span>:</label>
                                            <input class="form-control need" id="blog_title" name="blog_title" label="Blog Title" value="<?php echo $blog_data[0]->blog_title;?>">
                                            <span id="blog_title_error" style="color: red;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Added by<span style="color: red;">*</span>:</label>
                                            <input class="form-control need" id="added_by" name="added_by" label="Added By" value="<?php echo $blog_data[0]->added_by;?>">
                                            <span id="added_by_error" style="color: red;"></span>
                                        </div>
                                       <div class="form-group">
                                            <label>Tag <span style="color: red;">*</span>:</label>
					    
					    <?php
						    $blog_tag=explode(',',$blog_data[0]->blog_tag);
						  
						    $all_tag=$this->blog_tag_model->get_all_tag();
						    
						    foreach($all_tag as $get_all)
						    {
							 $checked="";
							 
							if (in_array($get_all->id, $blog_tag))
							{
							    $checked="checked";
							}
					    ?>
							  <input type="checkbox" name="tag_name" value="<?php echo $get_all->id;?>" <?php echo $checked;?>> &nbsp;<?php echo $get_all->tag_name;?>
					    <?php
						    }
					    ?>
                                           </br>
                                            <span id="get_tag_error" style="color: red;"></span>
                                        </div>
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Image :</label>
                                            <?php						
                                                if(isset($blog_data[0]->images) && $blog_data[0]->images!='')
                                                {
                                                ?>
                                                    <img alt="Your uploaded image" src="<?php echo base_url(). 'uploaded_image/normal/' .$blog_data[0]->images;?>"  height="100" width="100"/></td>
                                                    <input type="file" class="form-control" id="attachment_file" name="attachment_file" label="Attachment" style= "margin-top: 15px;" >
                                                        
                                                <?php
                                                }else
                                                {
                                                ?>
                                                    <img alt="Your uploaded image" src="<?php echo base_url(). 'uploaded_image/thumbnail/noimage.jpg';?>"  height="100" width="100"/></td>
                                                    <input type="file" class="form-control" id="attachment_file" name="attachment_file" label="Attachment" style= "margin-top: 15px;" >
                                                <?php
                                                }
                                                ?>
					                        <div id="docname_error" style="display: none; color: red;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Blog Description <span style="color: red;">*</span>:</label>
                                            <textarea class="ckeditor" cols="80" id="blog_desc" label="Blog Description" name="blog_desc" rows="10"><?php echo $blog_data[0]->details;?></textarea>
                                            <span id="blog_desc_error" style="color: red;"></span>
                                        </div>
									  <div class="form-group">
                                            <label>Status
                                            <span style="color: red;"></span>:</label>
                                           <!-- <input class="form-control need" id="faq_typ_name" name="faq_typ_name" label="FAQ Type Name">-->
                                            
                                            <select class="form-control need" id="status" name="status" label="Status">
                                            <option value="1" <?php if($blog_data[0]->status=='1'){?> selected="selected" <?php } ?>>Active</option>
                                            <option value="0" <?php if($blog_data[0]->status=='0'){?> selected="selected" <?php } ?>>Inactive</option>
                                            </select>
                                            
                                            
                                            <span id="status_error" style="color: red;"></span>
                                        </div>
                                        
                                        
                                        <button type="button" class="btn btn-success" onclick="validate_frm();">Submit</button>
                                        <button type="reset" class="btn btn-default">Reset</button>
										<div id="loading_img" style="display:none; float: right; margin-top: 5px;margin-right: 272px;"><img src="<?php echo base_url();?>images/facebook_loader.gif" alt=""></div>
										<div id="overlay_main" class="no_responce" style="display: none;"></div>						
                                    </form>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
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
<!------------validate form------------->
<script>
function validate_frm()
{
    var has_error=0;
    var editor4 = CKEDITOR.instances.blog_desc.getData();
    $('.need').each(function(){
        element_id = $(this).attr('id');
        element_value = $(this).val();
        element_label = $(this).attr('label');
        error_div = $("#"+element_id+"_error")
        //alert(element_id);
        if (element_value.search(/\S/)==-1)
        {
          has_error++;
          error_div.html(element_label+' is required.');
        }
        else
        {
            error_div.html('');
        }
    });
    
    //alert(has_error);
    if(editor4.search(/\S/)==-1)
    {
        has_error++;
        document.getElementById('blog_desc_error').innerHTML='Blog Description is required.';
    }
    else
    {
        document.getElementById('blog_desc_error').innerHTML='';
    }
    
    //alert(has_error);
    
    if (has_error>0)
    {
       return false;
    }
    else
    {
	go_select_tag();
	
	if (document.getElementById('get_tag').value.search(/\S/)==-1)
	{
	    document.getElementById('get_tag_error').innerHTML='Please select tag of the blog.';
	}
	else
	{
	        document.getElementById('get_tag_error').innerHTML='';
		$('#overlay_main').show();
		$('#loading_img').show();
		document.blog_frm.submit();
	}
		
    }
}

function go_reset()
{
    window.location.href="<?php echo base_url();?>index.php/blog_cont";
}
</script>
<!------------validate form------------->