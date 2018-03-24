<?php

class Navigation_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Log in functionality goes here
     */
    //=========fetch all Country Name with respect to country id ============//
    public function fetch_nav($id) {
        $this->db->select('name');
        $this->db->where("id", $id);
        $query = $this->db->get('navbar');
        //echo $this->db->last_query();
        //die();
        $res = $query->result();
        return $res;
    }

    //=========fetch all countries============//
    public function fetch_all_navigation() {

        $this->db->from('navbar');
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    //=========fetch all states============//
    public function fetch_data() {
        $this->db->select('*');
        $this->db->from('navbar');
        $this->db->order_by('id', "DESC");
        // $this->db->where('id', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    //=========fetch data from country============//
    public function get_nav($table, $id) {
        $this->db->from($table);
        $this->db->where("id", $id);
        $this->db->order_by('id', "DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    //=============changing the status of states============//
    function change_status_to($table, $stat_param, $id) {
        $this->db->where('id', $id);
        $val = $this->db->update($table, $stat_param);
        // echo $this->db->last_query();
        // die();
        if ($val) {
            return true;
        }
    }

    //=========insert state value======//
    function insert_nav_value($table, $data_to_store) {
        //print_r($data_to_store); die();
        $this->db->where('name', $data_to_store['name']);
        $query = $this->db->get('navbar');

        if ($query->num_rows() == 0) {
            $insrt = $this->db->insert($table, $data_to_store);

            return 1;
        } else {
            return 0;
        }
    }

    //=============delete states============//
    function del_data($table, $id) {
        $this->db->where('id', $id);
        $val = $this->db->delete($table);
        // echo $this->db->last_query();
        // die();
        if ($val) {
            return true;
        }
    }

    //=========update state value======//
    function update_nav_value($table, $data_to_store, $id) {

        $this->db->where('id', $id);
        $val = $this->db->update($table, $data_to_store);
        if ($val)
            return true;
        else
            return fals;
    }

}

?>