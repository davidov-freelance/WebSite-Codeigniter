<?php

class User_manipulation_model extends CI_Controller
{
	function ban($id, $text, $who = 'system') {
		$query = $this->db->get_where('users', array('id' => $id, 'status' => '1'));

		if($query->num_rows() == 0 || ($who != 'system' && $who != 'admin')) {
			return FALSE;
		}
		else {
			$this->db->where('id', $id);
			$this->db->update('users', array('status' => '0'));

			$data = array(
				'id_user' => $id,
				'puttime' => date("Y-m-d G:i:s"),
				'who' => $who,
				'text' => $text,
				'type' => 'ban'
				);

			$this->db->insert('ban_reason', $data);

			return TRUE;
		}
	}

	function unban($id, $text, $who = 'system') {
		$query = $this->db->get_where('users', array('id' => $id, 'status' => '0'));

		if($query->num_rows() == 0 || ($who != 'system' && $who != 'admin')) {
			return FALSE;
		}
		else {
			$this->db->where('id', $id);
			$this->db->update('users', array('status' => '1'));

			$data = array(
				'id_user' => $id,
				'puttime' => date("Y-m-d G:i:s"),
				'who' => $who,
				'text' => $text,
				'type' => 'unban'
				);

			$this->db->insert('ban_reason', $data);

			return TRUE;
		}
	}
}

?>