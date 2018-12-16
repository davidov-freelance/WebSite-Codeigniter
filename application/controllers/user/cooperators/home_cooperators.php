<?php

class Home_cooperators extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model("user/cooperators/cooperators_model", "c_model");
	}
	
	public function index(){
		$data["title"] = "Главная";
		$data["requests"] = $this->c_model->getRequests();
		$data["requests_type"] = array(
		    "-3"	=>	"inverse",
		    "-2"	=>	"warning",
		    "-1"	=>	"danger",
		    "0"		=>	"warning",
		    "1"		=>	"success"
		);
		$this->load->view("pages/user/cooperators/index", $data);
	}
	
	public function login(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('password', 'Пароль', 'trim|required');        

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view("pages/user/cooperators/login");
		}
		else
		{
			if( $this->c_model->goLogin( checkStr($this->input->post("password")) ) )
				redirect(base_url() . "cooperator/index");
			else
				redirect(base_url() . "cooperator/login");
		}
	}
	
	public function getHistory(){
		$this->load->helper("date_helper");
		$id = $this->input->post("request_id");
		$query = $this->db->from("requests_history")
				->where("request_id", $id)
				->order_by("date", "DESC")
				->get();
		$result = $query->result();
		$comments = config_item("call_center_history_names");
		$go = "<div class='table-responsive'><table class='table table-condensed'>";
		$go .= "<thead>"
			. "<tr>"
				. "<th>Комментарий</th>"
				. "<th>Время</th>"
			. "</tr>"
			. "</thead>"
			. "<tbody>";
		foreach($result AS $row){
			$go .= "<tr>"
				. "<td>".$comments[$row->comment]."</td>"
				. "<td>".normal_time(strtotime($row->date))."</td>"
			. "</tr>";
		}
		$go .= "</tbody></table></div>";
		echo $go;
	}
	
	public function setNewHistory(){
		$r = $this->input->post("request_id");
		$c = $this->input->post("comment_id");
		$this->db->insert("requests_history", array("request_id" => $r, "comment" => $c));
	}
	
	public function changeStatus(){
		$this->load->model("user/advertiser/stat_model", "stat_model");
		if($this->input->post() == false)
			return;
		$data = array(
		    "request_id"	=>	(int)$this->input->post("request_id"),
		    "fio"		=>	checkStr($this->input->post("fio")),
		    "address"		=>	checkStr($this->input->post("address")),
		    "postcode"		=>	(int)$this->input->post("postcode"),
		    "date"		=>	checkStr($this->input->post("date")),
		    "time"		=>	checkStr($this->input->post("time")),
		    "count"		=>	(int)$this->input->post("count"),
		    "comment"		=>	checkStr($this->input->post("comment"))
		);
		$status = $this->input->post("status");
		$this->stat_model->changeStatus($data["request_id"], $status, false);
		if($status == 1)
		{
			$this->db->insert("requests_orders", $data);
		}
		echo "true";
	}
	
}
