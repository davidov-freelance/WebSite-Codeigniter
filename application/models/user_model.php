<?php

class User_model extends CI_Model{
    
	public $login = false;
	public $info = null;
	public $type = "";
	public $id;
	private $isAdmin = false;

	/*
	 * Уровни доступа
	 * тип пользователя => страница
	 */
	private $config_arr = array(
	    0 => array('advertiser', 'admin'),
	    1 => array('webmaster', 'admin'),
	    2 => array('advertiser', 'webmaster'),
	    3 => array()
	);
	/*
	 * Список разрешенных страниц для гостей
	 */
	private $config_pages = array(
		'account/login',
		'account/block',
		'register',
		'register/check_answer',
		'webmaster/register',
		'webmaster/register/go',
		'webmaster/register/request',
	    'for_advertisers',
		'advertiser/register',
		'api/crm',
		'/',
		'cpa',
		'home',
		'api/crm/change_status',
	);
	/*
	 * Список разрешенных сегментов для всех
	 */
	private $rsegments = array(
	    'record', 'cpa', 'api_index', 'crm', 'api_189366e0d7cfe9beeeeef020eef69577', 'recover', 'home_cooperators', 'pages', 'home',
	);
	
	public function isAdmin(){
		return $this->isAdmin;
	}
    
	public function __construct() {
	    parent::__construct();
		if( $this->uri->rsegment(1) == "login" AND $this->isLogin() === TRUE ){
			redirect(base_url() . "panel");
		}
	    if($this->isLogin() === FALSE && !in_array($this->uri->rsegment(1), $this->rsegments))
	    {
		    if(!in_array($this->uri->uri_string(), $this->config_pages))
			redirect(base_url() . "account/login");
	    }

	    if($this->login){
			if($this->info->status == 0 AND $this->uri->rsegment(1)!= "block" ){
				redirect(base_url() . "account/block");
			}		    
		    if( in_array($this->uri->segment(1), $this->config_arr[$this->info->type]) )
		    {
			    show_404();
			    return;
		    }

		    switch($this->info->type){
				case 0: 
				    $this->type = "webmaster"; 
				    $this->load->model("webmaster_model");
				break;
				case 1: $this->type = "advertiser"; break;
				case 2: $this->type = "admin"; break;
				case 3: $this->type = "admin"; break;
		    }
		    $this->isAdmin = in_array($this->info->type, array("2", "3"));
	    }

	}

	public function isLogin(){
	    if($this->session->userdata("email") && $this->session->userdata("passhash")){
		$res = $this->getUserInfo(
			array(
			    "email" => $this->session->userdata("email"), 
			    "passhash" => $this->session->userdata("passhash")
			)
		    );

		if($res->num_rows() > 0)
		{   
		    $this->info = $res->row();

			$this->login = true;
			return true;
		}
	    }
	    return false;
	}

	public function getUserInfo($array = array()){
	    if(count($array) != 0)
		foreach($array AS $key => $value)
		    $this->db->where($key, $value);        
	    return $this->db->get("users");
	}

	public function getMD5($password){
	    return md5($password . "pass100lead" . $password . "okglass");
	}

	public function isCollapsed(){
		if($this->session->userdata("isCollapsed") === "true")
			return "aside-collapsed";
		else
			return "";
	}
    
	function get_count_unread_tickets(){
		if($this->info->type == 0)
		{
			$this->db->from("ticket_message tm")
				->join("ticket", "ticket.id=tm.ticket_id", "left")
				->where("ticket.user_id", $this->user_model->info->id)
				->where("tm.read", "false");
			return $this->db->get()->num_rows();
		}
		else
			return 0;
	}
    
}
