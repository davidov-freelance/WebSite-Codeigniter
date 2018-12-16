<?php

class Home_Webmaster extends CI_Controller{
	
	public function index(){
		$data = array(
		    "title" => "Панель"
		);

		
		$transitsQuery = "SELECT * FROM transits t WHERE t.date = CURDATE() AND user_id = ?";
		$requestsQuery = "SELECT COUNT(*) AS requests_count, SUM(profit) AS requests_profit FROM requests r WHERE date = CURDATE() AND status='1' AND user_id=?";
		$transits = $this->db->query($transitsQuery, array($this->user_model->info->id));
		$requests = $this->db->query($requestsQuery, array($this->user_model->info->id));
		$info = array(
		    "transits_count"	=> $transits->num_rows(),
		    "requests_count"	=> ($requests->num_rows() > 0 ? $requests->row()->requests_count : 0),
		    "requests_profit"	=> ($requests->num_rows() > 0 ? $requests->row()->requests_profit : 0),
		    "newOffers"		=> $this->db->where("type", "1")->from("offers")->order_by("added", "DESC")->limit(5)->get(),
		    "news"		=> $this->db->from("news")->order_by("added", "DESC")->get(),
		);


		$data['content'] = $this->load->view("pages/user/".$this->user_model->type."/home", $info, true);
		$this->load->view("layouts/main", $data);

	}
	
	/*
	 * Получение графика доходов за 7 дней
	 */
	public function getForChart(){
		$requestsQuery = "SELECT date, SUM(profit) AS requests_profit FROM requests r WHERE status='1' AND user_id=? AND date > ADDDATE(CURDATE(), -7) GROUP BY date";
		$requests = $this->db->query($requestsQuery, array($this->user_model->info->id));
		$str = array();
		$result = $requests->result_array();
		$nowDate = strtotime(date("Y-m-d")); // Сегодняшняя дата
		$startDate = $nowDate - (86400 * 6); //Дата начала графика
		$timeArray = array();
		foreach($result AS $row){
			$timeArray[strtotime($row["date"])] = $row["requests_profit"];
		}
		for($i = 0; $i < 7; $i++){
			$time = $startDate + 86400*$i;
			$str[] = '["'.(date("d.m", $time)).'", '.(isset($timeArray[$time]) ? $timeArray[$time] : 0).']';
		}
		echo '[{"color":"#7dc7df","data":['.implode(",", $str).']}]';
	}
	
}
