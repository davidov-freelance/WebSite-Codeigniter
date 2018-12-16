<?php

class Offer extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model("offer/info_model", "offer_info");
		$this->load->helper("stat_helper");
		require APPPATH . '/controllers/news/news.php';

		$this->data = array(
			"title"		=>  "Просмотр",
			"newsCount"	=>	News::newsCount(),
			"news"		=>	News::LastNews(),
		);

	}

    public function index() {
		$this->data['title'] = 'Офферы';

		$this->data['result'] = $this->offer_info->getOffers();
		$this->data['type'] = 'all';

		if (!empty($this->data['result'])) {
			foreach($this->data['result'] as &$offer) {
				$offer->cities = $this->offer_info->getCities($offer->id);
				$offer->goals = $this->offer_info->my_get_goals($offer->id);
			}
		}
		$this->data['content'] = $this->load->view("pages/offer/list", $this->data, true);
        $this->load->view("layouts/main", $this->data );

    }


	public function my(){

		$this->data['type'] = 'myweb';
		$this->data["title"] = "Мои офферы";
		$info = array();

		$this->data['result'] = $this->offer_info->getOffersForUser($this->user_model->info->id);



		if (!empty($this->data['result'])) {
			foreach($this->data['result'] as &$offer) {
				$offer->cities = $this->offer_info->getCities($offer->id);
				$offer->goals = $this->offer_info->my_get_goals($offer->id);
			}
		}

		if (!empty($this->data['result2'])) {
			foreach($this->data['result2'] as &$offer) {
				$offer->cities = $this->offer_info->getCities($offer->id);
				$offer->goals = $this->offer_info->my_get_goals($offer->id);
			}
		}

		$this->data['content'] = $this->load->view("pages/offer/list", $this->data, true);
		$this->load->view("layouts/main", $this->data);
	}





	public function id($id = 1) {


		checkInt($id);
		$this->db->where('id', $id);

		$info = $this->offer_info->getOffer( $id );
		if( !$info ):
			show_404(); return;
		endif;



		if($this->user_model->isAdmin() === FALSE) {
			if ($info->private == 1) {
				$r = $this->db->get_where('offers_private', array('offer_id' => $id, 'user_id' => $this->user_model->info->id))->row_array();
				if (empty($r)) {
					show_404();
					return null;
				}
			}
		}


		$this->data['content'] = $this->load->view("pages/offer/view", array(
			'info' => $info,
			'cities' => $this->offer_info->getCities($id),
			'goals' => $this->offer_info->my_get_goals($id),
			'pages' => $this->offer_info->getPages($id),
			'gaskets' => $this->offer_info->getGaskets($id),
			'news'	=> $this->db->where('offer_id', $id)->order_by('added', 'DESC')->get('news')
		), true );

		$this->load->view("layouts/main", $this->data );


	}


	public function goalGeo( $goal_id = 1 ){
		echo json_encode( $this->offer_info->getBunches($this->input->post()));
		exit();
	}



}