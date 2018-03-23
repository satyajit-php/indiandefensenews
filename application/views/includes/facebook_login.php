<script type="text/javascript">

	var fb_bt_clecked = 'false';
	
	//use to store value in db after getting fb details.	
	function get_email(fname, fmail)
	{
		//$('#fb_form').attr('action','<-?php echo base_url();?>index.php/fb_login/signup');
						
		//check email is avilable or not of fb user
		if($('#fb_email').val() == '')
		{
			// close the login popup if open
			if($('#f_mod').val() == 'lg')
			{
				$('#log_cl_bt').click();
			}
			
			//clise the registration popup if open
			if($('#f_mod').val() == 'rg')
			{
				$('#reg_cl_bt').click();
			}
			
						
			// to open the popup fro fb regestration
			$('#fbrgfrm').click();
			return false;			
		}
		
		send_data = 'fb_name='+fname+'&fb_email='+fmail;
		
		//alert(send_data);
		
		if(fb_bt_clecked == 'true')
		{		
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>index.php/fb_login/f_sinup',
				data: send_data,			
				success: function(data)
				{
					//alert('data>'+data);
					var r_vl = data.trim();		
					
					 window.location = "<?php echo base_url().'index.php/home' ?>";
				}
			})
		}
	}
	
	//use to check the email for fb login and registration
	function check_fb_email()
	{
		var name = $('#fb_name').val();
		var email=$('#fb_email').val();
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			
		if(email.search(/\S/)==-1)
		{
			//alert("test");
			has_error++;
		    $('#fb_email_error').html('Enter your valid email id');
		    $('#fb_email_error').show();
		}
		else if(!filter.test(email))
		{
			//alert("test1");
			has_error++;
		    $('#fb_email_error').html('Please provide a valid email address');
		    $('#fb_email_error').show();
		}
		else
		{
		    $('#fb_email_error').html('');
		    $('#fb_email_error').hide();
		    
		    // submit the value using ajax
		    get_email(name, email);
		}
	}
	
 	// =================================Use to facebook login=============================//	
 	$(document).ready(function(){
 		//use facebook button of login section 
	    $("#fb_log").click(function(){
	    	
	    	fb_bt_clecked = 'true';
	    	    	         
	        FB.login(function(){
	            checkLoginState();    
	        },{scope:'public_profile,email,user_friends'});
	    });
	    
	    // use facebook button of registratio section
	    $("#fb_reg").click(function(){
	    	
	    	fb_bt_clecked = 'true';
	    	
	        FB.login(function(){
	            checkLoginState();    
	        },{scope:'public_profile,email,user_friends'});
	    });
	   	    
	     // use to loguot from site and facebook
	     $(".fblog_out").click(function(){	     	
		     FB.logout(function(response) {
			  // user is now logged out			  
			  window.location = "<?php echo base_url().'index.php/home/logout' ?>";
			});
		});
	    
	});
	
	function statusChangeCallback(response)
	{
		
		//alert(1+'<statusChangeCallback');
		
		// show the loader
		if(fb_bt_clecked == 'true')
		{
			$('.d_loader').show();
		}
		
		
	  	console.log('statusChangeCallback');
	  	console.log(response);
	  	
	  	// The response object is returned with a status field that lets the
	  	// app know the current login status of the person.
	  	// Full docs on the response object can be found in the documentation
	  	// for FB.getLoginStatus().
	  	
	  	//alert('response.status>>'+response.status);
	  	if (response.status === 'connected')
	  	{
	    	// Logged into your app and Facebook.
	    	//alert('goto to testapi>');
	    	testAPI();
	    	
	 	} else if (response.status === 'not_authorized')
	 	{
	    	// The person is logged into Facebook, but not your app.
	    	document.getElementById('info').innerHTML = 'Please log ' + 'into this app.';
	    	
	    	$('.d_loader').hide();
	    	
	  	} else{
	  		
	  		 $('.d_loader').hide();
	  		 
	    	// The person is not logged into Facebook, so we're not sure if
	   		// they are logged into this app or not.
	    	document.getElementById('info').innerHTML = 'Please log ' + 'into Facebook.';
	  		document.getElementById("img").innerHTML="";
	  		document.getElementById("frnds").innerHTML="";
      }   
      
    }
	  
    
    // This function is called when someone finishes with the Login
	// Button.  See the onlogin handler attached to it in the sample
	// code below.
    
    function checkLoginState() {
    	
    	//alert(2+'<checkLoginState');
    	
   		FB.getLoginStatus(function(response) {
			statusChangeCallback(response);
		});    
    }	
	
	var fdappid = $('#fbappid').val();
	//alert('fdappid>'+fdappid);
    window.fbAsyncInit = function() {
	    FB.init({
     		appId      : fdappid, //1855551681336898
	  		cookie     : true,  // enable cookies to allow the server to access  //
	                      // the session
	 		xfbml      : true,  // parse social plugins on this page
	  		version    : 'v2.0' // use version 2.1
	    });
	  
	    // Now that we've initialized the JavaScript SDK, we call 
		// FB.getLoginStatus().  This function gets the state of the
		// person visiting this page and can return one of three states to
		// the callback you provide.  They can be:
		//
		// 1. Logged into your app ('connected')
		// 2. Logged into Facebook, but not your app ('not_authorized')
		// 3. Not logged into Facebook and can't tell if they are logged into
		//    your app or not.
		//
		// These three cases are handled in the callback function.
	  
	    FB.getLoginStatus(function(response) {
	      statusChangeCallback(response);
	    });	  
    };
	  
    // Load the SDK asynchronously
	(function(d, s, id) {
		
		//alert(3+'<Load the SDK asynchronously');
	  	var js, fjs = d.getElementsByTagName(s)[0];
	  	if (d.getElementById(id)) return;
	  	js = d.createElement(s); js.id = id;
	  	js.src = "//connect.facebook.net/en_US/sdk.js";
	  	fjs.parentNode.insertBefore(js, fjs);
	  	
	}(document, 'script', 'facebook-jssdk'));
	  
    // Here we run a very simple test of the Graph API after login is
	// successful.  See statusChangeCallback() for when this call is made.
	var id,mail,name;
	function testAPI()
	{
		//alert('testAPI1');
		
	 	console.log('Welcome!  Fetching your information.... ');
	 	
	 	var respo_count = 0;
	 	
	  	FB.api('/me', function(response)
	  	{
	  		//alert(4);
	    	console.log('Successful login for: ' + response.name);
	    	id=response.id;
	   		mail=response.email;
	    	name=response.name;
	    	console.log("Fetch: "+ id +" "+ mail +" "+ name);
	    	
	    	//document.getElementById("img").innerHTML="<img src='https://graph.facebook.com/"+ response.email +"/picture' width='300' height='300'>"
	    	document.getElementById('info').innerHTML ='Thanks for logging in, <br />' + "<br /><b>Name: </b>" + name +"<br/><b>Email: </b>"+ mail +"<br /><b>Login ID: </b>"+ id +"<br /><input type='button' value='Register' id='btnSubmit' />&nbsp;&nbsp;<input type='button' value='Logout' id='btnLogout' />";
	      
	      	$('#fb_name').val(name);
	      	$('#fb_email').val(mail);
	      	    
	      	$(document).ready(function()
	      	{	      		
	       		$("#btnLogout").click(function(){
	              FB.logout(function(){
	                  checkLoginState();
	              });
	          	});
	          
	         	$("#btnSubmit").click(function(){
	            	console.log("Submiting data.. \n: "+id +" "+ mail +" "+ name);
	            	$.post("index.php/fb_login/sbmt",{uid:id,umail:mail,uname:name},function(reply,status){
	               		console.log(status);
	            	});
	          	});
	      	});
	      	
	      	respo_count++;
	      	if(respo_count == 3 )
		  	{		  		
		  		get_email(name,mail);
		  	}
	    
	  	});
	  
	  	FB.api('/me/friends',function(resp){
	  		
	  		//alert(5);
	      	//document.getElementById('frnds').innerHTML=resp.data[0];
	      	//var friends=resp;
	     	//var friends={a:"Dibyendu",b:"Das"};
	     	//document.getElementById('frnds').innerHTML=resp.data[0].name;
	     	
	     	console.log('Got friends: ', resp.data);
	     	//alert(resp.data[0].name);
	      	//var ind;
	      	
	     	for(ind in resp.data){
	          //document.getElementById('frnds').innerHTML+=friends[ind];
	          //document.getElementById('frnds').innerHTML=typeof friends;
	          document.getElementById('frnds').innerHTML+=resp.data[ind].name+"<br />";
	          //alert(ind);
	      	}
	      	
	      	respo_count++;
	      	if(respo_count == 3 )
		  	{
		  		get_email(name,mail);
		  	}
	  	});
	  
	  	FB.api("/me/picture?width=180&height=180",  function(rspns) {
	  		
	          var profileImage = rspns.data.url.split('https://')[1]; //remove https to avoid any cert issues
	          //randomNumber = Math.floor(Math.random()*256);
	   
	         //remove if there and add image element to dom to show without refresh
	     	/*if( $fbPhoto.length ){
	         $fbPhoto.remove();
	     	}*/
	       //add random number to reduce the frequency of cached images showing
	     	/*$photo.append('<img class=\"fb-photo img-polaroid\" src=\"http://' + profileImage + '?' + randomNumber + '\">');
	      	$btn.addClass('hide');*/
	      	
	     	document.getElementById("img").innerHTML="<img src=\'http://" + profileImage + "\'>";
	     	$("#fb_img").val('http://'+profileImage)
	     	
	     	respo_count++;
	     	if(respo_count == 3 )
		  	{
		  		get_email(name,mail);
		  	}
	  	});
	  	
	  	
	}
</script>