<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct()
    {
		parent::__construct(); 
      
		$this->load->library("session");
		$this->load->library("encrypt");
		
		//extra libraries
		$this->load->library("email");
		$this->load->library("user");
		
		$this->load->helper("url");
		
		$this->load->model("functions");
		
		$this->user_info = $this->user->get_user();
    }
	
    public function checkaccess()
    {
		//by default return true
		return true;
    }
	
	public function get_web_results()
	{	
		$query_str = "dentist";
	
		$address = $this->input->post("address");
		
		$google_api_search_url = $this->config->item("GOOGLE_SEARCH_PRE_APPEND_URL");
		$google_api_search_url .= "key=" . $this->config->item("GOOGLE_API_KEY");
		$google_api_search_url .= "&output=xml_no_dtd&cx=" . $this->config->item("GOOGLE_SEARCH_cx");
		$google_api_search_url .= "start=0&num=10" . "&q=" . $query_str;
		$google_api_search_url .= "&near=" . $address;
		
		$result = $this->functions->make_curl_request($google_api_search_url);
		
		return $result;
	}
   
}