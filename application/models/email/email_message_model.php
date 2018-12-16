<?php

class Email_message_model extends CI_Model {
	
	public function getMessage($title, $text, $unsubscribe = true){
		$data = array(
			"title"				=>	$title,
			"text"				=>	$text,
			"unsubscribe" 		=>	$unsubscribe,
		    );
		$message = "";
		$message .= $this->load->view("email/head", $data, true);
		$message .= $this->load->view("email/message", $data, true);
		$message .= $this->load->view("email/foot", $data, true);
		return $message;
	}

}
