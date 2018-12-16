<?php

class View_admin extends CI_Controller
{
	function index($id = 0) {

		$this->security_model->checkInt($id);
		$this->load->helper("str_helper");

		$query = $this->db->get_where('users', array('id' => $id));
		$user = $query->row();

		$data = array(
			'title' => $user->name
			);

		$this->load->view("template/user/".$this->user_model->type."/head", $data);

		$user = array('user' => $user);
		$this->load->view("pages/user/".$this->user_model->type."/user/view_user_admin", $user);

		$this->load->view("template/user/".$this->user_model->type."/foot");

	}
}

?>