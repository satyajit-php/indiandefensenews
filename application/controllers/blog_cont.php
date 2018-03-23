<?php
class Blog_cont extends CI_Controller {
   // Controller class for Login
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('pagination');//loading session
		$this->load->model('blog_model');
		$this->load->model('login_model');
		$this->load->helper('text');
		$this->load->model('sidepanel_model');
		//if($this->session->userdata('is_logged_in')==true)
		//{
		//	redirect('dashboard_cont');			
		//}
	}
    
    //============load blog page================//
    function index()
	{		
        echo "hi";
        die();
		$config = array();
		$config["base_url"] =base_url()."index.php/blog_cont/index";
		
		if($this->uri->segment(2) != '')
		{
			$blog_tag_id = $this->uri->segment(2);
		}
		else
		{
			$blog_tag_id = '0';
		}
		
		
		$data['totalRow'] = $this->blog_model->get_total_count($blog_tag_id);
		$perPage = 2;
		if($this->input->get('page')=="" || $this->input->get('page')==0 )
		{
			$currentPage = 1;
		}else{
			$currentPage = $this->input->get('page');
		}
		$start = (($currentPage-1)*$perPage);
		$limit = $perPage;
		
		$data["blog_data"] = $this->blog_model->get_blog_value_pagi($perPage, $start, $blog_tag_id);
		$data['blog_pop']=$this->blog_model->get_pop_value();
		$data["links"] = $this->pagination->create_links();
		$data['pagi'] = $this->myPagination($data['totalRow'],$perPage,$currentPage,$url='?');
		$data['blog_by_comment'] = $this->blog_model->get_blogby_comment();
		
		$this->load->view('blog/blog', $data);
	}
	
	function blogdetails(){
		if($this->uri->segment(3) > 0){
			$data["blog_data"] = $this->blog_model->get_blogDetails($this->uri->segment(3));
			if($data["blog_data"] == false){
				redirect('blog_cont/index');
			}
			else{
				$data["blog_cmnt_val"] = $this->blog_model->get_blogCommentAll($this->uri->segment(3));
				$data['blog_pop']=$this->blog_model->get_pop_value();
				
				$data['blog_by_comment'] = $this->blog_model->get_blogby_comment();
				
				$this->load->view('blog/blog-details', $data);
			}
			
		}else{
			redirect('blog_cont/index');
		}
		
	}
	
	function insert_comment()
	{
		
		$post_on=$this->input->post('post_on');
		$com=$this->input->post('com');
		$ins_comm=array(
			'posted_by' => $this->session->userdata('uid'),
			'blog_id' =>$post_on,
			'comment'  =>$com
		);
		
		$data = $this->blog_model->insert_comment('blog_comment',$ins_comm);
		$getAllComments = $this->blog_model->getCommentsByBlog($post_on);
		$commentAll = '';
				if(!empty($getAllComments))
				{
					$i=0;
				foreach($getAllComments as $getAllCommentsAll)
				{
					$commentAll .='<div class="clearfix comment-blog">';
					$commentAll .='<div class="review-detail-pic">';
					$commentAll .='<div class="review-detail-icon">';
					$commentAll .='<img alt="" src="'.base_url().'assets/images/profile_picture/thumbnail/'.$getAllCommentsAll->profile_pic.'">';
					$commentAll .='</div>';
					$commentAll .='</div>';
					  
					$commentAll .='<div class="commentArea">';
					 
					$commentAll .='<p><a href="javascript:void(0);">'.$getAllCommentsAll->first_name.' '.$getAllCommentsAll->last_name.'</a>';
					$commentAll .='<u class="date-comment" style="color: darkorange;margin-left: 5px;">Date : '.date("j M Y H:m:s",strtotime($getAllCommentsAll->posted_on)).'</u></p>';
					$commentAll .='<p class="comment-section">'.$getAllCommentsAll->comment.'</p>';
					$commentAll .='</div>';
					$commentAll .='</div>';
					$i++;
				}
					$commentAll .='<p class="show-cmnt">';
					$commentAll .='<a href="'.base_url().'index.php/blog_cont/blogdetails/'.$getAllCommentsAll->blog_id.'">Show All Comments</a>';
					$commentAll .='</p>';
					
				echo $commentAll.'@@@'.$i;
				}
		
		/*$q=$this->blog_model->select_comment($post_on);
		$c = count($q);
		$up_rate=array('rating' => $c);
		$r=$this->blog_model->update_blog_rate('blog',$post_on,$up_rate);
		if($r==1)
		{
			$id=$this->session->userdata('id');
			$r=$this->blog_model->select_user(1);
			$nm=$r[0]->first_name;
			$name= ucfirst($nm);
			
			$r="<div>"."<b>".$name."</b>".':'." ".$com."</div>";
			echo $r;
		}*/
	}
	
	
	
	public function myPagination($total=0,$per_page=10,$page=1,$url='?')
   {
	
	$createURL = explode('?page=',$_SERVER['REQUEST_URI']);
	$createURL  =  $createURL[0].'?page=';
			$total = $total;
			$adjacents = "2"; 
			  
			$prevlabel = "&lsaquo; Prev";
			$nextlabel = "Next &rsaquo;";
			$lastlabel = "Last &rsaquo;&rsaquo;";
			  
			$page = ($page == 0 ? 1 : $page);  
			$start = ($page - 1) * $per_page;                               
			  
			$prev = $page - 1;                          
			$next = $page + 1;
			  
			$lastpage = ceil($total/$per_page);
		
			if($lastpage < 2){
				return '';
			}
			$lpm1 = $lastpage - 1; // //last page minus 1
			  
			$pagination = "";
			if($lastpage > 1){   
				$pagination .= "<ul class='pagination'>";
				$pagination .= "<li class='page_info'><span>Page {$page} of {$lastpage}</span></li>";
					  
					if ($page > 1) $pagination.= "<li><a href='{$createURL}{$prev}' id='GoSearchPagi' page='{$prev}'>{$prevlabel}</a></li>";
					  
				if ($lastpage < 7 + ($adjacents * 2)){   
					for ($counter = 1; $counter <= $lastpage; $counter++){
						if ($counter == $page)
							$pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
						else
							$pagination.= "<li><a href='{$createURL}{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
					}
				  
				} elseif($lastpage > 5 + ($adjacents * 2)){
					  
					if($page < 1 + ($adjacents * 2)) {
						  
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
							if ($counter == $page)
								$pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
							else
								$pagination.= "<li><a href='{$createURL}{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
						}
						$pagination.= "<li class='dot'>...</li>";
						$pagination.= "<li><a href='{$createURL}{$lpm1}' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
						$pagination.= "<li><a href='{$createURL}{$lastpage}' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";  
							  
					} elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
						  
						$pagination.= "<li><a href='{$createURL}1' id='GoSearchPagi' page='1'>1</a></li>";
						$pagination.= "<li><a href='{$createURL}2' id='GoSearchPagi' page='2'>2</a></li>";
						$pagination.= "<li class='dot'>...</li>";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
							if ($counter == $page)
								$pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
							else
								$pagination.= "<li><a href='{$createURL}{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
						}
						$pagination.= "<li class='dot'>..</li>";
						$pagination.= "<li><a href='{$createURL}{$lpm1}' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
						$pagination.= "<li><a href='{$createURL}{$lastpage}' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";      
						  
					} else {
						  
						$pagination.= "<li><a href='{$createURL}1' id='GoSearchPagi' page='1'>1</a></li>";
						$pagination.= "<li><a href='{$createURL}2' id='GoSearchPagi' page='2'>2</a></li>";
						$pagination.= "<li class='dot'>..</li>";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
							if ($counter == $page)
								$pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
							else
								$pagination.= "<li><a href='{$createURL}{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
						}
					}
				}
				  
					if ($page < $counter - 1) {
						$pagination.= "<li><a href='{$createURL}{$next}' id='GoSearchPagi' page='{$next}'>{$nextlabel}</a></li>";
						$pagination.= "<li><a href='{$createURL}{$lastpage}' id='GoSearchPagi' page='{$lastpage}'>{$lastlabel}</a></li>";
					}
				  
				$pagination.= "</ul>";        
			}
			  
			return $pagination;
	}
	
	
//	public function myPagination_baddesign_bckup($total=0,$per_page=10,$page=1,$url='?')
//   {
//	
//	$createURL = explode('?page=',$_SERVER['REQUEST_URI']);
//	$createURL  =  $createURL[0].'?page=';
//			$total = $total;
//			$adjacents = "2"; 
//			  
//			//$prevlabel = "&lsaquo; Prev";
//			//$nextlabel = "Next &rsaquo;";
//			//$lastlabel = "Last &rsaquo;&rsaquo;";
//			$prevlabel = "";
//			$nextlabel = "";
//			$lastlabel = "";
//			$page = ($page == 0 ? 1 : $page);  
//			$start = ($page - 1) * $per_page;                               
//			  
//			$prev = $page - 1;                          
//			$next = $page + 1;
//			  
//			$lastpage = ceil($total/$per_page);
//		
//			if($lastpage < 2){
//				return '';
//			}
//			$lpm1 = $lastpage - 1; // //last page minus 1
//			  
//			$pagination = "";
//			if($lastpage > 1){   
//				$pagination .= "<ul class='pagination pagination-outer list-unstyled'>";
//				//$pagination .= "<li class='page_info'><span>Page {$page} of {$lastpage}</span></li>";
//					  
//					//if ($page > 1) $pagination.= "<li><a href='{$createURL}{$prev}' id='GoSearchPagi' page='{$prev}'>{$prevlabel}</a></li>";
//					  
//				if ($lastpage < 7 + ($adjacents * 2)){   
//					for ($counter = 1; $counter <= $lastpage; $counter++){
//						if ($counter == $page)
//							$pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
//						else
//							$pagination.= "<li><a href='{$createURL}{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
//					}
//				  
//				} elseif($lastpage > 5 + ($adjacents * 2)){
//					  
//					if($page < 1 + ($adjacents * 2)) {
//						  
//						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
//							if ($counter == $page)
//								$pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
//							else
//								$pagination.= "<li><a href='{$createURL}{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
//						}
//						$pagination.= "<li class='dot'>...</li>";
//						$pagination.= "<li><a href='{$createURL}{$lpm1}' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
//						$pagination.= "<li><a href='{$createURL}{$lastpage}' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";  
//							  
//					} elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
//						  
//						$pagination.= "<li><a href='{$createURL}1' id='GoSearchPagi' page='1'>1</a></li>";
//						$pagination.= "<li><a href='{$createURL}2' id='GoSearchPagi' page='2'>2</a></li>";
//						$pagination.= "<li class='dot'>...</li>";
//						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
//							if ($counter == $page)
//								$pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
//							else
//								$pagination.= "<li><a href='{$createURL}{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
//						}
//						$pagination.= "<li class='dot'>..</li>";
//						$pagination.= "<li><a href='{$createURL}{$lpm1}' id='GoSearchPagi' page='{$lpm1}'>{$lpm1}</a></li>";
//						$pagination.= "<li><a href='{$createURL}{$lastpage}' id='GoSearchPagi' page='{$lastpage}'>{$lastpage}</a></li>";      
//						  
//					} else {
//						  
//						$pagination.= "<li><a href='{$createURL}1' id='GoSearchPagi' page='1'>1</a></li>";
//						$pagination.= "<li><a href='{$createURL}2' id='GoSearchPagi' page='2'>2</a></li>";
//						$pagination.= "<li class='dot'>..</li>";
//						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
//							if ($counter == $page)
//								$pagination.= "<li class='active'><a class='current'>{$counter}</a></li>";
//							else
//								$pagination.= "<li><a href='{$createURL}{$counter}' id='GoSearchPagi' page='{$counter}'>{$counter}</a></li>";                    
//						}
//					}
//				}
//				  
//					if ($page < $counter - 1) {
//						//$pagination.= "<li><a href='{$createURL}{$next}' id='GoSearchPagi' page='{$next}'>{$nextlabel}</a></li>";
//						//$pagination.= "<li><a href='{$createURL}{$lastpage}' id='GoSearchPagi' page='{$lastpage}'>{$lastlabel}</a></li>";
//					}
//				  
//				$pagination.= "</ul>";        
//			}
//			  
//			return $pagination;
//   }

	function display_comment()
	{
		$bid=$this->input->post('post_on');
		$r=$this->blog_model->dis_comm($bid);
		$d=$r[0]->details;
		$res="<div>".$d."</div>";
		echo $res;
	}
}
?>