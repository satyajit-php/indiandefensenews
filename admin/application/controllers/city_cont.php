<?php
class city_cont extends CI_Controller {
   
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('html');
        $this->load->helper('form');
        $this->load->library('email');
        $this->load->model('left_panel_model');		//load model for sidepanel
        $this->load->model('city_model');		//load model for city
        $this->load->library('session');                //load library for session
        if($this->session->userdata('admin_is_logged_in')!=true)
        {
            $this->session->set_userdata('error_msg', 'Please login first.');
            redirect('login_cont');
        }
    }
    
    //============load view page of city================//
        function index()
        {
                $this->load->view('includes/header');
                $this->load->view('includes/top_header');
                $this->load->view('includes/left_panel');
                
                $data['city_arr']=$this->city_model->fetch_city();
                $data['state_arr']=$this->city_model->fetch_state();
                $data['country_arr']=$this->city_model->fetch_country();
                
                
                $this->load->view('city/city', $data);
                
                $this->load->view('includes/footer');
        }
         //============load view page to add new city================//
	function add_new_city()
	{
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		
		$this->load->view('city/add_new_city');
		
		$this->load->view('includes/footer');
	}
        
        public function Select_state()
	{
	     $this->load->model('city_model');
	     $result=$this->city_model->Select_state($_REQUEST['country_id']);
	    if($result !=0)
	    {
		foreach($result as $key=>$val)
		{
		    ?>
		    <option value="<?php echo $val->id;?>"><?php echo $val->state;?></option>
		    <?php
		}
	    }
	    else
	    {
		?>
		    <option value="0">Not Available</option>
		<?php
	    }
	}

         //============insert data into city================//
	function insert_city()
	{
		$data=array(
					'city' => $this->input->post('city'),
					'country_id' => $this->input->post('country'),
					'state_id' => $this->input->post('state'),
					'modified_by' => $this->session->userdata('admin_uid')
					);
		
		$insrt_data = $this->city_model->city_insert('city',$data);
		if($insrt_data)
		{
			$this->session->set_userdata('success_msg', 'Data added susseccfully.');
			redirect('city_cont');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot add duplicate data.');
			redirect('city_cont');
		}

	}
    //=============changin the status of city============//
	function change_status_to()
	{
		$stat_param= array(
			'status' => $this->uri->segment(3)
			);
		$id= $this->uri->segment(4);
		$updt_status = $this->city_model->change_status_to('city',$stat_param,$id);
		if($updt_status)
		{
			$this->session->set_userdata('success_msg', 'Status Updated susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot update status.');
		}
		redirect('city_cont');
	}
    //=============delete the data from city============//
	function del_data()
	{
		$id= $this->uri->segment(3);
		$del_data = $this->city_model->del_data('city', $id);
		if($del_data)
		{
			$this->session->set_userdata('success_msg', 'Data deleted susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot delete data.');
		}
		redirect('city_cont');
	}
        
	 //============load view page to edit city================//
	function edit_city()
	{	$id = $this->uri->segment(3);
	         //echo $id;die();
		$this->load->view('includes/header');
		$this->load->view('includes/top_header');
		$this->load->view('includes/left_panel');
		$city_data['details'] = $this->city_model->edit_city_model($id);
		//echo"<pre>";
		//print_r($email_template_data['details']);
		//die();
		$this->load->view('city/edit_city_view',$city_data);
		
		$this->load->view('includes/footer');
	}
        //============update data of city================//
	function update_city()
	{
		$id= $this->input->post('id');
		//echo $id;die();
		$data=array(
					'city' => $this->input->post('city'),
					'country_id' => $this->input->post('country'),
					'state_id' => $this->input->post('state'),
                                        'status' => $this->input->post('status'),
					'modified_by' => $this->session->userdata('admin_uid')
					);
                
		$update_data = $this->city_model->update_city_model('city',$id,$data);
		if($update_data)
		{
			$this->session->set_userdata('success_msg', 'Data updated susseccfully.');
		}
		else
		{
			$this->session->set_userdata('error_msg', 'Cannot update duplicate data.');
		}
			redirect('city_cont');

	}
	
}