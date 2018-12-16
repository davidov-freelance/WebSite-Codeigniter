<?php

class Take_moderation extends CI_Controller {

	function solve($id = 0) {
		$this->security_model->checkInt($id);

		$query = $this->db->get_where('offers', array('id' => $id));

		if($query->num_rows() == 0) {
			show_404();
		}
		else {
			$this->db->where('id', $id);
			$this->db->update('offers', array('type' => '1'));

			$offer = $query->row();
			if( $offer->private ){
				$private_offers = $this->db->get_where('offers_private', array('offer_id' => $id))->result();
				foreach( $private_offers as $p_o ){
					$this->db->update('flows', array('status' => 'active_private'), 'offer_id = ' . $p_o->offer_id.' AND `user_id`=' . $p_o->user_id);
				}

			} else{
				$this->db->update('flows', array('status' => 'active'), 'offer_id = ' . $id.' AND `status`=\'stop\'');
			}

			redirect(base_url()."offer/view/id/".$id);
		}
	}
	
	function stop($id = 0) {
		$this->security_model->checkInt($id);

		$query = $this->db->get_where('offers', array('id' => $id));

		if($query->num_rows() == 0) {
			show_404();
		}
		else {
			$this->db->where('id', $id);
			$this->db->update('offers', array('type' => '0'));
			$this->db->update('flows', array('status' => 'stop'), 'offer_id = ' . $id.' AND (`status`=\'active\' OR `status`=\'active_private\')');
			redirect(base_url()."offer/view/id/".$id);
		}
	}

	function forbid($id = 0) {
		$this->security_model->checkInt($id);

		$query = $this->db->get_where('offers', array('id' => $id));

		if($query->num_rows() == 0) {
			show_404();
		}
		else {
			$this->db->where('id', $id);
			$this->db->update('offers', array('type' => '-1'));

			$this->db->update('flows', array('status' => 'stop'), 'offer_id = ' . $id.' AND (`status`=\'active\' OR `status`=\'active_private\')');

			redirect(base_url()."offer/view/id/".$id);
		}
	}
}

?>