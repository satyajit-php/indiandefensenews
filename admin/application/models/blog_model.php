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
		//$this->db->where('status',1);
		$this->db->order_by("id", "DESC");
		$query = $this->db->get();
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

	//=============changin the status of article============//
	function change_status_to($table, $stat_param, $id)
	{
		$this->db->where('id', $id);
		$val = $this->db->update($table, $stat_param);
		// echo $this->db->last_query();
		// die();
		if($val)
		{
			return true;
		}
	}

	//=============delete data from article============//
	function del_data($table, $id)
	{
		$this->db->where('id', $id);
		$val = $this->db->delete($table); 
		// echo $this->db->last_query();
		// die();
		if($val)
		{
			return true;
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
	//=========update article value======//
	function update_blog_value($table, $id, $data_to_store)
	{
		$this->db->where('blog_title', $data_to_store['blog_title']);
		$this->db->where('id !=', $id);
		$query = $this->db->get('blog');
		if($query->num_rows == 0)
		{
			$this->db->where('id', $id);
			$val = $this->db->update($table,$data_to_store);
			return true;
		}
		else
		{
			return false;
		}
	}
    /************************* Thumbnail Function - start *************************/
    function thumbnail($fileThumb, $file, $Twidth, $Theight, $tag)
    {
	    list($width, $height, $type, $attr) = getimagesize($file);
      //	print_r( getimagesize($file));
      //   echo "type->".$type;
      //		echo "attrib->".$attr;
      //		die();
	    switch($type)
	    {
		    case 1:
		    $img = @ImageCreateFromGIF($file);
		    break;
    
		    case 2:
		    $img = @ImageCreateFromJPEG($file);
		    break;
    
		    case 3:
		    $img = @ImageCreateFromPNG($file);
		    break;
	    }
    
	    if($tag == "width") //width contraint
	    {
		    $Theight = round(($height/$width)*$Twidth);
	    }
	    elseif($tag == "height") //height constraint
	    {
		    $Twidth = round(($width/$height)*$Theight);
	    }
	    elseif($tag=="both")
	    {
		    $Twidth = $Twidth;
		    $Theight = $Theight;
	    }
	    else
	    {
		$old_x=imageSX($img);
		$old_y=imageSY($img);
	       
		// next we will calculate the new dimmensions for the thumbnail image
		// the next steps will be taken:
		// 1. calculate the ratio by dividing the old dimmensions with the new ones
		// 2. if the ratio for the width is higher, the width will remain the one define in WIDTH variable
		// and the height will be calculated so the image ratio will not change
		// 3. otherwise we will use the height ratio for the image
		// as a result, only one of the dimmensions will be from the fixed ones
		if(($old_x>$Twidth)||($old_y>$Theight))
		{
		    $ratio1=$old_x/$Twidth;
		    $ratio2=$old_y/$Theight;
		    if($ratio1>$ratio2)
		    {
			$thumb_w=$Twidth;
			$thumb_h=$old_y/$ratio1;
		    }
		    else
		    {
			$thumb_h=$Theight;
			$thumb_w=$old_x/$ratio2;
		    }
		}
		else
		{
		    $thumb_h=$old_y;
		    $thumb_w=$old_x;
		}
	    }
    
	    $thumb = @imagecreatetruecolor($thumb_w, $thumb_h);
    
	    if(@imagecopyresampled($thumb, $img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y))
	    {
		    switch($type)
		    {
			    case 1:
			    ImageGIF($thumb,$fileThumb);
			    break;
    
			    case 2:
			    ImageJPEG($thumb,$fileThumb);
			    break;
    
			    case 3:
			    ImagePNG($thumb,$fileThumb);
			    break;
		    }
    
		    return true;
	    }
    }
/************************* Thumbnail Function - Ends *************************/

  function get_comment($id)
  {
	    $this->db->where('blog_id',$id);
		$this->db->order_by("id", "DESC");
		$query = $this->db->get('blog_comment');
		
		$val = $query->result();
		return $val;
		
		
   
  }
  
  function comm_detail($id)
  {
	    $this->db->where('id',$id);
		//$this->db->order_by("id", "DESC");
		$query = $this->db->get('people');
		if($query->num_rows > 0)
		{
			$val = $query->result();
			return $val;
		
		}
   
  }
  function getblog_id($i)
  {
	$this->db->where('id',$i);
	$query = $this->db->get('blog_comment');
	$val=$query->result();
	return $val;
  }
  
  
}
?>