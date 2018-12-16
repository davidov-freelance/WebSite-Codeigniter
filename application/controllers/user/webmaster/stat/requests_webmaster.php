<?php

class Requests_Webmaster extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model("user/webmaster/stat_model_requests", "stat_model");
	}
	
	public function index(){
		$data = array(
				'title' => 'Заявки'
		);

		$this->load->view("template/user/".$this->user_model->type."/head", $data);
		if($this->input->get())
		{
			$data = array(
			    "result"	=> $this->stat_model->getRequests(),
			    "type"	=> $this->input->get("status"),
			    "offers"	=> $this->stat_model->getMyOffers()->result()
			);
		}
		else
		{
			$data = array(
			    "result"	=> $this->stat_model->getRequests(),
			    "type"	=> "all",
			    "offers"	=> $this->stat_model->getMyOffers()->result()
			);
		}
		$this->load->view("pages/user/".$this->user_model->type."/stat/requests", $data);
		$this->load->view("template/user/".$this->user_model->type."/foot");
	}

}
