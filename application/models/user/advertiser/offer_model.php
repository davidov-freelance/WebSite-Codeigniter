<?php

class Offer_Model extends CI_Model{
	
	public function getOffersForUser($id = 0){
		$this->db->select("offers.*, (SELECT COUNT(*) FROM transits WHERE offer_id=offers.id) AS transits, "
			. "(SELECT COUNT(*) FROM requests WHERE offer_id=offers.id) AS requests, "
			. "(SELECT SUM(profit) FROM requests WHERE offer_id=offers.id) AS profits")
			->where("offers.user_id", $id)
			->from("offers");
		$query = $this->db->get();
		return $query;
	}
	
}
