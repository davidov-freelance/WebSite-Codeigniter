<?php

class Payments_admin extends CI_Controller{
	
	public function index(){
		
		$data = array(
		    "title"	=>	"Выплаты, заказанные вебмастерами"
		);
		$this->load->view("template/user/admin/head", $data);
		
		$this->db->select("payments.*, users.wmr, users.*")
			->where("paid", "0")
			->from("payments")
			->join("users", "users.id=payments.user_id", "left")
			->order_by("time", "ASC");
		$query = $this->db->get();
		$info = array(
		    "result"	=>	$query
		);
		
		$this->load->view("pages/user/admin/user/list_payments", $info);
		$this->load->view("template/user/admin/foot");
		
	}
	
	public function ok($id = 0){
		checkInt($id);
		$query = $this->db->select("payments.*")
				->from("payments")
				->where("payments.id", $id)
				->get();
		if($query->num_rows() == 0 || $query->row()->paid == '1')
			show_404();
		/*if($query->row()->hold < $query->row()->sum)
		{
			//У пользователя в холде меньше денег, чем сумма, которую он заказал
			//Зафиксировать как странное действие
		}*/
		$this->load->model("money_model");
		//$operation = $this->money_model->minusFromBalance($query->row()->sum, $query->row()->user_id);
		//if($operation)
		//{
			$this->db->where("id", $id);
			$this->db->update("payments", array("paid" => '1'));
			redirect(base_url() . "admin/user/payments");
		//}
	}
	
}