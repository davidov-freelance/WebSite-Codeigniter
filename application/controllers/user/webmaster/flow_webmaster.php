<?php

class Flow_Webmaster extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model("user/webmaster/flow_model", "flow_model");
		$this->load->library("form_validation");
		$this->load->model("offer/info_model");
		require APPPATH . '/controllers/news/news.php';

		$this->data = array(
			"newsCount"	=>	News::newsCount(),
			"news"		=>	News::LastNews(),
		);
	}

	
	public function add($offer_id = 0){
		
		checkInt($offer_id);
		$offer = $this->info_model->getOffer( $offer_id );

		if( !$offer OR !$offer->status['status'] )
		{
			show_404();
			return;
		}

		$this->form_validation->set_rules('name', 'Название', 'required|trim');
		$this->form_validation->set_rules('page', 'Страница', 'required|trim|callback_pagevalid');
		$this->form_validation->set_rules('flow_type', 'Тип потока', 'required');

		$flow_geo = $this->flow_model->get_flow_geo( $offer_id );
		$this->data += [
			"title" 		=> "Новый поток",
			"page"			=> "flow",
			"offer_cities"  			=> 		$flow_geo['geo_data']['cities'],
			"countries" 				=> 		$flow_geo['countries_list'],
			"prices_data"   			=> 		$flow_geo['prices_data'],
			"prices_for_countries"  	=> 		$flow_geo['prices_for_countries'],
		    "info" 	 					=> 		$this->db->get_where("offers", array("id" => $offer_id))->row(),
		    "pages" 					=> 		$this->info_model->getPages($offer_id),
		    "gaskets" 					=> 		$this->info_model->getGaskets($offer_id),
            "places" 					=> 		$this->db->get_where("places", array("user_id" => $this->user_model->info->id))->result(),
		    "type" 	 					=> 		"add"
		];
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->data['content'] = $this->load->view("pages/user/webmaster/flow/add", $this->data, true);
		}
		else
		{
			$this->flow_model->add($offer_id, $offer);

			redirect(base_url() . "webmaster/flow/all");
		}
		
		$this->load->view("layouts/main", $this->data);
	}
	
	public function all(){

		$this->data += [
		    "flows"	=> $this->flow_model->getMyAll()->result(),
			"title" => "Мои потоки"
		];
		$this->data['content'] = $this->load->view("pages/user/webmaster/flow/all", $this->data, true);
		$this->load->view("layouts/main", $this->data);
	}
	
	public function delete($id = 0){
		checkInt($id);
		$query = $this->db->get_where("flows", array("id"=>$id));
		if($query->num_rows() == 0 || @$query->row()->user_id != $this->user_model->info->id)
		{
			show_404();
			return;
		}
		if($this->flow_model->delete($id))
			redirect(base_url() . "webmaster/flow/all");
	}
	
	public function edit($id = 0){

		checkInt($id);
		$query = $this->flow_model->editInfo($id);
		$flow_geo = $this->flow_model->get_flow_geo( $query->row()->offer_id );

		if($query->num_rows() == 0 || @$query->row()->user_id != $this->user_model->info->id)
		{
			show_404();
			return;
		}

		$this->form_validation->set_rules('name', 'Название', 'required|trim');
		$this->form_validation->set_rules('page', 'Страница', 'callback_page_valid');;
		$this->form_validation->set_rules('metrika', '№ Счетчика Метрики', 'trim|max_length[10]|numeric');


		$this->data += [
			"title" 					=> 		"Редактирование потока",
			"page"						=> 		"flow",
			"offer_cities"  			=> 		$flow_geo['geo_data']['cities'],
			"countries" 				=> 		$flow_geo['countries_list'],
			"prices_data"   			=> 		$flow_geo['prices_data'],
			"prices_for_countries"  	=> 		$flow_geo['prices_for_countries'],
		    "info"  					=> 		$query->row(),
		    "pages" 					=> 		$this->info_model->getPages($query->row()->offer_id),
		    "gaskets" 					=> 		$this->info_model->getGaskets($query->row()->offer_id),
		    "type"  					=> 		"edit",
            "places" 					=> 		$this->db->get_where("places", array("user_id" => $this->user_model->info->id))->result()
		];

		if (!empty($this->data['info']->split_test)) {
			$this->data['info']->split_test = unserialize($this->data['info']->split_test);
		} else {
			$this->data['info']->split_test = array();
		}
		


		if ($this->form_validation->run() == FALSE)
		{
			$this->data['content'] = $this->load->view("pages/user/webmaster/flow/add", $this->data, true);
		}
		else
		{
			$this->flow_model->startEdit($id);
			redirect(base_url() . "webmaster/flow/all");
		}
		
		$this->load->view("layouts/main", $this->data  );
	}

	public function page_valid( ){
		if( !$this->input->post('page') ) {
		$this->form_validation->set_message('page_valid', 'Выберите страницу для потока');
		return false;
	}
	}
}
