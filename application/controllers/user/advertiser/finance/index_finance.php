<?php

class Index_finance extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model("user/advertiser/finance_model", "finance");
	}
	
	public function index(){
		
		$this->load->view("template/user/advertiser/head", array("title" => "Финансы"));
		
		if($this->input->post()){
			if($this->input->post("from_date"))
				$this->finance->set_from_date($this->input->post("from_date"));
			if($this->input->post("to_date"))
				$this->finance->set_to_date($this->input->post("to_date"));			
		}
		
		$data = array(
		    "result" =>	$this->finance->get_costs_days()->result()
		);
		
		$this->load->view("pages/user/advertiser/finance/index", $data);
		
		$this->load->view("template/user/advertiser/foot");
		
	}
	
}
