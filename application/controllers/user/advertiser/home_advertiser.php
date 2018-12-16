<?php

class Home_Advertiser extends CI_Controller{
	
	public function index(){
		$data = array(
				'title' => 'Главная'
			);

		$this->load->view("template/user/advertiser/head", $data);
		$this->load->view("pages/user/advertiser/home");
		$this->load->view("template/user/advertiser/foot");
	}
	
	/*
	 * Получение графика заявок за 7 дней
	 */
	public function getForChart(){
		$requestsQuery = "SELECT date, COUNT(*) AS count "
			. "FROM requests r "
			. "LEFT JOIN offers o ON o.id=r.offer_id "
			. "WHERE o.user_id=? AND date > ADDDATE(CURDATE(), -7) GROUP BY date";
		$requests = $this->db->query($requestsQuery, array($this->user_model->info->id));
		$str = array();
		$result = $requests->result_array();
		$nowDate = strtotime(date("Y-m-d")); // Сегодняшняя дата
		$startDate = $nowDate - (86400 * 6); //Дата начала графика
		$timeArray = array();
		foreach($result AS $row){
			$timeArray[strtotime($row["date"])] = (int)$row["count"];
		}
		for($i = 0; $i < 7; $i++){
			$time = $startDate + 86400*$i;
			$str[] = '["'.(date("d.m", $time)).'", '.(isset($timeArray[$time]) ? $timeArray[$time] : 0).']';
		}
		echo '[{"color":"#7dc7df","data":['.implode(",", $str).']}]';
	}
	
}