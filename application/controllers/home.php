<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

class Home extends CI_Controller {

    // Controller class for Login
    function __construct() {
        parent::__construct();

        $this->load->model('site_settings_model'); //loading model
        $this->load->model('home_model'); //loading model
        $this->load->library('pagination'); //loading session
    }

    //============load home page================//
    function index() {
        $data['slider'] = $slider = $this->home_model->get_slider();

        $data['totalRow'] = $this->home_model->get_total_count();
        $perPage = 20;
        if ($this->input->get('page') == "" || $this->input->get('page') == 0) {
            $currentPage = 1;
        } else {
            $currentPage = $this->input->get('page');
        }
        $start = (($currentPage - 1) * $perPage);
        $limit = $perPage;

        $data["blog_data"] = $this->home_model->get_blog_value_pagi($perPage, $start);
        $data["links"] = $this->pagination->create_links();
        $data['pagi'] = $this->myPagination($data['totalRow'], $perPage, $currentPage, $url = '?');
        $this->load->view('home/index', $data);
    }

    function category() {
        $id = $this->uri->segment(3);
        if (!$id) {
            redirect('home');
        } else {
            $data['slider'] = $slider = $this->home_model->get_slider();

            $data['totalRow'] = $totalRow = $this->home_model->get_total_count($id);
            if ($totalRow == 0) {
                redirect('home');
            }
            $perPage = 20;
            if ($this->input->get('page') == "" || $this->input->get('page') == 0) {
                $currentPage = 1;
            } else {
                $currentPage = $this->input->get('page');
            }
            $start = (($currentPage - 1) * $perPage);
            $limit = $perPage;

            $data["blog_data"] = $this->home_model->get_blog_value_pagi($perPage, $start, $id);
            $data["links"] = $this->pagination->create_links();
            $data['pagi'] = $this->myPagination($data['totalRow'], $perPage, $currentPage, $url = '?');
            $this->load->view('home/index', $data);
        }
    }

    function article() {
        $id = $this->uri->segment(3);
        if ($id) {
            $data['details'] = $details = $this->home_model->get_blog_value($id);
//            echo $this->db->last_query();
//            die();
            if (!empty($details)) {
                $this->load->view('home/details', $data);
            } else {
                redirect('home');
            }
        } else {
            redirect('home');
        }
    }

    public function myPagination($total = 0, $per_page = 20, $page = 1, $url = '?') {

        $createURL = explode('?page=', $_SERVER['REQUEST_URI']);
        $createURL = $createURL[0] . '?page=';
        $total = $total;
        $adjacents = "2";

        $prevlabel = "&lsaquo; Prev";
        $nextlabel = "Next &rsaquo;";
        $lastlabel = "Last &rsaquo;&rsaquo;";

        $page = ($page == 0 ? 1 : $page);
        $start = ($page - 1) * $per_page;

        $prev = $page - 1;
        $next = $page + 1;

        $lastpage = ceil($total / $per_page);

        if ($lastpage < 2) {
            return '';
        }
        $lpm1 = $lastpage - 1; // //last page minus 1

        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<ul class='pagination'>";
            $pagination .= "<li class='page_info'><span>Page {$page} of {$lastpage}</span></li>";

            if ($page > 1)
                $pagination .= "<li><a href='{$createURL}{$prev}' id='GoSearchPagi' page='{$prev}'>{$prevlabel}</a></li>";

            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li class='active'><a class='current'>{$counter}</a></li>";
                    else
                        $pagination .= "<li><a href='{$createURL}{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {

                if ($page < 1 + ($adjacents * 2)) {

                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='active'><a class='current'>{$counter}</a></li>";
                        else
                            $pagination .= "<li><a href='{$createURL}{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";
                    }
                    $pagination .= "<li class='dot'>...</li>";
                    $pagination .= "<li><a href='{$createURL}{$lpm1}' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
                    $pagination .= "<li><a href='{$createURL}{$lastpage}' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";
                } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

                    $pagination .= "<li><a href='{$createURL}1' id='GoSearchPagi' page='1'>1</a></li>";
                    $pagination .= "<li><a href='{$createURL}2' id='GoSearchPagi' page='2'>2</a></li>";
                    $pagination .= "<li class='dot'>...</li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='active'><a class='current'>{$counter}</a></li>";
                        else
                            $pagination .= "<li><a href='{$createURL}{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";
                    }
                    $pagination .= "<li class='dot'>..</li>";
                    $pagination .= "<li><a href='{$createURL}{$lpm1}' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
                    $pagination .= "<li><a href='{$createURL}{$lastpage}' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";
                } else {

                    $pagination .= "<li><a href='{$createURL}1' id='GoSearchPagi' page='1'>1</a></li>";
                    $pagination .= "<li><a href='{$createURL}2' id='GoSearchPagi' page='2'>2</a></li>";
                    $pagination .= "<li class='dot'>..</li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='active'><a class='current'>{$counter}</a></li>";
                        else
                            $pagination .= "<li><a href='{$createURL}{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";
                    }
                }
            }

            if ($page < $counter - 1) {
                $pagination .= "<li><a href='{$createURL}{$next}' id='GoSearchPagi' page='{$next}'>{$nextlabel}</a></li>";
                $pagination .= "<li><a href='{$createURL}{$lastpage}' id='GoSearchPagi' page='{$lastpage}'>{$lastlabel}</a></li>";
            }

            $pagination .= "</ul>";
        }

        return $pagination;
    }

    function log_out() {           // log out function
        $this->session->unset_userdata('is_logged_in');
        $this->session->unset_userdata('uid');
        $this->session->unset_userdata('comenterid');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('profile_pic');
        $this->session->set_userdata('success_msg', 'You have logged out successfully.');
        redirect('home');
    }

    function subsciption() {
        $email = $this->input->post('subsciptionmail');
        if ($email != "") {
            $flag = $this->site_settings_model->subscription($email);
            if ($flag == 1) {
                $template_html = $this->site_settings_model->get_email_template(37);

                if (!empty($template_html)) {
                    $subject = $template_html[0]['email_title'];
                    $body = $template_html[0]['email_desc'];
//                print_r($email);
//                die();
                    $flag = $this->all_function->send_mail($email, $subject, $body);
                }
            }
            echo $flag;
        }
    }

}

?>