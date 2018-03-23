 <?php
 class google_login_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
        function google_login_here()
        {
            //echo EMAIL_PATH;
            //die();
            ########## Google Settings.. Client ID, Client Secret from https://cloud.google.com/console #############
	       
			require_once EMAIL_PATH.'/google_login/src/Google_Client.php';
			require_once EMAIL_PATH.'/google_login/src/contrib/Google_Oauth2Service.php';
            $google_client_id     = '710047919217-8kb0r6isar7af7l4bfoc06moiko6o4ik.apps.googleusercontent.com';
            $google_client_secret = 'Qn4QKsH0_rmaNwO6EjRohZno';
            $google_redirect_url  = site_url().'/google_plus_login/google_login_cont'; //path to your script
            $google_developer_key = 'AIzaSyCtQed9QdTxjsJdYY1Ie7ps4yw6P0YW6fc';
            $gClient = new Google_Client();
            $gClient->setApplicationName('Login to Sanwebe.com');
            $gClient->setClientId($google_client_id);
            $gClient->setClientSecret($google_client_secret);
            $gClient->setRedirectUri($google_redirect_url);
            $gClient->setDeveloperKey($google_developer_key);
	   // $gClient->addScope("https://www.googleapis.com/auth/userinfo.email");
	    $gClient->setScopes("https://www.googleapis.com/auth/userinfo.email");
	    $gClient->setScopes("https://www.googleapis.com/auth/plus.login");
	   // $gClient->setScopes(" https://www.googleapis.com/auth/plus.me");
	   //  $gClient->setScopes(array('https://www.googleapis.com/auth/userinfo.email',
		// 'https://www.googleapis.com/auth/plus.me'));      // Important!
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            //$google_oauthV3 = new Google_Tokeninfo($gClient);
           
            
            //$google_oauthV4 = new Google_Userinfo($gClient);
            
            //If user wish to log out, we just unset Session variable
            
          
         
           //echo($gClient->getAccessToken());
           //die();
           
           //echo "<pre>";
           //print_r($google_oauthV2->userinfo->get());
           //die();
           
            if( isset($_REQUEST[ 'reset' ]) )
            {
                //unset($_SESSION['token']);
                $this->session->unset_userdata('token');
                $gClient->revokeToken();
                header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
            }

            //If code is empty, redirect user to google authentication page for code.
            //Code is required to aquire Access Token from google
            //Once we have access token, assign token to session variable
            //and we can redirect user back to page and login.
            //echo $_SESSION['token'];
            //die();
	  
            if( isset($_GET[ 'code' ]) )
            {
                $gClient->authenticate($_GET[ 'code' ]);
                $_SESSION['token'] = $gClient->getAccessToken();
		        //echo $_SESSION['token']; die();
                $this->session->set_userdata('token', $gClient->getAccessToken());
                //header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
                //return;
            }

            if( $this->session->userdata('token') != '' )
            {
                //echo "bvjhbhjkhnjkjk";die();
                $gClient->setAccessToken($this->session->userdata('token'));
            }

            //echo $gClient->getAccessToken();
            //die();
			if( $gClient->getAccessToken())
			{
			   //echo "bfgjkfhngjhkjnhgj";
			   //die();
			   
			   
			   //For logged in user, get details from google using access token
			   $user                = $google_oauthV2->userinfo->get();
			   $user_id             = $user[ 'id' ];
			   $user_name           = filter_var($user[ 'name' ], FILTER_SANITIZE_SPECIAL_CHARS);
			   $family_name         = filter_var($user[ 'family_name' ], FILTER_SANITIZE_SPECIAL_CHARS);
			   $given_name          = filter_var($user[ 'given_name' ], FILTER_SANITIZE_SPECIAL_CHARS);
			   //  $gender              = filter_var($user[ 'gender' ], FILTER_SANITIZE_SPECIAL_CHARS);
			   //$email               = filter_var($user[ 'email' ], FILTER_SANITIZE_EMAIL);
			   $profile_url         = filter_var($user[ 'link' ], FILTER_VALIDATE_URL);
			   $profile_image_url   = filter_var($user[ 'picture' ], FILTER_VALIDATE_URL);
			   //$personMarkup        = "$email<div><img src='$profile_image_url?sz=50'></div>";
			   $_SESSION[ 'token' ] = $gClient->getAccessToken();
			   
			   //		echo"<pre>";
			   //              print_r($user);die;
			   //existing user
			   $this->db->where('social_id',$user_id);
			   $this->db->where('status', 1);
			   $fetch_query = $this->db->get('people');
			   if( $fetch_query->num_rows() > 0 )
			   {
			   $details=$fetch_query->row();
			   $id=$details->id;
			   //echo $id; die;
			   return $id;
			   }
			   else
			   {
			   $data   = array(
			   'name'          => $user[ 'name' ],
			   'social_id'    => $user[ 'id' ],
			   'last_logged_in' => date('Y-m-d'),
			   //'facebook_accesstoken'=> $token,
			   'status'        => 1
			   );
			   $result = $this->db->insert('people', $data);
			   //    echo $this->db->last_query();
			   //die();
			   
			   $_SESSION["GOOGLE_NAME"]=$user_name;
			   $_SESSION["google_id"]=$user_id;
			   
			   //$_SESSION["FACEBOOK_EMAIL"]=$user_profile["email"];
			   //$_SESSION["GOOGLE_ACCESS"]=$token;
			   redirect('google_plus_login/google_login_cont');
			   }
			}
            else{
                $authUrl = $gClient->createAuthUrl();
               }
			   if(isset($authUrl)) //user is not logged in, show login button
			   {
			     redirect($authUrl);
			   }
        }
 }
        ?>