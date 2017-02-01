<?php
class Email{
    
   function __construct()
   {
     
   }
   
   function sendmail($config)
   {
      $error = 0;
      
      if( isset($config["to"]) && !empty($config["to"]) ) $to = $config["to"];
      else $error = 1;
      
      if( isset($config["from"]) && !empty($config["from"]) ) $from = $config["from"];
      else $error = 1;
      
      if( isset($config["subject"]) && !empty($config["subject"]) ) $subject = $config["subject"];
      else $subject = "";
      
      if( isset($config["action"]) && !empty($config["action"]) ) $action = $config["action"];
      else $action = "";
      
      if( isset($config["message"]) && !empty($config["message"]) ) $message = $config["message"];
      else $message = "";
      
      if( isset($config["params"]) && !empty($config["params"]) ) $params = $config["params"];
      else $params = array();
      
      if(empty($message) && !empty($action) && !empty($params)) $message = $this->getmessage($action,$params);
      
      if(empty($message)) $error = 1;
      
      $headers = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset = UTF-8' . "\r\n";

      // Additional headers
      $headers .= 'To:' . "\r\n";
      $headers .= 'From: ' .$from. "\r\n";
     
      if($error == 0)
      {  
         $message = nl2br($message);
         
         if(mail($to,$subject,$message,$headers)) return 1;
         
         else return -1;
      }
      
      else return -1;
   }
   
   public function getmessage($action = "", $params = array())
   {
      if($action == "app_register_to_user")
      {
      	 $message = "Dear ".ucwords($params['fname'])." ".ucwords($params['lname']).",<br/><br/>";
      	 $message .= "This is to confirm your registration on our app. Your login credentials are :<br/>";
      	 $message .= "Email : ".$params['email']."<br/>";
      	 $message .= "Password : ".$params["password"]."<br/>";
      	 $message .= "<br/><br/>";
      	 $message .= $this->getfooter($action);
      }
      if($action == "app_register_to_admin")
      {
      	 $message = "Hi Admin,<br/><br/>";
      	 $message .= "This is to confirm that a new user is registered on our app. User login details are :<br/>";
      	 $message .= "Email : ".$params['email']."<br/>";
      	 $message .= "<br/><br/>";
      	 $message .= $this->getfooter($action);
      }
      
      return $message;
   }
   
   function check_message($message="")
   {
      $ret = "";
      
      if($message)
      {
         $ret_arr = explode("\r\n",$message);
         if(count($ret_arr) == 1)
         {
            $ret_arr = explode("\r",$message);
         }
      }
      
      return $ret;
   }
   
   function getfooter($action = "")
   {
   	$footer = "Thanks<br/>";
   	$footer .= "Doctorapp Team";
   	
   	return $footer;
   }
}
?>