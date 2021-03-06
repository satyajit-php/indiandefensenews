<?php

class Twiter_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Validate the login's data with the database
     * @param string $user_name
     * @param string $password
     * @return void
     */
    //==========fetch data from article table===========//
    function get_twiterseo_value() {
        $this->db->from('twiter_seo');
        //$this->db->where('status', 'Y');
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            $val = $query->result();
            return $val;
        }
    }

    //=========insert article value======//
    function insert_aboutus_value($table, $data) {
        $insrt = $this->db->insert($table, $data);
        return '1';
    }

    //=============delete data from article============//
    //=============fetch data from article for updating particular rows ============//
    function sel_data_up($id) {
        $this->db->where('id', $id);
        $rslt = $this->db->get('twiter_seo');
        return $rslt->result();
    }

    //=========update article value======//
    function update_value($table, $id, $data_to_store) {
        $this->db->where('id', $id);
        $val = $this->db->update($table, $data_to_store);
        return true;
    }

}

?>