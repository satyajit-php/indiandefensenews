<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

class Home_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Log in functionality goes here
     */
    //=========fetch data from quote============//
    public function get_slider() {
        $this->db->from('slider');
        $this->db->where('status', 1);
        $this->db->order_by("id", "DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_image() {
        $this->db->from('slider');
        $this->db->where('status', 1);
        //$this->db->order_by("added_on", "DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getStaticArticlePages($ids) {

        $this->db->where_in('id', $ids);
        $query = $this->db->get('article');
        $result = $query->result();

        return $result;
    }

    public function getGuidePrinciple() {

        $this->db->where('status', 1);
        $query = $this->db->get('guiding');
        $result = $query->result();

        return $result;
    }

    public function getFaqContents() {

        $this->db->where('status', 1);
        $query = $this->db->get('faq');
        $result = $query->result();
        return $result;
    }

    public function insert_contact($data) {
        $insrt_data = $this->db->insert('contact_list', $data);
    }

    //====get all blogs randomely========//
    public function get_blog_value($id = false) {
        if ($id) {
            $this->db->select('blog.*,news_source.short_name,blog_tag.tag_name');
            $this->db->from('blog');
            $this->db->join('news_source', 'blog.blog_source = news_source.id');
             $this->db->join('blog_tag', 'blog.blog_category = blog_tag.id');
            $query = $this->db->get();
            return $query->result();
        } else {
            return false;
        }
    }

    //=======get all tags of a blog by tagid======//
    function get_blogTag($tag_id) {
        $blog_tag_arr = array();
        $this->db->where('id', $tag_id);
        $this->db->where('status', '1');
        $query = $this->db->get('blog_tag');
        $blog_tag_arr['blog_tag_num'] = $query->num_rows();
        if ($query->num_rows > 0) {
            $blog_tag_arr['blog_tag_array'] = $query->result();
        }
        return $blog_tag_arr;
    }

    // Slider Management

    function getSlider() {
        $this->db->where('status', 1);
        $query = $this->db->get('slider');
        $result = $query->result();
        return $result;
    }

    public function get_total_count($blog_tag_id = false) {
        //return $this->db->count_all("blog");
        $this->db->from('blog');
        $this->db->where('status', 1);
        if ($blog_tag_id) {
            $this->db->like('blog_tag', $blog_tag_id);
        }
        $query = $this->db->get();
        $val = $query->num_rows();
        return $val;
    }

    function get_blog_value_pagi($limit, $start, $blog_tag_id = false) {
        $this->db->from('blog');
        $this->db->order_by("added_on", "DESC");
        $this->db->where('status', 1);
        if ($blog_tag_id) {
            $this->db->like('blog_tag', $blog_tag_id);
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //echo  $this->db->last_query();
        if ($query->num_rows > 0) {
            $val = $query->result();
            return $val;
        }
    }

}

?>
        