<?php

class Stat_Model extends CI_Model{
	
	private $user_id;
	private $dopQuery = array();
	
	public function __construct() {
		parent::__construct();
		if($this->input->post("from_date"))
		{
			$this->dopQuery[] = "t.date >= " . $this->db->escape(checkStr($this->input->post("from_date")));
		}
		if($this->input->post("to_date"))
		{
			$this->dopQuery[] = "t.date <= " . $this->db->escape(checkStr($this->input->post("to_date")));
		}
	}
	
	public function setUserId($id = 0){
		$this->user_id = $id;
		$this->dopQuery[] = "o.user_id = " . $this->db->escape($this->user_id) . " ";
	}
	
	public function getMyOffers(){
		$this->db->select("id, name")
			->from("offers")
			->where("user_id", $this->user_model->info->id);
		return $this->db->get();
	}
	
	public function getRequests(){
		$this->db->select("requests.*, "
			. "offers.id AS offer_id, offers.name AS offer_name, "
			. "goals.name AS goal_name, goals.price AS goal_price, "
			. "pages.name AS page_name, pages.url AS page_url")
			->from("requests")
			->join("goals", "goals.id=requests.goal_id", "left")
			->join("offers", "offers.id=requests.offer_id", "left")
			->join("pages", "pages.id=requests.page_id", "left")
			->where("offers.user_id", $this->user_model->info->id)
			->order_by("requests.status", "ASC")
			->order_by("requests.date", "DESC")
			->order_by("requests.time", "DESC");

		if($this->input->get()){
			if($this->input->get("from_date"))
				$this->db->where("requests.date >=", date("Y-m-d", strtotime($this->input->get("from_date"))));
			if($this->input->get("to_date"))
				$this->db->where("requests.date <=", date("Y-m-d", strtotime($this->input->get("to_date"))));
			if($this->input->get("offer") && $this->input->get("offer") != 0)
				$this->db->where("offers.id", $this->input->get("offer"));	
			if($this->input->get("status") && $this->input->get("status") != "all")
				$this->db->where("requests.status", $this->statusNameToNum($this->input->get("status")));				
		}
		return $this->db->get();
	}
	
	private function statusNameToNum($status){
		$type = "all";
		switch($status){
			case "new": $type = "-2"; break;
			case "deflected": $type = "-1"; break;
			case "pending": $type = "0"; break;
			case "confirmed": $type = "1"; break;
		}
		return $type;
	}
	
	public function changeStatus($request_id = 0, $status = "0", $advertiser_id = true){


		//Проверка на верность рекламодателю
		$this->db->select("uw.hold_days, ua.money, ua.id, requests.status, requests.real_profit AS real_profit, requests.profit, requests.user_id")
			->from("requests")
			->join("offers", "offers.id=requests.offer_id", "left")
			->join("users AS uw", "uw.id=requests.user_id", "left")
			->join("users AS ua", "ua.id=offers.user_id", "left")
			->where("requests.id", $request_id);
		if($advertiser_id)
			$this->db->where("offers.user_id", $this->user_model->info->id);
		$query = $this->db->get();
		if($query->num_rows() > 0 && $query->row()->status != "1")
		{
			
			//Начисление денег вебмастеру от рекламодателя
			if($status == "1")
			{
				$this->load->model("money_model");
				$isOk = $this->money_model->fromAdvertiserToWebmasterWithHold(
					$request_id,
					$query->row()->money,
					$query->row()->id,
					$query->row()->user_id,
					$query->row()->hold_days,
					$query->row()->profit,
					$query->row()->real_profit
				);
				if($isOk)
				{
					$this->db->where("id", $request_id);
					$this->db->update("requests", array("status" => (string)$status));
				}
				else
					return ['status'=>'error', 'msg'=>'Status change successfully.'];

			}
			elseif($status == "0" OR $status == "-1" OR $status == "-3")
			{
				$this->db->where("id", $request_id);
				$this->db->update("requests", array("status" => $status));
			}
			
			return ['status'=>'success', 'msg'=>'Status change successfully.'];
		}
		else
		{
			return ['status'=>'error', 'msg'=>'Lead not found or status already changed.'];
		}
	}
	
	public function getGroupDays(){
		$query = "SELECT t.date AS one, "
			. "COUNT(CASE WHEN t.status!='-3' THEN 1 END) AS requests_all, "
			. "COUNT(CASE WHEN t.status='1' THEN 1 END) AS requests_confirm, "
			. "COUNT(CASE WHEN t.status='-1' THEN 1 END) AS requests_reflected, "
			. "COUNT(CASE WHEN t.status='-2' OR t.status='0' THEN 1 END) AS requests_pending, "
			. "SUM(IF(t.status='-2' OR t.status='0', real_profit, 0)) AS profit_pending, "
			. "SUM(IF(t.status='-1', real_profit, 0)) AS profit_reflected, "
			. "SUM(IF(t.status='1', real_profit, 0)) AS profit_confirm "
			. "FROM requests t "
			. "LEFT JOIN offers o ON o.id=t.offer_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY date "
			. "ORDER BY date DESC";
		$result = $this->db->query($query)->result();
		return $result;
	}
	
	public function getGroupOffers(){
		$query = "SELECT o.name AS one, "
			. "COUNT(CASE WHEN t.status!='-3' THEN 1 END) AS requests_all, "
			. "COUNT(CASE WHEN t.status='1' THEN 1 END) AS requests_confirm, "
			. "COUNT(CASE WHEN t.status='-1' THEN 1 END) AS requests_reflected, "
			. "COUNT(CASE WHEN t.status='-2' OR t.status='0' THEN 1 END) AS requests_pending, "
			. "SUM(IF(t.status='-2' OR t.status='0', real_profit, 0)) AS profit_pending, "
			. "SUM(IF(t.status='-1', real_profit, 0)) AS profit_reflected, "
			. "SUM(IF(t.status='1', real_profit, 0)) AS profit_confirm "
			. "FROM requests t "
			. "LEFT JOIN offers o ON o.id=t.offer_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY one ";
		$result = $this->db->query($query)->result();
		return $result;
	}
	
	public function getGroupCountries(){
		$query = "SELECT transits.country_code AS one, "
			. "COUNT(CASE WHEN t.status!='-3' THEN 1 END) AS requests_all, "
			. "COUNT(CASE WHEN t.status='1' THEN 1 END) AS requests_confirm, "
			. "COUNT(CASE WHEN t.status='-1' THEN 1 END) AS requests_reflected, "
			. "COUNT(CASE WHEN t.status='-2' OR t.status='0' THEN 1 END) AS requests_pending, "
			. "SUM(IF(t.status='-2' OR t.status='0', real_profit, 0)) AS profit_pending, "
			. "SUM(IF(t.status='-1', real_profit, 0)) AS profit_reflected, "
			. "SUM(IF(t.status='1', real_profit, 0)) AS profit_confirm "
			. "FROM requests t "
			. "LEFT JOIN transits ON transits.id=t.transit_id "
			. "LEFT JOIN offers o ON o.id=t.offer_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY one ";
		$result = $this->db->query($query)->result();
		return $result;
	}
	
	public function getLeads(){
		/*
		$query = "SELECT r.*, transits.country_code AS country, o.name AS offer_name "
			. "FROM requests r "
			. "LEFT JOIN transits ON transits.id=r.transit_id "
			. "LEFT JOIN offers o ON o.id=r.offer_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "ORDER BY r.date DESC, r.time DESC"
			. "";
		*/

		$query = "SELECT t.*, transits.country_code AS country, o.name AS offer_name "
			. "FROM requests t "
			. "LEFT JOIN transits ON transits.id=t.transit_id "
			. "LEFT JOIN offers o ON o.id=t.offer_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "ORDER BY t.date DESC, t.time DESC"
			. "";

		$result = $this->db->query($query)->result();
		return $result;
	}
	
}
