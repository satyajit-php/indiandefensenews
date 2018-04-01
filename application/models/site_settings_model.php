<?php

class Site_settings_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Log in functionality goes here
     */
    //=========== Select data from site_settings table============//
    function site_getdata() {
        $site_settings_query = $this->db->get('site_settings');
        $val = $site_settings_query->result();
        return $val;
    }

    //=========== Update data of site_settings table============//
    function update_data($table, $data_to_updt) {
        $this->db->where('id', '1');
        $val = $this->db->update($table, $data_to_updt);
        if ($val) {
            return true;
        }
    }

    function nav_menu() {

        $this->db->from('navbar');
        $this->db->where('status', '1');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function aboutus() {

        $this->db->from('aboutus');
        $this->db->where('status', 'Y');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function subscription($email = false) {
        if ($email) {
            $this->db->from('newsletter');
            $this->db->where('email', $email);
            $query = $this->db->get();
            $num = $query->num_rows();
            if ($num > 0) {
                return 0;
            } else {
                $data['email'] = $email;
                $insrt_data = $this->db->insert('newsletter', $data);
                return 1;
            }
        }
    }

    function get_email_template($id = false) {
        $this->db->from('email_template');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function footer_aboutus() {
        $this->db->from('aboutus');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function site_settings_data() {
        $this->db->from('site_settings');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function site_settings_tag() {
        $this->db->from('navbar');
        $this->db->where('status', '1');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

}

?>