<?php

class Cooperators_admin extends CI_Controller {
	
	private $data;
	
	public function index(){
		$this->data["title"] = "Сотрудники Call-Центра";
		$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
		$info = array(
		    "result" => $this->db->get("cooperators")
		);
		$this->load->view("pages/user/admin/cooperators/cooperators", $info);
		$this->load->view("template/user/".$this->user_model->type."/foot");
	}
	
	public function add(){
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('name', 'Фио', 'trim|required');
		$this->form_validation->set_rules('phone', 'Телефон', 'trim|required');
		$this->form_validation->set_rules('email', 'Емайл', 'trim|required|valid_email');

		if ($this->form_validation->run() == FALSE)
		{	
			$this->data["title"] = "Добавление нового сотрудника";
			$this->load->view("template/user/".$this->user_model->type."/head", $this->data);
			$info = array(
			    "offers"	=>	$this->db->get("offers")->result()
			);		
			$this->load->view("pages/user/admin/cooperators/add", $info);
			$this->load->view("template/user/".$this->user_model->type."/foot");
		}
		else
		{
			$this->load->helper('string');
			$data = array(
			    "name"	=>	checkStr($this->input->post("name")),
			    "email"	=>	checkStr($this->input->post("email")),
			    "phone"	=>	checkStr($this->input->post("phone")),
			    "password"	=>	random_string('alnum', 10),
			    "offers"	=>	implode(", ", $this->input->post("offer_id"))
			);
			$this->db->insert("cooperators", $data);
			redirect(base_url() . "admin/user/cooperators");
		}
	}
	
	public function remove($id = 0){
		checkInt($id);
		$this->db->where("id", $id)->delete("cooperators");
		redirect(base_url() . "admin/user/cooperators");
	}
	
}
