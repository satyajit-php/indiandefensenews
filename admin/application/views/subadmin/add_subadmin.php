	 	<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add New Sub-admin</h1>
					
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
				    <form role="form" id="subadmin_form" name="subadmin_form" method="POST" action="<?php echo site_url();?>/subadmin_cont/insert_subadmin">
                                        <input type="hidden" name="mode_addsubadmin" id="mode_addsubadmin" value="add_subadmin">
                                        <input type="hidden" name="nav_id" id="nav_id" value="">                                        
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Username:</label>
                                            <input type="text" class="form-control need" id="uname" name="uname" label="Username">
                                            <span id="uname_error" style="color: red;"></span>
                                        </div>

                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Password:</label>
                                            <input type="password" class="form-control need" id="pass" name="pass" label="Password">
                                            <span id="pass_error" style="color: red;"></span>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Email Id:</label>
                                            <input class="form-control need" id="email" name="email" label="Email Id">
                                            <span id="email_error" style="color: red;"></span>
                                        </div>

                                        
                                        <div class="form-group">
                                            <label><span style="color: red;">*</span> Access Page:</label>
                                            <ul style="list-style: none;">
                                                <?php
                                                $parentnav_val_arr = $this->left_panel_model->get_nav_value();
                                                foreach($parentnav_val_arr as $parentnav_val)
                                                {
                                                    if($parentnav_val->id != 5)
                                                    {
                                                    $childnav_val_arr = $this->left_panel_model->get_childnav_value($parentnav_val->id);
                                                ?>
                                                <li style="list-style: none;">
                                                    <?php
                                                    if(empty($childnav_val_arr))
                                                    {
                                                    ?>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="nav_val_<?php echo $parentnav_val->id;?>" name="nav_val[]" value="<?php echo $parentnav_val->id;?>" onclick="get_checkbox(this.value);"><?php echo $parentnav_val->management_name;?>
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
                                                                    <input type="checkbox" id="nav_val_<?php echo $childnav_val->id;?>" name="nav_val[]" value="<?php echo $childnav_val->id;?>" onclick="get_checkbox(this.value);"><?php echo $childnav_val->management_name;?>
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
                                                    }
                                                }
                                                ?>
                                            </ul>
                                            
                                            
                                            <span id="nav_val_error" style="color: red;"></span>
                                        </div>
                                        
                                        <button type="button" class="btn btn-success" onclick="subadmin_validation();">Submit</button>
                                        <button type="reset" class="btn btn-default">Reset</button>
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
			   url: "<?php base_url();?>uniquechk",
			   cache: false,
			   data :{ element_value: element_value, flag: 1},      // 1 flag for user name chk
			   async: false,
			   success: function(data)
			   {
			     
			     if(data==1)
				{
				    has_error++;
				    error_div.html('User name already registerd.');
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
		else
		{
		    $.ajax({
			   type: "POST",
			   url: "<?php base_url();?>uniquechk",
			   cache: false,
			   data :{ element_value: element_value, flag: 2},      // 2 flag for email id chk
			   async: false,
			   success: function(data)
			   {
			        if (data==1)
				{
				    has_error++;
				    error_div.html('Email id already registerd.');
				}
			      
			     
			   }
		   });   
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
        if(nav_val.item(i).checked== true)
        {
            nav_arr.push(nav_val[i].value);
        }
    }
    nav_arr= nav_arr.toString();
    $('#nav_id').val(nav_arr);
   }
</script>