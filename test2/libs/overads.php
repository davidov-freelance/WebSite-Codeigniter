<?php
class Overads {
	private $api_url = "http://overads.net/api/";
	public $script_url = "http://overads.net/scripts/";
	private $api_key = "crqh680ecwoks0w4wko4kcowg0c080k8";
	// этот ключ используется при прямом переходе пользователя
	private $flow_key = "xhufg";
	public $hash;
	public $goalId;
	public $term_group;
	public $data;
	private $access = 0;
	public  $flowData;
	public function __construct( $goalID, $term_group = 0 ){
		if( isset( $_GET['hash'] ) ){
			$this->hash = trim($_GET['hash'] );
		} elseif( isset( $_COOKIE['hash'] ) ){
			$this->hash = trim( $_COOKIE['hash'] );
		} else{
			$this->flow_key = (isset( $_GET['k'] ) )?$_GET['k']:$this->flow_key;
			$this->hash = $this->sendRequest("transit", ['flow_key'=>$this->flow_key, 'ip' => $this->getUserIp() ] );
		}
		$this->goalId = $goalID;
		$this->term_group = $term_group;
		$this->data = json_decode($this->getData());
		$this->setHash();
	}
	/*
	 * Получаем всю информацию по потоку
	*/
	public function getFlowData(){
		$this->flowData = json_decode( $this->sendRequest("flowData") );
	}
	/*
	 * Проводим постукивание по цели
	*/
	public function insertRequest( $type, $data ){
		$data['type'] = $type;
		return $this->sendRequest('', $data);
	}
	/*
	 * Запрашиваем у сервера генерацию тайтлы и номер телефона
	 * Ответ составит из массива переменных
	 * title
	 * 		defaultTitle - заголовок по умолчанию
	 * 				title - заголовок
	 * 				defaultPlace - место по умолчанию (например: в юридическом центре)
	 * 				name - название оффера
	 * 		cityName	- гео, например: Москве
	 * 		title - основной заголовок с указанием гео
	 * phone
	 */
	public function getData(){
		return $this->sendRequest( "getData" );
	}
	/*
	 * отправка запроса к серверу
	 * action - переменная действия
	 * по умолчанию происходит постукиванию
	 * также доступно:
	 * 		flowData - все данные по потоку
	 *		access - проверка доступа по api_key
	*/
	private function sendRequest( $action = '', $data=[] ){
		$postFields = "api_key=". $this->api_key
			."&hash=".$this->hash
			."&goalId=".$this->goalId
			."&get=".json_encode( $_GET )
			."&data=".json_encode( $data )
			."&term_group=".$this->term_group;
		$ch = curl_init($this->api_url . $action );
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_REFERER, $_SERVER["HTTP_HOST"]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		return $result;
	}
	/*
	 * Установка хэша
	 */
	private function setHash(){
		if( $this->hash AND !isset( $_COOKIE['hash'] ) )
			setcookie("hash", $this->hash, time() + $this->data->postclick * 3600);
	}
	/*
	 * Установка цели
	 */
	public function setGoal( $goal ){
		$this->goalId = $goal;
	}

	public function getUserIp(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

}