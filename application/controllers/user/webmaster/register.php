<?php

class Register extends CI_Controller {


	public function __construct() {
		parent::__construct();
		$this->load->model("user/webmaster/register_model", "register_model");

		$this->load->model("login_model");

		require_once(APPPATH.'helpers/recaptcha.php');
		require_once(APPPATH.'helpers/questions.php');

		$this->load->library('form_validation');
	}

	public function index(){
		if( $this->user_model->isLogin() ) redirect(base_url());

		$this->load->model("login_model", "login");
		$this->form_validation->set_rules('login', 'Логин', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_email_check');
		$this->form_validation->set_rules('password', 'Пароль', 'trim|required');
		$this->form_validation->set_rules('g-recaptcha-response', 'Каптча', 'callback_captcha_valid['.$this->input->post('g-recaptcha-response').']');


		if (($this->form_validation->run() == FALSE) OR $this->recaptch_helper->sendRequest($this->input->post('answer')) )
		{
			$this->question_helper = new Questions_Helper();
			$data = $this->question_helper->ask_question();
			$this->load->view("pages/user/webmaster/register", $data );
		}
		else
			$this->register();
	}

	public function request(){
		$this->load->helper('captcha');
		if(!$this->input->post())
			redirect(base_url());

		$login = checkStr($this->input->post("login"));
		$email = checkStr($this->input->post("email"));
		$skype = checkStr($this->input->post("skype"));
		$pass = checkStr($this->input->post("password"));
		$descr = checkStr($this->input->post("descr"));
		$count = checkStr($this->input->post("count"));
		if(strlen($login) == 0 || strlen($email) == 0 || strlen($pass) == 0)
		{
			echo "Важные поля не заполнены!";
			return;
		}

		$array = array(
		    "login"		=>	$login,
		    "email"		=>	$email,
		    "password"	=>	$pass,
		    "skype"		=>	$skype,
		    "time"		=>	time(),
		    "descr"		=>	$descr,
		    "count"		=>	$count
		);


		$this->db->insert("users_request", $array);

		echo "Ожидайте, с вами свяжется наш менеджер!";
	}



	public function register(){

		$login = checkStr($this->input->post("login"));
		$email = checkStr($this->input->post("email"));
		$pass = checkStr($this->input->post("password"));

		if( strlen($login) == 0 || strlen($email) == 0 || strlen($pass) == 0 )
			redirect(base_url());

		$array = array(
		    "login"	=>	$login,
		    "email"	=>	$email,
		    "passhash"	=>	$this->user_model->getMD5($pass),
		    "reg_date"	=>	date("Y-m-d")
		);

		if($this->register_model->add($array))
		{
			$this->login_model->go($email, $array["passhash"] );
			redirect(base_url() . "webmaster/");
		}
		else
			redirect(base_url());

	}


	function email_check($str){
		$this->register_model->email_check($str);
	}

	public function check_answer(){

		$this->question_helper = new Questions_Helper();
		if( $this->question_helper->answer_valid( $this->input->post('answer') ) ){
			$data['error'] = 0;
		} elseif( $this->input->post('answer') == '' ){
			$data['error'] = "not_answer";
		}
		else
		{
			$data['error'] = "incorrect";
			$data['question'] = $this->question_helper->ask_question()['question'];
		}
		echo json_encode($data);
	}


	public function captcha_valid( $value )
	{

		$this->recaptch_helper = new ReCaptcha_Helper();
		if( $this->recaptch_helper->sendRequest($value) ){
			return true;
		} else{
			$this->form_validation->set_message('captcha_valid', 'Подтвердите, что вы не робот');
			return false;
		}

	}



}
