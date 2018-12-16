<?php

class Webmaster_model extends CI_Model {
	
	public function __construct() {
		parent::__construct();
	}
	
	//Кол-во денег в холде вебмастера
	public function get_money_from_hold(){
		$sql = "SELECT SUM(money) AS sum FROM hold_money WHERE user_id = ?";
		$query = $this->db->query($sql, array($this->user_model->info->id));
		if($query->num_rows() == 0)
			return 0;
		else
			return $query->row()->sum;
	}
	
}
