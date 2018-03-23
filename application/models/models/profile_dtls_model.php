<?php
class Profile_dtls_model extends CI_Model {

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
    function update_pass_value($table, $data_to_store, $id)
    {
	$this->db->where('id', $id);
	$val = $this->db->update($table, $data_to_store);
	return true;
    }
    
    function update_profile_details_model($table,$id,$data)
    {
	$this->db->from($table);
            $this->db->where('email', $data['email']);
            $this->db->or_where('uname', $data['uname']);
            $query = $this->db->get();
	    
		//echo $this->db->last_query();
		//die();
	    
	    $admin_val = $query->result();
            if($query->num_rows == 0 || $admin_val[0]->id==$id)
            {
                $this->db->where('id', $id);
		$updt = $this->db->update($table, $data);
		//echo $this->db->last_query();
		//die();
                if($updt)
                {
                    return true;
                }
            }
            else if($admin_val[0]->uname == $data['uname'] && $admin_val[0]->email == $data['email'] && $admin_val[0]->id!=$id)
            {
                return 'both';
            }
	    else if($admin_val[0]->uname == $data['uname'] && $admin_val[0]->id!=$id)
            {
                return 'username';
            }
	    else if($admin_val[0]->email == $data['email'] && $admin_val[0]->id!=$id)
            {
                return 'email';
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
  
  
}
?>