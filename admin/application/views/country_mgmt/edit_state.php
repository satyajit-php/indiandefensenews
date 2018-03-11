
<script>

function Select_state(country_id )
{
  
          //code
    
    // alert('<?php echo base_url(); ?>index.php/country_cont/Select_state');
 
     $.ajax({
                    url: "<?php echo base_url(); ?>index.php/country_cont/Select_state",
                    async:false,
                    data: {
                     country_id:country_id
                    
                    },
                    
                    success: function(response) {
                         
                        
                              //code
                         
                                   
                                  //alert(response);
                                  if (response == 0)
                                  {
                                      //alert('no response');
                                      $('#state_div').hide();
                                      
                                  }
                                  else
                                  {
                                       $('#state_div').show();
                                       $('#state').html(response);
                                  }
                        
                               
                                //$('.selectpicker').selectpicker('refresh');
                           
                      
                          
                            
                    }
                          
                          
                    
                })
      
      
      
      
}
</script>
<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit State</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Fields marked with <span style="color: red;">*</span> are mandatory
                            <a href="<?php echo site_url();?>/country_cont" style="color: white;">
                            <button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                                Back
                            </button>
                            </a>
                        </div>
                        <div class="panel-body">
                            
                           <div class="row">
                                     <div class="col-lg-6">
                              <div id="state_managemnt" >
                                        
                                   <form role="form" id="state_frm" name="state_frm" method="POST" action="<?php echo base_url();?>index.php/country_cont/update_state" enctype="multipart/form-data">
                                    <input type="hidden" id="mode_state" name="mode_state" value="insert_state"/>                                        
                                      <?php  if(isset($country) && $country!="")
                                        {
                                        ?>        
                                      <div class="form-group">
                                            <label>Country Name
                                            <span style="color: red;"></span>:</label>
                                            <input class="form-control need" id="country_name" name="country_name" label="Country Name" value="<?php  echo $country ; ?>"readonly>
                                            <span id="country_name_error" style="color: red;"></span>
                                     </div>
                                     <?php
                                        }
                                        ?>
                                        <?php
                                        if(isset($state) && $state!="")
                                        {
                                        ?>
                                        <div class="form-group">
                                            <label>State Name
                                            <span style="color: red;">*</span>:</label>
                                            <input class="form-control need" id="state" name="state" label="State Name" value="<?php  echo $state ; ?>">
                                            <span id="state_error" style="color: red;"></span>
                                        </div>
                                      <?php
                                        }
                                        ?>
                                    <button type="button" class="btn btn-success" onclick="validate_frm();">Submit</button>
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <div id="loading_img" style="display:none; float: right; margin-top: 5px;margin-right: 272px;"><img src="<?php echo base_url();?>images/facebook_loader.gif" alt=""></div>
                                    <div id="overlay_main" class="no_responce" style="display: none;"></div>
                                    </form>
                                        
                                    </div>
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
    //var editor4 = CKEDITOR.instances.article_desc.getData();
    //alert("Test");
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
    //if(editor4.search(/\S/)==-1)
    //{
    //    has_error++;
    //    document.getElementById('article_desc_error').innerHTML='Article Description is required.';
    //}
    //else
    //{
    //    document.getElementById('article_desc_error').innerHTML='';
    //}
    //
    //alert(has_error);
    
    if (has_error>0)
    {
       return false;
    }
    else
    {
        $('#overlay_main').show();
        $('#loading_img').show();
        document.state_frm.submit();
    }
}

function go_reset()
{
    window.location.href="<?php echo base_url();?>index.php/country_cont";
}
</script>
<!------------validate form------------->