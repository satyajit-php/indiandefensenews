<?php

class News_source_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Log in functionality goes here
     */
    //=============insert into faq============//
    //=============delete data from country============//
    function del_data($table, $id) {
        $this->db->where('id', $id);
        $val = $this->db->delete($table);

        if ($val) {
            return true;
        }
    }

    //===================== for faq=====================//

    function insert_source($table, $data_to_store) {
        $this->db->where('name', $data_to_store['name']);
        $query = $this->db->get($table);

        if ($query->num_rows == 0) {
            $insrt = $this->db->insert($table, $data_to_store);
            return '1';
        } else {
            return '0';
        }
    }

    public function select_faqs($table, $id) {
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function change_status_to($table, $stat_param, $id) {
        $this->db->where('id', $id);
        $val = $this->db->update($table, $stat_param);
        // echo $this->db->last_query();
        // die();
        if ($val) {
            return true;
        }
    }

    public function lists($table) {
        $this->db->from($table);
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function update_data($table, $data_to_store, $id) {

        $this->db->where('id', $id);
        $val = $this->db->update($table, $data_to_store);
        if ($val) {
            return 1;
        } else {
            return 0;
        }
    }

    function change_status_faq($table, $stat_param, $id) {
        $this->db->where('id', $id);
        $val = $this->db->update($table, $stat_param);

        if ($val) {
            return true;
        }
    }

}

?>
        