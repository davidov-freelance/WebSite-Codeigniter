<?php

class Home extends CI_Controller
{
	function index() {

		$data = array(
			'title' => 'Админка'
			);
		$data['content'] = $this->load->view("pages/user/admin/home", $data, true);
		$this->load->view("template/main.php", $data);

	}
}

?>