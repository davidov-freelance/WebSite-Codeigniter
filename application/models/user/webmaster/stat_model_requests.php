<?php

class Stat_Model_Requests extends CI_Model{
	
	public function __construct() {
		parent::__construct();
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
			->join("flows", "flows.id=requests.flow_id", "left")
			->where("flows.user_id", $this->user_model->info->id)
			->where("requests.status !=", "-3")
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
	
	public function changeStatus($request_id = 0, $status = "0"){
		//Проверка на верность рекламодателю
		$this->db->select("requests.status, requests.real_profit AS real_profit, requests.profit, requests.user_id")
			->from("requests")
			->join("offers", "offers.id=requests.offer_id", "left")
			->where("offers.user_id", $this->user_model->info->id)
			->where("requests.id", $request_id);
		$query = $this->db->get();
		if($query->num_rows() > 0 && $query->row()->status != "1")
		{
			
			//Начисление денег вебмастеру от рекламодателя
			if($status == "1")
			{
				$this->load->model("money_model");
				$isOk = $this->money_model->fromAdvertiserToWebmaster(
					$this->user_model->info->money,
					$this->user_model->info->id,
					$query->row()->user_id,
					$query->row()->profit,
					$query->row()->real_profit
				);
				if($isOk)
				{
					$this->db->where("id", $request_id);
					$this->db->update("requests", array("status" => $status));
				}
				else
					return false;
			}
			elseif($status == "0" OR $status == "-1")
			{
				$this->db->where("id", $request_id);
				$this->db->update("requests", array("status" => $status));
			}
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
}
