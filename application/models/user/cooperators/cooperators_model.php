<?php

class Cooperators_model extends CI_Model {
	
	public $info = null;
	
	function __construct() {
		parent::__construct();
		$this->isLogin();
	}
	
	function isLogin(){
		$password = $this->session->userdata("cooperator_password");
		if($this->uri->uri_string() != "cooperator/login")
		{
			if(!$password)
				redirect(base_url() . "cooperator/login");
			$query = $this->db->get_where("cooperators", array("password" => $password));
			if($query->num_rows() == 0)
				redirect(base_url() . "cooperator/login");
			else
				$this->info = $query->row();
		}
	}
	
	function goLogin($pass = ''){
		$query = $this->db->get_where("cooperators", array("password" => $pass));
		if($query->num_rows() > 0)
		{			
			$this->session->set_userdata("cooperator_password", $pass);
			return true;
		}
		return false;
	}
	
	public function getRequests(){
		$offers = $this->info->offers;
		if($offers != "0")
		{
			$offers_array = explode(", ", $offers);
			foreach($offers_array AS $offer_id)
				$this->db->or_where("offer_id", $offer_id);
		}
		$where = "requests.status = '-2' OR requests.status = '0'";
		$this->db->select("requests.*, offers.name AS offer_name")
			->from("requests")
			->join("offers", "offers.id = requests.offer_id", "left")
			->order_by("date", "DESC")
			->order_by("time", "DESC")
			->having($where);
		return $this->db->get();
	}
	
}
