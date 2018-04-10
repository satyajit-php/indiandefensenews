<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

class Country_cont extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('left_panel_model');

        $this->load->model('country_model'); //load email template model
        $this->load->model('state_model');
        $this->load->model('district_model');
        $this->load->model('city_model');
        $this->load->model('login_model');
        $this->load->library('session');   //load session library
        if ($this->session->userdata('admin_is_logged_in') != true) {
            $this->session->set_userdata('error_msg', 'Please log in first..');
            redirect('login_cont');
        } else if ($this->session->userdata('admin_is_superadmin') != 1) {
            $data = $this->login_model->page_details('country_cont', 'admin_management_list');
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

    //============load view page of email template================//
    function index() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');

        $perPage = 10;
        if ($this->input->get('page') == "" || $this->input->get('page') == 0) {
            $currentPage = 1;
        } else {
            $currentPage = $this->input->get('page');
        }
        if ($currentPage == "") {
            $currentPage = 1;
        }
        $start = (($currentPage - 1) * $perPage);
        //echo	$start = (($currentPage*$perPage)-$perPage);
        $limit = $perPage;
        $searchData = $this->input->get('searchData');
        $allDataInCompany = $this->country_model->select_all_country($searchData);
        $data['result'] = $this->country_model->select_all_country_last($searchData, $start, $limit);
        $totalItem = count($allDataInCompany);

        $data['pagi'] = $this->myPagination($totalItem, $perPage, $currentPage, $url = '?');


        //$data['result'] = $this->country_model->select_all_country();
        $this->load->view('country_mgmt/country_list', $data);

        $this->load->view('includes/footer');
    }

    //============load view page of add_article================//
    function add_country() {
        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $this->load->view('country_mgmt/add_country');
        $this->load->view('includes/footer');
    }

    //============insert data into article================//	
    function insert_country() {
        if ($this->input->post('mode_article') == 'insert_country') {
            $data_to_store = array(
                'name' => $this->input->post('country_name'),
                'currency_name' => $this->input->post('currency'),
                'country_code' => $this->input->post('country_code'),
                'currency_code' => $this->input->post('currency_code'),
                'currrency_symbol' => $this->input->post('symbol'),
                'location_type' => 0,
                'parent_id' => 0
                    //'modified_by' => $this->session->userdata('uid')
            );
            //$insrt_data=$this->country_model->insert_country_value('country', $data_to_store);
            $insrt_data = $this->country_model->insert_country_value('location', $data_to_store);
            if ($insrt_data == 1) {
                $this->session->set_userdata('success_msg', 'Article inserted successfully');
                redirect('country_cont');
            } else if ($insrt_data == 0) {
                $this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
                redirect('country_cont/add_country');
            }
        }
    }

    //=============changin the status of article============//
    function change_status_to() {
        $stat_param = array(
            'is_visible' => $this->uri->segment(3)
        );
        $id = $this->uri->segment(4);
        $updt_status = $this->country_model->change_status_to('location', $stat_param, $id);
        if ($updt_status) {
            $this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot update status.');
        }
        redirect('country_cont');
    }

    //=============delete the data from country============//
    function del_data() {
        $id = $this->uri->segment(3);
        $del_data = $this->country_model->country_name($id);
        $loc_type = $del_data[0]->location_type;
        $state = array();
        $district = array();
        $city = array();
        if ($loc_type == 0) {

            $data_state = $this->country_model->fetch_all_state_of_country($id);
            foreach ($data_state as $key => $row1) {
                if ($row1->location_type == 1) {
                    $state[$key] = $row1->location_id;
                }
                if ($row1->location_type == 3) {
                    $district[$key] = $row1->location_id;
                }
                if ($row1->location_type == 2) {
                    $city[$key] = $row1->location_id;
                }
            }

            foreach ($city as $city_id) {
                echo $city_id;
                //$del_data = $this->country_model->del_data('location', $city_id);
            }
            foreach ($district as $distict_id) {
                echo $distict_id;
                //$del_data = $this->country_model->del_data('location', $distict_id);
            }
            foreach ($state as $state_id) {
                echo $state_id;
                //$del_data = $this->country_model->del_data('location', $state_id);
            }

            //$del_data = $this->country_model->del_data('location', $id);
            die();
        }
        if ($loc_type == 1) {
            $data_district = $this->country_model->fetch_all_state_of_country($id);
            foreach ($data_district as $key2 => $row2) {

                if ($row2->location_type == 3) {
                    $district[$key2] = $row1->location_id;
                }
                if ($row2->location_type == 2) {
                    $city[$key2] = $row1->location_id;
                }
            }
            foreach ($city as $city_id) {
                $del_data = $this->country_model->del_data('location', $city_id);
            }
            foreach ($district as $distict_id) {
                $del_data = $this->country_model->del_data('location', $distict_id);
            }

            $del_data = $this->country_model->del_data('location', $id);
        }
        if ($loc_type == 3) {
            $data_district = $this->country_model->fetch_all_state_of_country($id);
            foreach ($data_district as $key3 => $row3) {


                if ($row3->location_type == 2) {
                    $city[$key3] = $row1->location_id;
                }
            }
            foreach ($city as $city_id) {
                $del_data = $this->country_model->del_data('location', $city_id);
            }
            $del_data = $this->country_model->del_data('location', $id);
        }
        if ($loc_type == 2) {
            $del_data = $this->country_model->del_data('location', $id);
        }
        if ($del_data) {
            $this->session->set_userdata('success_msg', 'location deleted susseccfully.');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot delete data.');
        }
        redirect('country_cont');
    }

    //======================load edit country=====================//
    function edit_country() {
        $id = $this->uri->segment(3);
        $data['country_arr'] = $this->country_model->get_country_mgmt('country', $id);

        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $this->load->view('country_mgmt/edit_country', $data);
        $this->load->view('includes/footer');
    }

    //============update data into article================//	
    function update_country() {
        $id = $this->uri->segment(3);
        $data_to_store = array(
            'country_name' => $this->input->post('country_name'),
            'currency_name' => $this->input->post('currency'),
            'currency_code' => $this->input->post('currency_code'),
            'symbol' => $this->input->post('symbol'),
            'status' => $this->input->post('country_stat'),
            'modified_by' => $this->session->userdata('uid')
        );
        $insrt_data = $this->country_model->update_country_value('country', $data_to_store, $id);
        if ($insrt_data == '1') {
            $this->session->set_userdata('success_msg', 'Article inserted successfully');
        } else {
            $this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
        }
        redirect('country_cont');
    }

    //============insert data into state================//	
    function insert_state() {
        if ($this->input->post('mode_state') == 'insert_state') {
            $data_to_store = array(
                'parent_id' => $this->input->post('country_id'),
                'name' => $this->input->post('state'),
                'location_type' => 1

                    //'modified_by' => $this->session->userdata('uid')
            );
            //$insrt_data=$this->state_model->insert_state_value('state', $data_to_store);
            $insrt_data = $this->state_model->insert_state_value('location', $data_to_store);
            if ($insrt_data == 1) {
                $this->session->set_userdata('success_msg', 'State inserted successfully');
                redirect('country_cont');
            } else if ($insrt_data == 0) {
                $this->session->set_userdata('error_msg', 'Can not insert duplicate data.');
                redirect('country_cont');
            }
        }
    }

    //=============changin the status of state============//
    //==============get ajax value for fetch state==================//

    public function Select_state() {
        //echo "dfsddgfdgd";
        //die();
        $this->load->model('city_model');
        $result = $this->city_model->Select_state($_REQUEST['country_id']);

        if ($result) {
            //print_r($result);
            $varbl = '';
            $varbl .= '<option value="0">Select state </option>';
            foreach ($result as $key => $val) {

                $varbl .= '<option value="' . $val->location_id . '">' . ucfirst($val->name) . '</option>';
            }
            echo $varbl;
        } else if (count($result) == 0) {
            echo(count($result));
        }
    }

    //==================end get ajax value for fetch state============//
    //==============get ajax value for fetch state==================//

    public function Select_dist() {
        //echo "dfsddgfdgd";
        //die();
        // $this->load->model('city_model');
        $result = $this->city_model->Select_dist($_REQUEST['state_id']);

        if ($result) {
            //print_r($result);
            $varbl = '';
            $varbl .= '<option value="0">Select district</option>';
            foreach ($result as $key => $val) {

                $varbl .= '<option value="' . $val->location_id . '">' . ucfirst($val->name) . '</option>';
            }
            echo $varbl;
        } else if (count($result) == 0) {
            echo(count($result));
        }
    }

    //==================end get ajax value for fetch state============//
    //============insert data into city================//
    function insert_dist() {
        if ($this->input->post('state1') != '' || $this->input->post('state1') != 0) {
            $parent_id = $this->input->post('state1');

            $flag = 'state';
            //echo $this->input->post('state1');
            //die();

            $data = array(
                'parent_id' => $this->input->post('state1'),
                'name' => $this->input->post('dist'),
                'location_type' => 3
            );
        } else {
            $parent_id = $this->input->post('country');

            //echo $this->input->post('country');
            //die();
            $flag = 'country';

            $data = array(
                'parent_id' => $this->input->post('country'),
                'name' => $this->input->post('dist'),
                'location_type' => 3
            );
        }


        $insrt_data = $this->district_model->dist_insert('location', $data, $flag);
        if ($insrt_data == 1) {
            $this->session->set_userdata('success_msg', 'Data added susseccfully.');
            redirect('country_cont');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot add duplicate data.');
            redirect('country_cont');
        }
    }

    //=============changin the status of city============//

    function insert_city() {
        if ($this->input->post('district1') != '' || $this->input->post('district1') != 0) {


            //$flag='district';
            //echo $this->input->post('state1');
            //die();

            $data = array(
                'parent_id' => $this->input->post('district1'),
                'name' => $this->input->post('city'),
                'zipcode' => $this->input->post('pin'),
                'location_type' => 2
            );
        } else if ($this->input->post('state2') != '' || $this->input->post('state2') != 0) {

            //$flag='state';
            //echo $this->input->post('state1');
            //die();

            $data = array(
                'parent_id' => $this->input->post('state2'),
                'name' => $this->input->post('city'),
                'zipcode' => $this->input->post('pin'),
                'location_type' => 2
            );
        } else {
            $parent_id = $this->input->post('country');

            //echo $this->input->post('country');
            //die();
            //$flag='country';

            $data = array(
                'parent_id' => $this->input->post('country'),
                'name' => $this->input->post('city'),
                'zipcode' => $this->input->post('pin'),
                'location_type' => 2
            );
        }


        $insrt_data = $this->city_model->city_insert_country('location', $data);
        if ($insrt_data) {
            $this->session->set_userdata('success_msg', 'Data added susseccfully.');
            redirect('country_cont');
        } else {
            $this->session->set_userdata('error_msg', 'Cannot add duplicate data.');
            redirect('country_cont');
        }
    }

    //=============changin the status of city============//

    function edit_location() {

        $this->load->view('includes/header');
        $this->load->view('includes/top_header');
        $this->load->view('includes/left_panel');
        $id = $this->uri->segment(3);
        $data = array();

        $result = $this->country_model->get_location_id($id);
        $data['zip'] = $result[0]->zipcode;
        $loc_type = $result[0]->location_type;

        if ($loc_type == 0) {


            $data['country'] = $result[0]->name;
            $data['location_id'] = $id;

            //print_r($dat);
            //die();
            $this->load->view('country_mgmt/edit_con', $data);
        }
        if ($loc_type == 1) {
            $data['state'] = $result[0]->name;
            $data['location_id'] = $id;
            $id3 = $result[0]->parent_id;
            $con_nm = $this->country_model->country_name($id3);
            $data['country'] = $con_nm[0]->name;
            $this->load->view('country_mgmt/edit_state', $data);
        }
        if ($loc_type == 3) {
            $data['district'] = $result[0]->name;
            $data['location_id'] = $id;
            $id2 = $result[0]->parent_id;

            $res2_state = $this->country_model->get_location_id($id2);
            if (!empty($res2_state)) {
                $type3 = $res2_state[0]->location_type;

                if ($type3 == 1) {
                    $data['state'] = $res2_state[0]->name;
                } else if ($type3 == 0) {
                    $data['country'] = $res2_state[0]->name;
                }

                $cid2 = $res2_state[0]->parent_id;


                $res2_con = $this->country_model->get_location_id($cid2);
            }
            if (!empty($res2_con)) {

                $data['country'] = $res2_con[0]->name;
            }
            $this->load->view('country_mgmt/edit_district', $data);
        }
        if ($loc_type == 2) {
            $data['city'] = $result[0]->name;
            $data['location_id'] = $id;
            $id1 = $result[0]->parent_id;

            $res_dis = $this->country_model->get_location_id($id1);
            if (!empty($res_dis)) {
                $type1 = $res_dis[0]->location_type;
                if ($type1 == 3) {

                    $data['district'] = $res_dis[0]->name;
                } else if ($type1 == 1) {
                    $data['state'] = $res_dis[0]->name;
                } else if ($type1 == 0) {
                    $data['$country'] = $res_dis[0]->name;
                }

                $sid = $res_dis[0]->parent_id;


                $res_state = $this->country_model->get_location_id($sid);
            }
            if (!empty($res_state)) {
                $type2 = $res_state[0]->location_type;

                if ($type2 == 1) {
                    $data['state'] = $res_state[0]->name;
                } else if ($type2 == 0) {
                    $data['country'] = $res_state[0]->name;
                }

                $cid = $res_state[0]->parent_id;


                $res_con = $this->country_model->get_location_id($cid);
            }
            if (!empty($res_con)) {
                $data['country'] = $res_con[0]->name;
            }
            $this->load->view('country_mgmt/edit_city', $data);
        }
        $this->load->view('includes/footer');
    }

    function update_con() {

        $id = $this->input->post('id');
        $data_to_store = array(
            'name' => $this->input->post('country_name'),
        );
        $insrt_data = $this->country_model->update_country_value('location', $data_to_store, $id);
        if ($insrt_data) {
            $this->session->set_userdata('success_msg', 'Country updated successfully');
        } else {
            $this->session->set_userdata('error_msg', 'Can not update duplicate data.');
        }
        redirect('country_cont');
    }

    function update_state() {
        $id = $this->input->post('id');
        $data_to_store = array(
            'name' => $this->input->post('state'),
        );
        $insrt_data = $this->country_model->update_state_value('location', $data_to_store, $id);
        if ($insrt_data) {
            $this->session->set_userdata('success_msg', 'State is updated successfully');
        } else {
            $this->session->set_userdata('error_msg', 'Can not update duplicate data.');
        }
        redirect('country_cont');
    }

    function update_district() {
        $id = $this->input->post('id');
        $data_to_store = array(
            'name' => $this->input->post('district'),
        );
        $insrt_data = $this->country_model->update_state_value('location', $data_to_store, $id);
        if ($insrt_data) {
            $this->session->set_userdata('success_msg', 'District updated successfully');
        } else {
            $this->session->set_userdata('error_msg', 'Can not update duplicate data.');
        }
        redirect('country_cont');
    }

    function update_city() {
        $id = $this->input->post('id');
        $data_to_store = array(
            'name' => $this->input->post('city'),
            'zipcode' => $this->input->post('pin'),
        );
        $insrt_data = $this->country_model->update_city_value('location', $data_to_store, $id);
        if ($insrt_data) {
            $this->session->set_userdata('success_msg', 'City updated successfully');
        } else {
            $this->session->set_userdata('error_msg', 'Can not update duplicate data.');
        }
        redirect('country_cont');
    }

    public function myPagination($total = 0, $per_page = 10, $page = 1, $url = '?') {

        $createURL = explode('&page=', $_SERVER['REQUEST_URI']);
        $createURL = $createURL[0] . '&page=';
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

}

?>