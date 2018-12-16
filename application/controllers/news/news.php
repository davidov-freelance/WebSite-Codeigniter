<?php

class News extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model("user/admin/news_model");
		$this->load->library('form_validation');
		$this->load->helper("date");
	}

	public function index(){
		$this->load->helper("date_helper");
		$data["title"] = "Список новостей";

		$info['result'] = $this->news_model->getNews();
		$data['content'] = $this->load->view("pages/news/list", $info, true );

		$data["newsCount"] =	$this->newsCount();
		$data["news"] =	$this->LastNews();
		$this->load->view("layouts/main", $data );
	}

	// пользователь просмотрел все новости
	public function sawnews(){

		$data = array('saw_news' => 1,);

		$this->db->where('id', $this->user_model->info->id);
		$this->db->update('users', $data);
		exit();

	}

	public function view( $id ){
		$data['news'] = $this->news_model->getViewData($id);
		if(!$data['news']){
			show_404();
			return;
		}
		die($this->load->view("pages/news/item", $data, true ));
	}

	public function newsCount(){
		return $this->db->from('news')->get()->num_rows();
	}


	public  function LastNews(){

		$this->load->model("user/admin/news_model");
		return $this->news_model->getNews();
	}


	public function add_news( $action = "add", $id = 0 ){

		if( $this->user_model->info->type != 3 ) return false;

		if( $action == "edit" ) {
			$data['title'] = "Редактирование новости";
			$data['result'] = $this->db->from("news")->where(array('id'=>$id))->get()->row();
		} else{
			$data['title'] = "Добавление новости";
			$data['result'] = array();
		}

		$data['offers']	=	$this->db->get("offers")->result();

		$this->form_validation->set_rules('offer_id', 'id', 'callback_check_offer');
		$this->form_validation->set_rules('name', 'тема', 'trim|required|max_length[100]|htmlspecialchars');
		$this->form_validation->set_rules('text', 'текст', 'trim|required');

		if ($this->form_validation->run() != FALSE)
		{
			$data = [
				'offer_id' 	=> (int)$this->input->post('offer_id'),
				'name'	   	=> checkStr($this->input->post('name')),
				'text'	   	=> $this->input->post('text'),

				'show' 	=> (int)$this->input->post("show_for"),
				'news_type' => checkStr($this->input->post("news_type")),

				'id'		=> (int)$id

			];
			$params = [
				'alert'	   	=> (int)$this->input->post("alert"),
				'action'	=> checkStr($action),
			];

			$this->news_model->add_new( $data, $params );
			redirect(base_url()."news");
		}


		$data['content'] = $this->load->view("pages/news/edit", $data, true );
		$data["newsCount"] = $this->newsCount();
		$data["news"] =	$this->LastNews();
		$this->load->view("layouts/main", $data );

	}


	public function delete($id)
	{
		if(!$this->user_model->isAdmin()) {
			show_404();
			return;
		}
		$this->db->delete("news", array("id" => $id));
		redirect(base_url() . "/news" );
	}
}


