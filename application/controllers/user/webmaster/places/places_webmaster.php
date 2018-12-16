<?php

class Places_webmaster extends CI_Controller{

    public function __construct(){
        parent::__construct();
        require APPPATH . '/controllers/news/news.php';
        $this->data = array(
            "newsCount"	=>	News::newsCount(),
            "news"		=>	News::LastNews(),
        );
    }



    public function index(){
        $this->data["title"] = "Площадки";
        $info["result"] = $this->db->get_where("places", array("user_id" => $this->user_model->info->id))->result();

        $this->data['content'] = $this->load->view("pages/user/webmaster/places", $info, true);
        $this->load->view("layouts/main", $this->data);

    }
    
    public function edit($id = 0){
        $this->load->library("form_validation");
        
        $this->form_validation->set_rules("name", "Название", "trim|required");
        $this->form_validation->set_rules("type", "Источник трафика", "trim|required");
        
        if($this->form_validation->run() == FALSE)
        {
            return false;
        }
        else
        {
            $data = array(
                "name"  =>  $this->input->post("name"),
                "type"  =>  (int)$this->input->post("type")
            );

            if( !$id ){
                $data['user_id'] = $this->user_model->info->id;
                $this->db->insert("places", $data);
                echo  $this->db->insert_id();
            }
            else{
                $this->db->where(array( "id" => $id, "user_id" => $this->user_model->info->id))->update("places", $data);
            }
            return true;
        }
    }
    
    public function delete($id = 0){
        $this->db->where(array("id" => $id, "user_id" => $this->user_model->info->id))->delete("places");
        exit();
    }
    
}