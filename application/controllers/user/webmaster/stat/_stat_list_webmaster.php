<?php

class Stat_List_Webmaster extends CI_Controller {

	private $data = array();
	
	function __construct() {
		parent::__construct();
		$this->load->model("user/webmaster/stat_model", "stat_model");
		$this->load->helper("stat_helper");
		$this->stat_model->setUserId($this->user_model->info->id);
		$this->data["urls"] = array(
		    array("url" => base_url(). "webmaster/stat/list", "type" => "days", "name" => "По дате"),
		    array("url" => base_url(). "webmaster/stat/list/subs", "type" => "subs", "name" => "По субаккаунтам"),
		    array("url" => base_url(). "webmaster/stat/list/flows", "type" => "flows", "name" => "По потокам"),
		    array("url" => base_url(). "webmaster/stat/list/offers", "type" => "offers", "name" => "По офферам"),
		    array("url" => base_url(). "webmaster/stat/list/leads", "type" => "leads", "name" => "По действиям")
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
	
	public function subs(){
		$this->data["title"] = "Статистика по субаккаунтам";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$info = array(
		    "type" => "subs", 
		    "one_column" => "Суб 1",
		    "two_column" => "Суб 2",
                    "three_column" => "Суб 3",
                    "four_column" => "Суб 4",
                    "num_columns" => 4,
		    "result" => $this->stat_model->getGroupSubs()
		);
		$this->load->view("pages/user/".$this->user_model->type."/stat/list", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");
	}
	
	public function flows(){
		$this->data["title"] = "Статистика по потокам";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$info = array(
		    "type" => "flows", 
		    "one_column" => "Поток",
		    "result" => $this->stat_model->getGroupFlows()
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
	
	public function leads(){
		$this->data["title"] = "Статистика по офферам";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$info = array(
		    "type" => "leads", 
		    "result" => $this->stat_model->getLeads()
		);
		$this->load->view("pages/user/".$this->user_model->type."/stat/list", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");
	}
	/*
	public function goals(){
		$data = array("title" => "Статистика по целям");
		$this->load->view("template/user/".$this->user_model->type."/head", $data);
		$info = array(
		    "type" => "goals", 
		    "one_column" => "Цель",
		    "result" => $this->stat_model->getGroupGoals()
		);
		$this->load->view("pages/user/".$this->user_model->type."/stat/list", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");
	}*/

	
}
