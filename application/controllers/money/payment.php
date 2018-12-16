<?php
	
class Payment extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->helper("date");
		$this->load->model("money/payment_model", "payment_model");
		$this->load->model("money_model");
		require APPPATH . '/controllers/news/news.php';
	}


	function index() {
		$data['newsCount'] = News::newsCount();
		$data['news'] = News::LastNews();

		$data['title'] = 'Выплаты';

		if( !$this->user_model->isAdmin() ){
			$user_id = $this->user_model->info->id;
		} else {
			$user_id = '';
		}

		$info["result"]	= $this->payment_model->getPaymentsList($user_id)->result();
		$data['content'] = $this->load->view("/pages/money/payment_list", $info, true);
		$this->load->view("layouts/main", $data);
	}

	public function orderPayment(){

		$sum = checkStr($this->input->post("sum"));
		$type = checkStr($this->input->post("payment_type"));
		$bill = checkStr($this->user_model->info->wmr);
		if(
			!$sum
			|| $sum < config_item("min_payment")
			|| $this->user_model->info->money < $sum
		){

			redirect(base_url() . "money/payment");
		}
		else
		{
			$this->load->model("money_model");			
			$this->payment_model->newPayment(array(
				"user_id"	=> $this->user_model->info->id,
				"payment_type"	=> $type,
				"bill"		=> $bill,
				"sum"		=> $sum
			));
			$this->money_model->minusFromBalance($sum, $this->user_model->info->id);
			redirect(base_url() . "money/payment");
		}
	}




	public function ok($id = 0){

		checkInt($id);
		$query = $this->db->select("payments.*")->from("payments")->where("payments.id", $id)->get();

		if($query->num_rows() == 0 || $query->row()->paid == '1')
			show_404();

		$this->db->where("id", $id);
		$this->db->update("payments", array("paid" => '1'));
		redirect(base_url() . "money/payment");
		//}
	}


}
?>