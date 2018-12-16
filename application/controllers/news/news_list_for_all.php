<?php

class News_list_for_all extends CI_Controller {
	
	public function index(){
		$this->load->helper("date_helper");
		
		$data = array(
		    "title" => "Список новостей"
		);
		$this->load->view("template/user/".$this->user_model->type."/head", $data);
		
		$info = array(
		    "result"	=>	$this->db->from("news")->order_by("added", "DESC")->get()->result()
		);
		
		/* проеряем новости по статусу
		* 1 - показывать всем
		* 2 - тем, у кого добавлен оффер
		*/
		foreach( $info['result'] as $key => $news )
		{
			if( $news->show == 2 )
			{
				echo $this->user_model->info->id;
				$where_array = array( 'offer_id' => $news->offer_id, 'user_id' => $this->user_model->info->id );
				$find_offer = $this->db->from("my_offers")->where($where_array)->get()->row();
				if( !isset( $find_offer->id ) ) unset( $info['result'][$key] );
			}
		}
		$this->db->where("id", $this->user_model->info->id)
			->update("users", array("view_news" => count($info["result"])));
		
		$this->load->view("pages/news/list", $info);
		
		$this->load->view("template/user/".$this->user_model->type."/foot");
	}
	
	public function edit()
	{
		//
	}
	
}


