<?php

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Log in functionality goes here
     */
    function login_admin($table, $data) {
        $this->db->where('uname', $data['uname']);
        $query = $this->db->get($table);
        $result = $query->result();

        if ($query->num_rows == 1) {
            if ($result[0]->status == 1) {
                return 'block';
            } else if ($this->encrypt->decode($result[0]->password) == $data['password']) {
                $val = $query->result();
                $uid = $val[0]->id;
                $superadmin = $result[0]->its_superadmin;

                $data = array(
                    'admin_uid' => $uid,
                    'admin_is_logged_in' => true,
                    'admin_is_superadmin' => $superadmin
                );
                $session_login = $this->session->set_userdata($data);

                return true;
            } else {
                return 'wrong';
            }
        } else {
            return 'wrong';
        }
    }

    function login_forgotpass($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('admin');
        if ($query->num_rows == 1) {
            $val = $query->result();
            $uid = $val[0]->id;
            $superadmin = $val[0]->its_superadmin;

            $data = array(
                'uid' => $uid,
                'is_logged_in' => true,
                'is_superadmin' => $superadmin
            );
            $session_login = $this->session->set_userdata($data);

            return 1;
        }
    }

    function mail_id($table, $data) {     //  check mail id exists or not
        $this->db->where('email', $data['email']);
        $query = $this->db->get($table);
        $result = $query->result();
        if ($query->num_rows == 1) {
            return 1;
        } else
            return 0;
    }

    function email_chk_user($table, $data) {
        $this->db->where('email', $data['email']);
        $query = $this->db->get($table);
        $result = $query->result();
        $id = $result[0]->id;

        //$url_id = rtrim($id, '=');
        $code = rand(000000, 999999);
        $sc = array('security_code' => $code);
        $p = base_url();
        $p = str_replace('/admin', '', $p);
        $logo = $p . "assets/images/logo.png";
        $path = base_url() . 'index.php/login_cont/getact/' . $code;
        $link = "<a href='" . $path . "'>
					<button style='border-radius: 6px;font-size: 18px;line-height: 1.33333;padding: 10px 16px;background-color: #5cb85c;border-color: #4cae4c;color: #fff;'>
						Retrive Your Password
					</button>
				</a>";
        if ($query->num_rows > 0) {
            $this->db->where('id', '1');
            $query = $this->db->get('site_settings');
            $result_settings = $query->result();
            $site_name = $result_settings[0]->site_name;
            $email_admin = $result_settings[0]->admin_email;

            $this->db->where('id', $id);
            $query = $this->db->get('admin');
            $result_admin = $query->result();
            $uname = $result_admin[0]->uname;
            $email_user = $result_admin[0]->email;

            $this->db->where('id', '7');
            $query1 = $this->db->get('email_template');
            $result1 = $query1->result();
            $email_title1 = $result1[0]->email_title;
            $email_desc1 = $result1[0]->email_desc;
            $email_plcholders1 = array("[RECEIVER]", "[LINK]", "[SITENAME]", "[LOGO]", "[RECEIVER_EMAIL]");
            $email_plcholders_rplc1 = array($uname, $link, $site_name, "<a href='" . $p . "'><img src='" . $logo . "' alt=''></a>", $email_user);

            $body1 = str_replace($email_plcholders1, $email_plcholders_rplc1, $email_desc1);

            $email = $data['email'];
            $subject = str_replace("[SITENAME]", $site_name, $email_title1);
            ;

            $this->db->where('id', $id);
            $r = $this->db->update($table, $sc);
            if ($r) {
                $mail = $this->left_panel_model->send_mail($email, $subject, $body1);
                return true;
            }
        } else {
            return false;
        }
    }

    function check_security($sc) {
        $admin = array();
        $this->db->where('security_code', $sc);
        $query = $this->db->get('admin');
        //echo $this->db->last_query();
        //echo $query->num_rows;
        // die();
        $admin['num'] = $query->num_rows();
        $admin['admin_arr'] = $query->result();
        return $admin;
    }

    function update($id, $pw) {
        $data_update = array(
            'password' => $pw,
            'security_code' => ''
        );
        $this->db->where('id', $id);
        $query = $this->db->update('admin', $data_update);
        return true;
    }

    function allstatelist() {    // select industry
        $this->db->select('*');
        $this->db->where('location_type', 1);
        $this->db->where('parent_id', 100);
        $query = $this->db->get('location');
        if ($query->num_rows > 0) {
            $result = $query->result();
            return $result;
        } else
            return false;
    }

    //=============getting controller page details====================//
    function page_details($name, $table) {
        $this->db->where('page_name', $name);
        $query = $this->db->get($table);
        if ($query->num_rows > 0) {
            $result = $query->result();
            return $result;
        }
    }

    //===================getting subadmin page access details============//
    function page_access($table, $id) {
        $this->db->where('id', $id);
        $query = $this->db->get($table);
        if ($query->num_rows > 0) {
            $result = $query->result();
            return $result;
        }
    }

    //================get total viewer===============//
    function get_totalViewer() {
        $date = date('Y-m-d');
        $this->db->where('date', $date);
        $query = $this->db->get('viewers_details');
        $num = $query->num_rows();
        return $num;
    }

    //============get all viwer=============//
    function get_allViewer($table, $date) {
        $this->db->where('date', $date);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get($table);
        $data['num'] = $query->num_rows();
        if ($query->num_rows > 0) {
            $data['result'] = $query->result();
            return $data;
        }
    }

    function get_days_visitors($table, $sdate, $ldate) {

        $query = $this->db->query("SELECT * FROM `viewers_details` WHERE `date` BETWEEN '" . $ldate . "' AND '" . $sdate . "' order by `id` DESC");
        //echo $this->db->last_query();
        $data['num'] = $query->num_rows();
        if ($query->num_rows > 0) {
            $data['result'] = $query->result();
            return $data;
            //print_r($data);
        }
    }

    //=============get total no of data in table===============//
    function get_totalNo($table, $field, $data) {
        $this->db->where($field, $data);
        $query = $this->db->get($table);
        $num = $query->num_rows();
        return $num;
    }

    //==============total no of claimed company=======//
    function get_claimNo($table) {
        $this->db->where('status', '1');
        $this->db->group_by('company_id');
        $query = $this->db->get($table);
        $num = $query->num_rows();
        return $num;
    }

    //============Total Reviews===========//
    function get_totalNoReview($table) {
        $query = $this->db->get($table);
        $num = $query->num_rows();
        return $num;
    }

}

?>