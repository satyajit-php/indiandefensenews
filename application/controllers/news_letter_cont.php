<?php

class news_letter_cont extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('left_panel_model');
        $this->load->model('news_letter_model');   //load email template model
        $this->load->library('session');   //load session library
        $this->load->library('email');    //load email library
        if ($this->session->userdata('is_logged_in') != true) {
            $this->session->set_userdata('error_msg', 'Please log in first..');
            redirect('login_cont');
        }
    }

    //=============changin the status of news letter============//
    function change_status_to() {
        $stat_param = array(
            'status' => $this->uri->segment(3)
        );
        $id = $this->uri->segment(4);
        $updt_status = $this->news_letter_model->change_status_to('nwesletter', $stat_param, $id);
        if ($updt_status) {
            $this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot update status.');
        }
        redirect('news_letter_cont');
    }

    //============load view page of email template================//
    function index() {
        $flag = $this->uri->segment(3);
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        if ($flag == 'mail_sent') {
            $this->session->set_userdata('success_msg', 'Mail sent susseccfully.');
        } else {
            $this->session->unset_userdata('success_msg');
        }
        $data['result'] = $this->news_letter_model->select_news_letter();
        $this->load->view('news_letter/news_letter', $data);

        $this->load->view('includes/footer');
    }

    //============delete data from news letter management================//
    function del_data() {
        $id = $this->uri->segment(3);
        $del_data = $this->news_letter_model->del_data('nwesletter', $id);
        if ($del_data) {
            $this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot delete data.');
        }
        redirect('news_letter_cont');
    }

    //============send mail  from news panel================//
    function send_news_letter() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');

        $data['template'] = $this->news_letter_model->get_news_letter_template();
        $this->load->view('news_letter/edit_news_letter', $data);

        $this->load->view('includes/footer');
    }

    //============select emails================//
    function select_student_cont() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');

        $data['res'] = $this->news_letter_model->select_student_model();

        $this->load->view('news_letter/edit_news_letter', $data);

        $this->load->view('includes/footer');
    }

    //=================send mail to subscribers==================//
    function sendmail_to() {
        $data_to_send = array(
            'email_sub' => $_REQUEST['email_sub'],
            'nav_id' => $_REQUEST['nav_id'],
            'send_to' => $_REQUEST['email_type']
        );

        //print_r($data_to_send);
        //die();
        $send_mail = $this->news_letter_model->sendmail_to($data_to_send);
        //$this->session->set_userdata('success_msg', 'Mail sent susseccfully.');
        //if($send_mail)
        //{
        //	$this->session->set_userdata('success_msg', 'Mail sent susseccfully.');
        //}
        //else
        //{
        //	$this->session->set_userdata('error_msg', 'Something is wrong. Mail cannot be sent.');
        //}
        //redirect('news_letter_cont');
    }

    //========export as csv=========//
    function export_news_letter() {

        $csv_stat = $this->input->post('csv_stat');
        $stat_arr = explode(',', $csv_stat);


        $email = $this->input->post('csv_val');
        $email_arr = explode(',', $email);
        foreach ($email_arr as $email_val) {
            $output .= $email_val;
            $output .= "\n";
        }

        $output_file = PHYSICAL_PATH . 'newletter.csv';

        //// Open a new output file
        $file_csv = fopen($output_file, 'w');

        $heading .= 'Email';
        //$heading.='Status';
        $heading .= "\n";


        //// Put contents of $output into the $file_csv
        fputs($file_csv, $heading);
        fputs($file_csv, trim($output));

        //// Closing the file $file_csv
        fclose($file_csv);
        chmod($file_csv, 0777);


        //=================download csv file================//
        $file = $output_file;
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
        }

        //// Deleting CSV file from the directory
        unlink($output_file);


        $this->session->set_userdata('success_msg', 'Data downloaded susseccfully.');

        redirect('news_letter_cont');
    }

}

?>