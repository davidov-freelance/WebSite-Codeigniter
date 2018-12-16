<?php
	/*
		Контроллер по умолчанию для главной страницы панели управления
	*/
class Home extends CI_Controller{

	public function __construct() {
		parent::__construct();

	}



	public function index() {
		require APPPATH . '/controllers/news/news.php';
	
		$data = array(
			"title" 	=> 	"Панель",
			"newsCount"	=>	News::newsCount(),
		);
		if( isset( $this->user_model->info->type ) ){
			$data['news'] = News::LastNews();
		}

		if($this->user_model->login === FALSE){
			include FCPATH . 'landing/index.php';
		} else {
			if( $this->user_model->info->type == "0" ){
				$this->web_stat();
			} elseif( $this->user_model->info->type == "3" ){
				$this->admin_stat();
			}

			$data['content'] = $this->load->view("pages/user/".$this->user_model->type."/home", $this->info, true);
			$this->load->view("layouts/main", $data);
		}

	 }
	public function landing(){
		include FCPATH . 'landing/index.php';
		exit();
	}


	public static function profit(){
		return 'test';
	}


    // этому тоже здесь не место
    public function changeCollapsed(){
	    if($this->input->post("isCollapsed") == "true")
		$this->session->set_userdata("isCollapsed", $this->input->post("isCollapsed"));
	    else
		$this->session->unset_userdata('isCollapsed');
    }




	public function web_stat(){

		$this->load->model("helper_model");
		$this->load->model("offer/info_model");
		// в идеале, вот это надо вынести в отдельные модули
		$transitsQuery = "SELECT * FROM transits t WHERE t.date = CURDATE() AND user_id = ?";
		$requestsQuery = "SELECT COUNT(*) AS requests_count, SUM(profit) AS requests_profit FROM requests r WHERE date = CURDATE() AND status='1' AND user_id=?";
		$transits = $this->db->query($transitsQuery, array($this->user_model->info->id));
		$requests = $this->db->query($requestsQuery, array($this->user_model->info->id));


		$newOffers = $this->info_model->getOffers(true);
		$this->info = array(

			"helper" => $this->helper_model->getHelpers(),
			"transits_count"	=> $transits->num_rows(),
			"requests_count"	=> ($requests->num_rows() > 0 ? $requests->row()->requests_count : 0),
			"requests_profit"	=> ($requests->num_rows() > 0 ? $requests->row()->requests_profit : 0),
			"newOffers"		=> $newOffers,
			"news"		=> $this->db->from("news")->order_by("added", "DESC")->get(),
		);
	}


		public function admin_stat(){

			// в идеале, вот это надо вынести в отдельные модули


			$this->info = array(
				"stat_today"	=> $this->getLidsCount(),
				"stat_week"	=> $this->getLidsCount(7),
				"stat_all"	=> $this->getLidsCount(1000),

			);
		}


		public function getLidsCount( $date = ""){
			if( $date == "" ){
				$date = 'r.date = CURDATE()';
			} else{
				$date = 'r.date >= CURDATE() - INTERVAL '.$date.' DAY';
			}
			return  $this->db->query( "SELECT COUNT(*) AS requests_count FROM requests r WHERE ".$date." AND status='1'" )->num_rows();

		}


}