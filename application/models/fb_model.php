<?php
class fb_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
        
    function facebook_login_model()
	{
           
		require_once PHYSICAL_PATH_FRONT .'facebook/facebook.php';
			$facebook = new Facebook(array(
			    //'appId'  => '1426577397650699',
			    //'secret' => '04352453b3da88f40fc41941cc1688b4',
			    
			    'appId'  => '832270506890682',
			    'secret' => '3cc3f593aa2b747e839d9ab100d997e7',
			));
			
			$user = $facebook->getUser();
			$token = $facebook->getAccessToken();
			
		if( $user )
		{
			$user_profile = array();
			try{
			  // Proceed knowing you have a logged in user who's authenticated.
			  $user_profile = $facebook->api('/me?fields=id,name,first_name,last_name,email,gender,birthday,hometown,address');
			}
			catch( FacebookApiException $e )
			{
				error_log($e);
				$user = null;
			}		       
		       
			if( $user_profile )
			{
				$social_id = $user_profile['id'];
				$first_name = $user_profile['first_name'];
				$last_name = $user_profile['last_name'];
				
				
				$email = $user_profile['email'];
				
				
				//existing user
				$this->db->where('social_id', $social_id);
				$this->db->where('status', 1);
				$fetch_query = $this->db->get('people');
			
				if( $fetch_query->num_rows() > 0 )
				{
					$details=$fetch_query->row();
					$user_id=$details->id;
					
					if($details->first_name=='' && $details->last_name=='')
						{
							$name= explode('@',$details->email)[0];
						}else{
						  $name= $details->first_name.' '. $details->last_name;  
						}
						
								$data = array(
									 'uid' => $user_id,
									 'is_logged_in' => true,
									 'name'=>$name,
									 'profile_pic'=>$details->profile_pic
								);	
				        $session_login = $this->session->set_userdata($data);
					return 'already_has';
				}
				else
				{
					//save profile picture from fb to our server
					$url = "https://graph.facebook.com/".$user_profile['id']."/picture?width=500&heigth=500";
					$image_name = time().'_proflie_pic.jpg';
					$save_to = PHYSICAL_PATH_FRONT.'assets/images/profile_picture/thumbnail/'.$image_name;
					copy($url,$save_to);
					if (!file_exists($save_to)) {
						$image_name='user_default.png';
					}
					
					
					$data  = array(					
							'first_name'		=> $first_name,
							'last_name'		=> $last_name,
							'email'			=> $email,
							'social_id'		=> $social_id,					
							'user_type'		=> '1',
							'profile_pic'    	=> $image_name,
							'login_type'		=> '1',
							'registered_on'		=> date('Y-m-d H:i:s'),
							'last_logged_in'	=> date('Y-m-d  H:i:s'),
							'status'		=> '1'
						);
					
					if($email != '')
					{
						$this->db->where('email', $email);
			
				                 $fetch_query = $this->db->get('people');
						 if( $fetch_query->num_rows() > 0 )
						 {
							$details=$fetch_query->row();
							$user_id=$details->id;
							$status=$details->status;
							if($status==1)
							{
								if($details->first_name=='' && $details->last_name=='')
								{
									$name= explode('@',$details->email)[0];
								}else{
								  $name= $details->first_name.' '. $details->last_name;  
								}
										
								$data = array(
										'uid' => $user_id,
										'is_logged_in' => true,
										'name'=>$name,
										'profile_pic'=>$details->profile_pic
								);
									$session_login = $this->session->set_userdata($data);
									return true;
							}
							else
								return false;
						 }
						 else
						 {
						     $result = $this->db->insert('people', $data);				    
								if( $result )
								{
								    $user_id = $this->db->insert_id();
								}
								
								if($data['first_name']=='' && $data[0]->last_name=='')
									{
										$name= explode('@',$data['email'])[0];
									}else{
									  $name= $data['first_name'].' '. $data['last_name'];  
									}
										
										$data = array(
									 'uid' => $user_id,
									 'is_logged_in' => true,
									 'name'=>$name,
									 'profile_pic'=>$data['profile_pic']
								);
								
							  $session_login = $this->session->set_userdata($data);
							  return true;
						 }
				
					}
					else
					{
						$data = array(					
								'first_name'		=> $first_name,
								'last_name'		=> $last_name,
								'social_id'		=> $social_id,					
								'user_type'		=> '1',
								'profile_pic'    	=> $image_name,
								'login_type'		=> '1',
								'registered_on'		=> date('Y-m-d H:i:s'),
								'last_logged_in'	=> date('Y-m-d  H:i:s'),
								'status'		=> '1'
							);
						return $data;
					}
				}
				//$facebook->destroySession();
			}
			else
			{
			    return false;
			}
		}		 
		else
		{
		     # There's no active session, let's generate one
		     //email,read_stream,publish_stream,user_birthday,user_location,user_work_history,user_hometown,user_photos
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