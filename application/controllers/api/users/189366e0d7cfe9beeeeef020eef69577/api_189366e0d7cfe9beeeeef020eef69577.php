<?php

class Api_189366e0d7cfe9beeeeef020eef69577 extends CI_Controller {
	
	private $url = "";
	
	public function __construct() {
		parent::__construct();
		$this->load->model("user/webmaster/country_model", "country_model");
	}
	
	public function index(){
		if(!$this->input->post() || !$this->input->post("hash"))
			return;
		switch($this->input->post("product_name"))
		{
			case "gshock":
				$this->url = "http://gshocks.leadvertex.ru/api/webmaster/addOrder.html?webmasterID=90&token=molodost360";
				break;
			case "diesel":
				$this->url = "http://diesel5.leadvertex.ru/api/webmaster/addOrder.html?webmasterID=90&token=molodost360";
				break;
			case "patek":
				$this->url = "http://patek-philippe.leadvertex.ru/api/webmaster/addOrder.html?webmasterID=90&token=molodost360";
				break;
			case "pandora":
				$this->url = "http://watch-pandora.leadvertex.ru/api/webmaster/addOrder.html?webmasterID=90&token=molodost360";
				break;
		}		
		$query = $this->db->get_where("transits", array("hash" => $this->input->post("hash")));
		if($query->num_rows() == 0)
			return;
		$info = $query->row();
		$postFields = "country=".$this->country_model->get(long2ip($info->ip))
			. "&fio=".$this->input->post("fio")
			. "&phone=".$this->input->post("phone")
			. "&price=".$this->input->post("price")
			. "&total=".$this->input->post("total")
			. "&quantity=1"
			. "&timezone=".$this->input->post("timezone")
			. "&domain=".$this->input->post("domain")
			. "&ip=".long2ip($info->ip)
			. "&referer=".$info->referer
			;

		$ch = curl_init($this->url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec($ch);
		curl_close($ch);
		
	}
	
}
