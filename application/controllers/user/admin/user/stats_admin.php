<?php

class Stats_admin extends CI_Controller {
	
	private $data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model("user/webmaster/stat_model", "stat_model");
		$this->load->helper("stat_helper");
		$id = $this->uri->segment(4);
		$this->data["urls"] = array(
		    array("url" => base_url(). "admin/stats/index/" . $id, "type" => "days", "name" => "По дате"),
		    array("url" => base_url(). "admin/stats/subs/" . $id, "type" => "subs", "name" => "По субаккаунтам"),
		    array("url" => base_url(). "admin/stats/flows/" . $id, "type" => "flows", "name" => "По потокам"),
		    array("url" => base_url(). "admin/stats/offers/" . $id, "type" => "offers", "name" => "По офферам"),
		    array("url" => base_url(). "admin/stats/leads/" . $id, "type" => "leads", "name" => "По действиям")
		);
	}
	
	public function index($id = 0){
		checkInt($id);
		$this->stat_model->setUserId($id);
		$this->data["title"] = "Статистика по дате";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$info = array(
		    "type" => "days", 
		    "one_column" => "Дата", 
		    "result" => $this->stat_model->getGroupDays()
		);
		$this->load->view("pages/user/webmaster/stat/list", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");
	}
	
	public function subs($id = 0){
		$this->data["title"] = "Статистика по субаккаунтам";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$this->stat_model->setUserId($id);
		$info = array(
		    "type" => "subs", 
		    "one_column" => "Суб 1",
		    "two_column" => "Суб 2",
		    "num_columns" => 2,
		    "result" => $this->stat_model->getGroupSubs()
		);
		$this->load->view("pages/user/webmaster/stat/list", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");
	}
	
	public function flows($id = 0){
		checkInt($id);
		$this->stat_model->setUserId($id);
		$this->data["title"] = "Статистика по потокам";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$info = array(
		    "type" => "flows", 
		    "one_column" => "Поток",
		    "result" => $this->stat_model->getGroupFlows()
		);
		$this->load->view("pages/user/webmaster/stat/list", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");
	}
	
	public function offers($id = 0){
		checkInt($id);
		$this->stat_model->setUserId($id);
		$this->data["title"] = "Статистика по офферам";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$info = array(
		    "type" => "offers", 
		    "one_column" => "Оффер",
		    "result" => $this->stat_model->getGroupOffers()
		);
		$this->load->view("pages/user/webmaster/stat/list", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");
	}
	
	public function leads($id = 0){
		checkInt($id);
		$this->stat_model->setUserId($id);
		$this->data["title"] = "Статистика по офферам";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$info = array(
		    "type" => "leads", 
		    "result" => $this->stat_model->getLeads()
		);
		$this->load->view("pages/user/webmaster/stat/list", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");
	}
	
}
