<?php

class Recover extends CI_Controller{
    
	public function index(){
		require_once(APPPATH.'helpers/recaptcha.php');
		$this->load->model("login_model", "login");
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|email_check');
		$this->form_validation->set_rules('g-recaptcha-response', 'Каптча', 'callback_captcha_valid['.$this->input->post('g-recaptcha-response').']');

		$user_id = $this->db->get_where("users", array("email" => $this->input->post("email")))->row();

		if ($this->form_validation->run() == FALSE || !isset( $user_id->id ) )
		{
			$data['error'] = 1;
		}
		else
		{
			$this->load->model("email/email_model", "email_model");
			$this->load->model("email/email_message_model", "email_message_model");
			$this->load->helper('string');


			$hash = $this->user_model->getMD5(random_string('alnum', 8));
			
			$data = array(
			    "user_id"	=>	$user_id->id,
			    "hash"  =>	$hash,
			    "time"	=>	time() + config_item("email_recover_time")
			);
			
			$this->db->insert("users_recover", $data);
			/*
			 * Отправляем сообщение на емайл
			 */


			$this->load->model("email/email_model", "email_model");
			$this->load->model("email/email_message_model", "email_message_model");
			$email = $this->db->get_where('emails', array('alias' => 'recover' ))->row();

			$recover_url = base_url()."account/recover/confirm/".$hash;

			$search = ['{recover_url}', '{name}'];
			$replace = [$recover_url, $user_id->login];
			$email_text = str_replace($search, $replace, $email->message);

			$this->email_model->setSubject($email->subject);

			$message = $this->email_message_model->getMessage($email->subject, $email_text, false);
			$this->email_model->setMessage($message);

			$this->email_model->setEmails([$user_id->email]);
			$this->email_model->send();
			/*
			 * Показываем сообщение об отправке
			 */
			unset( $data );
			$data['success'] = 1;


		}
		echo json_encode( $data );
		exit();
	}
	
	function email_check($str){
		$query = $this->db->get_where("users", array("email" => $str));
		if($query->num_rows() == 0)
		{
			$this->form_validation->set_message('email_check', 'Данный email отсутствует в базе');
			return false;
		}
		else
			return true;
	}


	function confirm($hash = ''){
		$query = $this->db->get_where("users_recover", array("hash" => $hash));
		if($query->num_rows() == 0)
		{
			show_404();
			return;
		}


		$row = $query->row();
		if($row->time <= time())
		{
			show_404();
			return;
		}


		$this->load->library('form_validation');

		$this->form_validation->set_rules('password', 'Пароль', 'trim|required');
		$this->form_validation->set_rules('password_two', 'Пароль', 'trim|required|matches[password]');
		if ($this->form_validation->run() == FALSE )
		{
			$this->load->view("pages/account/set_password");
		}
		else {
			$user = $this->db->get_where("users", array("id" => $row->user_id))->row();
			$this->load->model("login_model", "login");
			$pass_hash = $this->user_model->getMD5($this->input->post("password"));
			$data = ["passhash"	=>	$pass_hash ];
			$this->db->where("id", $row->user_id)->update("users", $data);
			if( $this->login->goLogin( $user->email, checkStr($this->input->post("password")) ) )
				redirect("/panel");
		}

	}
	
}