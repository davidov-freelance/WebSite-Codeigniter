<?php

class Flow_Model extends CI_Model{
	
	public function add($offer_id, $offer = []){
		$this->load->model("url_model");
		if( $this->input->post('flow_type') == "mix" ){
			$city_id = 0;
			$country_id = 0;
		} else{
			
			$city_id = $this->input->post('city_id');
			$country_id = $this->input->post('country_id');
		}

		$arrayToDb = array(
		    'user_id'	=> $this->user_model->info->id,
            'place_id'	=> checkStr($this->input->post('place_id')),
		    'page_id'	=> checkStr($this->input->post('page')),
			'gasket_id'	=> checkStr($this->input->post('gasket')),
			'phone'	=> checkStr($this->input->post('phone')),
		    'offer_id'	=> $offer_id,
			'country_id'   =>  $country_id,
			'city_id'   =>  $city_id,
			'flow_type'   =>  $this->input->post('flow_type'),
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
		   	'm_page_id' => 0,
		);



		if( $offer->private AND $offer->status['status'] ){
			$arrayToDb['status'] = 'active_private';
		}


		if( $this->input->post('flow_type') == "mix" ){
			$arrayToDb['city_id'] = 0;
			$arrayToDb['country_id'] = 0;
		}

		$split_test = $this->input->post('split_test');
		if (!empty($split_test)) {
			$arrayToDb['split_test'] = serialize($split_test);
		}

		$mobile_opt = $this->input->post('mobile_opt');
		if (!empty($mobile_opt)) {
			$arrayToDb['m_page_id'] = intval($this->input->post('m_page_id'));
		}
		
		$this->db->insert('flows', $arrayToDb);
		return true;
	}
	
	public function getMyAll(){
		$this->db->select("flows.url, flows.url_str, flows.status, flows.name, cities.name AS city_name, flows.id, pages.name AS page_name, pages.url AS page_url, offers.name AS offer_name, offers.id AS offer_id")
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
		$this->db->select("flows.*, offers.name as offer_name")
			->from("flows")
			->join("pages", "pages.id = flows.page_id", "left")
			->join("offers", "offers.id = flows.offer_id", "left")
			->where("flows.user_id", $this->user_model->info->id)
			->where("flows.id", $id);
		return $this->db->get();
	}
	
	public function startEdit($id = 0){
		$this->load->model('url_model');
		$arrayToDb = array(
		    'page_id'	=> checkStr($this->input->post('page')),
			'country_id'   =>  $this->input->post('country_id'),
			'city_id'   =>  $this->input->post('city_id'),
			'flow_type'   =>  $this->input->post('flow_type'),
			'phone'	=> checkStr($this->input->post('phone')),
            'place_id'	=> checkStr($this->input->post('place_id')),
		    'gasket_id'	=> checkStr($this->input->post('gasket')),
		    'name'	=> checkStr($this->input->post('name')),
		    'url_str'	=> checkStr($this->input->post('url_str')),
		    'metrika'	=> (int)($this->input->post('metrika')),
		    'mail'	=> (int)($this->input->post('mail')),
		    'google'	=> (int)($this->input->post('google')),
			'postback_url'	=> checkStr($this->input->post('postback_url')),
			'postback_method'	=> checkStr($this->input->post('postback_method')),
			'postback_gen'	=> checkStr($this->input->post('postback_gen')),
			'postback_success'	=> checkStr($this->input->post('postback_success')),
			'postback_fail'	=> checkStr($this->input->post('postback_fail')),
		    'trafficback_url'	=> checkStr($this->input->post('trafficback_url')),	
		    'comebacker'	=> checkStr($this->resultCheckbox($this->input->post('comebacker'))),
		    'newwindow'		=> checkStr($this->resultCheckbox($this->input->post('newwindow'))),
			'split_test' => '',
			'm_page_id' => 0,
		);

		if( $this->input->post('flow_type') == "mix" ){
			$arrayToDb['city_id'] = 0;
			$arrayToDb['country_id'] = 0;
		}

		$split_test = $this->input->post('split_test');
		if (!empty($split_test)) {
			$arrayToDb['split_test'] = serialize($split_test);
		}

		$mobile_opt = $this->input->post('mobile_opt');
		if (!empty($mobile_opt)) {
			$arrayToDb['m_page_id'] = intval($this->input->post('m_page_id'));
		}


		$this->db->where('id', $id);
		$this->db->update('flows', $arrayToDb);
		return true;
	}
	
	public function delete($id = 0){
		$this->db->delete('flows', array('id' => $id, 'user_id' => $this->user_model->info->id));
		return true;
	}
	
	private function resultCheckbox($value){
		if($value == 'on')
			return 1;
		else
			return 0;
	}
	public function get_flow_goal( $flow_id ){

		$flow = $this->db->select("offer_id")->from("flows")->where("id", $flow_id)->get()->row();
		if( isset( $flow->offer_id ) ){
			$goal = $this->db->select("id")
				->from("goals")
				->where("offer_id", $flow->offer_id)
				->get()->row();
			if( isset( $goal->id ) ) return $goal->id;
		}
		return '';
	}



	public function get_flow_geo( $offer_id ){
			$goals = $this->db->select("id")
				->from("goals")
				->where("offer_id", $offer_id)
				->get();
		$prices_for_countries = [];
		$prices_data = [];
		$geo_data = ['countries'=>[], 'cities'=>[]];
		foreach( $goals->result() as $goal ){
			$geo = $this->db->select("g.*,c.country_name, ct.name")
				->from("geo_goals g")
				->join("cities ct", "ct.id=g.city_id", "left")
				->join("countries c", "c.country_id=g.country_id", "left")
				->where("goal_id", $goal->id)
				->where("status", 1)->get();
			foreach( $geo->result() as $geo_one ){
				$geo_data['countries'][$geo_one->country_id] = $geo_one->country_name;
				if( $geo_one->city_id ){
					$geo_data['cities'][$geo_one->country_id][$geo_one->city_id] = $geo_one->name;
					$prices_data[$geo_one->country_id][$geo_one->city_id] = array( $geo_one->price, $geo_one->lid_count );
				} else{
					$prices_for_countries[$geo_one->country_id] = array( $geo_one->price, $geo_one->lid_count );
				}



			}
		}

		if( count( $geo_data['countries'] ) )
			$offerCountries = array_flip( array_keys( $geo_data['countries'] ) );
		else $offerCountries = array();


		foreach( $this->db->get('countries')->result() as $c ){
			$all_countries[$c->country_id] = $c;
		}
		return [
				'countries_list' 		=> 	array_intersect_key( $all_countries, $offerCountries ),
				'geo_data'				=>	$geo_data,
				'prices_data'			=>	$prices_data,
				'prices_for_countries'	=>	$prices_for_countries,
		];


	}
	
}