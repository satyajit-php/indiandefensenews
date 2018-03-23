<?php
class fb_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
        
        function facebook_login_model()
	{
           
            require_once EMAIL_PATH .'/facebook/facebook.php';
			$facebook = new Facebook(array(
			    'appId'  => '1426577397650699',
			    'secret' => '04352453b3da88f40fc41941cc1688b4',
			));

		$user = $facebook->getUser();
		$token=$facebook->getAccessToken();
                //$facebook->destroySession();
            if( $user )
            {
                   $user_profile = array();
                   try{
                      // Proceed knowing you have a logged in user who's authenticated.
                      $user_profile = $facebook->api('/me');
                    }
                    catch( FacebookApiException $e )
                    {
                           error_log($e);
                             $user = null;
                   }
		if( $user_profile )
		{
		   //echo $user_profile[ 'id' ];die();
                    //existing user
                    $this->db->where('social_id', $user_profile[ 'id' ]);
                    $this->db->where('status', 1);
                    $fetch_query = $this->db->get('people');
                    
                    //echo $this->db->last_query();
                    //die();
                    if( $fetch_query->num_rows() > 0 )
		    {
			  $details=$fetch_query->row();
			  $id=$details->id;
			  //echo $id; die;
			  //return $id;
		    }
                    else
		    {
                        //print_r($user_profile);
                        //die();
                        // FOR NEW USER
//                        $gender = 0;
//                        if( $user_profile[ gender ] == 'male' ){
//                            $gender = 1;
//                        }
//                        else if( $user_profile[ gender ] == 'female' ){
//                            $gender = 2;
//                        }
//                        $birthday = "";
//                        if( array_key_exists('birthday', $user_profile) && ($user_profile[ 'birthday' ] != '') ){
//                            $birthday = date('Y-m-d', strtotime($user_profile[ 'birthday' ]));
//                        }
                        $data   = array(
                            'name'          => $user_profile[ 'name' ],
                            'email'         => $user_profile[ 'email' ],
                            'social_id'    => $user_profile[ 'id' ],
                            'last_logged_in' => date('Y-m-d'),
			    //'facebook_accesstoken'=> $token,
                            'status'        => 1
                        );
                        $result = $this->db->insert('people', $data);
                    //    echo $this->db->last_query();
                    //die();
                        
                        if( $result )
                        {
                            $new_id = $this->db->insert_id();
                            

                        }
                        
			$first_name='';
			$last_name='';
			if($user_profile['first_name']){$first_name=$user_profile['first_name'];}
			if($user_profile['last_name']){$last_name=$user_profile['last_name'];}
			$full=$user_profile['name'];
			$_SESSION["FACEBOOK_USERNAME"]=$user_profile['name'];
			$_SESSION["FACEBOOK_NAME"]=$full;
			$_SESSION["fb_id"]=$user_profile["id"];
			$_SESSION["FACEBOOK_EMAIL"]=$user_profile["email"];
			$_SESSION["FACEBOOK_ACCESS"]=$token;
			//$id="";
			//$this->db->where('facebook_id', $_SESSION["fb_id"]); // check from database wheather facebook id is exist or not
			//$q = $this->db->get('user');

			//redirect('facebook_login/facebook_login_cont');

                        
                    }
                        //$facebook->destroySession();
                    return true;
                }
                else
		{
                    return false;
                }
            }
             
	    else
            {
		 # There's no active session, let's generate one
		$login_url = $facebook->getLoginUrl(array( 'scope' => 'email user_birthday' ));
		header("Location: " . $login_url);
		?>
		<script>
		window.location = "<?php echo $login_url; ?>";
		</script>
		<?php
		exit;
	    }
	}
           
}
?>