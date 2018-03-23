<?php
class Blog_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
    /**
    * Validate the login's data with the database
    * @param string $user_name
    * @param string $password
    * @return void
    */
	//==========fetch data from article table===========//
	function get_blog_value()
	{
		$this->db->from('blog');
		$this->db->order_by("added_on", "DESC");
		$this->db->where('status',1);
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;
		
		}
	}
	 
	
	function get_pop_value()
	{
		$this->db->from('blog');
		$this->db->order_by("rating", "DESC");
		$this->db->where('status',1);
		$query = $this->db->get();
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;
		
		}
	}
	public function get_total_count($blog_tag_id)
	{
	  //return $this->db->count_all("blog");
		$this->db->from('blog');
		$this->db->where('status',1);
		if($blog_tag_id != 0)
		{
			$this->db->like('blog_tag', $blog_tag_id);
		}
		$query = $this->db->get();
		$val = $query->num_rows();
		return $val;
	}
	
	function get_blog_value_pagi($limit,$start,$blog_tag_id)
	{
		$this->db->from('blog');
		$this->db->order_by("added_on", "DESC");
		$this->db->where('status',1);
		if($blog_tag_id != 0)
		{
			$this->db->like('blog_tag', $blog_tag_id);
		}
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo  $this->db->last_query();
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;
		}
	}
	
	//=========insert article value======//
	function insert_blog_value($table, $data)
	{
		$this->db->where('blog_title', $data['title']);
		$query = $this->db->get('blog');
		
		if($query->num_rows == 0)
		{
			$insrt = $this->db->insert($table, $data);
			return '1';
		}
		else
		{
			return '0';
		}
	}
	function blogComments($id){
		$this->db->select('blog_comment.*, people.first_name, people.last_name,people.profile_pic');
		$this->db->from('blog_comment');
		$this->db->join('people', 'people.id = blog_comment.posted_by');
		$this->db->where('blog_id', $id);
		$this->db->order_by('id', 'desc');
		$this->db->limit(2);
		$query = $this->db->get();
		
		if($query->num_rows > 0){
			return $query->result();
		}else{
			return false;
		}		
	}
	function get_blogCommentAll($id)
	{
		$blog_cmmnt = array();
		$this->db->select('blog_comment.*, people.first_name, people.last_name,people.profile_pic');
		$this->db->from('blog_comment');
		$this->db->join('people', 'people.id = blog_comment.posted_by');
		$this->db->where('blog_id', $id);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$blog_cmmnt['num'] = $query->num_rows();
		
		if($query->num_rows > 0)
		{
			$blog_cmmnt['blog_cmnt'] = $query->result();
		}
			return $blog_cmmnt;
	}
	
	//==get all blog by comment===//
	function get_blogby_comment()
	{
		$blog_val_arr = array();
		$blog_detl = $this->db->query('SELECT `blog_id`, COUNT(*) AS GroupAmount FROM `blog_comment` GROUP BY `blog_id` ORDER BY `GroupAmount` DESC');
		$blog_detl_arr = $blog_detl->result();
		if(!empty($blog_detl_arr))
		{
			$i = 0;
			foreach($blog_detl_arr as $blog_detl_val)
			{
				$ID = $blog_detl_val->blog_id;
				$this->db->select('*');
				$this->db->from('blog');
				$this->db->where('id', $ID);
				$blog_val = $this->db->get();
				$blg_val = $blog_val->result();
				if(!empty($blg_val))
				{
					$blog_val_arr[$i]['blog_id'] = $blg_val[0]->id;
					$blog_val_arr[$i]['images'] = $blg_val[0]->images;
					$blog_val_arr[$i]['blog_title'] = $blg_val[0]->blog_title;
					$blog_val_arr[$i]['details'] = $blg_val[0]->details;
					$blog_val_arr[$i]['added_on'] = $blg_val[0]->added_on;
				}
				$i++;
			}
			return $blog_val_arr;
		}
	}
	
	//=======get all tags of a blog by tagid======//
	function  get_blogTag($tag_id)
	{
		$blog_tag_arr = array();
		$this->db->where('id', $tag_id);
		$this->db->where('status', '1');
		$query = $this->db->get('blog_tag');
		$blog_tag_arr['blog_tag_num'] = $query->num_rows();
		if($query->num_rows > 0)
		{
			$blog_tag_arr['blog_tag_array'] = $query->result();
		}
		return $blog_tag_arr;
	}
	
	function  get_blogDetails($blog_id)
	{
		$this->db->where('id', $blog_id);
		$query = $this->db->get('blog');
		if($query->num_rows > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	//=============fetch data from article for updating particular rows ============//
	function sel_data_up($id)
	{
		$this->db->where('id',$id);
	   	$rslt = $this->db->get('blog');
	    return $rslt->result();
		//echo"<pre>";
		//print_r($rslt);
		//die();
	}
	function insert_comment($table,$data)
	{
		$insrt = $this->db->insert($table, $data);
		if($insrt)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function select_comment($pid)
	{
		$this->db->where('blog_id',$pid);
		$r=$this->db->get('blog_comment');
		$r=$r->result_array();
		return $r;
		
	}
    function update_blog_rate($table,$pid,$up_rate)
	{
		$this->db->where('id', $pid);
		$val = $this->db->update($table, $up_rate);
		if($val)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
	function  select_user($id)
	{
		$this->db->where('id',$id);
		$r=$this->db->get('people');
		$r=$r->result();
		return $r;
	}
	function dis_comm($bid)
	{
		$this->db->where('id',$bid);
		$r=$this->db->get('blog');
		$r=$r->result();
		return $r;
	}
	
	
	//=======get comment by blog id=========//
	function getCommentsByBlog($id)
	{
		$this->db->select('blog_comment.*, people.first_name, people.last_name,people.profile_pic');
		$this->db->from('blog_comment');
		$this->db->where('blog_comment.blog_id', $id);
		$this->db->join('people', 'people.id = blog_comment.posted_by');
		
		$this->db->order_by('id', 'desc');
		$this->db->limit(2);
		$query = $this->db->get();
		
		if($query->num_rows > 0){
			return $query->result();
		}
	}

/************************* Thumbnail Function - Ends *************************/
}
?>