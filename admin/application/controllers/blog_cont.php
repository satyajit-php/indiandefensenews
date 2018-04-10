<?php

//error_reporting(E_ALL);
//    ini_set('display_errors', 1);
class Blog_cont extends CI_Controller {

    // Controller class for site_settings
    function __construct() {
        parent::__construct();
        $this->load->model('left_panel_model'); // calls the model
        $this->load->model('login_model');
        $this->load->model('site_settings_model'); // calls the model
        $this->load->model('blog_model'); // calls the model
        $this->load->model('blog_tag_model');
        $this->load->model('news_source_model');
        $this->load->model('guest_post_model');   //load email template model
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

        $data['blog_data'] = $this->blog_model->get_blog_value();
        $this->load->view('blog_management/index', $data);

        $this->load->view('includes/footer');
    }

    //============load view page of add_article================//
    function add_blog() {
        $id = $this->uri->segment(3);
        if ($id) {
            $data['guestpost_arr'] = $guestpost_arr = $this->guest_post_model->get_data('guest_post', $id);
        }
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $this->load->view('blog_management/add_content', $data);
        $this->load->view('includes/footer');
    }

    function viewcomm($id) {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');

        $d = $this->blog_model->get_comment($id);

        foreach ($d as $key => $r) {
            $p = $r->posted_by;

            $name = $this->blog_model->comm_detail($p);
            if (!empty($name)) {
                $d[$key]->name = $name[0]->first_name;
            }
        }

        $data['result'] = $d;

        $this->load->view('blog_management/comm_detail', $data);

        $this->load->view('includes/footer');
    }

    //============insert data into article================//	
    function insert_blog_content() {
        if ($this->input->post('mode_blog') == 'insert_blog') {

            $blog_source = $this->input->post('blog_source');
            $blog_category = $this->input->post('blog_category');
            $files = $_FILES['attachment_file'];


            if (isset($_FILES['attachment_file']['name']) && !empty($_FILES['attachment_file']['name'])) {
                if ($_FILES["attachment_file"]["name"] != "") {
                    if (preg_match('/video\/*/', $_FILES['attachment_file']['type'])) {
                        // this code for video
                        $thumb = false;
                        $DIR_DOC = PHYSICAL_PATH . "uploaded_video/normal/";
                        $data_to_store['media_type'] = 'V';
                    } else {
                        // this code for image
                        $thumb = true;
                        $DIR_DOC = PHYSICAL_PATH . "uploaded_image/normal/";
                        $data_to_store['media_type'] = 'I';
                    }
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

                    if ($result == 1 && ($thumb)) {
                        $DIR_IMG_THUMB = PHYSICAL_PATH . "uploaded_image/thumbnail/";
                        $fileThumb = $DIR_IMG_THUMB . $s;
                        $thumbWidth = 747;
                        $thumbHeight = 309;

                        //thumbnail($DIR_DOC,$DIR_IMG_THUMB,$thumbWidth,$thumbHeight,$s);			    
                        $update_image = $this->blog_model->thumbnail($fileThumb, $fileNormal, $thumbWidth, $thumbHeight, '');
                        //$date = date('Y-m-d H:i:s');
                    }
                    if ($this->input->post('new_tag')) {
                        $this->load->model('blog_tag_model'); // calls the model
                        $data_to_store = array(
                            'tag_name' => $this->input->post('new_tag'),
                            'status' => '1'
                        );
                        $insrt_data = $this->blog_tag_model->insert_blog_value('blog_tag', $data_to_store);
                        $blog_category = $this->db->insert_id();
                    }
                    if ($this->input->post('new_source')) {
                        $this->load->model('news_source_model'); // calls the model
                        $new_source = $this->input->post('new_source');
                        $data_to_store = array(
                            'short_name' => $new_source,
                            'status' => '1'
                        );
                        $insrt_data = $this->news_source_model->insert_source('news_source', $data_to_store);
                        $blog_source = $this->db->insert_id();
                    }
                    $data_to_store = array(
                        'blog_title' => $this->input->post('blog_title'),
                        'blog_tag' => $this->input->post('get_tag'),
                        'added_by' => $this->input->post('added_by'),
                        'blog_category' => $blog_category,
                        'blog_source' => $blog_source,
                        'added_on' => date('Y-m-d'),
                        'images' => $s,
                        'details' => $this->input->post('blog_desc'),
                        'meta_title' => $this->input->post('meta_title'),
                        'meta_description' => $this->input->post('meta_description'),
                        'blog_url' => $this->input->post('blog_url'),
                        'status' => $this->input->post('status')
                    );
                    $insrt_data = $this->blog_model->insert_blog_value('blog', $data_to_store);
                    if ($insrt_data == '1') {
                        if ($this->input->post("guest")) {
                            $guestId = $this->input->post("guest");
                            $stat_param['status'] = 'P';
                            $stat_param['released_on'] = date('Y-m-d');

                            $this->guest_post_model->change_status_to('guest_post', $stat_param, $guestId);
                            $guestpost_arr = $this->guest_post_model->get_data('guest_post', $guestId);
                            $email = $guestpost_arr[0]->email;
                            $name = $guestpost_arr[0]->name;
                            $template_html = $this->site_settings_model->get_email_template(36);
                            if (!empty($template_html)) {
                                $logourl = "<a href='" . base_url() . "'><img class='img-responsive' src='" . LOGO_URL . "' alt='indiandefensenews.org'></a>";
                                $subject = $template_html[0]['email_title'];
                                $body = $template_html[0]['email_desc'];
                                $body = str_replace("[LOGO]", $logourl, $body);
                                $body = str_replace("[LINK]", base_url(), $body);
                                $body = str_replace("[RECEIVER]", $name, $body);
                            }
                            $flag = $this->all_function->send_mail($email, $subject, $body);
                        }
                        $this->session->set_userdata('success_msg', 'Blog content inserted successfully');
                        redirect('blog_cont');
                    } else {
                        $this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
                        redirect('blog_cont/add_blog');
                    }
                }
            } else {
                $date = date('Y-m-d H:i:s');
                $data_to_store['media_type'] = 'Y';
                $data_to_store = array(
                    'blog_title' => $this->input->post('blog_title'),
                    'blog_tag' => $this->input->post('get_tag'),
                    'added_by' => $this->input->post('added_by'),
                    'added_on' => $date,
                    'images' => $this->input->post('last_img'),
                    'details' => $this->input->post('blog_desc'),
                    'meta_title' => $this->input->post('meta_title'),
                    'meta_description' => $this->input->post('meta_description'),
                    'youtube_url' => $this->input->post('youtube_url'),
                    'blog_url' => $this->input->post('blog_url'),
                    'status' => $this->input->post('status')
                );
                $insrt_data = $this->blog_model->insert_blog_value('blog', $data_to_store);

                if ($insrt_data) {
                    if ($this->input->post("guest")) {
                        $guestId = $this->input->post("guest");
                        $stat_param['status'] = 'P';
                        $stat_param['released_on'] = date('Y-m-d');

                        $this->guest_post_model->change_status_to('guest_post', $stat_param, $guestId);
                        $guestpost_arr = $this->guest_post_model->get_data('guest_post', $guestId);
                        $email = $guestpost_arr[0]->email;
                        $name = $guestpost_arr[0]->name;
                        $template_html = $this->site_settings_model->get_email_template(36);
                        if (!empty($template_html)) {
                            $logourl = "<a href='" . base_url() . "'><img class='img-responsive' src='" . base_url() . "'assets/images/logo.png' alt='indiandefensenews.org'></a>";
                            $subject = $template_html[0]['email_title'];
                            $body = $template_html[0]['email_desc'];
                            $body = str_replace("[LOGO]", $logourl, $body);
                            $body = str_replace("[LINK]", base_url(), $body);
                            $body = str_replace("[RECEIVER]", $name, $body);
                        }
                        $flag = $this->all_function->send_mail($email, $subject, $body);
                    }
                    $this->session->set_userdata('success_msg', 'Blog content add successfully');
                    redirect('blog_cont');
                } else {
                    $this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
                    redirect('blog_cont/add_blog');
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
        $updt_status = $this->blog_model->change_status_to('blog', $stat_param, $id);
        if ($updt_status) {
            $this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot update status.');
        }
        redirect('blog_cont');
    }

    function del_data() {
        $id = $this->uri->segment(3);

        $del_data = $this->blog_model->del_data('blog', $id);
        if ($del_data) {
            $this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot delete data.');
        }

        redirect('blog_cont');
    }

    //=============delete the data from article============//
    function del_comm() {
        $id = $this->uri->segment(3);
        $bid = $this->blog_model->getblog_id($id);

        $i = $bid[0]->blog_id;
        $del_data = $this->blog_model->del_data('blog_comment', $id);
        if ($del_data) {
            $this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot delete data.');
        }

        redirect('blog_cont/viewcomm/' . $i);
    }

    //============load view page of edit_article================//
    function edit_blog() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        //$this->load->view('article/edit_article');
        $id = $this->uri->segment(3);
        $data['blog_data'] = $this->blog_model->sel_data_up($id);
        $this->load->view('blog_management/edit_content', $data);
        $this->load->view('includes/footer');
    }

    //============update data into article================//	
    function update_blog() {
        if ($this->input->post('mode_blog') == 'update_blog') {
            $id = $this->input->post('id');
            //print_r($_FILES['attachment_file']);
            if (isset($_FILES['attachment_file']['name']) && !empty($_FILES['attachment_file']['name'])) {
                if ($_FILES["attachment_file"]["name"] != "") {

                    if (preg_match('/video\/*/', $_FILES['attachment_file']['type'])) {
                        // this code for video

                        $thumb = false;
                        $DIR_DOC = PHYSICAL_PATH . "uploaded_video/normal/";
                        $data_to_store['media_type'] = 'V';
                    } else {
                        // this code for image

                        $thumb = true;
                        $DIR_DOC = PHYSICAL_PATH . "uploaded_image/normal/";
                        $data_to_store['media_type'] = 'I';
                    }
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
                    if ($result == 1 && ($thumb)) {
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
                        $update_image = $this->blog_model->thumbnail($fileThumb, $fileNormal, $thumbWidth, $thumbHeight, '');
                    }
                    $date = date('Y-m-d H:i:s');
                    $data_to_store = array(
                        'blog_title' => $this->input->post('blog_title'),
                        'blog_tag' => $this->input->post('get_tag'),
                        'added_by' => $this->input->post('added_by'),
                        'added_on' => $date,
                        'images' => $s,
                        'details' => $this->input->post('blog_desc'),
                        'status' => $this->input->post('status'),
                        'blog_url' => $this->input->post('blog_url'),
                        'meta_title' => $this->input->post('meta_title'),
                        'meta_description' => $this->input->post('meta_description'),
                        'youtube_url' => $this->input->post('youtube_url'),
                    );
                    $upd_data = $this->blog_model->update_blog_value('blog', $this->input->post('id'), $data_to_store);

                    if ($upd_data) {
                        $this->session->set_userdata('success_msg', 'Blog content updated successfully');
                    } else {
                        $this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
                    }
                    redirect('blog_cont');
                }
            } else {
                $date = date('Y-m-d H:i:s');
                $data_to_store['media_type'] = 'Y';
                $data_to_store = array(
                    'blog_title' => $this->input->post('blog_title'),
                    'blog_tag' => $this->input->post('get_tag'),
                    'added_by' => $this->input->post('added_by'),
                    'added_on' => $date,
                    'images' => $this->input->post('last_img'),
                    'details' => $this->input->post('blog_desc'),
                    'blog_url' => $this->input->post('blog_url'),
                    'meta_title' => $this->input->post('meta_title'),
                    'meta_description' => $this->input->post('meta_description'),
                    'youtube_url' => $this->input->post('youtube_url'),
                );
                $upd_data = $this->blog_model->update_blog_value('blog', $this->input->post('id'), $data_to_store);

                if ($upd_data) {
                    $this->session->set_userdata('success_msg', 'Blog content updated successfully');
                } else {
                    $this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
                }
                redirect('blog_cont');
            }
        }
    }

}

?>