<?php

class Home extends CI_Controller{

    public function index() {

	$this->load->helper('file');
	$this->load->model("user/webmaster/country_model", "country_model");
	write_file('./files/ip.txt', $this->input->ip_address());
		    
	if($this->user_model->login === FALSE){
		$this->load->view("landing2/head", array("title" => "Tusa.biz - cpa сеть", "type" => 0));
		
		//Загружаем новости
		$news_query = $this->db->from('news')->order_by('added', 'Desc')->limit(5)->get();
		//Загружаем офферы
		$offers_query = $this->db->select('offers.name, goals.price')
			->from('offers')
			->where('offers.type', '1')
			->where('offers.private', '0')
			->join('goals', 'goals.offer_id=offers.id', 'left')
			->order_by('added', 'desc')
			->limit(5)
			->get();
		
		$to_index = array(
			"news" => $news_query->result()
			, "offers" => $offers_query->result()
		);
		
		$this->load->view("landing2/index", $to_index);
		$this->load->view("landing2/foot");
	}
	else
	{
		redirect(base_url() . $this->user_model->type . "/");
	}
    }
    
    public function for_advertisers(){
	    $this->load->view("landing2/head", array("title" => "Для рекламодателей | Tusa.biz - cpa сеть", "type" => 1));
	    $this->load->view("landing2/index");
	    $this->load->view("landing2/foot");
    }
    
    public function changeCollapsed(){
	    if($this->input->post("isCollapsed") == "true")
		$this->session->set_userdata("isCollapsed", $this->input->post("isCollapsed"));
	    else
		$this->session->unset_userdata('isCollapsed');
    }
    
}