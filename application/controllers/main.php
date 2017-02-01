<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

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
	
	public function index()
	{
		if( $this->user_info["login"] ) 
	    {
			$controller = $this->functions->get_user_role_controller();
		  
		    if( !empty($controller) ) redirect($controller);
			else echo "Access denied";
	    }
		else
		{
			redirect( $this->router->fetch_class() . "/page/home" );
		}
	}
	
    public function page($page = "")
    {    
		if( $this->user_info["login"] ) 
	    {
			redirect(base_url());
	    } 
	    else
	    {
	        if( !empty($page) )
	        {
		        $dirpath = $this->config->item("main_path") . "application/views/before_login";
		  
		        $dir_files = scandir($dirpath);
		  
		        $page = urldecode($page);
		        
				$page = str_replace("-","_",$page);
		        
		        if( !in_array($page . ".php" , $dir_files) ) redirect(base_url());
				else
				{
					$this->data = array(
					   "main_body" => $page,
					   "title" => ucwords( str_replace("_", " ", $page) ),
					);
					
					$this->load->view("templates/base") ;
				}
	        }
	        else redirect(base_url());
	    }
    }

}