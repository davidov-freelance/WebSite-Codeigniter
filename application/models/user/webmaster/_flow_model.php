<?php

class Flow_Model extends CI_Model{
	
	public function add($offer_id){
		$this->load->model("url_model");
		$arrayToDb = array(
		    'user_id'	=> $this->user_model->info->id,
            'place_id'	=> checkStr($this->input->post('place_id')),
		    'page_id'	=> checkStr($this->input->post('page')),
		    'gasket_id'	=> checkStr($this->input->post('gasket')),
		    'offer_id'	=> $offer_id,
            'city_id'   =>  $this->input->post('city_id'),
		    'name'	=> checkStr($this->input->post('name')),
		    'url'	=> $this->url_model->generateNew(),
		    'url_str'	=> checkStr($this->input->post('url_str')),
		    'metrika'	=> checkStr($this->input->post('metrika')),
		    'mail'	=> checkStr($this->input->post('mail')),
		    'google'	=> checkStr($this->input->post('google')),
		    'postback_url'	=> checkStr($this->input->post('postback_url')),
		    'trafficback_url'	=> checkStr($this->input->post('trafficback_url')),
		    'comebacker'	=> checkStr($this->resultCheckbox($this->input->post('comebacker'))),
		    'newwindow'		=> checkStr($this->resultCheckbox($this->input->post('newwindow'))),
		   	'split_test' => '',
		   	'm_page_id' => intval($this->input->post('m_page_id')),
		);

		$split_test = $this->input->post('split_test');
		if (!empty($split_test)) {
			$arrayToDb['split_test'] = serialize($split_test);
		}
		
		$this->db->insert("flows", $arrayToDb);
		return true;
	}
	
	public function getMyAll(){
		$this->db->select("flows.url, flows.url_str, flows.active, flows.name, cities.name AS city_name, flows.id, pages.name AS page_name, pages.url AS page_url, offers.name AS offer_name, offers.id AS offer_id")
			->from("flows")
			->join("pages", "pages.id = flows.page_id", "left")
			->join("offers", "offers.id = flows.offer_id", "left")
                        ->join("cities", "cities.id = flows.city_id", "left")
			->where("flows.user_id", $this->user_model->info->id)
			->order_by("flows.id", "DESC");
		$query = $this->db->get();
		return $query;
	}
	
	public function editInfo($id = 0){
		$this->db->select("flows.*")
			->from("flows")
			->join("pages", "pages.id = flows.page_id", "left")
			->where("flows.user_id", $this->user_model->info->id)
			->where("flows.id", $id);
		return $this->db->get();
	}
	
	public function startEdit($id = 0){
		$this->load->model('url_model');
		$arrayToDb = array(
		    'page_id'	=> checkStr($this->input->post('page')),
		    'city_id'	=> checkStr($this->input->post('city_id')),
            'place_id'	=> checkStr($this->input->post('place_id')),
		    'gasket_id'	=> checkStr($this->input->post('gasket')),
		    'name'	=> checkStr($this->input->post('name')),
		    'url_str'	=> checkStr($this->input->post('url_str')),
		    'metrika'	=> (int)($this->input->post('metrika')),
		    'mail'	=> (int)($this->input->post('mail')),
		    'google'	=> (int)($this->input->post('google')),
		    'postback_url'	=> checkStr($this->input->post('postback_url')),
		    'trafficback_url'	=> checkStr($this->input->post('trafficback_url')),	
		    'comebacker'	=> checkStr($this->resultCheckbox($this->input->post('comebacker'))),
		    'newwindow'		=> checkStr($this->resultCheckbox($this->input->post('newwindow'))),
			'split_test' => '',
			'm_page_id' => intval($this->input->post('m_page_id')),
		);

		$split_test = $this->input->post('split_test');
		if (!empty($split_test)) {
			$arrayToDb['split_test'] = serialize($split_test);
		}

		$this->db->where("id", $id);
		$this->db->update("flows", $arrayToDb);
		return true;
	}
	
	public function delete($id = 0){
		$this->db->delete("flows", array("id" => $id, "user_id" => $this->user_model->info->id));
		return true;
	}
	
	private function resultCheckbox($value){
		if($value == "on")
			return 1;
		else
			return 0;
	}
	
}