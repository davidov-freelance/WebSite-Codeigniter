<?php

class Change_Status_Advertiser extends CI_Controller {

	private $referer;
	
	function __construct() {
		parent::__construct();
		$this->load->model("user/advertiser/stat_model", "stat_model");
		if($_SERVER["HTTP_REFERER"])
			$this->referer = $_SERVER["HTTP_REFERER"];
		else
			$this->referer = base_url() . "advertiser/stat/requests";
		if(config_item("change_status_advertiser") === false)
			redirect($this->referer);
	}
	
	public function confirm($id = 0){
		$this->stat_model->changeStatus($id, "1");
		redirect($this->referer);
	}
	
	public function pending($id = 0){
		$this->stat_model->changeStatus($id, "0");
		redirect($this->referer);
	}
	
	public function deflect($id = 0){
		$this->stat_model->changeStatus($id, "-1");
		redirect($this->referer);
	}
	
	public function cancel($id = 0){
		$this->stat_model->changeStatus($id, "-3");
		redirect($this->referer);
	}
	
}
