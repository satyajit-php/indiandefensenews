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
                return 2;
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

    function get_blog_value_latest() {
        $this->db->from('blog');
        $this->db->order_by("added_on", "DESC");
        $this->db->where('status', 1);
        $this->db->limit(3, 0);
        $query = $this->db->get();
        //echo  $this->db->last_query();
        if ($query->num_rows > 0) {
            $val = $query->result();
            return $val;
        }
    }

    function getcategoryDetails() {
        //echo ' '.$review_id;
        $query_val = "SELECT count(blog.id) as total, navbar.name FROM (blog) JOIN navbar ON blog.blog_tag = navbar.id WHERE `blog`.`status` =  '1' group BY  navbar.id";
        $CI = & get_instance();
        $result = $CI->db->query($query_val);
        return $result->result();
    }

    function google_seo() {
        $this->db->from('googleplus_seo');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function twiter_seo() {
        $this->db->from('twiter_seo');
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function seo($controller = false) {
        $this->db->from('seo');
        $this->db->where('routes', $controller);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function get_blog_value($id = false) {
        if ($id) {
            $this->db->select('blog.*,news_source.short_name,navbar.*');
            $this->db->from('blog');
            $this->db->join('news_source', 'blog.blog_source = news_source.id');
            $this->db->join('navbar', 'blog.blog_tag = navbar.id');
            $this->db->where('blog.id', $id);
            $query = $this->db->get();
            return $query->result();
        } else {
            return false;
        }
    }

    public function disclaimer() {
        $this->db->from('privacy_policy');
        $this->db->where('status', "Y");
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            $val = $query->result_array();
            return $val;
        }
    }

    public function get_latestnews() {
        $final_array = [];
        $url = "https://newsapi.org/v2/top-headlines?country=in&apiKey=24b0ba7b805c4b5a9a1afe1ece3db201";
        $result = file_get_contents($url);
        $news_array = json_decode($result, true);
        if (!empty($news_array)) {
            if ($news_array['status'] == 'ok') {
                $data = $news_array['articles'];
                if (!empty($data)) {
                    foreach ($data as $key => $value) {
                        $temp['source'] = $value['source']['name'];
                        $temp['title'] = $value['title'];
                        $temp['url'] = $value['url'];
                        $temp['urlToImage'] = $value['urlToImage'];
                        $temp['publishedAt'] = date("M d,Y", strtotime($value['publishedAt']));
                        $final_array[] = $temp;
                    }
                }
            }
            return $final_array;
        }
        return false;
    }

}

?>