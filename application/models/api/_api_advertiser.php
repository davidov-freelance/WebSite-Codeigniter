<?php

class Api_advertiser extends CI_Model {
	
	private $api_key , $hash, $dop_info, $goal_id, $t_info, $g_info;
	
	function __construct() {
		parent::__construct();
		$this->api_key = htmlspecialchars($this->input->post("api_key"));
		$this->hash = htmlspecialchars($this->input->post("hash"));
		$this->dop_info = strip_tags($this->input->post("dop_info"));
		$this->goal_id = (int)($this->input->post("goal_id"));
	}
	
	public function getApiKey(){
		return $this->api_key;
	}
	
	public function getHash(){
		return $this->hash;
	}
	
	public function getDopInfo(){
		return $this->dop_info;
	}
	
	public function getGoalId(){
		return $this->goal_id;
	}
	
	//Проверка на приличность запроса
	public function isNormal(){
		if(!$this->input->post())
			return false;
		if(!$this->getApiKey() || strlen($this->getApiKey()) != 32)
			return false;
		if(!$this->getHash() || strlen($this->getHash()) != 32)
			return false;
		return true;
	}
	//Есть ли такой api_key в бд
	public function hasApiKeyInDb(){
		$query = $this->db->get_where("users", array("api_key" => $this->getApiKey()));
		return $query;
	}
	//Получаем всю информацию о переходе
	public function getHashInfo(){
		//Получаем информацию о цели (цену)
		$query = $this->db->get_where("goals", array("id" => $this->getGoalId()));
		if($query->num_rows() == 0)
		{
			//Цель отсутствует
			return false;
		}
		$this->g_info = $query->row();
		$profit = $query->row()->price;
		$real_profit = $query->row()->real_price;
		$transitQuery = $this->db->get_where("transits", array("hash" => $this->getHash()));
		if($transitQuery->num_rows() == 0)
		{
			//Такой hash отсутствует
			return false;
		}
		$this->t_info = $transitQuery->row();


		// check ind payments (price for webmaster)
		$ind = $this->db->get_where('ind_payments', array('goal_id' => $this->g_info->id, 'user_id' => $this->t_info->user_id))->row_array();
		if (!empty($ind)) {
			$this->g_info->price = $ind['price'];
			$profit = $ind['price'];
		}


		return array(
			"transit" => $transitQuery->row()
			, "profit" => $profit
			, "real_profit" => $real_profit
		);
	}
	//Добавляем информацию в requests
	public function insertNewRequest($arr = array()){
		foreach($arr AS $key => $value){
			$this->db->set($key, $value);
		}
		$this->db->set("date", date("Y-m-d"));
		$this->db->set("time", date("H:i:s"));
		
		$this->db->insert("requests");

		
		
		/*
		 * POSTBACK
		 */
		if(isset($arr["flow_id"]))
		{
			$query = $this->db->get_where("flows", array("id" => $arr["flow_id"]));
			if($query->num_rows() > 0)
			{
				$row = $query->row();
				if(trim($row->postback_url) != "")
				{
					$url = $row->postback_url;
					$this->send_postback($url);
				}
			}
		}
		$this->sendToCrm($arr, $this->db->insert_id());

	}
	
        private function sendToCrm($arr, $lead_id){
            
            $flowQuery = $this->db->select("cities.name, cities.country_id")
                                    ->from("flows")
                                    ->join("cities", "cities.id=flows.city_id", "left")
                                    ->where("flows.id", $this->t_info->flow_id)->get();
            $countries = config_item("countries");
            $offer_row = $this->db->get_where("offers", array("id" => $arr["offer_id"]))->row();





            $dop_info = json_decode($arr["dop_info"]);
            if($offer_row->send_to == "crm")
            {

            	$user = $this->db->get_where('users', array('id' => $this->t_info->user_id))->row();
            	$page = $this->db->get_where('pages', array('id' => $this->t_info->page_id))->row();

            	// check ind payments (price for webmaster)
            	/*
				$ind = $this->db->get_where('ind_payments', array('goal_id' => $this->g_info->id, 'user_id' => $this->t_info->user_id))->row_array();
				if (!empty($ind)) {
					$this->g_info->price = $ind['price'];
				}*/
            	

                $postInfo = "date=" . urlencode(date("Y-m-d H:i:s")) . "&"
                    . "fio=". $dop_info->fio . "&"
                    . "domain=" . urlencode(str_replace(array('http://', 'www.'), '', $page->url)) . "&"
                    . "country=".$countries[$flowQuery->row()->country_id] . "&"
                    . "city=".$flowQuery->row()->name . "&"
                    . "phone=".$dop_info->phone . "&"
                    . "offer_name=".$offer_row->name . "&"
                    . "offer_id=" . $offer_row->id . "&"
                    . "lead_id=" . $lead_id . "&"
                    . "lead_price=" . $offer_row->price . "&"
                    . "pp_lead_price=" . $this->g_info->price . "&"
                    . "pp_lead_price_rekl=" . $this->g_info->real_price . "&"
                    . "webmaster_id=" . $this->t_info->user_id . "&"
                    . "webmaster_login=" . $user->email . "&"    
                    . "lead_source=" . "overads.net";

                    file_put_contents(dirname(__FILE__).'/out.txt', print_r($postInfo, true));

				$ch = curl_init("http://crm.overleads.ru/site/api");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_REFERER, config_item("base_url"));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postInfo);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
				$result = curl_exec($ch);
				curl_close($ch);  
                
            }
            
        }
        
	/*
	 * ПЕРЕДАВАЕМЫЕ ДАННЫЕ
	 * flow_id, ip, time, datetime, goal_id, goal_name, profit, status, offer_id, offer_name
	 */
	
	private function send_postback($url){
		
		$postInfo = "";
		
		$offer = $this->db->select("name")->from("offers")->where("id", $this->t_info->offer_id)->get();
		
		$str1 = array(
		    "{flow_id}", "{ip}", "{lead_time}", "{lead_date}", "{goal_id}", "{goal_name}",
		    "{profit}", "{offer_id}", "{offer_ name}",
                    "{data1}", "{data2}", "{data3}", "{data4}"
		);
		$str2 = array(
		    $this->t_info->flow_id, $this->t_info->ip, time(), date("Y-m-d"), $this->g_info->id, $this->g_info->name,
		    $this->g_info->price, $this->t_info->offer_id, $offer->row()->name,
                    $this->t_info->data1, $this->t_info->data2, $this->t_info->data3, $this->t_info->data4,
		);
		
		$infoStr = explode("?", $url);
		$infoArray = explode("&", $infoStr[1]);
		
		foreach($infoArray AS $info){
			$vars = explode("=", $info);
			$postInfo .= $vars[0] . "=" . str_replace($str1, $str2, $vars[1]) . "&";
		}
		
		$ch = curl_init($infoStr[0]);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_REFERER, config_item("base_url"));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postInfo);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
	
}
