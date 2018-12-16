<?php

class Stat_Model extends CI_Model {
	

	private $query;
	private $dopQuery = array();
	private $user_id = 0;
	
	function __construct() {
		parent::__construct();
		$dop_query = array();
		if($this->input->post("from_date"))
		{
			$this->dopQuery[] = "t.date >= " . $this->db->escape(checkStr($this->input->post("from_date")));
		} else{
			$this->dopQuery[] = "t.date >= '".date('Y-m-d', time()-3600*24*7 )."'";
		}
		if($this->input->post("to_date"))
		{
			$this->dopQuery[] = "t.date <= " . $this->db->escape(checkStr($this->input->post("to_date")));
		} else{
			$this->dopQuery[] = "t.date <= '".date('Y-m-d', time() )."'";
		}
	}
	
	public function getUserId(){
		return $this->user_id;
	}
	
	public function setUserId($user_id = 0){
		$this->user_id = $user_id;
		$this->dopQuery[] = "t.user_id = " . $this->db->escape($user_id) . " ";
	}
	
	public function getGroupDays(){
		//$this->dopQuery[] = "t.date=r.date ";
		$query1 = "SELECT COUNT(DISTINCT ip) AS click_all, date AS one FROM transits t "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY date ORDER BY date DESC";
		$result1 = $this->db->query($query1)->result();
		$query2 = "SELECT t.date AS one, "
			. "COUNT(CASE WHEN t.status!='-3' THEN 1 END) AS requests_all, "
			. "COUNT(CASE WHEN t.status='1' THEN 1 END) AS requests_confirm, "
			. "COUNT(CASE WHEN t.status='-1' THEN 1 END) AS requests_reflected, "
			. "COUNT(CASE WHEN t.status='-2' OR t.status='0' THEN 1 END) AS requests_pending, "
			. "SUM(IF(t.status='-2' OR t.status='0', profit, 0)) AS profit_pending, "
			. "SUM(IF(t.status='-1', profit, 0)) AS profit_reflected, "
			. "SUM(IF(t.status='1', profit, 0)) AS profit_confirm, "
			. "date AS one FROM requests t "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY date ORDER BY date DESC";
		$result2 = $this->db->query($query2)->result();
		$trs = array();
		foreach($result1 AS $row)
		{
			$trs[$row->one] = array();
			$trs[$row->one]["click_all"] = $row->click_all;
			$trs[$row->one]["requests_all"] = 0;
			$trs[$row->one]["requests_confirm"] = 0;
			$trs[$row->one]["requests_reflected"] = 0;
			$trs[$row->one]["requests_pending"] = 0;
			$trs[$row->one]["profit_pending"] = 0;
			$trs[$row->one]["profit_reflected"] = 0;
			$trs[$row->one]["profit_confirm"] = 0;				
		}
		foreach($result2 AS $row)
		{
			if(empty($trs[$row->one]))
			{
				$trs[$row->one]["click_all"] = '0';
			}
			$trs[$row->one]["requests_all"] = $row->requests_all;
			$trs[$row->one]["requests_confirm"] = $row->requests_confirm;
			$trs[$row->one]["requests_reflected"] = $row->requests_reflected;
			$trs[$row->one]["requests_pending"] = $row->requests_pending;
			$trs[$row->one]["profit_pending"] = $row->profit_pending;
			$trs[$row->one]["profit_reflected"] = $row->profit_reflected;
			$trs[$row->one]["profit_confirm"] = $row->profit_confirm;
		}
		return $trs;
	}
	
	public function getGroupSubs(){
		$query1 = "SELECT COUNT(DISTINCT ip) AS click_all, t.data1 AS one, t.data2 AS two, t.data3 AS three, t.data4 AS four FROM transits t "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " AND (data1 != '' OR data2 != '' OR data3 != '' OR data4 != '') "
			. "GROUP BY one,two,three,four";
		$result1 = $this->db->query($query1)->result();
		$query2 = "SELECT transits.data1 AS one, transits.data2 AS two, transits.data3 AS three, transits.data4 AS four, "
			. "COUNT(CASE WHEN t.status!='-3' THEN 1 END) AS requests_all, "
			. "COUNT(CASE WHEN t.status='1' THEN 1 END) AS requests_confirm, "
			. "COUNT(CASE WHEN t.status='-1' THEN 1 END) AS requests_reflected, "
			. "COUNT(CASE WHEN t.status='-2' OR t.status='0' THEN 1 END) AS requests_pending, "
			. "SUM(IF(t.status='-2' OR t.status='0', profit, 0)) AS profit_pending, "
			. "SUM(IF(t.status='-1', profit, 0)) AS profit_reflected, "
			. "SUM(IF(t.status='1', profit, 0)) AS profit_confirm "
			. "FROM requests t "
			. "LEFT JOIN transits ON transits.id=t.transit_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " AND (transits.data1 != '' OR transits.data2 != '' OR transits.data3 != '' OR transits.data4 != '') "
			. "GROUP BY one,two,three,four";
		$result2 = $this->db->query($query2)->result();
		$trs = array();
		foreach($result1 AS $row)
		{
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four] = array();
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["click_all"] = $row->click_all;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["requests_all"] = 0;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["requests_confirm"] = 0;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["requests_reflected"] = 0;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["requests_pending"] = 0;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["profit_pending"] = 0;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["profit_reflected"] = 0;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["profit_confirm"] = 0;			
		}
		foreach($result2 AS $row)
		{
			if(empty($trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]))
			{
				$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["click_all"] = '0';
			}
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["requests_all"] = $row->requests_all;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["requests_confirm"] = $row->requests_confirm;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["requests_reflected"] = $row->requests_reflected;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["requests_pending"] = $row->requests_pending;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["profit_pending"] = $row->profit_pending;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["profit_reflected"] = $row->profit_reflected;
			$trs[$row->one . " - " . $row->two . " - " . $row->three . " - " . $row->four]["profit_confirm"] = $row->profit_confirm;
		}
		
		return $trs;

	}
	
	public function getGroupFlows(){
		$query1 = "SELECT COUNT(DISTINCT ip) AS click_all, flows.name AS one, flow_id FROM transits t "
			. "LEFT JOIN flows ON flows.id=t.flow_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY flow_id";
		$result1 = $this->db->query($query1)->result();
		$query2 = "SELECT flows.name AS one, flows.id AS flow_id, "
			. "COUNT(CASE WHEN t.status!='-3' THEN 1 END) AS requests_all, "
			. "COUNT(CASE WHEN t.status='1' THEN 1 END) AS requests_confirm, "
			. "COUNT(CASE WHEN t.status='-1' THEN 1 END) AS requests_reflected, "
			. "COUNT(CASE WHEN t.status='-2' OR t.status='0' THEN 1 END) AS requests_pending, "
			. "SUM(IF(t.status='-2' OR t.status='0', profit, 0)) AS profit_pending, "
			. "SUM(IF(t.status='-1', profit, 0)) AS profit_reflected, "
			. "SUM(IF(t.status='1', profit, 0)) AS profit_confirm "
			. "FROM requests t "
			. "LEFT JOIN flows ON flows.id=t.flow_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY flow_id";
		$result2 = $this->db->query($query2)->result();
		$trs = array();
		foreach($result1 AS $row)
		{
			$trs[$row->one] = array();
			$trs[$row->one]["click_all"] = $row->click_all;
			$trs[$row->one]["flow_id"] = $row->flow_id;
			$trs[$row->one]["requests_all"] = 0;
			$trs[$row->one]["requests_confirm"] = 0;
			$trs[$row->one]["requests_reflected"] = 0;
			$trs[$row->one]["requests_pending"] = 0;
			$trs[$row->one]["profit_pending"] = 0;
			$trs[$row->one]["profit_reflected"] = 0;
			$trs[$row->one]["profit_confirm"] = 0;			
		}
		foreach($result2 AS $row)
		{
			if(empty($trs[$row->one]))
			{
				$trs[$row->one]["click_all"] = '0';
			}
			$trs[$row->one]["flow_id"] = $row->flow_id;
			$trs[$row->one]["requests_all"] = $row->requests_all;
			$trs[$row->one]["requests_confirm"] = $row->requests_confirm;
			$trs[$row->one]["requests_reflected"] = $row->requests_reflected;
			$trs[$row->one]["requests_pending"] = $row->requests_pending;
			$trs[$row->one]["profit_pending"] = $row->profit_pending;
			$trs[$row->one]["profit_reflected"] = $row->profit_reflected;
			$trs[$row->one]["profit_confirm"] = $row->profit_confirm;
		}
		return $trs;
	}
	
	public function getGroupOffers(){
		$query1 = "SELECT COUNT(DISTINCT ip) AS click_all, offers.name AS one, offer_id FROM transits t "
			. "LEFT JOIN offers ON offers.id=t.offer_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY offer_id";
		$result1 = $this->db->query($query1)->result();
		$query2 = "SELECT offers.name AS one, offers.id AS offer_id, "
			. "COUNT(CASE WHEN t.status!='-3' THEN 1 END) AS requests_all, "
			. "COUNT(CASE WHEN t.status='1' THEN 1 END) AS requests_confirm, "
			. "COUNT(CASE WHEN t.status='-1' THEN 1 END) AS requests_reflected, "
			. "COUNT(CASE WHEN t.status='-2' OR t.status='0' THEN 1 END) AS requests_pending, "
			. "SUM(IF(t.status='-2' OR t.status='0', profit, 0)) AS profit_pending, "
			. "SUM(IF(t.status='-1', profit, 0)) AS profit_reflected, "
			. "SUM(IF(t.status='1', profit, 0)) AS profit_confirm "
			. "FROM requests t "
			. "LEFT JOIN offers ON offers.id=t.offer_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY offer_id";
		$result2 = $this->db->query($query2)->result();
		$trs = array();
		foreach($result1 AS $row)
		{
			$trs[$row->one] = array();
			$trs[$row->one]["click_all"] = $row->click_all;
			$trs[$row->one]["offer_id"] = $row->offer_id;
			$trs[$row->one]["requests_all"] = 0;
			$trs[$row->one]["requests_confirm"] = 0;
			$trs[$row->one]["requests_reflected"] = 0;
			$trs[$row->one]["requests_pending"] = 0;
			$trs[$row->one]["profit_pending"] = 0;
			$trs[$row->one]["profit_reflected"] = 0;
			$trs[$row->one]["profit_confirm"] = 0;				
		}
		foreach($result2 AS $row)
		{
			if(empty($trs[$row->one]))
			{
				$trs[$row->one]["click_all"] = '0';
			}
			$trs[$row->one]["offer_id"] = $row->offer_id;
			$trs[$row->one]["requests_all"] = $row->requests_all;
			$trs[$row->one]["requests_confirm"] = $row->requests_confirm;
			$trs[$row->one]["requests_reflected"] = $row->requests_reflected;
			$trs[$row->one]["requests_pending"] = $row->requests_pending;
			$trs[$row->one]["profit_pending"] = $row->profit_pending;
			$trs[$row->one]["profit_reflected"] = $row->profit_reflected;
			$trs[$row->one]["profit_confirm"] = $row->profit_confirm;
		}
		return $trs;
	}


	public function getGroupPages(){
		$query1 = "SELECT COUNT(DISTINCT ip) AS click_all, pages.name AS one, page_id FROM transits t "
			. "LEFT JOIN pages ON pages.id=t.page_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY page_id";
		$result1 = $this->db->query($query1)->result();
		$query2 = "SELECT pages.name AS one, pages.id AS page_id, "
			. "COUNT(CASE WHEN t.status!='-3' THEN 1 END) AS requests_all, "
			. "COUNT(CASE WHEN t.status='1' THEN 1 END) AS requests_confirm, "
			. "COUNT(CASE WHEN t.status='-1' THEN 1 END) AS requests_reflected, "
			. "COUNT(CASE WHEN t.status='-2' OR t.status='0' THEN 1 END) AS requests_pending, "
			. "SUM(IF(t.status='-2' OR t.status='0', profit, 0)) AS profit_pending, "
			. "SUM(IF(t.status='-1', profit, 0)) AS profit_reflected, "
			. "SUM(IF(t.status='1', profit, 0)) AS profit_confirm "
			. "FROM requests t "
			. "LEFT JOIN pages ON pages.id=t.page_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY page_id";
		$result2 = $this->db->query($query2)->result();
		$trs = array();
		foreach($result1 AS $row)
		{
			$trs[$row->one] = array();
			$trs[$row->one]["click_all"] = $row->click_all;
			$trs[$row->one]["page_id"] = $row->page_id;
			$trs[$row->one]["requests_all"] = 0;
			$trs[$row->one]["requests_confirm"] = 0;
			$trs[$row->one]["requests_reflected"] = 0;
			$trs[$row->one]["requests_pending"] = 0;
			$trs[$row->one]["profit_pending"] = 0;
			$trs[$row->one]["profit_reflected"] = 0;
			$trs[$row->one]["profit_confirm"] = 0;				
		}
		foreach($result2 AS $row)
		{
			if(empty($trs[$row->one]))
			{
				$trs[$row->one]["click_all"] = '0';
			}
			$trs[$row->one]["page_id"] = $row->page_id;
			$trs[$row->one]["requests_all"] = $row->requests_all;
			$trs[$row->one]["requests_confirm"] = $row->requests_confirm;
			$trs[$row->one]["requests_reflected"] = $row->requests_reflected;
			$trs[$row->one]["requests_pending"] = $row->requests_pending;
			$trs[$row->one]["profit_pending"] = $row->profit_pending;
			$trs[$row->one]["profit_reflected"] = $row->profit_reflected;
			$trs[$row->one]["profit_confirm"] = $row->profit_confirm;
		}
		return $trs;
	}



	
	public function getLeads(){
		$this->db->select("t.*, "
			. "offers.id AS offer_id, offers.name AS offer_name, "
			. "goals.name AS goal_name, "
			. "pages.name AS page_name, pages.url AS page_url")
			->from("requests t")
			->join("goals", "goals.id=t.goal_id", "left")
			->join("offers", "offers.id=t.offer_id", "left")
			->join("pages", "pages.id=t.page_id", "left")
			->where(implode(" AND ", $this->dopQuery) . " AND t.status != '-3'")
			->order_by("t.date", "DESC")
			->order_by("t.time", "DESC");
		return $this->db->get();
	}
	
	/*
	public function getGroupGoals(){
		$query1 = "SELECT COUNT(*) AS click_all, goals.name AS one FROM transits t "
			. "LEFT JOIN goals ON goals.id=t.goal_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY goal_id";
		$result1 = $this->db->query($query1)->result();
		$query2 = "SELECT flows.name AS one, "
			. "COUNT(*) AS requests_all, "
			. "COUNT(CASE WHEN t.status='1' THEN 1 END) AS requests_confirm, "
			. "COUNT(CASE WHEN t.status='-1' THEN 1 END) AS requests_reflected, "
			. "COUNT(CASE WHEN t.status='-2' OR t.status='0' THEN 1 END) AS requests_pending, "
			. "SUM(IF(t.status='-2' OR t.status='0', profit, 0)) AS profit_pending, "
			. "SUM(IF(t.status='-1', profit, 0)) AS profit_reflected, "
			. "SUM(IF(t.status='1', profit, 0)) AS profit_confirm, "
			. "date AS one FROM requests t "
			. "LEFT JOIN goals ON goals.id=t.goal_id "
			. "WHERE " . implode(" AND ", $this->dopQuery) . " "
			. "GROUP BY goal_id";
		$result2 = $this->db->query($query2)->result();
		$trs = array();
		foreach($result1 AS $row)
		{
			$trs[$row->one] = array();
			$trs[$row->one]["click_all"] = $row->click_all;
		}
		foreach($result2 AS $row)
		{
			if(empty($trs[$row->one]))
			{
				$trs[$row->one]["click_all"] = '0';
			}
			$trs[$row->one]["requests_all"] = $row->requests_all;
			$trs[$row->one]["requests_confirm"] = $row->requests_confirm;
			$trs[$row->one]["requests_reflected"] = $row->requests_reflected;
			$trs[$row->one]["requests_pending"] = $row->requests_pending;
			$trs[$row->one]["profit_pending"] = $row->profit_pending;
			$trs[$row->one]["profit_reflected"] = $row->profit_reflected;
			$trs[$row->one]["profit_confirm"] = $row->profit_confirm;
		}
		return $trs;
	}*/
	
	
}
