<?php

$filepath = $this->user_info["login"] ? "after_login/" : "before_login/" ;

if( isset($this->data["inner_folder"] ) && !empty( $this->data["inner_folder"] )) $filepath .= $this->data["inner_folder"] . "/";

$filepath .= $this->data["main_body"];
 
$this->load->view('layout/header');
$this->load->view($filepath);
$this->load->view('layout/footer');

?>
