<?php

class guest_post_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Log in functionality goes here
     */
    //=========fetch data from email template============//
    public function select_post($query = false) {
        $this->db->from('guest_post');
        if ($query) {
            $this->db->where("status", $query);
        }
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function guest_post_insert($data) {
        $this->db->insert('guest_post', $data);
        return $this->db->insert_id();
    }

    //=========fetch student email id from email template============//
    public function select_($id) {
        $this->db->from('guest_post');
        $this->db->where("id", $id);
        $query = $this->db->get();
        $result = $query->result();
      return $result;
    }

    //=============changin the status of news letter============//
    function change_status_to($table, $stat_param, $id) {
        $this->db->where('id', $id);
        $val = $this->db->update($table, $stat_param);
        // echo $this->db->last_query();
        // die();
        if ($val) {
            return true;
        }
    }

    //=========delete data from new letter============//
    function del_data($table, $id) {
        $this->db->where('id', $id);
        $val = $this->db->delete($table);
        // echo $this->db->last_query();
        // die();
        if ($val) {
            return true;
        }
    }

    public function get_data($table = false, $id = false) {
        if (($table) && ($id)) {
            $this->db->select("*");
            $this->db->where("id", $id);
            $query = $this->db->get($table);
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }

    //=========fetch data from email template============//
    public function get_news_letter_template() {
        $this->db->from('email_template');
        $this->db->where("email_type", "1");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    //=========send mail to subscribers============//	
    function sendmail_to($data_to_send) {
        $email_temp_id = $data_to_send['email_sub'];
        $email_arr = array();
        $mail_val = 0;

        //=====get all emails to send mail to them======//

        if ($data_to_send['send_to'] == 'selected') {
            if (strpos($data_to_send['nav_id'], ',') != -1) {
                $subscribe_id_arr = explode(',', $data_to_send['nav_id']);
                foreach ($subscribe_id_arr as $subscribe_id) {
                    $this->db->from('guest_post');
                    $this->db->where("id", $subscribe_id);
                    $this->db->where("status", '0');
                    $query = $this->db->get();
                    //echo $this->db->last_query();
                    $result = $query->result();
                    array_push($email_arr, $result[0]->email);
                }
            } else if (strpos($data_to_send['nav_id'], ',') == -1) {
                $subscribe_id = $data_to_send['nav_id'];
                $this->db->from('guest_post');
                $this->db->where("id", $subscribe_id);
                $this->db->where("status", '0');
                $query = $this->db->get();
                $result = $query->result();
                array_push($email_arr, $result[0]->email);
            }
        } else if ($data_to_send['send_to'] == 'all') {
            $this->db->from('guest_post');
            $this->db->where("status", '0');
            $query = $this->db->get();
            $result = $query->result_array();
            foreach ($result as $result_val) {
                array_push($email_arr, $result_val['email']);
            }
        }

        //$email=implode(',',$email_arr);
        $email = 'soumili.chakraborty@esolzmail.com';
        $email = trim($email);
        //echo $email;
        //die();
        //========get value of email template==============//

        $this->db->from('email_template');
        $this->db->where("id", '1');
        $query = $this->db->get();
        $email_val = $query->result();

        $subject = $email_val[0]->email_title;
        $body = $email_val[0]->email_desc;

        $command = "php  -f /var/www/esolz.co.in/public/lab4/project/cms_admin/send_backend_mail.php " . $email . " " . $subject . " " . $body;
        exec("$command", $getoutput);

        //redirect('news_letter_cont');
        //redirect();
        ////======send mail to subscribers======//
        //
		////foreach($email_arr as $email)
        ////{
        ////	//echo $email;
        //	$mail = $this->left_panel_model->send_mail('soumili.chakraborty@esolzmail.com',$subject,$body);
        //	$mail1 = $this->left_panel_model->send_mail('soumilichakraborty8@gmail.com',$subject,$body);
        //	//if($mail)
        //	//{
        //	//	$mail_val++;
        //	//}
        ////}
        //
		////if($mail_val > 0)
        ////{
        //return true;
        ////}
        ////else
        ////{
        ////	return false;
        ////}
        //die();
    }

}
?>
        
