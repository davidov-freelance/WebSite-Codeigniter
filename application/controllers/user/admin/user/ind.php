<?php

class Ind extends CI_Controller{
	
	public function index(){
		
		$data = array(
		    'title'	=> 'Индивидуальные выплаты вебмастерам'
		);

		$this->load->view('template/user/admin/head', $data);

		// add new
		$new = $this->input->post('new');
		if (!empty($new)) {
			$new['goal_id'] = intval($new['goal_id']);
			$new['user_id'] = intval($new['user_id']);

			if ($new['user_id'] > 0 && $new['goal_id'] > 0) {
				$this->db->delete('ind_payments', 'goal_id = ' . $new['goal_id'] . ' AND user_id = ' . $new['user_id']);
				$this->db->insert('ind_payments', $new);
			}
		}
		

		$info = array();

		$info['webmasters'] = $this->db->get_where('users', array('type' => '0'))->result();
		$info['offers'] = $this->db->get('offers')->result();

		$this->db->select('ind_payments.*, 
				goals.name AS goal_name, 
				goals.price AS old_price, 
				offers.name AS offer_name, 
				users.email AS user')
			
			->from('ind_payments, goals, offers, users')

			->where('ind_payments.goal_id = goals.id')
			->where('goals.offer_id = offers.id')
			->where('ind_payments.user_id = users.id');
			//->order_by('', 'DESC');

		$query = $this->db->get();
		$info['rows'] = $query->result();
		
		$this->load->view('pages/user/admin/user/ind', $info);
		$this->load->view('template/user/admin/foot');
	}


	public function goals($offer_id = 0) {
		$goals = $this->db->get_where('goals', array('offer_id' => $offer_id))->result();

		$response = '';
		if (!empty($goals)) {
			foreach ($goals as $g) {
				$response .= '<option value="' . $g->id . '">' . $g->name . '</option>';
			}
		} else {
			$response .= '<option value="0">-</option>';
		}

		echo $response;
	}


	public function delete($id = 0) {
		$this->db->delete('ind_payments', 'id = ' . intval($id));
		redirect(base_url() . 'admin/ind');
	}
	
	
	
}