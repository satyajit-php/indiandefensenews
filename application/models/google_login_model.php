 <?php
 class google_login_model extends CI_Model {

       function __construct()
       {
	      parent::__construct();
       }
	  function google_login_here($user)
	  {
	      $social_id = $user[ 'id' ];
	      $email_id = $user['email'];
	      $profile_image_url = $user[ 'picture' ];
	      $gender_val = $user[ 'gender' ];
	      $name = $user[ 'given_name' ].' '.$user[ 'family_name' ];
	      
	      //existing user
	      $this->db->where('email', $email_id);
	      $this->db->where('status', 1);
	      $fetch_query = $this->db->get('people');
	      if( $fetch_query->num_rows() > 0 )
	      {
			$details=$fetch_query->row();
			$user_id=$details->id;
			$name = $details->first_name . " " . $details->last_name;
			$profile_image_url = $details->profile_pic;
			
			$this->session->set_userdata('uid', $user_id);
			$this->session->set_userdata('is_logged_in',true);
			$this->session->set_userdata('name', $name);
			$this->session->set_userdata('profile_pic', $profile_image_url);
		     
			$data = array(					
			      'first_name'		=> $user[ 'given_name' ],
			      'last_name'		=> $user[ 'family_name' ],
			      'social_id'		=> $user[ 'social_id' ]
			);
			
			$this->db->where('id', $user_id);
			$fetch_query = $this->db->get('people');
			if($fetch_query->num_rows() == 0)
			{
			$results=$this->db->update('people', $data);
			}
			return 'already_has';
	      }
	      else
	      {
		     //save profile picture from fb to our server
			$image_name = time().'_proflie_pic.jpg';
			$save_to = PHYSICAL_PATH_FRONT.'assets/images/profile_picture/thumbnail/'.$image_name;
			copy($profile_image_url,$save_to);
			 
			if (!file_exists($save_to)) {
						$image_name='user_default.png';
					}
		      
		     if($gender_val == 'female')
		     {
			    $gender = 0;
		     }
		     else
		     {
			    $gender = 1;
		     }
			
		     $data  = array(					
					  'first_name'		=> $user[ 'given_name' ],
					  'last_name'		=> $user[ 'family_name' ],
					  'social_id'		=> $user[ 'social_id' ],
					  'user_type'		=> '1',
					  'gender'		=> $gender,
					  'email' 		=> $user[ 'email' ],
					  'profile_pic'    	=> $image_name,
					  'login_type'		=> '2',
					  'registered_on'	=> date('Y-m-d H:i:s'),
					  'last_logged_in'	=> date('Y-m-d H:i:s'),
					  'status'		=> '1'
				   );
		     $insrt_data = $this->insert_data($data);
		     if($insrt_data)
		     {
			   
			    return true;
		     }
	      }
       }
       
       function insert_data($data)
       {
	      $social_id = $data['social_id'];
	      
	      //existing user
	      $this->db->where('email',$data['email']);
	     
	      $fetch_query = $this->db->get('people');
	      if( $fetch_query->num_rows() > 0 )
	      {
		     $details=$fetch_query->row();
		     $user_id=$details->id;
		     $status=$details->status;
	      }
	      else
	      {
		     $insrt_data = $this->db->insert('people', $data);
		     if($insrt_data)
		     {
			    $user_id = $this->db->insert_id();
			    $status=1;
		     }
	      }
	      if($status==1)
	      {
			if($data['first_name']=='' && $data[0]->last_name=='')
				  {
					  $name= explode('@',$user_profile[0]->email)[0];
				  }else{
					$name= $data['first_name'].' '. $data['last_name'];  
				  }
			
			$this->session->set_userdata('uid', $user_id);
				$this->session->set_userdata('is_logged_in',true);
				$this->session->set_userdata('name',$name);
				$this->session->set_userdata('profile_pic',$data['profile_pic']);
	         return true;  
	      }
	      else{                         // if the user email id blocked
		   return false;
	      }
	      
       }
}
?>