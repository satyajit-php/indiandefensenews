<?php
class google_plus_login extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->model('google_login_model');	//loading model
	}
	function index()
	{
		$this->load->view('includes/header');
	}
	function google_login_cont()
	{
		########## Google Settings.. Client ID, Client Secret from https://cloud.google.com/console #############	       
		require_once PHYSICAL_PATH_FRONT.'google_login/src/Google_Client.php';
		require_once PHYSICAL_PATH_FRONT.'google_login/src/contrib/Google_Oauth2Service.php';
		require_once PHYSICAL_PATH_FRONT.'google_login/src/contrib/Google_PlusService.php';
		
		
		$google_client_id     = '343976466781-5846n60lbepq74a3sreccrahsklcmqct.apps.googleusercontent.com';
		//$google_client_id     = '244082345999-o6m8f1pmb1e76tjfj9v7b96j31e53ps5.apps.googleusercontent.com';
		$google_client_secret = 'cfFRHKB-ZSIME9fuw742NX-V';
		//$google_client_secret = 'fnhqHhkzWrX-mtFQ4PRdMoy0';
		
		$google_redirect_url  = base_url().'google_plus_login/google_login_cont'; //path to your script
		$google_developer_key = 'AIzaSyDkLm4IGAgs94PfdaCg7OxrmYojSDUb-lo';
		
		$gClient = new Google_Client();
		$gClient->setApplicationName('Credit Monk');
		$gClient->setClientId($google_client_id);
		$gClient->setClientSecret($google_client_secret);
		$gClient->setRedirectUri($google_redirect_url);
		$gClient->setDeveloperKey($google_developer_key);
		
		$gClient->setScopes(array('https://www.googleapis.com/auth/plus.login', 'https://www.googleapis.com/auth/userinfo.email'));
		
		$plus = new Google_PlusService($gClient);
		$google_oauthV2 = new Google_Oauth2Service($gClient);
		
		if( isset($_REQUEST[ 'reset' ]) )
		{
		    $this->session->unset_userdata('token');
		    $gClient->revokeToken();
		    header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL)); //redirect user back to page
		}
		
		if( isset($_GET[ 'code' ]) )
		{
		       $gClient->authenticate($_GET[ 'code' ]);
		       $_SESSION['token'] = $gClient->getAccessToken();
		       $this->session->set_userdata('token', $gClient->getAccessToken());
		}
	      
		if( $this->session->userdata('token') != '' )
		{
		    $gClient->setAccessToken($this->session->userdata('token'));
		}
	     
		if( $gClient->getAccessToken())
		{
		       //For logged in user, get details from google using access token
			$user	= $google_oauthV2->userinfo->get();
		       //echo "<pre>";
		       //print_r($user);
		       //die();
			if($user['email'] != '')
			{
				$data_arr = array(
						'social_id'           => $user[ 'id' ],
						'user_name'           => filter_var($user[ 'name' ], FILTER_SANITIZE_SPECIAL_CHARS),
						'family_name'         => filter_var($user[ 'family_name' ], FILTER_SANITIZE_SPECIAL_CHARS),
						'given_name'          => filter_var($user[ 'given_name' ], FILTER_SANITIZE_SPECIAL_CHARS),
						'gender_val'          => filter_var($user[ 'gender' ], FILTER_SANITIZE_SPECIAL_CHARS),
						'email'               => filter_var($user[ 'email' ], FILTER_SANITIZE_EMAIL),
						'profile_url'         => filter_var($user[ 'link' ], FILTER_VALIDATE_URL),
						'profile_image_url'   => filter_var($user[ 'picture' ], FILTER_VALIDATE_URL)
						);
				$_SESSION[ 'token' ] = $gClient->getAccessToken();
				
				$data = $this->google_login_model->google_login_here($data_arr);
				
				if($data == 1)
				{	
				     
						$this->session->set_userdata('success_msg', 'Register successfully');
						redirect('account_settings/index');		
				}
				elseif($data == 'already_has'){
					redirect('account_settings/index');
				}
				else{
				                $this->session->set_userdata('error_msg', 'Your google plus email id blocked by admin.');
						redirect('home');		
				}
			}
			else
			{
				$data['get_data'] = array(
						'social_id'           => $user[ 'id' ],
						'user_name'           => filter_var($user[ 'name' ], FILTER_SANITIZE_SPECIAL_CHARS),
						'family_name'         => filter_var($user[ 'family_name' ], FILTER_SANITIZE_SPECIAL_CHARS),
						'given_name'          => filter_var($user[ 'given_name' ], FILTER_SANITIZE_SPECIAL_CHARS),
						'gender_val'          => filter_var($user[ 'gender' ], FILTER_SANITIZE_SPECIAL_CHARS),
						'profile_url'         => filter_var($user[ 'link' ], FILTER_VALIDATE_URL),
						'profile_image_url'   => filter_var($user[ 'picture' ], FILTER_VALIDATE_URL)
					);
				
				$this->load->view('includes/header');
				$this->load->view('includes/intermideate_email', $data);
				$this->load->view('includes/footer');
			}
		}
		else
		{
		       $authUrl = $gClient->createAuthUrl();
		}
		if(isset($authUrl)) //user is not logged in, show login button
		{
		       redirect($authUrl);
		}
	}
	function register_here()
	{
		$fname = $this->input->post('fname');
		$lname = $this->input->post('lname');
		$social_id = $this->input->post('social_id');
		$gender = $this->input->post('gender');
		$prof_img = $this->input->post('prof_img');
		$login_type = $this->input->post('login_type');
		$email_reg = $this->input->post('email_reg');
		
		$data  = array(					
				'first_name'	=> $fname,
				'last_name'		=> $lname,
				'social_id'		=> $social_id,					
				'user_type'		=> '1',
				'gender'		=> $gender,
				'email' 		=> $email_reg,
				'profile_pic'    	=> $prof_img,
				'login_type'	=> $login_type,
				'registered_on'	=> date('Y-m-d H:i:s'),
				'last_logged_in'	=> date('Y-m-d H:i:s'),
				'status'		=> '1'
			      );
				
		$insrt_val = $this->google_login_model->insert_data($data);
		if($insrt_val)
		{
		       $this->session->set_userdata('success_msg', 'Register successfully');
		       redirect('account_settings/index');
		}
	}
}
        ?>