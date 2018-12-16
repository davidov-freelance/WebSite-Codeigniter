<?php

class Ticket extends CI_Controller{
	
	public function __construct() {
		parent::__construct();
		$this->load->helper("date");
		$this->load->model('help/ticket_model');
	}

	public function view($id = 0) {
		checkInt($id);
		$query = $this->ticket_model->getTicket( $id );
		if($query->num_rows != 0) {
			$data['ticket'] = $query->row();
		} else{
			show_404();
			return false;
		}
		$data['result'] = $this->ticket_model->getTicketMessages( $id );
		$this->ticket_model->unreadToread( $id );

		echo $this->load->view("pages/help/view", $data, true);
		exit();
	}

	public function lists ($type = 'open', $id = 0) {
		$this->add();
		if($type == 'open')
		{
			$data['title'] = 'Открытые тикеты';
			$status = '0';
		}
		else
		{
			$data['title'] = 'Закрытые тикеты';
			$status = '1';
		}

		$data['ticket'] = $this->ticket_model->getTickets( $status, $this->user_model->info->type );
		$data['tickets_count'] = $this->ticket_model->getTickets_count();
		$data['type'] = $type;
		$data['user_id'] = $id;

		require APPPATH . '/controllers/news/news.php';
		$data["newsCount"] =	News::newsCount();
		$data["news"] =	News::LastNews();
		$data["action"] = "list";
		$data['content'] = $this->load->view("pages/help/list", $data, true);
		$this->load->view("layouts/main", $data);
	}

	function addComment(){
		if($this->input->post("message"))
		{
			$data = array(
			    "ticket_id" => checkStr($this->input->post("ticket_id")),
			    "text"	=> checkStr($this->input->post("message"))
			);
			$query = $this->db->get_where("ticket", array("id" => $data["ticket_id"]));
			if(!in_array($this->user_model->info->type, array("2", "3")))
				if( $query->num_rows() == 0 || $query->row()->user_id != $this->user_model->info->id || $query->row()->status == "1" )
				{
					show_404();
					return;
				}			
			if( in_array($this->user_model->info->type, array("2", "3")) )
			{
				$whoAnswer = 1;
				$data["author"] = '1';
			}
			else
				$whoAnswer = 0;
			
			$this->db->insert("ticket_message", $data);
			
			echo '
				<li class="comment'.($whoAnswer ? " timeline-inverted" : "").'">
				   <div class="timeline-badge '.($whoAnswer ? "danger" : "primary").'">
				      <em class="fa '.($whoAnswer ? "fa-group" : "fa-male").'"></em>
				   </div>
				   <div class="timeline-date">
				      <time datetime="'.normal_time(strtotime(date("Y-m-d H:i:s"))).'"></time>
				   </div>
				   <div class="timeline-panel">
				      <div class="popover '.($whoAnswer ? "right" : "left").'">
					 <div class="arrow"></div>
					 <h3 class="popover-title">'.($whoAnswer ? "Служба поддержки" : "Ваш ответ").'</h3>
					 <div class="popover-content">
					    <p>
							'.$data["text"].'
					    </p>
					 </div>
				      </div>
				   </div>
				</li>
			';
		}
		else
		{
			//ПОДОЗРИТЕЛЬНОЕ ДЕЙСТВИЕ
			show_404 ();
		}
	}
	
	public function add($id = 0) {

		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Тема', 'trim|required');
		$this->form_validation->set_rules('text', 'Вопрос', 'trim|required');
		if ($this->form_validation->run() != FALSE)
		{
			$this->load->model('help/ticket_model');

			$title = checkStr($this->input->post('title'));
			$text = checkStr($this->input->post('text'));

			$ticket_data = array(
				'title' => $title,
				'user_id' => $this->user_model->info->id
			);
			if($this->user_model->info->type >= 2)
				$ticket_data["user_id"] = (int)$this->input->post("user_id");

			$ticket_id = $this->ticket_model->create_ticket($ticket_data);

			$message_data = array(
				'ticket_id' => $ticket_id,
				'text' => $text,
				'author' => '0'
			);
			if($this->user_model->info->type >= 2)
				$message_data["author"] = '1';

			$this->ticket_model->add_message($message_data);

			redirect(base_url()."tickets/view/".$ticket_id);
		}

	}
	
	public function close($id = 0){
		checkInt($id);
		$query = $this->db->get_where("ticket", array("id" => $id));
		if($query->num_rows() == 0 || $query->row()->user_id != $this->user_model->info->id && !$this->user_model->isAdmin())
		{
			//ПОДОЗРИТЕЛЬНОЕ ДЕЙСТВИЕ
			show_404();
			return;
		}
		$this->db->where("id", $id)->update("ticket", array("status" => "1"));
		redirect(base_url() . "tickets/lists/close");
	}
	
}

?>