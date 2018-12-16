<?php

class Email_model extends CI_Model {
	
	private $from;
	private $subject;
	private $message;
	private $emails;
	
	function __construct() {
		parent::__construct();
		
		$this->load->library("email");
		
		//$this->from = config_item("site_email");
		$this->from = 'robot@overads.net';
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['mailtype'] = 'html';
		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);
	}
	
	public function setSubject($subject = ''){
		$this->subject = $subject;
	}
	
	public function setMessage($message = ''){
		$this->message = $message;
	}
	
	public function setEmails($array = array()){
		$this->emails = $array;
	}
	
	public function send(){
		foreach ($this->emails as $email)
		{
			$this->email->clear();
			$headers = 	'Content-type: text/html; charset=utf-8" . "\r\n'.
						'From: Overads.net - CPA партнерская программа <robot@overads.net>' . "\r\n" .
					    'X-Mailer: PHP/' . phpversion();
					    
			mail( $email, $this->subject, $this->message, $headers );

		}
	}
	
}
