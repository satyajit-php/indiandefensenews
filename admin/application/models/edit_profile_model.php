<?php
class edit_profile_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	//=========== Select language ============//
	
	function get_all($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('admin');
		$val = $query-> result();
		return $val;
	}
	function fetch_static($id)
	{
		$this->db->where('id',$id);
		$admin_query = $this->db->get('static_page');
		$val = $admin_query-> result();
		return $val;
	}
	function insert_static($data_store)
	{
		$t=$data_store['title'];
		$id=$data_store['language_id'];
		$this->db->where('title',$t);
		$this->db->where('language_id',$id);
		$q=$this->db->get("static_page");
		$num = $q->num_rows();
		if($num==0)
		{
			$this->db->insert('static_page',$data_store);
			return 1;
		}
		else
		{
			return 0;
		}
	  }
	
	  /************************* Thumbnail Function - start *************************/
    function thumbnail($fileThumb, $file, $Twidth, $Theight, $tag)
    {
	    list($width, $height, $type, $attr) = getimagesize($file);
    
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
	
	
	
    //=========== update data from contact list table of a record============//
	function update_pro($table, $data_to_updt,$id)
	{
		$this->db->where('id', $id);
		$val = $this->db->update($table,$data_to_updt);
		if($val)
		{
			return true;
		}
		else
		{
			return false;
			
		}
	}
	
	//=========== Delete data from contact list table ============//
	function del_data($id)
	{
		
		$this->db->where('id', $id);
		$val=$this->db->delete('static_page');
		if($val)
		{
			
		   return true;
		}
		
	}
	//=========== update status  from contact list table ============//
	function update_status($t,$data,$id)
	{
		$this->db->where('id', $id);
		$val = $this->db->update($t,$data);
		if($val)
		{
			return true;
		}
		
	}
	
	
	
}
?>