<?php
class Login_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	function login_admin($table, $data)
	{
		$this->db->where('email', $data['email']);
		$this->db->where('password', $data['password']);
		$this->db->where('status', '1');
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		//die();
		$result = $query->result();
		//print_r($result);
		//echo $result[0]->status;
		//die();
		if($query->num_rows == 1)
		{
			
				$val=$query->result();
				$uid=$val[0]->id;
				//$superadmin = $result[0]->its_superadmin;
				
				$data = array(
						'uid' => $uid,
						'is_logged_in' => true
						//'is_superadmin'=> $superadmin
					);
				$session_login = $this->session->set_userdata($data);
				
				return true;
			
		}
		else
		{
			return 'wrong';
		}
	}
	
	function email_chk_admin($table, $data)
	{
		$this->db->where('email', $data['email']);
		$query = $this->db->get($table);
		//echo $this->db->last_query();
		//die();
		$result = $query->result();
		$id=base64_encode($result[0]->id);
		
		//print_r(($result[0]->id));die();
		
		$url_id = rtrim($id, '=');
		if($query->num_rows > 0)
		{
			$email = $data['email'];
			
			$link = site_url()."/login_cont/reset_password/$url_id";
			$subject = "Retrive Your Password";
			$body = "For reset password please click on this link..".$link;
			$mail = $this->left_panel_model->send_mail($email,$subject,$body);
			return true;
			
		}
		else
		{
			return false;
		}
		
	}
	
	function update_password($table,$data, $newid)
	{
	    $this->db->from($table);
	    $this->db->where('id', $newid);
            $query = $this->db->get();
	    
		//echo $this->db->last_query();
		//die();
	    
	    $reset_password1 = $query->result();
	    $email =$reset_password1[0]->email;
	    //echo $email;
	    //die();
            if($query->num_rows == 0 || $reset_password1[0]->id == $newid)
            {
                $this->db->where('id', $newid);
		$updt = $this->db->update($table, $data);
		//echo $this->db->last_query();
		//die();
                if($updt)
                {
		    $pass = $data['password'];
		    $link = base_url();
		    $subject = "Password has been reset";
		    $body = "Your password has been reset. Here is your new password:<br><br>Please click on the following link to go to the site and use the new password for login:<br><br>".$link;
            $mail = $this->left_panel_model->send_mail($email,$subject,$body);
                    return true;
                }
		else
		{
			return false;
		}
            }
            
	}
	function get_admin()
	{
		$this->db->where('id',1);
		$query=$this->db->get('admin_contact_details');
		$result=$query->result();
		return $result;
		
	}
}
?>