	 	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Sub-admin</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Sub-admin Form Elements
							<a href="<?php echo site_url();?>/subadmin_cont" style="color: white;">
			                  <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                                Back
                              </button>
							</a>
                        </div>
                        <div class="panel-body">                        
                            <div class="row">
                                <div class="col-lg-6">
				    <form role="form" id="subadmin_form" name="subadmin_form" method="POST" action="<?php echo site_url();?>/subadmin_cont/update_subadmin/<?php echo $subadmin_data[0]->id;?>">
                                        <input type="hidden" name="mode_addsubadmin" id="mode_addsubadmin" value="add_subadmin">
                                        <input type="hidden" name="nav_id" id="nav_id" value="<?php echo $subadmin_data[0]->page_access;?>">
					 <input type="hidden" name="uid" id="uid" value="<?php echo $subadmin_data[0]->id;?>">  
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> User name:</label>
                                            <input class="form-control need" id="uname" name="uname" label="Username" value="<?php echo $subadmin_data[0]->uname;?>">
                                            <span id="uname_error" style="color: red;"></span>
                                        </div>

                                        <div class="form-group">
                                            <label style="display: block"><span style="color: red;">*</span> Password:</label>
											<div style="display: inline-block; width: 58%">
                                            <input type="password" class="form-control need" id="pass" name="pass" label="Password" value="<?php echo $this->encrypt->decode($subadmin_data[0]->password);?>">
											</div>
					    <button type="button" class="btn btn-primary btn-sm"style="display: inline-block" id="show_btn" onclick="showpass('pass','show');">Show Password</button>
					    <button type="button" class="btn btn-primary btn-sm hide"style="display: inline-block" id="hide_btn" onclick="showpass('pass','hide');">Hide Password</button>
					    <span id="pass_error" style="color: red; display: block"></span>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Email Id:</label>
                                            <input class="form-control need" id="email" name="email" label="Email Id" value="<?php echo $subadmin_data[0]->email;?>"readonly>
                                            <span id="email_error" style="color: red;"></span>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Access Page:</label>
                                            <ul style="list-style: none;">
                                                <?php
                                                $nav_id_arr= explode(',', $subadmin_data[0]->page_access);
                                                $parentnav_val_arr = $this->left_panel_model->get_nav_value();
                                                foreach($parentnav_val_arr as $parentnav_val)
                                                {
											//if($parentnav_val->id != 5)
											//{
                                                    $childnav_val_arr = $this->left_panel_model->get_childnav_value($parentnav_val->id);
                                                ?>
                                                <li style="list-style: none;">
                                                    <?php
                                                    if(empty($childnav_val_arr))
                                                    {
                                                    ?>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="nav_val_<?php echo $parentnav_val->id;?>" name="nav_val[]" value="<?php echo $parentnav_val->id;?>" onclick="get_checkbox(this.value);" <?php if(in_array($parentnav_val->id, $nav_id_arr)){?> checked="checked" <?php } ?>><?php echo $parentnav_val->management_name;?>
                                                        </label>
                                                    </div>
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                    ?>
                                                    <div class="checkbox">
                                                        <label>
                                                            <u><?php echo $parentnav_val->management_name;?></u>
                                                        </label>
                                                    </div>
                                                    <?php    
                                                    }
                                                    if(!empty($childnav_val_arr))
                                                    {
                                                        foreach($childnav_val_arr as $childnav_val)
                                                        {
                                                        ?>
                                                    <ul style="list-style: none;">
                                                        <li style="list-style: none;">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" id="nav_val_<?php echo $childnav_val->id;?>" name="nav_val[]" value="<?php echo $parentnav_val->id.'-'.$childnav_val->id;?>" onclick="get_checkbox(this.value);" <?php if(in_array($childnav_val->id, $nav_id_arr)){?> checked="checked" <?php } ?>><?php echo $childnav_val->management_name;?>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </li>
                                                <?php
											//}
                                                }
                                                ?>
                                            </ul>
                                            
                                            
                                            <span id="nav_val_error" style="color: red;"></span>
                                        </div>
                                        
                                        <button type="button" class="btn btn-success" onclick="subadmin_validation();">Submit</button>
                                        <button type="reset" class="btn btn-default" onclick="go_reset()">Reset</button>
										<div id="loading_img" style="display:none; float: right; top: -30px;margin-right: 170px;"><img src="<?php echo base_url();?>images/facebook_loader.gif" alt=""></div>
										<div id="overlay_main" class="no_responce" style="display: none;"></div>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                               
                                <!-- /.col-lg-6 (nested) -->
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
   </div>


<script type="text/javascript">

//====================validation section===============//
function subadmin_validation()
{
    var has_error=0;
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var uid= $("#uid").val();
    $('.need').each(function(){
        element_id = $(this).attr('id');
        element_value = $(this).val();
        element_label = $(this).attr('label');
        error_div = $("#"+element_id+"_error");
         //alert(element_id);
        if (element_value.search(/\S/)==-1)
        {
          has_error++;
          error_div.html(element_label+' is required.');
        }
        else if (element_value.search(/\S/)!=-1)
        {
	    if(element_id=='uname')
        {  
            $.ajax({
			   type: "POST",
			   url: "<?php echo base_url();?>index.php/subadmin_cont/uniquechk_edit",
			   cache: false,
			   data :{ element_value: element_value, uid: uid,flag: 1},      // 1 flag for user name chk
			   async: false,
			   success: function(data)
			   {
			   
			     
			     if(data==1)
				{
				    has_error++;
				    error_div.html('User name already registerd.');
				    
				}
				else{
				   error_div.html(''); 
				}
			     
			   }
		   });
        }
            if (element_id=='email')
            {
              
                if (!filter.test(element_value))
                {
                    has_error++;
                    error_div.html("Email Id is Not Valid");
                }
            }
	    
        }
        else
        {
          error_div.html('');	  
        }
    });

    var nav_arr=[];
    var nav_val=document.getElementsByName('nav_val[]');
    var len = nav_val.length;
    for (i=0; i<len; i++)
    {
        if(nav_val.item(i).checked== true)
        {
            nav_arr.push(nav_val[i].value);
        }
    }
    if (nav_arr.length==0)
    {
        has_error++;
        $('#nav_val_error').html("Please choose pages you want to give access..");
    }
    else
    {
        $('#nav_val_error').html("");
    }
    //alert(has_error);
    if (has_error>0)
    {
      return false;
    }
    else
    {
	  $('#overlay_main').show();
	  $('#loading_img').show();
      document.subadmin_form.submit();
    }
}
//=========validation section==========//

   function go_reset()
   {
    window.location.href="<?php echo site_url();?>/subadmin_cont";
   }
   
   function get_checkbox(id)
   {
	var nav_arr=[];
    var nav_val=document.getElementsByName('nav_val[]');
    var len = nav_val.length;
    for (i=0; i<len; i++)
    {
        if(nav_val.item(i).checked == true)
        {
            nav_arr.push(nav_val[i].value);
        }
    }
	//$.ajax({
	//	type: "POST",
	//	url: "<?php echo base_url();?>index.php/subadmin_cont/getparentID",
	//	cache: false,
	//	data :{ id: id},
	//	async: false,
	//	success: function(data)
	//	{
	//		//alert(nav_arr.indexOf(data));
	//		if (data > 0)
	//		{
	//			alert(data);
	//			nav_arr.push(nav_val.data);
	//		}
	//		//nav_arr = nav_arr.toString();
	//		//alert(nav_arr);
			$('#nav_id').val(nav_arr);
	//	}
	//});
   
   }
   
   function showpass(id,flag)
   {
    if (flag=='show')
    {
	$('#'+id).attr('type', 'text');
	$('#show_btn').addClass('hide');
	$('#hide_btn').removeClass('hide');
    }
    else if (flag=='hide')
    {
	$('#'+id).attr('type', 'password');
	$('#show_btn').removeClass('hide');
	$('#hide_btn').addClass('hide');
    }
   }
</script>