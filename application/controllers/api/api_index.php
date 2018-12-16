<?php

/*
 * Описание API системы
 * Чтобы обратиться к API рекламодатель должен авторизоваться, 
 * отправив его индивидуальный API-key на сервер, вместе с передаваемыми данными.
 * Например:
 * POST={api_key=s8sd87f7788asd097768f&hash=89fsd768sf9v787677as&name=Марат&phone=79372920862&...}
 */

class Api_index extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("api/API_model", "api_model");
		$this->load->model("country_model", "country_model");
		$this->load->model("sms_model");
	}


	/*
	 * Запись обращения
	 */
	public function index(){
		$userQuery = $this->api_model->hasAPIKey();
		$goalId = (int)$this->input->post('goalId');
		$order = json_decode( $this->input->post('data') );
		print_r( $order );
		if($userQuery->num_rows() == 0)
			die("false");

		$userInfo = $userQuery->row();
		$flowInfo = $this->api_model->getFlowInfo();


		if($flowInfo == false)
			die( "False" );


		if( !$flowInfo->city_id  ){
			$flowInfo->city_id = (int)$order->city_id;
		}

		if( !$flowInfo->country_id  ){
			$flowInfo->country_id = $this->country_model->getCityCountry( $flowInfo->city_id );
		}


		$geoData = $this->db->select('*')->from('geo_goals')->where('status', 1 )->where('goal_id', $goalId)
			->where('city_id', $flowInfo->city_id)->get()->row();

		if( isset( $geoData->price ) ){
			$profit = $geoData->price;
			$real_profit = $geoData->real_price;

		} else{
			$profit = 0;
			$real_profit = 0;
		}


		$arr = array(
			"user_id"		=>	$flowInfo->user_id,
			"transit_id"	=>	$flowInfo->transit_id,
			"flow_id"		=>	$flowInfo->id,
			"goal_id"		=>	$goalId,
			"page_id"		=>	$flowInfo->page_id,
			"gasket_id"		=>	$flowInfo->gasket_id,
			"offer_id"		=>	$flowInfo->offer_id,
			"dop_info"		=>	$this->input->post('data'),
			"profit"		=>	$profit,
			"real_profit"	=>	$real_profit,
		);


		$request_id = $this->api_model->insertNewRequest($arr);
		$request =  $this->api_model->getRequest( $request_id )->row_array();

		$this->api_model->sendToCrm($flowInfo, $order, $request_id );

		if( $flowInfo->postback_gen ) {
			$this->api_model->sendPostback( $request, $flowInfo );
		}


		die("true");

	}

	public function getInfo(){
		if($this->api->isNormal() == false)
		{
			die("false");
		}
		if($this->api->hasApiKeyInDb() == false)
		{
			die("false");
		}
		$this->db->select("offers.postclick, offers.id, flows.metrika, flows.flow_type, flows.country_id, flows.city_id, cities.name, cities.name2, cities.name3")
			->from("transits")
			->join("flows", "flows.id=transits.flow_id", "left")
			->join("offers", "offers.id=transits.offer_id", "left")
			->join("cities", "cities.id=flows.city_id", "left")
			->where("hash", $this->api->getHash());
		$transitQuery = $this->db->get();
		if($transitQuery->num_rows() == 0)
		{
			//Такой hash отсутствует
			die("false");
		}
		$row = $transitQuery->row();

		$cities = array();
		$main_cities = array();
		$query = $this->db->select('id')->from('goals')->where('offer_id', $row->id)->get();

		$all_countries = config_item("countries");

		foreach ($query->result() as $row_city)
		{
			$city_query = $this->db->select('city_id, country_id')->from('geo_goals')->where('goal_id', $row_city->id)->where('status', 1)->get();
			if($city_query->num_rows() > 0)
			{
				foreach ($city_query->result() as $city)
				{
					if( $city->city_id )
						$cities[] = $city->city_id;

					if( $city->country_id )
						$countries[$city->country_id] = $all_countries[$city->country_id];
				}
			}
		}

		if( $row->flow_type == "city" AND count( $cities ) ){
			$api_city = "http://leads.overleads.ru/web/api/city-list";
			// получили все города
			$all_cities = json_decode( file_get_contents( $api_city ) );
			$cities = array_flip( $cities );
			foreach( $all_cities as $key=>$city ){

				if( isset( $cities[$city->id] ) ){
					$main_cities[$city->id] = $city;
					unset( $all_cities[$key] );
				}
			}
		} else{
			$all_cities = '';
		}
		$array = array(
			"postclick"		=>	$row->postclick,
			"metrika_id"	=>	$row->metrika,
			"main_countries"=>  array_unique($countries),
			"countries"		=>  config_item("countries"),
			"country_id"	=>	'1',
			"flow_type"	=>	$row->flow_type,
			"city_id"	=>	$row->city_id,
			"cities"            =>      array(
				"name"  =>  $row->name,
				"name2" =>  $row->name2,
				"name3" =>  $row->name3
			),
			"cities" => $main_cities,
			"other_cities" => $all_cities,
		);
		echo json_encode($array);
	}

	public function get_info_transit($hash = ''){
		if(strlen(trim($hash)) != 32)
			return;
		$query = $this->db->select("f.comebacker, f.newwindow, p.url")
			->from("transits t")
			->join("flows f", "f.id=t.flow_id", "left")
			->join("pages p", "p.id=t.page_id", "left")
			->where("t.hash", $hash)
			->get();
		if($query->num_rows() == 0)
			return;
		$row = $query->row();
		$info = array(
			"comebacker"	=>	$row->comebacker,
			"newwindow"		=>	$row->newwindow,
			"url"		=>	$row->url
		);
		header('Access-Control-Allow-Origin: *');
		echo json_encode($info);
	}



	/*
	 * Формируем заголовки и телефон для лэндинга
	 *
	*/
	public function getData(){

		$this->load->model("utm_model", "utm_model");
		$flowData = $this->api_model->getFlowInfo();
		$get = json_decode( $_POST['get'] );
		$data = ['title'=>'', 'cityName'=>'', 'phone'=>'', 'postclick'=>'5'];
		if( isset($flowData->id ) ){
			$data['postclick'] = $this->db->get_where("offers", ['id'=>$flowData->offer_id])->row()->postclick;
			if( isset( $get->utm_term ) ){
				$data['title'] = $this->utm_model->getTitle( $get->utm_term, $_POST['term_group'] );
			} else {
				$data['title'] = $this->utm_model->getTitleByPageId( $flowData->page_id );
			}

			if( $flowData->city_id > 0 ){
				$city = $this->country_model->getCity($flowData->city_id);
				$data['cityName'] =  $city->name2;
			}

			$data['phone'] = $flowData->phone;
		}
		if( !$data['title'] ) {
			$data['title'] = $this->utm_model->getDefaultTitle( $_POST['term_group'] );
		}
		if( $data['cityName'] AND $data['title'] )
			$data['title'] = $data['title']. ' в '. $data['cityName'];


		echo json_encode($data);


	}


	public function transit(){
		$flow_key = json_decode($this->input->post("data"));
		echo $flow_key;
		exit();
	}



	public function landingJs(){
		header('Content-Type: text/javascript');

		// если нет хэша, то отмечает переменную
		if( isset($_GET['hash']) AND $_GET['hash'] == "without_hash" ){
			$data['without_hash'] = 1;
		} else{
			$data['without_hash'] = 0;
		}
		$data['transit'] = $this->api_model->getTransitInfo();
		$data['goals'] = $this->api_model->getBunches( $this->input->get('goal_id') );

		if( $data['goals']['geo_type'] == "by_countries" ){
			$data['allCountries'] = $this->country_model->getCountries();
			$data['mainCountries'] = $data['goals']['bunches'];
		}
		elseif( $data['goals']['geo_type'] == "by_cities" ){
			$data['mainCities'] = $data['goals']['bunches'];
			$data['allCities'] = $this->country_model->getCities( array_shift($data['goals']['bunches'])->country_id );
		}

		$this->load->view("api/landings", $data );
	}

}
