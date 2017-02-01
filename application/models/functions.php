<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Functions extends CI_Model{

    public function __construct()
    {
		parent::__construct();
		
		$this->load->database(); 
	}
  
    //Common functions
	
	public function get_user_info($id = "", $email = "", $status = 1)
	{
		if(!( empty($id) && empty($email)))
		{
			if( !empty($id) ) $condition = "WHERE id = $id";
			else $condition = "WHERE email = '$email'";

			$users_role_tables = $this->config->item("users_role_tables");
			
			$response = array(
				"status" => TRUE,
				"response" => array(),
			);
			
			foreach($users_role_tables as $role => $table)
			{  	  
				$query_str = "SELECT * FROM $table $condition";
				$query_str .= !empty($status) ? " AND status = $status" : "";
				
				$query = $this->db->query($query_str);
				
				$response["response"][$role] = $query->result();
			}
		}	
		else
		{
			$response = array(
				"status" => FALSE,
				"exception"	=> "* Error, id or email is missing", 
			);
		}
		
		return $response;
	}
  
	function insert_in_table($table = "", $data = "")
	{
	    if( !empty($table) && !empty($data) )
		{
			$query_str = "INSERT INTO " . $table . " ";
  	  
			foreach($data as $key => $val)
			{
				$val = !is_array($val) ? mysql_real_escape_string($val) : $val;
				
				if($this->check_column_exists($table,$key)) 
				{
				    $strapp = !isset($strapp) ? 'SET '.$key.'='."'$val'" : $strapp . ', ' . $key . '=' . "'$val'";
				}
			}
     
			if(isset($strapp) && !empty($strapp))
			{
				$query_str .= $strapp;
				
				if($this->db->query($query_str)) 
				{
					$response = array(
					    "status" => TRUE,
						"response" => $this->get_last_inserted_data($table),
					);
				}
				else
				{
					$response = array(
						"status" => FALSE,
						"exception"	=> "* Error, unable to insert data",
					);
				}
			}
			else
			{
				$response = array(
					"status" => FALSE,
					"exception"	=> "* Error, unable to parse request object into key-value pairs",
				);
			}	
		}
		else
		{
			$response = array(
				"status" => FALSE,
				"exception"	=> empty($table) ? "* Error, empty table exception" : "* Error, empty data exception", 
			);
		}
		
		return $response;
	}
  
    public function update_in_table($table = "", $data = "", $condition = "")
	{
		if( !empty($table) && !empty($data) && !empty($condition) )
		{
			$query_str = "UPDATE $table ";
		  
			foreach($data as $key => $val)
			{
				$val = !is_array($val) ? mysql_real_escape_string($val) : $val;
			    
				if($this->check_column_exists($table,$key)) 
				{
				    $strapp = !isset($strapp) ? 'SET '.$key.'='."'$val'" : $strapp . ', ' . $key . '=' . "'$val'";
				}
			}
		 
			if( isset($strapp) && !empty($strapp) )
			{
				$query_str .= $strapp . " WHERE $condition";
				
				if($this->db->query($str)) 
				{
					$response = array(
					    "status" => TRUE,
						"response" => $this->get_table_data($table, $condition, "row"),
					);
				}
				else 
				{
				    $response = array(
						"status" => FALSE,
						"exception"	=> "* Error, unable to update data",
					);
				}
			}
			else
			{
				$response = array(
					"status" => FALSE,
					"exception"	=> "* Error, unable to parse request object into key-value pairs",
				);
			}
		}
		else
		{
			$response = array(
				"status" => FALSE,
				"response" => empty($table) ? "* Error, empty table exception" : ( empty($data) ? "* Error, empty update data object exception" : "* Error, empty condition for update exception" ),  
			);
		}
		
		return $response;
	}
	
    public function delete_from_table($table = "", $condition = "")
	{
		if(!empty($condition) && !empty($table))
		{ 
			$str = "DELETE FROM $table WHERE ".$condition;
			$query = $this->db->query($str);
  	  
			if($query) return 1;
			else return 0;
		}
		else return "";
	}
	
	private function check_column_exists($table = "", $column_name = "")
	{
		if( !empty($table) && !empty($column_name) )
		{
			$query_str = "SHOW COLUMNS FROM $table LIKE '$column_name'";
  	     	   
			$query = $this->db->query($query_str);
			
			$response = count($query->result()) > 0 ? TRUE : FALSE;
		}
		else
		{
			$response = FALSE;
		}
		
		return $response;
	}
  
	public function get_table_data($table = "", $condition = "", $type = "array")
	{
		if(!empty($table))
		{  	  
			if(!empty($condition)) $query_str = "SELECT * FROM $table WHERE $condition";
			else $query_str = "SELECT * FROM $table";
  	  
			$query = $this->db->query($query_str);
  	  
			$response = $type == "array" ? $query->result_array() : $query->row_array();
		}
		else
		{
			$response = array();
		}
		
		return $response;
	}
  
	public function get_last_inserted_data($table = "")
	{
		if( !empty($table) )
		{
			$query_str = "SELECT * FROM $table ORDER BY id DESC LIMIT 1";
			$query = $this->db->query($query_str);
		  
		    $response = $query->row_array();
		}
		else
		{
			$response = array();
		}
		
		return $response;
	}
  
	public function check_not_duplicate($column_name = "", $column_value="", $table = "", $existing_id = 0, $action = "insert")
	{
		if( !empty($table) && !empty($column_name) && empty($column_value) )
		{
			$query_str = "SELECT id,count(*) as count FROM $table WHERE $column_name = '$column_value'";
     
			if( $query = $this->db->query($query_str) ) 
			{
				$count = 0;
     	  
				foreach($query->result() as $row)
				{
					$count = $row->count;
					$id = $row->id;
				}
     	     
				if(empty($action)) $action = "insert";
     	     
				if($action == "insert")
				{
					$response = $count > 0 ? FALSE : TRUE;
				}
				else if($action == "update")
				{
					if( $count >= 1 && $id != $existing_id) $response = FALSE;
					else if( $count == 1 && $id == $existing_id) $response = TRUE;
					else if( $count == 0 ) $response = TRUE;
				} 
			}
			else 
			{
				$response = FALSE;
			}
		}
		else
		{
			$response = FALSE;
		}
		
		return $response;
	}
   
	public function get_upload_dir($datakey = "")
	{
		if( in_array($datakey, $this->config->item("datakeys")) )
		{
			$response = $this->config->item("upload_parent_folder") . strtolower($datakey) . "/";
		}
  	    else
		{
			$response = "";
		}
		
		return $response;
	}
  
	public function get_upload_url($datakey = "")
	{
		if( in_array($datakey, $this->config->item("datakeys")) )
		{
			$response = $this->config->item("upload_base_url") . strtolower($datakey) . "/";
		}
  	    else
		{
			$response = "";
		}
		
		return $response;
	}
  
	public function get_request_data_in_array($requestObj = "")
	{
		if( !empty($requestObj) )
		{
			$response = (array) $requestObj;
		  
			if( !array_key_exists("created_on", $response) ) $response["created_on"] = new \DateTime();
			if( !array_key_exists("last_modified", $response) ) $response["last_modified"] = new \DateTime();
			
			if( !array_key_exists("created_by", $response) ) $response["created_by"] = $this->userinfo["id"];
			if( !array_key_exists("created_by_role", $response) ) $response["created_by_role"] = $this->userinfo["role"];
		}		
		
		return $response;
	}
  
	public function generate_password()
	{
		$response = array(
			"status" => FALSE,
			"exception" => "* Error, unable to generate password", 
		);
  	    
		$generator_charset = $this->config->item["generator_charset"];
		$min_pass_length = $this->config->item["min_pass_length"];
		$max_pass_length = $this->config->item["max_pass_length"];
		
		$count = mb_strlen($generator_charset);
		
		$length = rand($min_pass_length, $max_pass_length);
		
		$password = "";
     
		for ($i = 0; $i < $length; $i++)
		{
			$index = rand(0, $count - 1);
			$password .= mb_substr($this->generator_charset, $index, 1);
		}

		if(!empty($password)) 
		{
			$encryptedpass = md5($password);
		
			$response = array(
				"status" => TRUE,
				"response" => array(
					"password" => $password,
					"encryptedpass" => $encryptedpass,
				),
			);
		}
      
		return $response;
	}
  
	public function validate_array($data = "", $required = "", $unique = "", $table = "", $action = "insert", $id = 0)
	{
		$response = array(
			"status" => TRUE,
			"response" => 400,
		);  	
  	  
		if(empty($action)) $action = "insert";
  	  
		if(!empty($data))
		{
  	  	  	$flag = 1;
  	  	  	  
  	  	  	foreach($data as $key => $val)
  	  	  	{
  	  	  	  	if( in_array($key,$required) )
  	  	  	  	{
  	  	  	  	  	if(empty($val))
  	  	  	  	  	{
  	  	  	  	  	   	$flag = 0;
  	  	  	  	  	   	$errors[] = ucwords($key) . " is required";
  	  	  	  	  	}
  	  	  	  	}
  	  	  	  	  
  	  	  	  	if( in_array($key,$unique) )
  	  	  	  	{
  	  	  	  	  	if( !$this->check_not_duplicate($key, $val, $table, $id, $action) )
  	  	  	  	  	{
  	  	  	  	  	   	$flag = 0;
  	  	  	  	  	   	$errors[] = ucwords($key) . " already exists";
  	  	  	  	  	}
  	  	  	  	}
  	  	  	}
  	  	     
  	  	    foreach($required as $key => $val)
  	  	  	{
  	  	  	  	if( !array_key_exists($val,$data) )
  	  	  	  	{
  	  	  	  	  	$flag = 0;
  	  	  	  	  	$errors[] = ucwords($val) . " is required";
  	  	  	  	}
  	  	  	}
  	  	  	  
			if($flag)
			{
				$response = array(
					"status" => TRUE,
					"response" => 200,
				);
			}	
			else
			{
				$response = array(
					"status" => FALSE,
					"exception"	=> $errors,
				);
			}
			
			return $response;
		}
  	  
		return $response;
	}
	
	public function get_user_role_controller($role = "")
	{
		$user_roles_controllers = $this->config->item("user_roles_controllers");
		
		if(empty($role)) $role = $this->user_info["role"];
		  
		$controller = array_key_exists($role, $user_roles_controllers) ? $user_roles_controllers[$role] : "";
		
		return $controller;
	}
	
	//Project functions
	
	public function get_different_proxies()
	{
		$proxies = array();
		
		$proxies[] = 'user:password@173.234.11.134:54253';  // Some proxies require user, password, IP and port number
		$proxies[] = 'user:password@173.234.120.69:54253';
		$proxies[] = 'user:password@173.234.46.176:54253';
		$proxies[] = '173.234.92.107';  // Some proxies only require IP
		$proxies[] = '173.234.93.94';
		$proxies[] = '173.234.94.90:54253'; // Some proxies require IP and port number
		$proxies[] = '69.147.240.61:54253';
		
		return $proxies;
	}
	
	public function make_curl_request( $url = "" )
	{
		$ch = curl_init();  // Initialise a cURL handle
 
		$proxies = $this->get_different_proxies();
		
		$proxy = $proxies[ 3 ];
		
		// Setting proxy option for cURL
		if (isset($proxy)) 
		{    
			// If the $proxy variable is set, then
			curl_setopt($ch, CURLOPT_PROXY, $proxy);    // Set CURLOPT_PROXY with proxy in $proxy variable
		}
		 
		// Set any other cURL options that are required
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_COOKIESESSION, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_URL, $url);
		 
		$results = curl_exec($ch);  // Execute a cURL request
		curl_close($ch);    // Closing the cURL handle
		
		return $results;
	}
}
?>