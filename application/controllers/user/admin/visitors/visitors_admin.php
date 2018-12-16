<?php

class Visitors_admin extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		require APPPATH . '/controllers/news/news.php';
		$this->load->helper(array("visitors", "str"));
	}
	
	public function index($user_id = 0, $start_date = 0, $finish_date = 0, $flow_id = 0, $offer_id = 0, $status = 0){
		
		$data['title'] = 'Визиты посетителей от вебмастеров';
		$data['newsCount'] = News::newsCount();
		$data['news'] = News::LastNews();

		if($this->input->post()){
			$user_id = $this->input->post("user_id");
			$info['startDate'] = $this->input->post("start_date");
			$info['endDate'] = $this->input->post("finish_date");
			$flow_id = $this->input->post("flow_id");
			$offer_id = $this->input->post("offer_id");
			$status = $this->input->post("status");
		} else{
			$info['startDate'] = date( "Y-m-d", time() - 84000*31 );
			$info['endDate'] = date( "Y-m-d", time() );
		}


		if($start_date > 0)
			$this->db->where("transits.date >=", $start_date);
		if($finish_date > 0)
			$this->db->where("transits.date <=", $finish_date);		
		if($user_id > 0)
			$this->db->where("transits.user_id", $user_id);
		if($flow_id > 0)
			$this->db->where("transits.flow_id", $flow_id);	
		if($offer_id > 0)
			$this->db->where("transits.offer_id", $offer_id);
		if($status != 0)
			$this->db->where("requests.status", $status);
		
		$this->db->select("transits.*, offers.name, requests.id AS request_id, requests.status AS request_status")
			->from("transits")
			->join("offers", "offers.id=transits.offer_id", "left")
			->join("requests", "requests.transit_id=transits.id", "left")
			->order_by("date", "DESC")
			->order_by("time", "DESC");
		if($offer_id == 0 && $flow_id == 0 && $user_id == 0 && $start_date == 0 && $finish_date == 0)
			$this->db->limit(1000);
		$query = $this->db->get();
		$info += array(
		    'result'	=>	$query->result(),
		    'offers'	=>	$this->db->select('id, name')->get('offers')->result(),
		    'offer_id'	=>	$offer_id,
		    'user_id'	=>	$user_id,
		    'status'	=>	$status,
		    'start_date' => $start_date,
		    'finish_date' => $finish_date,
		);
		
		$data['content'] = $this->load->view("pages/user/admin/visitors/index", $info, true);
		$this->load->view("layouts/main", $data );
		
	}
	
}
