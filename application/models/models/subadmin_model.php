<?php
class Subadmin_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	//=========fetch all subadmins from admin============//
	public function fetch_subadmin()  
	{  
            $this->db->from('admin');
            $this->db->where("its_superadmin", "0");
            $this->db->order_by("id", "DESC");
            $query = $this->db->get();
            $result= $query->result();
            return $result;
	}
        
        //=============changing the status of subadmin============//
	function change_status_to($table, $stat_param, $id)
	{
            $this->db->where('id', $id);
            $val = $this->db->update($table, $stat_param);
            // echo $this->db->last_query();
            // die();
            if($val)
            {
                return true;
            }
	}

	//=============delete subadmin from admin============//
	function del_data($table, $id)
	{
            $this->db->where('id', $id);
            $val = $this->db->delete($table); 
            // echo $this->db->last_query();
            // die();
            if($val)
            {
                return true;
            }
	}
        
        //=========================insert sub admin========================//
        function insert_subadmin($table,$data_to_store)
        {
            $this->db->from('admin');
            $this->db->where('email', $data_to_store['email']);
            $this->db->or_where('uname', $data_to_store['uname']);
            $query = $this->db->get();
	    $admin_val = $query->result();
	    //echo $admin_val[0]->uname .'=='. $data_to_store['uname'].'=='.$admin_val[0]->email.'=='. $data_to_store['email'].'=='.$query->num_rows;
	    //die();
	    
            if($query->num_rows == 0)
            {
                $insrt = $this->db->insert($table,$data_to_store);
                if($insrt)
                {
		    $email = $data_to_store['email'];
		    $uname = $data_to_store['uname'];
		    $pass = $data_to_store['password'];
		    
		    $link = site_url()."/subadmin_cont";
		    $subject = "You are chossen as subadmin of our site";
		    $body = "Congratulation! You are chossen as subadmin of our site. Here is your credentials:<br><br>Username: ".$uname."<br>Password: ".$pass."<br><br>Please click on the following link to go to the site and use the given credentials for login:<br><br>".$link;
                    $mail = $this->left_panel_model->send_mail($email,$subject,$body);
		    return true;
                }
            }
            else if($admin_val[0]->uname == $data_to_store['uname'] && $admin_val[0]->email == $data_to_store['email'])
            {
                return 'both';
		//echo $admin_val[0]->uname.'=='. $data_to_store['uname'];
		//die();
            }
	    else if($admin_val[0]->uname == $data_to_store['uname'])
            {
                return 'username';
		//echo $admin_val[0]->uname.'=='. $data_to_store['uname'];
		//die();
            }
	    else if($admin_val[0]->email == $data_to_store['email'])
            {
                return 'email';
            }
        }
	
	//=========================get data from sub admin========================//
        function get_subadmin($id)
	{
	    $this->db->from('admin');
	    $this->db->where("id", $id);
            $query = $this->db->get();
            $result= $query->result();
            return $result;
	}
	
	//=========================update sub admin========================//
        function update_subadmin($table,$data,$id)
        {
            $this->db->from($table);
            $this->db->where('email', $data['email']);
            $this->db->or_where('uname', $data['uname']);
            $query = $this->db->get();
	    
		//echo $this->db->last_query();
		//die();
	    
	    $admin_val = $query->result();
            if($query->num_rows == 0 || $admin_val[0]->id==$id)
            {
                $this->db->where('id', $id);
		$updt = $this->db->update($table, $data);
		//echo $this->db->last_query();
		//die();
                if($updt)
                {
		    $email = $data['email'];
		    $uname = $data['uname'];
		    $pass = $data['password'];
		    
		    $link = site_url()."/subadmin_cont";
		    $subject = "Credentials of our site has been changed";
		    $body = "Your credentials of our site has been changed. Here is your new credentials:<br><br>Username: ".$uname."<br>Password: ".$pass."<br><br>Please click on the following link to go to the site and use the given credentials for login:<br><br>".$link;
                    $mail = $this->left_panel_model->send_mail($email,$subject,$body);
                    return true;
                }
            }
            else if($admin_val[0]->uname == $data['uname'] && $admin_val[0]->email == $data['email'] && $admin_val[0]->id!=$id)
            {
                return 'both';
            }
	    else if($admin_val[0]->uname == $data['uname'] && $admin_val[0]->id!=$id)
            {
                return 'username';
            }
	    else if($admin_val[0]->email == $data['email'] && $admin_val[0]->id!=$id)
            {
                return 'email';
            }
        }
}
?>