<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Add New Slider Image</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Fields marked with <span style="color: red;">*</span> are mandatory
                    <a href="<?php echo site_url(); ?>/slider_con" style="color: white;"><button type="button" class="btn btn-primary btn-sm" style="float: right; margin-top: -5px;">
                            Back
                        </button></a>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-6">
                            <form role="form" id="blog_frm" name="blog_frm" method="POST" action="<?php echo base_url(); ?>index.php/slider_con/insert_image" enctype="multipart/form-data">
                                <input type="hidden" id="mode_blog" name="mode_blog" value="insert_blog"/>
                                <div class="form-group">
                                    <label><span style="color: red;">*</span>Tagline</label>
                                    <input class="form-control need"  name="tagline" label="Tagline">
                                    <span id="city_error" style="color: red;"></span>
                                </div>
                                <div class="form-group">
                                    <label><span style="color: red;">*</span> Image :</label>

                                    <input type="file" class="form-control need file" id="featured-img" name="attachment_file" label="Slider Image" style= "margin-top: 15px;"  >
                                    <span  id="img_error" style="color: red;"></span>
                                    <span id="attachment_file_error" style="color: red;"></span>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <span style="color: red;">*</span>Status :</label>
                                       <!-- <input class="form-control need" id="faq_typ_name" name="faq_typ_name" label="FAQ Type Name">-->

                                    <select class="form-control need" id="status" name="status" label="Status" required>
                                        <option value="">Select Status</option>   
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>


                                    <span id="status_error" style="color: red;"></span>
                                </div>

                                <!--<div class="form-group">
                                    <label>Image</label>
                                    <input type="file">
                                </div>-->

                                <button type="button" class="btn btn-success" id="upload">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                                <div id="loading_img" style="display:none; float: right; margin-top: 5px;margin-right: 272px;"><img src="<?php echo base_url(); ?>images/facebook_loader.gif" alt=""></div>
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

    function go_reset()
    {
        window.location.href = "<?php echo base_url(); ?>index.php/slider_con";
    }


    $(function () {
        $("#upload").bind("click", function () {
            //Get reference of FileUpload.

            var has_error = 0;

            $('.need').each(function () {
                element_id = $(this).attr('id');
                element_value = $(this).val();
                element_label = $(this).attr('label');
                error_div = $("#" + element_id + "_error")
                //alert(element_id);
                if (element_value.search(/\S/) == -1)
                {
                    has_error++;
                    error_div.html(element_label + ' is required.');
                } else
                {
                    error_div.html('');
                }
            });

            if (has_error > 0)
            {
                return false;
            } else
            {
                var fileUpload = $("#featured-img")[0];
                //Check whether the file is valid Image.
                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
                if (regex.test(fileUpload.value.toLowerCase())) {
                    //Check whether HTML5 is supported.
                    if (typeof (fileUpload.files) != "undefined") {
                        //Initiate the FileReader object.
                        var reader = new FileReader();
                        //Read the contents of Image File.
                        reader.readAsDataURL(fileUpload.files[0]);
                        reader.onload = function (e) {
                            //Initiate the JavaScript Image object.
                            var image = new Image();
                            //Set the Base64 string return from FileReader as source.
                            image.src = e.target.result;
                            image.onload = function () {
                                //Determine the Height and Width.
                                var height = this.height;
                                var width = this.width;
                                if (height < 500 || width < 1200) {
                                    $('#img_error').html("Image size should not less than 1200x800.");
                                    return false;
                                }
                                $('#img_error').html(" ");
                                //						  $('#overlay_main').show();
                                //                          $('#loading_img').show();
                                document.blog_frm.submit();
                                //return true;
                            };
                        }
                    } else {
                        $('#img_error').html("This browser does not support HTML5.");
                        return false;
                    }
                } else {
                    $('#img_error').html("Please select a valid Image file.");
                    return false;
                }
            }
        });
    });
</script>

</script>





<!------------validate form------------->