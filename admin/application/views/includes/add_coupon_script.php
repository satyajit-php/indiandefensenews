<!------------validate form------------->
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script>
$(function() {
$( "#s_date" ).datepicker({dateFormat: "yy-mm-dd",
                          onClose: function( selectedDate ) {
                                                $( "#e_date" ).datepicker( "option", "minDate", selectedDate );
                                              }
                          });
$( "#e_date" ).datepicker({dateFormat: "yy-mm-dd"});
});



</script>
<!------------validate form------------->