<?php

class API_model extends CI_Model {

	private $api_key, $hash, $goal_id;
	private $crm_url = 'http://api.overleads.ru/leads';



	public function __construct() {
		parent::__construct();
		$this->api_key = htmlspecialchars($this->input->post('api_key'));
		$this->hash = ($this->input->get('hash'))?htmlspecialchars($this->input->get('hash')):htmlspecialchars($this->input->post('hash'));
		$this->goal_id = (int)($this->input->post('goal_id'));
	}


	public function getApiKey(){
		return $this->api_key;
	}

	public function getHash(){
		return $this->hash;
	}

	public function getGoalId(){
		return $this->goal_id;
	}

	/*
	 * Возвращаем лида
	 */

	public function getRequest( $id ){
		return $this->db->select("requests.*, goals.name as goal_name, transits.data1, transits.data2, transits.data3, transits.data4, transits.ip")
			->from("requests")
			->join("goals", "goals.id=requests.goal_id", "left")
			->join("transits", "transits.id=requests.transit_id", "left")
			->where("requests.id", $id)->get();
	}

	/*
	 * Проверяем доступ
	 */
	public function hasAccess(){
		if(!$this->getApiKey() || strlen($this->getApiKey()) != 32)
			return false;
		if(!$this->getHash() || strlen($this->getHash()) != 32)
			return false;
		return true;
	}


	/*
	 * Проверяем наличие ключа API в базе данных
	 */
	public function hasAPIKey(){
		$query = $this->db->get_where('users', ['api_key' => $this->getApiKey()]);
		return $query;
	}



	/*
	 * Получаем информацию о переходе
	*/

	public function getTransitInfo(){

		return $this->db->select("flows.flow_type, flows.country_id, flows.city_id, transits.flow_id")
			->from("transits")
			->join("flows", "flows.id=transits.flow_id", "left")
			->where("hash", $this->hash)->get()->row();


	}


	/*
	 * Получаем информацию о переходе по URL
	*/

	public function getFlowInfoByURL( $url ){

		return $this->db->select('flows.*, pages.url AS page_url, gaskets.url AS gasket_url, offers.countries, offers.name as offer_name, goals.id as goal_id, goals.name as goal_name')
			->where('flows.url', $url)
			->from('flows')
			->join('pages', 'pages.id=flows.page_id', 'left')
			->join('gaskets', 'gaskets.id=flows.gasket_id', 'left')
			->join('offers', 'offers.id=flows.offer_id', 'left')
			->join('goals', 'goals.offer_id=offers.id', 'left')
			->get()->row();

	}


	/*
	 * Получаем информацию о потоке,
	 * на который произошел переход
	 */
	public function getFlowInfo(){

		return $this->db->select("flows.*, transits.id as transit_id, offers.name as offer_name, offers.id as offer_id, offers.id_in_crm")
			->from("transits")
			->join("flows", "flows.id=transits.flow_id", "left")
			->join('offers', 'offers.id=flows.offer_id', 'left')
			->where("hash", $this->hash)->get()->row();
	}


	/*
	 * Получаем всю информацию по связкам оффера
	 */
	public function getBunches( $goal_id ){

		// запрашиваем все связки для данной цели
		$bunches = $this->db->select("country_id, city_id")
			->from("geo_goals")
			->where("goal_id", $goal_id )
			->where("status", 1 )->get();

		/*
		 * определяем, поток по странам или городам
		 * по умолчанию поток по странам, если же найден хоть один город,
		 * то поток считается по городам, это ключевой момент для формирования
		 * списоков выбора на лэндинге
		 */

		$goals['geo_type'] = "by_countries";
		foreach( $bunches->result() as $bunche ){
			if( $bunche->city_id>0 ){
				$goals['geo_type'] = "by_cities";
				$cities[$bunche->city_id] = $bunche;
			} else{
				unset( $bunche->city_id );
				$countries[$bunche->country_id] = $bunche;
			}

		}
		if( $goals['geo_type'] == "by_cities" ) $goals['bunches'] = $cities;
		else $goals['bunches'] = $countries;
		return $goals;

	}





	/*
	 * Добавляем информацию о запросе
	 */

	public function insertNewRequest($arr = array()){
		foreach($arr AS $key => $value){
			$this->db->set($key, $value);
		}
		$this->db->set('date', date('Y-m-d'));
		$this->db->set('time', date('H:i:s'));

		$this->db->insert('requests');


		return $this->db->insert_id();



	}



	/*
	 * Метод оформляет нобходимую стркутуру запроса и передает на отправку
	 * Получает три параметра: адрес, массив с данными и способ отправки(пост или гет)
	 * flow_id, ip, time, datetime, goal_id, goal_name, profit, status, offer_id, offer_name
	 */

	public function sendPostback( $data, $flowInfo ){
		// prepare url
		$url = str_replace('&amp;', '&', $flowInfo->postback_url );
		$postInfo = '';

		$keys = [
			'{flow_id}', '{ip}', '{lead_time}', '{lead_date}', '{goal_id}',
			'{goal_name}', '{profit}', '{offer_id}', '{offer_name}',
			'{sub1}', '{sub2}', '{sub3}', '{sub4}', '{status}'
		];


		$values = [
			$flowInfo->id, $data['ip'], time(), date('Y-m-d'), $data['goal_id'], $data['goal_name'],
			$data['profit'], $flowInfo->offer_id, $flowInfo->offer_name,
			$data['data1'], $data['data2'], $data['data3'], $data['data4'], $data['status'],
		];

		$query = explode('?', $url );
		$parameters = explode('&', $query['1'] );
		$sendUrl = $query[0] . '?';
		foreach($parameters AS $parameter ){
			$vars = explode('=', $parameter );

			// если метод пост, то формируем массив
			// иначе продолжаем формировать url для запроса
			if( $flowInfo->postback_method == "post" ){
				$postInfo[$vars[0]] = str_replace($keys, $values, $vars[1]);
			} else{
				$sendUrl .= $vars[0] . '=' . str_replace($keys, $values, $vars[1]) . '&';
			}

		}
		$this->sendQuery( $sendUrl, $postInfo, $flowInfo->postback_method );

	}




	public function sendToCrm( $flowInfo, $orderInfo, $request_id ){

		$offer_row = $this->db->get_where('offers', array('id' => $flowInfo->offer_id ))->row();
		$request_data = $this->db->get_where('requests', array('id' => $request_id ))->row();
		$user = $this->hasAPIKey()->row();

		if( $offer_row->send_to == 'crm' )
		{
			$param1 = json_decode( $request_data->dop_info );
			$postInfo = array(

				'pp_lead_id' 		=> $request_id,
				'offer_id' 			=> $flowInfo->id_in_crm,
				'country_id' 		=> $flowInfo->country_id,
				'city_id' 			=> $flowInfo->city_id,
				'pp_fio' 			=> $orderInfo->fio,
				'pp_phone' 			=> $orderInfo->phone,
				'pp_webmaster_id'	=> $flowInfo->user_id,
				'pp_webmaster_login'=> $user->login,
				'pp_params'			=> $param1->param1,
				'pp_email'			=> $user->email,
				'type_id'      		=> '1',
				'pp_lead_source' 	=> 'overads.net',
			);

			$this->sendQuery( $this->crm_url, $postInfo, "post" );

		}

	}

	/*
     * Метод инициализации курл
     * url - адрес
     * method - post | get
     * info - массив с переменными
     */
	private function sendQuery( $url, $info, $method ){

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_REFERER, config_item('base_url'));
		if( $method == "post" ){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $info );
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
	}



}
