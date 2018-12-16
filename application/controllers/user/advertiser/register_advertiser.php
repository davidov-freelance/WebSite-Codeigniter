<?php

class Register_advertiser extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model("user/advertiser/register_model", "register_model");
	}
	
	public function index(){
		$array = array(
		    "name"	=>	checkStr($this->input->post("name")),
		    "phone"	=>	checkStr($this->input->post("phone")),
		    "skype"	=>	checkStr($this->input->post("skype")),
		    "offer_name"=>	checkStr($this->input->post("offer_name")),
		    "offer_descr"=>	checkStr($this->input->post("offer_descr"))
		);
		$this->register_model->add($array);
		redirect(base_url() . "for_advertisers");
	}
	
}
