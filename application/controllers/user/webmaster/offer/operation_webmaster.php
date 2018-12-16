<?php

class Operation_Webmaster extends CI_Controller{

	public function __construct(){
		parent::__construct();

		$this->load->model("offer/info_model", "offer_model");
	}

	public function add($id = 0){
		checkInt($id);

		$this->db->select(""
			. "offers.* ")
			->from("offers");
			
		if(!$this->user_model->isAdmin()) {
			$this->db->where("offers.type", "1");
		}
			
		$this->db->where("offers.private = '0' OR (offers.private = '1' AND (SELECT COUNT(*) FROM offers_private WHERE user_id=".$this->db->escape($this->user_model->info->id)." AND offer_id='".$id."') >=1 )");
			
		
		$query = $this->db->get();
		if($query->num_rows == 0)
		{
			show_404();
			return;
		}
		$this->offer_model->addNewOfferToMe($id);
		redirect(base_url() . "offer/view/id/" . $id);
	}
	
	public function delete($id = 0){
		checkInt($id);
		if($this->db->get_where("offers", array("id"=>$id))->num_rows() == 0)
		{
			show_404();
			return;
		}
		$this->offer_model->removeOfferToMe($id);
		redirect(base_url() . "offer/list");
	}
	
}