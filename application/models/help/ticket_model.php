<?php
class Ticket_model extends CI_Model
{
	function create_ticket($ticket_data) {
		$this->db->insert('ticket', $ticket_data);
		return $this->db->insert_id();
	}

	function add_message($message_data) {
		$this->db->insert('ticket_message', $message_data);
	}


	public function getTicket( $id ){
		return $this->db->select("t.*, u.email")
			->from("ticket t")
			->join("users u", "t.user_id=u.id", "left")
			->where("t.id", $id)
			->get();
	}

	public function getTickets_count( ){
		$count['open'] = $this->db->get_where("ticket", ['status'=>'0', 'user_id'=>$this->user_model->info->id])->num_rows();
		$count['close'] = $this->db->get_where("ticket", ['status'=>'1', 'user_id'=>$this->user_model->info->id])->num_rows();
		return $count;
	}


	public function getTicketMessages( $id ){
		$this->db->where("ticket_id", $id)
			->from("ticket_message tm")
			->order_by("time", "ASC");
		return $this->db->get()->result();
	}

	public function unreadToread($id){
		$this->db->where("ticket_id", $id)->update("ticket_message", array("read" => "true"));
	}

	public function getTickets( $status, $type ){


		$this->db->select('t.id, t.title, t.date, u.email, u.login, (SELECT COUNT(*) FROM ticket_message tm WHERE tm.ticket_id=t.id) AS message_num')
			->from("ticket t")
			->join("users u", "u.id=t.user_id", "left")
			->where("t.status", $status);
		if($type == 0)
			$this->db->where("t.user_id", $this->user_model->info->id);
		$this->db->order_by("date", "DESC");
		$query = $this->db->get();

		return $query->result();
	}


}