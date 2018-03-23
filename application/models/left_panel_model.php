<?php
class Left_panel_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        require PHYSICAL_PATH_FRONT.'smtpmail/PHPMailerAutoload.php';
    }
    /**
    * Validate the login's data with the database
    * @param string $user_name
    * @param string $password
    * @return void
    */
    
    //==========fetch admin details===========//
    function get_admin()
    {
        $uid=$this->session->userdata('uid');
        $this->db->from('admin');
        $this->db->where('id', $uid);
        $query = $this->db->get();
        if($query->num_rows > 0)
        {
            $val = $query->result();
            return $val;
        }
    }
    
    //==========fetch admin details by id===========//
    function get_admin_by_id($uid)
    {
        $this->db->from('admin');
        $this->db->where('id', $uid);
        $query = $this->db->get();
        if($query->num_rows > 0)
        {
            $val = $query->result();
            return $val;
        }
    }
    
    //==========fetch all parent navigations from article table===========//
    function get_nav_value()
    {
        $this->db->from('admin_management_list');
        $this->db->where('parent_menu', '0');
        $this->db->where('status', 'Y');
        $query = $this->db->get();
        if($query->num_rows > 0)
        {
            $val = $query->result();
            return $val;
        }
    }
    
    //==========fetch all child navigations from article table===========//
    function get_childnav_value($parent_menu)
    {
        $this->db->from('admin_management_list');
        $this->db->where('parent_menu', $parent_menu);
        $this->db->where('status', 'Y');
        $query = $this->db->get();
        if($query->num_rows > 0)
        {
            $val = $query->result();
            return $val;
        }
    }
    
    //==============send mail function=============================//
    function send_mail($email,$subject,$body)
   {
       
        $mail = new PHPMailer();
       
        $mail->IsSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com'; // Specify main and backup server
        $mail->SMTPAuth = true; // Enaele SMTP authentication
       $mail->Username = 'care@creditmonk.com'; // SMTP username
        $mail->Password = 'clrpqjkaumioosze'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted
        $mail->Port = 587; //Set the SMTP port number - 587 for authenticated TLS
        $mail->setFrom('monk@creditmonk.com', 'Shraddha Ghogare'); //Set who the message is to be sent from
        //$mail->addReplyTo('labnol@gmail.com', 'First Last'); //Set an alternative reply-to address
        //$mail->addAddress('ridhi@double-dee.com', 'Josh Adams'); // Add a recipient
        //$mail->addAddress('ellen@example.com'); // Name is optional
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        $mail->WordWrap = 50; // Set word wrap to 50 characters
        //$mail->addAttachment('/usr/labnol/file.doc'); // Add attachments
        //$mail->addAttachment('/images/image.jpg', 'new.jpg'); // Optional name
        $mail->isHTML(true); 
        $mail->FromName = 'Credit Monk';
        $mail->addAddress($email);     // Add a recipient
        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        //$mail->send();
        if(!$mail->send())
        {
           echo 'Message could not be sent Hum.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           $return=1;
           exit;
        }
        else
        {
           //echo 'Message has been sent';
           $return=0;
        }
        return $return;
  
   }
}
?>