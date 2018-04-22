<?php

class Contact_page extends CI_Controller {

    // Controller class for site_settings
    function __construct() {
        parent::__construct();
        $this->load->model('left_panel_model'); // calls the model
        $this->load->model('login_model');
        $this->load->model('site_settings_model'); // calls the model
        $this->load->model('contactpage_model'); // calls the model
        $this->load->library('session');
        $this->load->helper('date');
        if ($this->session->userdata('admin_is_logged_in') != true) {
            $this->session->set_userdata('error_msg', 'Please login first.');
            redirect('login_cont');
        } else if ($this->session->userdata('admin_is_superadmin') != 1) {
            $data = $this->login_model->page_details('blog_cont', 'admin_management_list');
            $page_id = $data[0]->id;
            //print_r($this->session->all_userdata());
            $id = $this->session->userdata('admin_uid');
            $admin_val_arr = $this->login_model->page_access('admin', $id);
            $page_arr = explode(',', $admin_val_arr[0]->page_access);
            if (!(in_array($page_id, $page_arr))) {
                $this->session->set_userdata('error_msg', 'You Don\'t Have Permission To Access This Page.');
                redirect('dashboard_cont');
            }
        }
    }

    //============load view page of article================//
    function index() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $data['contactpage_data'] = $this->contactpage_model->get_contactpage_value();
        $this->load->view('contactpage/index', $data);
        $this->load->view('includes/footer');
    }

    //============load view page of edit_article================//
    function edit_contactpage() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        //$this->load->view('article/edit_article');
        $id = $this->uri->segment(3);
        $data['contactpage_data'] = $this->contactpage_model->sel_data_up($id);
        $this->load->view('contactpage/edit', $data);
        $this->load->view('includes/footer');
    }

    //============update data into article================//	
    function update_contactpage() {
        if ($this->input->post('mode_update') == 'update') {
            $id = $this->input->post('id');
            //print_r($_FILES['attachment_file']);
            if (isset($_FILES['attachment_file']['name']) && !empty($_FILES['attachment_file']['name'])) {
                if ($_FILES["attachment_file"]["name"] != "") {
                    $DIR_DOC = PHYSICAL_PATH . "uploaded_image/normal/";
                    $ext = explode('/', strtolower($_FILES["attachment_file"]["type"]));
                    $file_size = filesize($_FILES["attachment_file"]["tmp_name"]);

                    $arra1 = array(' ', '--', '&quot;', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', '\\', ';', "'", ',', '/', '*', '+', '~', '`', '=');
                    $arra2 = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

                    $filename = str_replace($arra1, $arra2, $_FILES["attachment_file"]['name']);
                    $s = time() . "*^*" . $filename;

                    $fileNormal = $DIR_DOC . $s;

                    $file = $_FILES["attachment_file"]['tmp_name'];
                    list($width, $height) = getimagesize($file);
                    $result = move_uploaded_file($file, $fileNormal);
                    if ($result == 1) {
                        //$m_img_real= $_SERVER['DOCUMENT_ROOT'].'/lab4/project/cms_admin/images/uploaded/'.$_REQUEST['img_last'];
                        $m_img_real = PHYSICAL_PATH . "uploaded_image/normal/" . $_REQUEST['last_img'];
                        $m_img_thumb = PHYSICAL_PATH . "uploaded_image/thumbnail/" . $_REQUEST['last_img'];
                        if (file_exists($m_img_real)) {
                            unlink($m_img_real);
                            //unlink($m_img_thumbs);
                        }
                        if (file_exists($m_img_thumb)) {
                            unlink($m_img_thumb);
                            //unlink($m_img_thumbs);
                        }
                        $DIR_IMG_THUMB = PHYSICAL_PATH . "uploaded_image/thumbnail/";
                        $fileThumb = $DIR_IMG_THUMB . $s;
                        $thumbWidth = 747;
                        $thumbHeight = 309;

                        //thumbnail($DIR_DOC,$DIR_IMG_THUMB,$thumbWidth,$thumbHeight,$s);			    
                        $update_image = $this->contactpage_model->thumbnail($fileThumb, $fileNormal, $thumbWidth, $thumbHeight, '');
                    }

                    $data_to_store = array(
                        'text' => $this->input->post('text'),
                        'image' => $s,
                        'contact' => $this->input->post('contact'),
                        'status' => $this->input->post('status'),
                    );
                    $upd_data = $this->contactpage_model->update_contactpage_value('contact_page', $this->input->post('id'), $data_to_store);

                    if ($upd_data) {
                        $this->session->set_userdata('success_msg', 'Write us page content updated successfully');
                    } else {
                        $this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
                    }
                    redirect('contact_page');
                }
            } else {

                $data_to_store = array(
                    'text' => $this->input->post('text'),
                    'contact' => $this->input->post('contact'),
                    'status' => $this->input->post('status'),
                );
                $upd_data = $this->contactpage_model->update_contactpage_value('contact_page', $this->input->post('id'), $data_to_store);

                if ($upd_data) {
                    $this->session->set_userdata('success_msg', 'Write us page content updated successfully');
                } else {
                    $this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
                }
                redirect('contact_page');
            }
        }
    }

}

?>