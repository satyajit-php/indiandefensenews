<html>
    <head>
        <title>Facebook Login</title>
        <!--<script type="text/javascript" src="<?php echo site_url();?>/jquery.min.js"></script>-->
        <script type="text/javascript">
            $(document).ready(function(){
                $("#btnLogin").click(function(){
                    //alert("Loging in...");
                    //statusChangeCallback();
                    FB.login(function(){
                        checkLoginState();    
                    },{scope:'public_profile,email,user_friends'});
                });
            });
            
            function statusChangeCallback(response) {
            //alert("inside");
              console.log('statusChangeCallback');
              console.log(response);
              // The response object is returned with a status field that lets the
              // app know the current login status of the person.
              // Full docs on the response object can be found in the documentation
              // for FB.getLoginStatus().
              if (response.status === 'connected') {
                // Logged into your app and Facebook.
                testAPI();
              } else if (response.status === 'not_authorized') {
                // The person is logged into Facebook, but not your app.
                document.getElementById('info').innerHTML = 'Please log ' + 'into this app.';
              } else {
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
              FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
              });    
            }
          
            window.fbAsyncInit = function() {
            FB.init({
              appId      : '1426577397650699',
              cookie     : true,  // enable cookies to allow the server to access 
                                  // the session
              xfbml      : true,  // parse social plugins on this page
              version    : 'v2.3' // use version 2.1
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
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_US/sdk.js";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
          
            // Here we run a very simple test of the Graph API after login is
            // successful.  See statusChangeCallback() for when this call is made.
            var id,mail,name;
            function testAPI() {
              console.log('Welcome!  Fetching your information.... ');
              FB.api('/me', function(response) {
                console.log('Successful login for: ' + response.name);
                id=response.id;
                mail=response.email;
                name=response.name;
                console.log("Fetch: "+ id +" "+ mail +" "+ name);
                //document.getElementById("img").innerHTML="<img src='https://graph.facebook.com/"+ response.email +"/picture' width='300' height='300'>"
                document.getElementById('info').innerHTML ='Thanks for logging in, <br />' + "<br /><b>Name: </b>" + name +"<br/><b>Email: </b>"+ mail +"<br /><b>Login ID: </b>"+ id +"<br /><input type='button' value='Register' id='btnSubmit' />&nbsp;&nbsp;<input type='button' value='Logout' id='btnLogout' />";
                  /*var users=response.user_friends;
                  var indx;
                  for(indx in users){
                      document.getElementById("frnds").innerHTML+=users[indx];
                  }*/
                  //document.getElementById("frnds").innerHTML=typeof response.user_friends;
                  
                //document.getElementById('status').innerHTML =response;
                
                  $(document).ready(function(){
                      $("#btnLogout").click(function(){
                          FB.logout(function(){
                              //alert("after logout");
                              checkLoginState();
                          });
                          //alert("abc");
                      });
                      $("#btnSubmit").click(function(){
                        console.log("Submiting data.. \n: "+id +" "+ mail +" "+ name);
                        $.post("index.php/fb_login/sbmt",{uid:id,umail:mail,uname:name},function(reply,status){
                            console.log(status);
                            alert(reply);
                            //alert(status);
                        });
                      });
                  });
                
              });
              
              FB.api('/me/friends',function(resp){
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
              });
            }
        </script>
    </head>
    <body>
