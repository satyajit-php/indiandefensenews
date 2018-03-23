<?php
class Feedback_cont extends CI_Controller {
   // Controller class for Login
	function __construct()
	{
		parent::__construct();
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->model('feedback_model');	//loading model
		$this->load->model('login_model');	//loading model
		$this->load->model('site_settings_model'); //Site settings model
	}
    
   
	// mail sending function start
	function send_mail($email,$subject,$body)
        {
	        require_once PHYSICAL_PATH_FRONT.'/smtpmail/PHPMailerAutoload.php';
	        $mail = new PHPMailer;
			$mail->IsSMTP(); // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com'; // Specify main and backup server
			$mail->SMTPAuth = true; // Enaele SMTP authentication
			$mail->Username = 'care@creditmonk.com'; // SMTP username
			$mail->Password = 'clrpqjkaumioosze'; // SMTP password
			$mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted
			$mail->Port = 587; //Set the SMTP port number - 587 for authenticated TLS
			$mail->setFrom('care@creditmonk.com', 'Shraddha Ghogare'); //Set who the message is to be sent from
			//$mail->addReplyTo('labnol@gmail.com', 'First Last'); //Set an alternative reply-to address
			//$mail->addAddress('care@creditmonk.com', 'Josh Adams'); // Add a recipient
		
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
			   //echo 'Message could not be sent.';
			   //echo 'Mailer Error: ' . $mail->ErrorInfo;
			   $return=0;
			}
			else
			{
			   //echo 'Message has been sent';
			   $return=1;
			}
			return $return;
			//die;
	}
	// mail sending function end
    
	function feedback_ins()        // email already taken validation
	{
		$currentUrl = $this->input->post('current_url_feedback_post');
		$data=array(
			'email'=> $this->input->post('email_feed'),
			'contact'=> $this->input->post('contact_feed'),
			'comment'=> $this->input->post('comment_feed')
		);
		
		$register = $this->feedback_model->insert_data('feedback', $data);
		$emailtmp = $this->feedback_model->email_tmp('email_template', 11);
		$emailtmpadmin = $this->feedback_model->email_tmp('email_template', 2);
		
		$body = $emailtmp[0]->email_desc;
		$logo = "<a href='".base_url()."'><img src='".base_url()."assets/images/logo-1.png' alt=''></a>";
		$register_details = $this->feedback_model->fetch_data('feedback', $register);
		$receiver_name_exp= explode("@",$register_details[0]->email);
		$receiver_name = $receiver_name_exp[0];
		$receiver_email = $register_details[0]->email;
		$sessionFlash = 0;
		
		$baseurl = base_url();
			
		//this is for footer section in email template//
		
		//generating social logos//
		$sites = $this->login_model->site_list('site_settings', 'facebook', 'twitter', 'linkedin');
		$social_logo = "<a href='".$sites->facebook."' style='cursor: pointer;'><img src='".base_url()."assets/images/socailloginicons/facebook-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>
		<a href='".$sites->linkedin."' style='cursor: pointer;'><img src='".base_url()."assets/images/socailloginicons/linkedin-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>
		<a href='".$sites->twitter."' style='cursor: pointer;'><img src='".base_url()."assets/images/socailloginicons/twitter-brown.png' alt='' style='margin: 0 5px;' width='45' height='44' border='0'></a>";
		//generating social logos//
		
		//generating static links//
		$static_pages = "<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/disclaimer'>Disclaimer</a>
		| <a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/privacy'>Privacy</a> |
		<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/termsCondition'> Terms &amp; Conditions</a> |
		<a style='color: #171717; font-size: 15px; text-decoration: none; cursor: pointer;' href='".base_url()."home/helpCenter?tab=Guiding'> Help</a>";
		//generating static links//
		
		//this is for footer section in email template//
		$link = base_url()."company/index?company_name=&company_location=&page=1";
		$email_id=$this->input->post('email_feed');
		$email_name=explode('@',$email_id);
		// Sende mail section
		$email_plcholders2 = array("[RECEIVER]","[LINK]","[LOGO]","[BODY]","[SOCIAL_LOGO]","[STATICPAGES]","[BASEURL]");
		$email_plcholders_rplc2 = array($email_name[0],$link,$logo,$register_details[0]->comment,$social_logo,$static_pages,$baseurl);
		$body = str_replace($email_plcholders2,$email_plcholders_rplc2,$body);
		if(!empty($emailtmp))
		{
			//echo $var = $this->send_mail($this->input->post('email_feed'), $emailtmp[0]->email_title,$emailtmp[0]->email_desc); die;
			$sessionFlash = 1;
			if($this->send_mail($this->input->post('email_feed'), $emailtmp[0]->email_title,$body))
				{
					$this->session->set_userdata('success_msg', 'Thank you for your comments');
				}
				else
				{
					$this->session->set_userdata('error_msg', 'Unable to send email please try again.');
				}
					
	   }
	   else
		{
			$this->session->set_userdata('error_msg', 'Unable to send email due to some administrative restrictions.');
		}
	   if(!empty($emailtmpadmin))
		{
			$sessionFlash = 1;
			$body = $emailtmpadmin[0]->email_desc;
			$site_settings_data = $this->site_settings_model->site_getdata();
			$email_plcholders1 = array("[RECIEVER]","[SITENAME]","[LOGO]","[RECEIVER_EMAIL]","[BODY]","DATE");
			$email_plcholders_rplc1 = array("Admin","Credit Monk",$logo,$site_settings_data[0]->admin_email,$register_details[0]->comment,date("j M Y"));
			$body1 = str_replace($email_plcholders1,$email_plcholders_rplc1,$body);
				if($this->send_mail($site_settings_data[0]->admin_email,$emailtmpadmin[0]->email_title,$body1))
				{
					//$this->session->set_userdata('success_msg', 'Thank you for your comments');
				}
				else
				{
					$this->session->set_userdata('error_msg', 'Unable to send email please try again.');
				}
					
	   }
	   else
		{
				//$this->session->set_userdata('error_msg', 'Unable to send email due to some administrative restrictions.');
		}
		echo $currentUrl;
		header("Location: $currentUrl");
		exit;
		//redirect('home');
	   
	   
	}
}
        