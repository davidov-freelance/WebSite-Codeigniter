<?php

class News_model extends CI_Model {

	public function getViewData( $id ){
		return $this->db->from("news")->where(array('id'=>$id))->get()->row();
	}

	public function getNews(){

		$this->db->select('news.*, offers.name as offer_name');
		$this->db->join('offers', 'news.offer_id = offers.id', 'left');
		$this->db->order_by("news.added", "DESC");

		$result	= $this->db->get('news')->result();
		/* проеряем новости по статусу
		* 1 - показывать всем
		* 2 - тем, у кого добавлен оффер
		*/
		foreach( $result as $key => $news )
		{
			if( $news->show == 2  )
			{
				$where_array['offer_id'] = $news->offer_id;
				if(  $this->user_model->info->type != 3 )
					$where_array['user_id'] = $this->user_model->info->id;
				$find_offer = $this->db->from("my_offers")->where($where_array)->get()->row();
				if( !isset( $find_offer->id ) ) unset( $result[$key] );
			}
		}
		$this->db->where("id", $this->user_model->info->id)
			->update("users", array("view_news" => count($result)));

		return $result;
	}



	function add_new( $data,$params )
	{

		$offer_info = $this->db->select("*")->from("offers")->where("id", $data['offer_id'])->get()->row();
		$email_text = $data["text"];
		if($data['offer_id'] > 0)
		{			
			$email_text = str_replace("{offer_name}", "<a href='".base_url() . 'offer/view/id/' . $offer_info->id ."'>".$offer_info->name."</a>", $data["text"]);
			$data["text"] = str_replace("{offer_name}", $offer_info->name, $data["text"]);
		}
		$email_text = str_replace("(brbr)", "<br />", $email_text);
		$data["text"] = str_replace("(brbr)", "\r\n", $data["text"]);
		if( $data['show'] AND $params['action'] == "add" ){
			$data['added'] = time();
			$this->db->insert('news', $data);
		}

		if( $data['show'] AND $params['action'] == "edit" )
			$this->db->where("id", $data['id'])->update("news", $data);


		/*
		 * Email оповещение
		 */
		 
		if(config_item("email_news") && $params['alert']  )
		{
			$this->load->model("email/email_model", "email_model");
			$this->load->model("email/email_message_model", "email_message_model");
			
			$this->email_model->setSubject($data["name"]);
			$message = $this->email_message_model->getMessage($data["name"], $email_text);
			$this->email_model->setMessage($message);


			$emails = array();
			
			//Получаем список емайл, на которые нужно отправить сообщение
			if( $data["offer_id"] AND $params['alert'] == "2" )
			{
				
				//Тем, кто добавил этот оффер к себе
				$query = $this->db->select("user_id")->from("my_offers")->where("offer_id", $data["offer_id"] )->get();
				foreach($query->result() as $row)
				{
					$where_array = array( "id"=> $row->user_id, "notices_status" => "1", "type" => "0" );
					$this->db->where( $where_array );
					$email = $this->db->select("email")->from("users")->get()->row();
					if( count( $email ) ){
						$emails[] = $email->email;
					}
				}	
			}
			else
			{
				//Значит всем
				$where_array = array( "type" => "0", "notices_status" => "1" );
				$this->db->select("email")->from("users")->where($where_array);
				$query = $this->db->get();
				foreach($query->result() AS $row)
					$emails[] = $row->email;
			}
			$this->email_model->setEmails($emails);
			$this->email_model->send();
		}
	}
}
