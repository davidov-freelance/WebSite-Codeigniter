<?php

class My_Advertiser extends CI_Controller{
	
	public function index(){
		
		$this->load->model("user/advertiser/offer_model", "offer_model");
		$this->load->model("offer/info_model", "offer_info");
		
		$data = array(
			'title' => 'Мои офферы'
		);
		
		$this->load->view("template/user/advertiser/head", $data);

		$data = array(
			'title' => $data["title"],
			'type'	=> 'advertiser',
			'result' => $this->offer_model->getOffersForUser($this->user_model->info->id)->result()
		);
		
		$this->load->view("pages/offer/list", $data);

		$this->load->view("template/user/advertiser/foot");
		
	}
	
}