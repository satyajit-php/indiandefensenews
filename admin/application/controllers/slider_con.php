<?php

class Slider_con extends CI_Controller {

    // Controller class for site_settings
    function __construct() {
        parent::__construct();
        $this->load->model('left_panel_model'); // calls the model
        $this->load->model('login_model');
        $this->load->model('site_settings_model'); // calls the model
        $this->load->model('slider_model'); // calls the model
        $this->load->library('session');
        $this->load->helper('date');
        if ($this->session->userdata('admin_is_logged_in') != true) {
            $this->session->set_userdata('error_msg', 'Please login first.');
            redirect('login_cont');
        } else if ($this->session->userdata('admin_is_superadmin') != 1) {
            $data = $this->login_model->page_details('slider_con', 'admin_management_list');
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

        $data['blog_data'] = $this->slider_model->get_blog_value();
        $this->load->view('slider/slider_mgmt', $data);

        $this->load->view('includes/footer');
    }

    //============load view page of add_article================//
    function add_slider() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $this->load->view('slider/add_slider');
        $this->load->view('includes/footer');
    }

    //============insert data into article================//	
    function insert_image() {
        if ($this->input->post('mode_blog') == 'insert_blog') {
            $files = $_FILES['attachment_file'];
            if (isset($_FILES['attachment_file']['name']) && !empty($_FILES['attachment_file']['name'])) {
                if ($_FILES["attachment_file"]["name"] != "") {
                    $ext = explode('/', strtolower($_FILES["attachment_file"]["type"]));

                    $DIR_DOC = PHYSICAL_PATH . "uploaded_image/slider_normal/";

                    $file_size = filesize($_FILES["attachment_file"]["tmp_name"]);

                    $arra1 = array(' ', '--', '&quot;', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', '\\', ';', "'", ',', '/', '*', '+', '~', '`', '=');
                    $arra2 = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

                    $filename = str_replace($arra1, $arra2, $_FILES["attachment_file"]['name']);
                    $s = time() . rand(000, 999) . $filename;

                    $fileNormal = $DIR_DOC . $s;

                    $file = $_FILES["attachment_file"]['tmp_name'];
                    list($width, $height) = getimagesize($file);
                    //echo "width->". $width;
                    //echo "hight->" .$height;
                    //die();

                    $result = move_uploaded_file($file, $fileNormal);


                    if ($result == 1) {
                        $DIR_IMG_THUMB = PHYSICAL_PATH . "uploaded_image/slider_thumbnail/";
                        $fileThumb = $DIR_IMG_THUMB . $s;
                        $thumbWidth = 1200;
                        $thumbHeight = 800;
                        //thumbnail($DIR_DOC,$DIR_IMG_THUMB,$thumbWidth,$thumbHeight,$s);			    
                        $update_image = $this->slider_model->thumbnail($fileThumb, $fileNormal, $thumbWidth, $thumbHeight, '');
                        $data_to_store = array(
                            'images' => $s,
                            'tagline' => $this->input->post('tagline'),
                            'status' => $this->input->post('status')
                        );
                        $insrt_data = $this->slider_model->insert_blog_value('slider', $data_to_store);
                        if ($insrt_data == '1') {
                            $this->session->set_userdata('success_msg', 'Slider image inserted successfully');
                            redirect('slider_con');
                        } else {
                            $this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
                            redirect('slider_con/add_slider');
                        }
                    }
                }
            }
        }
    }

    //=============changin the status of article============//
    function change_status_to() {
        $stat_param = array(
            'status' => $this->uri->segment(3)
        );
        $id = $this->uri->segment(4);
        $updt_status = $this->slider_model->change_status_to('slider', $stat_param, $id);
        if ($updt_status) {
            $this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot update status.');
        }
        redirect('slider_con');
    }

    //=============delete the data from article============//
    function del_data() {
        $id = $this->uri->segment(3);
        $del_data = $this->slider_model->del_data('slider', $id);
        if ($del_data) {
            $this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot delete data.');
        }
        redirect('slider_con');
    }

    //============load view page of edit_article================//
    function edit_data() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        //$this->load->view('article/edit_article');
        $id = $this->uri->segment(3);
        $data['blog_data'] = $this->slider_model->sel_data_up($id);
        $this->load->view('slider/edit_slider', $data);
        $this->load->view('includes/footer');
    }

    //============update data into article================//	
    function update_data() {
        if ($this->input->post('mode_blog') == 'update_blog') {
            $id = $this->input->post('id');
            //print_r($_FILES['attachment_file']);
            if (isset($_FILES['attachment_file']['name']) && !empty($_FILES['attachment_file']['name'])) {
                if ($_FILES["attachment_file"]["name"] != "") {
                    $ext = explode('/', strtolower($_FILES["attachment_file"]["type"]));

                    $DIR_DOC = PHYSICAL_PATH . "uploaded_image/slider_normal/";

                    $file_size = filesize($_FILES["attachment_file"]["tmp_name"]);

                    $arra1 = array(' ', '--', '&quot;', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', ':', '"', '<', '>', '?', '[', ']', '\\', ';', "'", ',', '/', '*', '+', '~', '`', '=');
                    $arra2 = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

                    $filename = str_replace($arra1, $arra2, $_FILES["attachment_file"]['name']);
                    $s = time() . rand() . $filename;

                    $fileNormal = $DIR_DOC . $s;

                    $file = $_FILES["attachment_file"]['tmp_name'];
                    list($width, $height) = getimagesize($file);
                    $result = move_uploaded_file($file, $fileNormal);
                    if ($result == 1) {
                        //$m_img_real= $_SERVER['DOCUMENT_ROOT'].'/lab4/project/cms_admin/images/uploaded/'.$_REQUEST['img_last'];
                        $m_img_real = PHYSICAL_PATH . "uploaded_image/slider_normal/" . $_REQUEST['last_img'];
                        $m_img_thumb = PHYSICAL_PATH . "uploaded_image/slider_thumbnail/" . $_REQUEST['last_img'];
                        if (file_exists($m_img_real)) {
                            unlink($m_img_real);
                            //unlink($m_img_thumbs);
                        }
                        if (file_exists($m_img_thumb)) {
                            unlink($m_img_thumb);
                            //unlink($m_img_thumbs);
                        }
                        $DIR_IMG_THUMB = PHYSICAL_PATH . "uploaded_image/slider_thumbnail/";
                        $fileThumb = $DIR_IMG_THUMB . $s;
                        $thumbWidth = 1200;
                        $thumbHeight = 800;

                        //thumbnail($DIR_DOC,$DIR_IMG_THUMB,$thumbWidth,$thumbHeight,$s);			    
                        $update_image = $this->slider_model->thumbnail($fileThumb, $fileNormal, $thumbWidth, $thumbHeight, '');


                        $data_to_store = array(
                            'images' => $s,
                            'tagline' => $this->input->post('tagline'),
                            'status' => $this->input->post('status')
                        );
                        $upd_data = $this->slider_model->update_blog_value('slider', $this->input->post('id'), $data_to_store);

                        if ($upd_data) {
                            $this->session->set_userdata('success_msg', 'Slider image updated successfully');
                        } else {
                            $this->session->set_userdata('error_msg', 'Cannot update  data.');
                        }
                        redirect('slider_con');
                    }
                }
            } else {

                $data_to_store = array(
                    'tagline' => $this->input->post('tagline'),
                    'status' => $this->input->post('status')
                );
                $upd_data = $this->slider_model->update_blog_value('slider', $this->input->post('id'), $data_to_store);

                if ($upd_data) {
                    $this->session->set_userdata('success_msg', 'Slider image inserted successfully');
                } else {
                    $this->session->set_userdata('error_msg', 'Cannot update  data.');
                }
                redirect('slider_con');
            }
        }
    }

}

?>