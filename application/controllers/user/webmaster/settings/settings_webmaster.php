<?php

class Settings_webmaster extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("user/webmaster/settings_model", "settings_model");
		$this->load->helper('email');
	}

	public function index(){

		require APPPATH . '/controllers/news/news.php';
		$data["newsCount"] =	News::newsCount();
		$data["news"] =	News::LastNews();

		$this->load->library("form_validation");
		$this->form_validation->set_rules('login', 'Логин', 'trim|required');


		$data["title"] = "Настройки аккаунта";

		if ($this->input->post() !== false AND $this->form_validation->run() !== FALSE) {
			$info = array(
				'login'	=> checkStr($this->input->post('login')),
				'phone'	=> checkStr($this->input->post('phone')),
				'email'	=> checkStr($this->input->post('email'))?checkStr($this->input->post('email')):$this->user_model->info->email,
				'notices_status'	=> $this->input->post('notices_status'),
				'skype'	=> checkStr($this->input->post('skype'))
			);
			if( empty( $this->user_model->info->wmr ) ){
				$info['wmr'] = checkStr($this->input->post('wmr'));
			}


			$new_password = trim($this->input->post("new_password"));
			if (!empty($new_password)) {
				$this->load->model("user_model");
				$new_password = $this->user_model->getMD5($new_password);
				$info['passhash'] = $new_password;
			}

			$this->db->where("id", $this->user_model->info->id)
				->update("users", $info);
			redirect(base_url() . "webmaster/settings");

		}

		if( $this->user_model->info->notices_status ){
			$this->user_model->info->notices_status = 'active';
			$this->user_model->info->notices_status_disabled = 'disabled';
		} else{

			$this->user_model->info->notices_status = '';
			$this->user_model->info->notices_status_disabled = '';
		}
		$data['row'] = $this->user_model->info;
		$data['content'] = $this->load->view("pages/user/webmaster/settings/settings", $data, true);
		$this->load->view("layouts/main", $data);


	}

}
