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

    public function getMostPopularCompany() {
        //$query = $this->db->query("SELECT company_details.*,SUM(`company_review`.`overall_pay_exp`) AS `overall_pay_exp`,count(`company_review`.`company_id`) as `totalreview` ,`company_review`.`usuall_pay`,`company_review`.`credit_allow`
        //FROM company_details
        //LEFT JOIN company_review ON company_review.company_id = company_details.id
        //LEFT JOIN company_type ON company_details.company_type = company_type.id
        //GROUP BY `company_details`.id ORDER BY company_review.overall_pay_exp desc LIMIT 0,10");
        //$query = $this->db->query("SELECT company_details.company_name,company_details.id AS CompID, new_table.* FROM
        //						  (SELECT `id`,`disable`, `company_id`,`credit_allow`,`usuall_pay`, AVG(`overall_pay_exp`) AS avg_overall_pay_exp FROM `company_review` GROUP BY `company_id`) as new_table 
        //
		//							INNER JOIN company_details ON company_details.id = new_table.company_id
        //							where new_table.avg_overall_pay_exp >=3 AND new_table.disable = '0' AND company_details.parent_id = 0 AND company_details.status = 1 order by rand() limit 2");
        $query = $this->db->query("SELECT company_details.company_name,company_details.id AS CompID,company_details.average_rating, new_table.* FROM
								  (SELECT `id`,`disable`, `company_id`,`credit_allow`,`usuall_pay` FROM `company_review` GROUP BY `company_id`) as new_table 

									INNER JOIN company_details ON company_details.id = new_table.company_id
									where company_details.average_rating >=3 AND new_table.disable = '0' AND company_details.parent_id = 0 AND company_details.status = 1 order by rand() limit 2");

        return $queryResult = $query->result();
    }

    public function getMostUnpopularCompany() {
        //$query = $this->db->query("SELECT company_details.company_name, company_details.id AS CompID,new_table.* FROM
        //						(SELECT `id`, `disable`,`company_id`,`credit_allow`,`usuall_pay`, AVG(`overall_pay_exp`) AS avg_overall_pay_exp FROM `company_review` GROUP BY `company_id`) as new_table 
        //
		//						INNER JOIN company_details ON company_details.id = new_table.company_id
        //						where new_table.avg_overall_pay_exp < 3 AND new_table.disable = '0' AND company_details.parent_id = 0 AND company_details.status = 1 order by rand() limit 1");
        $query = $this->db->query("SELECT company_details.company_name, company_details.id AS CompID,company_details.average_rating,new_table.* FROM
								(SELECT `id`, `disable`,`company_id`,`credit_allow`,`usuall_pay` FROM `company_review` GROUP BY `company_id`) as new_table 

								INNER JOIN company_details ON company_details.id = new_table.company_id
								where company_details.average_rating < 3 AND company_details.average_rating !=0 AND new_table.disable = '0' AND company_details.parent_id = 0 AND company_details.status = 1 order by rand() limit 1");
        return $queryResult = $query->result();
    }

    public function insert_contact($data) {
        $insrt_data = $this->db->insert('contact_list', $data);
    }

    //====get all blogs randomely========//
    public function get_blog_value() {
        //$blog_val_arr = array();
        //$blog_detl = $this->db->query('SELECT `blog_id`, COUNT(*) AS GroupAmount FROM `blog_comment` GROUP BY `blog_id` ORDER BY `GroupAmount` DESC');
        //$blog_detl_arr = $blog_detl->result();
        //print_r($blog_detl_arr);die;
        //if(!empty($blog_detl_arr))
        //{
        //	$i = 0;
        //	foreach($blog_detl_arr as $blog_detl_val)
        //	{
        //	    $ID = $blog_detl_val->blog_id;
        //		$this->db->select('*');
        //		$this->db->from('blog');
        //		$this->db->where('id', $ID);
        //		$blog_val = $this->db->get();
        //		$blg_val = $blog_val->result();
        //		
        //		if(!empty($blg_val))
        //		{
        //			$blog_val_arr[$i]['blog_id'] = $blg_val[0]->id;
        //			$blog_val_arr[$i]['images'] = $blg_val[0]->images;
        //			$blog_val_arr[$i]['blog_title'] = $blg_val[0]->blog_title;
        //			$blog_val_arr[$i]['details'] = $blg_val[0]->details;
        //			$blog_val_arr[$i]['added_on'] = $blg_val[0]->added_on;
        //			$blog_val_arr[$i]['added_by'] = $blg_val[0]->added_by;
        //			$blog_val_arr[$i]['blog_tag'] = $blg_val[0]->blog_tag;
        //		}
        //		$i++;
        //	}
        //	return $blog_val_arr;
        //}
        $this->db->select('*');
        $this->db->where('status', 1);
        $qr = $this->db->get('blog');

        return $qr->result();
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

}

?>
        