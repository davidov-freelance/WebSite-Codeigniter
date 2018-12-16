<?php

class Stat_advertiser extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("user/advertiser/stat_model", "stat_model");
		$this->load->helper("stat_helper");
		$this->stat_model->setUserId($this->user_model->info->id);
		$this->data["urls"] = array(
		    array("url" => base_url(). "advertiser/stat/list", "type" => "days", "name" => "По дате"),
		    array("url" => base_url(). "advertiser/stat/list/offers", "type" => "offers", "name" => "По офферам"),
		    array("url" => base_url(). "advertiser/stat/list/countries", "type" => "countries", "name" => "По странам"),
		    array("url" => base_url(). "advertiser/stat/list/leads", "type" => "leadss", "name" => "По продажам")
		);
	}
	
	public function index(){
		$this->data["title"] = "Статистика по дате";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$info = array(
		    "type" => "days", 
		    "one_column" => "Дата", 
		    "result" => $this->stat_model->getGroupDays()
		);
		$this->load->view("pages/user/".$this->user_model->type."/stat/list", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");	
	}
	
	public function offers(){
		$this->data["title"] = "Статистика по офферам";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$info = array(
		    "type" => "offers", 
		    "one_column" => "Оффер", 
		    "result" => $this->stat_model->getGroupOffers()
		);
		$this->load->view("pages/user/".$this->user_model->type."/stat/list", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");	
	}
	
	public function countries(){
		$this->data["title"] = "Статистика по странам";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$info = array(
		    "type" => "countries", 
		    "one_column" => "Страна", 
		    "result" => $this->stat_model->getGroupCountries()
		);
		$this->load->view("pages/user/".$this->user_model->type."/stat/list", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");	
	}
	
	public function leads(){
		$this->data["title"] = "Статистика по продажам";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$info = array(
		    "type" => "leadss", 
		    "one_column" => "Продажа", 
		    "result" => $this->stat_model->getLeads()
		);
		$this->load->view("pages/user/".$this->user_model->type."/stat/list", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");	
	}
	
}
