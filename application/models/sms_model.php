<?php

class Sms_model extends CI_Model {
	
	private $message;
	private $phone;
	
	function setPhone($phone = ''){
		$this->phone = $phone;
	}
	
	function setMessage($message = ''){
		$this->message = $message;
	}
	
	function send()
	{
		$ch = curl_init("http://sms.ru/sms/send");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array(

			"api_id" => "a3bf7553-7564-ab64-51ce-8431e0c9a7fb",
			"to" => $this->phone,
			"text" => $this->message

		));
		if($body = curl_exec($ch)) {
			curl_close($ch);
			return true;
		}
		else {
			curl_close($ch);
			return false;
		}
	}
	
}
