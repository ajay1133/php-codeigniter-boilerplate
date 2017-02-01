<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User{
    
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('functions');   	
   	
		$this->user_info = array(
			"login" => FALSE,
			"role" => $this->CI->config->item("default_user_role"),
			"user_data" => array(),
		);

		$this->user_info = $this->get_user();
	}
   
	public function get_user()
	{
		$id = $this->CI->session->userdata("id") ? $this->CI->session->userdata("id") : "" ;
		$email = $this->CI->session->userdata("email") ? $this->CI->session->userdata("email") : "" ;
		$encryptedpass = $this->CI->session->userdata("encryptedpass") ? $this->CI->session->userdata("encryptedpass") : "" ;
   	
		$this->set_user($id, $email, $encryptedpass); 
		
		return $this->user_info;
	}  
    
	public function set_user($id = "", $email = "", $encryptedpass = "")
	{
		$user_info = $this->CI->functions->get_user_info($id, $email);
      
		foreach($user_info as $role => $user_data)
		{
			foreach($user_data as $user)
			{       		
				if($user->encryptedpass == $encryptedpass) 
				{
					$this->user = array(
						"login" => TRUE,
						"role" 	=>	$role,
						"user_data" => $user,
					);
				}
			}
   		}	
	}
  
}
?>