<?php

class Operations_admin extends CI_Controller{
	
	public function addMoney($user_id){

		checkInt($user_id);
		
		$this->load->library("form_validation");
		
		$data = array(
		    "title"	=>	"Пополнение баланса рекламодателя"
		);
		$this->load->view("template/user/admin/head", $data);

	
		$this->form_validation->set_rules("user_id", "User Id", "trim|required");
		$this->form_validation->set_rules("sum", "Сумма", "trim|required");

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view("pages/user/admin/user/add_money", array("user_id" => $user_id));
		}
		else
		{
			$this->load->model("money_model");
			$user_id = (int)$this->input->post("user_id");
			$query = $this->db->get_where("users", array("id" => $user_id));
			if($query->num_rows() == 0)
			{
				show_404();
				return;
				//ПОДОЗРИТЕЛЬНОЕ ДЕЙСТВИЕ
			}
			$sum = (int)$this->input->post("sum");
			$this->money_model->addMoneyToUser($sum, $user_id);
			redirect(base_url() . "admin/users/advertisers");
		}
		
		$this->load->view("template/user/admin/foot");
		
	}
	
	public function setblock($user_id = 0, $status = 1){
		$this->db->where("id", $user_id)->update("users", array("status" => $status));
		redirect(base_url() . "admin/users");
	}
	
}