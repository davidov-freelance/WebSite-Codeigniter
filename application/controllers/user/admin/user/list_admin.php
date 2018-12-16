<?php

class List_admin extends CI_Controller{

	public function __construct(){
		parent::__construct();

		require APPPATH . '/controllers/news/news.php';
		$this->data["newsCount"] =	News::newsCount();
		$this->data["news"] = News::LastNews();
	}

	public function index(){

		$this->load->model("user/admin/user_admin_model");
		$info = array(
			"result"	=>	$this->user_admin_model->getUsersList(),
			"title"	=>	"Список пользователей"
		);



		$this->data['content'] = $this->load->view("pages/user/admin/user/list_webmasters", $info, true );
		$this->load->view("layouts/main", $this->data);


	}

	public function go_login_to_user($id = 0){
		$row = $this->db->get_where("users", array("id" => (int)$id))->row();
		if( !isset( $row->email ) )
			show_404 ();
		else
		{
			$this->load->model("login_model");
			$this->login_model->go($row->email, $row->passhash);
			redirect(base_url());
		}
	}

	public function advertisers(){
		$data['title'] = "Список рекламодателей и офферов";
		$this->load->model("user/admin/user_admin_model");


		// подгружаем новости для страницы
		require APPPATH . '/controllers/news/news.php';
		$data["newsCount"] =	News::newsCount();
		$data["news"] =	News::LastNews();
		$data['users'] = $this->user_admin_model->getAdvertsUsers();
		$data['content'] = $this->load->view("pages/user/admin/user/list_advertisers", $data, true );
		$this->load->view("layouts/main", $data);

	}

}