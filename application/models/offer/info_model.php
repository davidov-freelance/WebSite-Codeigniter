<?php

class Info_model extends CI_Model{


	public function get($ar = array()){

		if(isset($ar["select"]))
			$this->db->select($ar["select"]);
		if(isset($ar["id"]))
			$this->db->where("id", $ar["id"]);
		if(isset($ar["type"]) && $ar["type"] >= -1 && $ar["type"] <= 1)
			$this->db->where("type", $ar["type"]);
		if(isset($ar["user_id"]))
			$this->db->where("user_id", $ar["user_id"]);

		$query = $this->db->get("offers");
		if(isset($ar["count"]))
		{
			if($ar["count"])
				return $query->row();
			else
				return $query->result();
		}
		else
			return $query->result();
	}
	
	public function getGoals($offer_id = 0){
		$this->db->where("offer_id", $offer_id);
		$query = $this->db->get("goals");
		return $query->result();
		
	}


	public function my_get_goals($offer_id = 0){
		$this->db->select('goals.name, goals.id');
		$this->db->where("offer_id", $offer_id);	
		$query = $this->db->get("goals");
		return $query->result();		
		
	}	
	
	
	public function getPages($offer_id = 0){

		$this->db->select("pages.*
			, (SELECT COUNT(*) FROM transits WHERE page_id=pages.id) AS transits_count
			, (SELECT COUNT(*) FROM requests WHERE page_id=pages.id) AS requests_count")
			->where("offer_id", $offer_id)
			->from("pages");
		$pages = $this->db->get();
		return $pages->result();
		
	}
	
	public function getGaskets($offer_id = 0){
		
		$this->db->select("gaskets.*
			, (SELECT COUNT(*) FROM transits WHERE gasket_id=gaskets.id) AS transits_count
			, (SELECT COUNT(*) FROM requests WHERE gasket_id=gaskets.id) AS requests_count")
			->where("offer_id", $offer_id)
			->from("gaskets");
		$pages = $this->db->get();
		return $pages->result();
		
	}

	public function getLastGoal(){
		$goal  =$this->db->query('SELECT id FROM goals ORDER BY id DESC LIMIT 1')->result();
		return $goal['0']->id;
	}

	public function getCities($offer_id = 0){
		$tmp = $this->db->query('SELECT cities.name FROM cities, offers_cities'.
			' WHERE offers_cities.offer_id = ' . intval($offer_id) .
			' AND offers_cities.city_id = cities.id')->result_array();

		$cities = array();

		if (!empty($tmp)) {
			foreach ($tmp as $city) {
				$cities[] = $city['name'];
			}
		}
		
		return $cities;

	}
 
	public function getBunches( $info ){
		$this->db->select('cities.name as city,countries.country_name as country_name, geo_goals.price');
		$this->db->join('cities', 'cities.id = geo_goals.city_id', 'left');
		$this->db->join('countries', 'countries.country_id = geo_goals.country_id', 'left');
		$this->db->where("geo_goals.goal_id", (int)$info['goal_id']);
		$this->db->where("geo_goals.status", 1 );
		$query = $this->db->get("geo_goals");
		return $query->result();;
	}


	public function getOffer( $id = 0 ){
		$this->db->select(""
			. "offers.*, "
			. "(SELECT COUNT(*) FROM my_offers WHERE offer_id=offers.id AND user_id=".$this->db->escape($this->user_model->info->id).") AS is_my")
			->from("offers");

		$this->db->where("offers.id", $id );
		if(!$this->user_model->isAdmin()) {
			$this->db->where("(offers.private = '0' OR (offers.private = '1' AND (SELECT COUNT(*) FROM offers_private s WHERE s.user_id=" . $this->db->escape($this->user_model->info->id) . " AND s.offer_id=offers.id) >=1 ))");
			$this->db->where("offers.type", "1");
		}

		$offer = $this->db->get()->row();
		if( !$offer ) return false;
		$offer->status = $this->offerAllow( $offer );
		return $offer;
	}




	public function getOffers( $last = false ){
		$this->db->select("offers_private.offer_id as private_offer,"
			. "offers.*, "
			. "(SELECT COUNT(*) FROM offers_private s WHERE s.user_id=" . $this->db->escape($this->user_model->info->id) . " AND s.offer_id=offers.id) AS private_access, "
			. "(SELECT COUNT(*) FROM transits WHERE offer_id=offers.id) AS transits, "
			. "(SELECT COUNT(*) FROM requests WHERE offer_id=offers.id) AS requests, "
			. "(SELECT SUM(profit) FROM requests WHERE offer_id=offers.id) AS profits, "
			. "(SELECT COUNT(*) FROM my_offers WHERE offer_id=offers.id AND user_id=".$this->db->escape($this->user_model->info->id).") AS is_my")
			->from("offers");

		if(!$this->user_model->isAdmin() AND !$last) {
			$this->db->where("offers.type", "1");
			$this->db->where("(offers.private = '0' OR (offers.private = '1' AND (SELECT COUNT(*) FROM offers_private s WHERE s.user_id=" . $this->db->escape($this->user_model->info->id) . " AND s.offer_id=offers.id) >=1 ))");
		}
		elseif( $last ) {

			$this->db->where("offers.type", "1");
			$this->db->order_by("added", "DESC")->limit(5);
		}

		$this->db->join("offers_private", "offers_private.offer_id = offers.id AND offers_private.user_id=".$this->user_model->info->id, "left");


		$query = $this->db->get();
		return $this->offersData( $query );
	}


	public function getOffersForUser($id = 0 ){
		$query = $this->db->select("offers.*, offers_private.offer_id as private_offer,"
			. "(SELECT COUNT(*) FROM transits WHERE offer_id=offers.id) AS transits, "
			. "(SELECT COUNT(*) FROM offers_private s WHERE s.user_id=" . $this->db->escape($this->user_model->info->id) . " AND s.offer_id=offers.id) AS private_access, "
			. "(SELECT COUNT(*) FROM requests WHERE offer_id=offers.id) AS requests, "
			. "(SELECT SUM(profit) FROM requests WHERE offer_id=offers.id) AS profits")
			->where("my.user_id", $id)
			->where("offers.id >", "0")
			->from("my_offers AS my")
			->join("offers", "offers.id = my.offer_id", "left")
			->join("offers_private", "offers_private.offer_id = my.offer_id AND offers_private.user_id=my.user_id", "left")->get();

		return $this->offersData( $query );
	}

	public function offersData( $query ){

		$offers = $query->result();
		foreach( $offers as $key => $offer ){
			$offers[$key]->access_data = $this->offerAllow( $offer );

		}
		return $offers;
	}

	public function offerAllow( $offer_data ){
		if( !$offer_data ) return false;
		// оффер отключен
		if( $offer_data->type != "1" ) return ['status'=>'0', 'msg' => 'Выключен'];

		// проверяем статус оффера
		if( $offer_data->private AND isset( $offer_data->private_access) AND $offer_data->private_access){
			return ['status'=>'1', 'msg' => 'Приватный оффер, доступен'];
		}
		if( $offer_data->private AND isset( $offer_data->private_access) AND !$offer_data->private_access){
			return ['status'=>'0', 'msg' => 'Приватный оффер, недоступен для вас'];
		}


		return ['status'=>'1', 'msg' => ''];
	}




	public function addNewOfferToMe($offer_id){
		$this->load->model("url_model");
		$data = array(
			"offer_id"	=> $offer_id,
			"user_id"	=> $this->user_model->info->id,
		);
		$this->db->insert("my_offers", $data);
		return true;
	}




	public function removeOfferToMe($offer_id){
		$this->db->delete("my_offers", array(
			"offer_id" => $offer_id,
			"user_id" => $this->user_model->info->id
		));
	}

}
