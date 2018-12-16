<?php

class Orders_advertiser extends CI_Controller {
	
	public function index(){
		$data = array(
				'title' => 'Заказы'
		);

		$this->load->view("template/user/".$this->user_model->type."/head", $data);
		

		/*
		$this->db->select("r.dop_info, o.name As offer_name, ro.*")
			->from("requests_orders ro")
			->join("requests r", "r.id=ro.request_id", "left")
			->join("offers o", "o.id=r.offer_id", "left")
			->where("o.user_id", $this->user_model->info->id)
			->where("ro.fio !=", "")
			->order_by("r.id", "DESC");
		$query = $this->db->get();
		$data = array(
		    "orders"	=>	$query->result()
		);*/


		$this->db->select("r.dop_info, o.name As offer_name, cities.name AS city")
			->from("requests r, cities, flows")
			->join("offers o", "o.id=r.offer_id", "left")
			->where("o.user_id", $this->user_model->info->id)

			->where('r.flow_id = flows.id')
			->where('flows.city_id = cities.id')


			->order_by("r.id", "DESC");
		$query = $this->db->get();
		$data = array(
		    "orders"	=>	$query->result()
		);



		
		$this->load->view("pages/user/".$this->user_model->type."/stat/orders", $data);
		$this->load->view("template/user/".$this->user_model->type."/foot");
	}
	
}
