<?php

// Список офферов

class List_admin extends CI_Controller
{
	
	function __construct() {
		parent::__construct();

		$this->load->model("offer/info_model");
		require APPPATH . '/controllers/news/news.php';


		$this->data = array(
			"newsCount"	=>	News::newsCount(),
			"news"		=>	News::LastNews(),
		);


		$this->load->model('offer/info_model', 'offer_info');
	}

	function passed_moderation() {
		$this->data['title'] =  'Список офферов';
		$query = $this->db->from("offers")->where("type", "1")->order_by("added", "DESC")->get();
		$result = array("type" => 1, "result" => $query->result());


		if (!empty($result['result'])) {
			foreach($result['result'] as &$offer) {
				$offer->cities = $this->offer_info->getCities($offer->id);
			}
		}


		$this->data['content'] = $this->load->view("pages/user/admin/offer/list", $result, true);
		$this->load->view("layouts/main", $this->data);
	}

	function not_passed_moderation() {

		$this->data['title'] = 'Офферы на модерации';


		$query = $this->db->from("offers")
				->where("type", "0")
				->order_by("added", "DESC")->get();
		
		$result = array("type" => 0, "result" => $query->result());


		// get cities
		if (!empty($result['result'])) {
			foreach($result['result'] as &$offer) {
				$offer->cities = $this->offer_info->getCities($offer->id);
			}
		}

		$this->data['content'] = $this->load->view("pages/user/admin/offer/list", $result, true);

		$this->load->view("layouts/main", $this->data);
	}
}

?>