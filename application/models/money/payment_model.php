<?php

class Payment_Model extends CI_Model {
	
	public function getPaymentsList($user_id = ''){
		if( $user_id ) {
			$this->db->where("user_id", $user_id)
				->from("payments")
				->order_by("paid", "DESC");
		} else{
			$this->db->select('payments.*, users.name, users.email')->from("payments")
				->join("users", "users.id=payments.user_id", "left")
				->order_by("paid", "DESC");
		}

		return $this->db->get();
	}
	
	public function newPayment($array = array()){
		$this->db->insert("payments", $array);
	}


	public function profit(){
		$transitsQuery = "SELECT * FROM transits t WHERE t.date = CURDATE() AND user_id = ?";
		$requestsQuery = "SELECT COUNT(*) AS requests_count, SUM(profit) AS requests_profit FROM requests r WHERE date = CURDATE() AND status='1' AND user_id=?";
		$transits = $this->db->query($transitsQuery, array($this->user_model->info->id));
		$requests = $this->db->query($requestsQuery, array($this->user_model->info->id));
		print_r( $requests->row() );
		return $requests->num_rows() > 0 ? $requests->row()->requests_profit : 0;
	}
	
}
