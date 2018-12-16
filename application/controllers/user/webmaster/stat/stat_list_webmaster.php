<?php

class Stat_List_Webmaster extends CI_Controller {

	private $data = array();
	
	function __construct() {
		parent::__construct();

		if( $this->input->post("from_date") AND $this->input->post("to_date") ){
			$this->info['startDate'] = $this->input->post("from_date");
			$this->info['endDate'] = $this->input->post("to_date");
		} else{
			$this->info['startDate'] = date( "Y-m-d", time() - 3600*24*6 );
			$this->info['endDate'] = date( "Y-m-d", time() );
		}

		require APPPATH . '/controllers/news/news.php';
		$this->load->model("user/webmaster/stat_model", "stat_model");
		$this->load->helper("stat_helper");
		$this->stat_model->setUserId($this->user_model->info->id);
		$this->data["newsCount"] =	News::newsCount();
		$this->data["news"] =	News::LastNews();

	}
	
	public function index(){

		$this->info += array(
		    "type" => "",
			"title"=> "Статистика по дате",
			"header_title" => "Статистика <small>по дате</small>",
		    "one_column" => "Дата",
			"maxDate"	=> date('d-m-Y', time() ),
			"table_data" =>  $this->load->view("pages/user/".$this->user_model->type."/stat/table", array("result" => $this->stat_model->getGroupDays()), true),

		);

		$this->data['content'] = $this->load->view("pages/user/".$this->user_model->type."/stat/list", $this->info, true);
		$this->load->view("layouts/main", $this->data);


	}
	
	public function subs(){

		$this->info += array(
		    "type" => "subs",
			"title" => "Статистика по субаккаунтам",
			"header_title" => "Статистика <small>по субаккаунтам</small>",
		    "one_column" => "Суб 1",
		    "two_column" => "Суб 2",
            "three_column" => "Суб 3",
            "four_column" => "Суб 4",
            "num_columns" => 4,
			"result" => $this->stat_model->getGroupSubs()
		);

		$this->data['table_data'] = $this->load->view("pages/user/".$this->user_model->type."/stat/table", $this->info, true);


		$this->data['content'] = $this->load->view("pages/user/".$this->user_model->type."/stat/list", $this->data+$this->info, true);
		$this->load->view("layouts/main", $this->data+$this->info);
	}
	
	public function flows(){
		$this->data["title"] = "Статистика по потокам";
		$this->data["header_title"] = "Статистика <small>по потокам</small>";
		$this->info += array(
		    "type" => "flows", 
		    "one_column" => "Поток",
		    "result" => $this->stat_model->getGroupFlows()
		);
		$this->data['table_data'] = $this->load->view("pages/user/".$this->user_model->type."/stat/table", $this->info, true);
		$this->data['content'] = $this->load->view("pages/user/".$this->user_model->type."/stat/list", $this->data+$this->info, true);
		$this->load->view("layouts/main", $this->data+$this->info);
	}
	
	public function offers(){
		$this->data["title"] = "Статистика по офферам";
		$this->data["header_title"] = "Статистика <small>по офферам</small>";
		$this->info += array(
		    "type" => "offers", 
		    "one_column" => "Оффер",
		    "result" => $this->stat_model->getGroupOffers()
		);


		$this->data['table_data'] = $this->load->view("pages/user/".$this->user_model->type."/stat/table", $this->info, true);
		$this->data['content'] = $this->load->view("pages/user/".$this->user_model->type."/stat/list", $this->data+$this->info, true);
		$this->load->view("layouts/main", $this->data+$this->info);
	}

	public function pages(){
		$this->data["title"] = "Статистика по лендингам";
		$this->data["header_title"] = "Статистика <small>по лендингам</small>";
		$this->info += array(
		    "type" => "pages", 
		    "one_column" => "Лендинг",
		    "result" => $this->stat_model->getGroupPages()
		);

		$this->data['table_data'] = $this->load->view("pages/user/".$this->user_model->type."/stat/table", $this->info, true);
		$this->data['content'] = $this->load->view("pages/user/".$this->user_model->type."/stat/list", $this->data+$this->info, true);
		$this->load->view("layouts/main", $this->data+$this->info);
	}

	
	public function leads(){
		$this->data["title"] = "Статистика по офферам";
		$this->data["header_title"] = "Статистика <small>по офферам</small>";
		$this->info += array(
		    "type" => "leads",
		    "result" => $this->stat_model->getLeads()
		);


		$this->data['table_data'] = $this->load->view("pages/user/".$this->user_model->type."/stat/table", $this->info, true);
		$this->data['content'] = $this->load->view("pages/user/".$this->user_model->type."/stat/list", $this->data+$this->info, true);
		$this->load->view("layouts/main", $this->data+$this->info);
	}

}
