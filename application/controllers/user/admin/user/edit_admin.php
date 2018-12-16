<?php

class Edit_Admin extends CI_Controller {

	public function index($id = 0){

		require APPPATH . '/controllers/news/news.php';
		$data["newsCount"] =	News::newsCount();
		$data["news"] =	News::LastNews();

		$query = $this->db->where("id", (int)$id)->get("users");
		if($query->num_rows() == 0) {
			show_404();
			return;
		}
		$this->load->library("form_validation");
		$data["title"] = "Настройки аккаунта";
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$data['row'] = $query->row();
		if($this->form_validation->run() === FALSE){
			if( $this->input->post("login") )
				$data['info_msg'] = ['type'=>'danger', "msg"=> "Неверный формат почтового ящика"];
			$data['content'] = $this->load->view("pages/user/webmaster/settings/settings", $data, true );
			$this->load->view("layouts/main", $data);
		}
		else
		{
			$info = array(
				"type"		=> $this->input->post("type"),
				"login"		=> trim(checkStr($this->input->post("login"))),
				"phone"	=>	trim(checkStr($this->input->post("phone"))),
				"skype"	=>	trim(checkStr($this->input->post("skype"))),
				"email"	=>	trim(checkStr($this->input->post("email"))),
				"api_key"	=>	trim(checkStr($this->input->post("api_key"))),
				"hold_days"	=>	trim(checkStr($this->input->post("hold_days"))),
			);

			$new_password = trim($this->input->post("new_password"));
			if (!empty($new_password)) {
				$this->load->model("user_model");
				$new_password = $this->user_model->getMD5($new_password);
				$info['passhash'] = $new_password;
			}

			$this->db->where("id", $id)->update("users", $info);
			redirect(base_url() . "admin/user/edit/".$id);
		}
	}


	public function delete($id = 0) {
		if( !$this->user_model->isAdmin() ) return false;
		$this->db->delete('users', 'id = ' . (int)$id);
		redirect(base_url() . 'admin/users');
	}

	public function set_status($id = 0, $status = 1) {
		if( !$this->user_model->isAdmin() ) return false;
		$status = (int)$status;
		$this->db->where("id", $id);
		$this->db->update("users", array("status" => "$status" ));

		redirect(base_url() . 'admin/user/edit/'.$id);
	}




}
