<!-- jQuery -->
<!-- Bootstrap Core JavaScript -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php echo base_url(); ?>assets/bower_components/metisMenu/dist/metisMenu.min.js"></script>
<!-- DataTables JavaScript -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url(); ?>assets/dist/js/sb-admin-2.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
<script src="http://select2.github.io/select2/select2-3.5.1/select2.js"></script>
<script src="<?php echo base_url(); ?>assets/js/fileinput.js"></script>
<script>
    $(document).ready(function () {
        $(".select2").select2();
        $('form').validator();
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    $(document).ready(function () {
        $('form').validator().on('submit', function (e) {
            if (e.isDefaultPrevented()) {
                // handle the invalid form...
            } else {
                // everything looks good!
                $('#overlay_main').show();
                $('#loading_img').show();
            }
        })
       
    })
</script>

</body>

</html>