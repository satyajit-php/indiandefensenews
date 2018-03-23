<?php
class Contact_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	function store_contact_details($table,$data)
	{
		
            $insrt = $this->db->insert($table, $data);
            //echo $this->db->last_query();
            //die();
                if($insrt)
                {
		    $email = $data['contact_email'];
		    $msg = $data['message'];
                    $name = ucfirst($data['contacted_by']);
                    
                    //get site details
                    $this->db->where('id', '1');
                    $query = $this->db->get('site_settings');
                    $result_settings = $query->result();
                    $site_name = $result_settings[0]->site_name;
                    $email_admin = $result_settings[0]->admin_email;
                    
                    //send mail to admin
                    $this->db->where('id', '3');
                    $query1 = $this->db->get('email_template');
                    $result1 = $query1->result();
                    $email_desc1 = $result1[0]->email_desc;
                    $body_detls = '<table>
                                        <tr>
                                            <td>
                                              Email:
                                            </td>
                                            <td>
                                              '.$email.'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                              Message:
                                            </td>
                                            <td>
                                              '.$msg.'
                                            </td>
                                        </tr>
                                    </table>';
                    
                    
                    $email_plcholders1 = array("[RECEIVER]","[SENDER]","[RECEIVER_EMAIL]","[SENDER_EMAIL]","[DATE]","[PRICE]","[SITENAME]","[LINK]","[LOGO]","[BODY]");
                    $email_plcholders_rplc1 = array("ADMIN",$name,$email_admin,"","[DATE]","[PRICE]",$site_name,"[LINK]","<a href='".base_url()."'><img src='".base_url()."assets/images/logo-1.png' alt=''></a>",$body_detls);
                    
                    $subject1 = "One user has contacted with you";
                    $body1 = str_replace($email_plcholders1,$email_plcholders_rplc1,$email_desc1);
                    //$obj = $this->email_settings_model;
                    $mail1 = $this->send_mail($email_admin,$subject1,$body1);
                    if($mail1 == 0)
		    {
			$mailto_user = $this->send_mailuser($name,$email,$site_name);
			if($mailto_user == 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		    }  
                }
		else
		{
		    return false;
		}            
	}
        
        function send_mailuser($name,$email,$site_name)
        {
            //send mail to user
            $this->db->where('id', '5');
            $query = $this->db->get('email_template');
            $result = $query->result();
            $email_desc = $result[0]->email_desc;
            
            $email_plcholders = array("[RECEIVER]","[SENDER]","[RECEIVER_EMAIL]","[SENDER_EMAIL]","[DATE]","[PRICE]","[SITENAME]","[LINK]","[LOGO]","[BODY]");
            $email_plcholders_rplc = array($name,"ADMIN",$email,"","[DATE]","[PRICE]",$site_name,"[LINK]","<a href='".base_url()."'><img src='".base_url()."assets/images/logo-1.png' alt=''></a>","");

            $subject_user = "Thank you for contacting with us";
            $body_user = str_replace($email_plcholders,$email_plcholders_rplc,$email_desc);
            $mail = $this->send_mail($email,$subject_user,$body_user);
            
	    return $mail;
        }
        
        //==============send mail function=============================//
        function send_mail($email,$subject,$body)
        {
            $mail = new PHPMailer();
            
            $mail->isSMTP();                                       // Set mailer to use SMTP
            $mail->Host = "ssl://smtp.gmail.com";                 // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                              // Enable SMTP authentication
            $mail->Username = 'esolz.technologies@gmail.com';   // SMTP username
            $mail->Password = 'un!techvikas';                  // SMTP password
            $mail->SMTPSecure = 'ssl';
            $mail->isHTML(true);                              // Set email format to HTML
            $mail->From = 'esolz.technologies@gmail.com';
            $mail->Port = 465;                               // TCP port to connect to
            
            //$mail->Port=26;    // Enable encryption, 'ssl' also accepted
            //$mail->From = ADMIN_EMAIL;
            //$mail->FromName = SITE_NAME;
            $mail->FromName = 'CreditMonk';
            $mail->addAddress($email);     // Add a recipient
            $mail->WordWrap = 50;
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
           
            //$mail->send();
            if(!$mail->send())
            {
               echo 'Message could not be sent.';
               echo 'Mailer Error: ' . $mail->ErrorInfo;
               $return=1;
               //exit;
            }
            else
            {
               //echo 'Message has been sent';
               $return=0;
            }
            return $return;  
        }
		function get_contact()
        {
            $this->db->where('id', '1');
            $query = $this->db->get('admin_contact_details');
            $result = $query->result();
           
            
	    return $result;
        }
		
}
?>