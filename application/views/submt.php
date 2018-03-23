<?php
    /*$id=$_REQUEST['uid'];
    $mail=$_REQUEST['umail'];
    $name=$_REQUEST['uname'];*/
    $id=$this->input->post('uid');
    $mail=$this->input->post('umail');
    $name=$this->input->post('uname');
    $insrt=$this->db->query("insert into tbl_fb_data(id,mail,name) values('$id','$mail','$name')");
    if($insrt){
        echo "Data Inserted";
    }
    else{
        echo "Insertion Failed";
    }
    //echo $insrt;
?>