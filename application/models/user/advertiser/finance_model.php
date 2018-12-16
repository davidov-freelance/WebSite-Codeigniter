<?php

class Finance_model extends CI_Model {
	
	private $from_date;
	private $to_date;
	
	function __construct() {
		parent::__construct();
	}
	
	public function set_from_date($date = ''){
		$this->from_date = $date;
	}
	
	public function set_to_date($date = ''){
		$this->to_date = $date;
	}
	
	public function get_costs_days($ad_id = 0){
		if($ad_id == 0)
			$ad_id = $this->user_model->info->id;
		if($this->from_date)
			$this->db->where("date >=", $this->from_date);
		if($this->to_date)
			$this->db->where("date <=", $this->to_date);		
		$query = $this->db->select("SUM(real_profit) AS sum, date")
			->from("requests")
			->join("offers o", "o.id=requests.offer_id")
			->where("status", "1")
			->where("o.user_id", $ad_id)
			->group_by("date")
			->order_by("date", "desc")->get();
		return $query;
	}
	
}
