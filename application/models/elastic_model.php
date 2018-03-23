<?php
class Elastic_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}
	/**
	* Log in functionality goes here
	*/
	
	function insert_data($id,$company,$city)
	{
            $site_settings_query = $this->db->get('site_settings');
	    $val = $site_settings_query-> result();
            //print_r($val);
	    $elastick= $val[0]->elastick;
            
            if($elastick)
            {
              $url='curl -X POST "'.$elastick.'rudra/bomsankars/'.$id.'" -d \'{"company" : "'.$company.'","city" : "'.$city.'"}\'';
			
			
               if(exec($url))
               {
                    return 1;
               }
               else{
                    return 0;
               }   
            }
	   
	}
	
	function update_data($id,$company,$city)    // update company details
	{
		
	    $site_settings_query = $this->db->get('site_settings');
	    $val = $site_settings_query-> result();
            //print_r($val);
	    $elastick= $val[0]->elastick;
	    if($elastick)
	    {
               $url='curl -X POST "'.$elastick.'rudra/bomsankars/'.$id.'/_update" -d \'{"doc": {"company" : "'.$company.'","city" : "'.$city.'"}}\'';
			  
			 
	       if(exec($url))
               {
                    return 1;
               }
               else{
                    return 0;
               } 

	    }
	}
	
	
	function search_company($company,$location)      // search company from the json file
	{
	     //$match_result=array();
	     $site_settings_query = $this->db->get('site_settings');
	     $val = $site_settings_query-> result();
        $elastick= $val[0]->elastick;
		if($location)
		{
		 $url='curl -X GET "'.$elastick.'rudra/bomsankars/_search?size=10" -d \'{"query":{"bool":{"should":[{"match_phrase_prefix":{"company":"'.$company.'"}},{"match_phrase_prefix":{"city":"'.$location.'"}}]}}}\'';	
		}
		else{
		 $url='curl -X GET "'.$elastick.'rudra/bomsankars/_search?size=10" -d \'{"query":{"bool":{"should":[{"match_phrase_prefix":{"company":"'.$company.'"}},{"match_phrase_prefix":{"city":"'.$location.'"}}]}}}\'';	
		}

		$value_users = exec($url);
		$value_users = json_decode($value_users);
		$arr=$value_users->hits->hits;         // store result value.
		$total=$value_users->hits->total;     // total number of result found.
		if(!empty($arr))
		{
			for($i=0;$i<$total;$i++)
			{
				
				if($arr[$i]->_source->company!=null)
				{
					
				        $match_result[$i]=$arr[$i]->_source->company;	
				}
			}
		}
			 return $value_users = json_encode($match_result);
		
		
	}
	
	
	
}
?>