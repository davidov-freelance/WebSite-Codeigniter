<?php

/*
 * КАК ПРОИСХОДИТ ПОДКЛЮЧЕНИЕ ПРОКЛАДКИ ДЛЯ ЛЕНДИНГА
 * 1) Подключаем Jquery в прокладке
 * 2) Подключаем библиотеку Cookies
 * 3) При переходе по выданной ссылке, в GET параметре будет hash, 
 * его нужно записать в <input id="get_hash" value="<?=$_GET["hash"];?> type="hidden" />
 * 4) Запустить Jquery код, записав в cookies hash перехода, hash=$("#get_hash").val()
 * 5) И готово, после того, как пользователь перейдет на лендинг, передавать ничего не нужно
 */

class Record extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model("user/webmaster/record_model", "record_model");
		$this->load->model("api/api_model", "api_model");
		$this->load->library("user_agent");
	}
	
	public function url($url = '', $utms = ''){

		$request_data = json_decode($this->input->post("data"));
		if( count( $request_data ) ){
			$url = $request_data->flow_key;
			$flow_key = $request_data->flow_key;
			$ip  = $request_data->ip;
		} else{
			$flow_key = 0;
			$ip  = $this->input->ip_address();
		}

		$flow_info = $this->api_model->getFlowInfoByURL( $url );
		if( ($flow_info->status == "forbidden" OR $flow_info->status == "stop") AND !$flow_key ){
			redirect(($flow_info->trafficback_url?$flow_info->trafick_back:"http://google.com"));
		}
		$data = array(
		    "referer"	=> $this->input->server("HTTP_REFERER"),
		    "ip"	=> ip2long($ip),
		    "agent"	=> $this->agent->browser().' '.$this->agent->version(),
		    "date"	=> date("Y-m-d"),
		    "time"	=> date("H:i:s"),
		);


		if (isset($_SERVER['QUERY_STRING'])) {
			$utms = trim($_SERVER['QUERY_STRING']);
		}
		if(trim($utms) != "")
		{
			preg_match("#sub1=(.*)(&|$)#isU", $utms, $data1);
			preg_match("#sub2=(.*)(&|$)#isU", $utms, $data2);
            preg_match("#sub3=(.*)(&|$)#isU", $utms, $data3);
            preg_match("#sub4=(.*)(&|$)#isU", $utms, $data4);

			if(count($data1) > 1)
				$data["data1"] = rawurldecode(($data1[1]));
			if(count($data2) > 1)
				$data["data2"] = rawurldecode($data2[1]);
			if(count($data3) > 1)
				$data["data3"] = rawurldecode($data3[1]);
			if(count($data4) > 1)
				$data["data4"] = rawurldecode($data4[1]);
		}
		$request['goal_id'] = $flow_info->goal_id;
		$request['goal_name'] = $flow_info->goal_name;

		$result = $this->record_model->add($data, $flow_info, $flow_key);

		if( $flow_key ){
			echo $result;
			exit();
		}


		if(is_array($result))
		{
			$url = $result["trafficback_url"];
			redirect($url);
		}
		else
		{
			if(trim($utms) == "")
				redirect($result);
			else
				redirect($result . "&" . $utms);
		}
	}
	
}
