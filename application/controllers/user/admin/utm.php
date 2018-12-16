<?php

class Utm extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("utm_model");
        $this->load->library('form_validation');
        $this->load->helper("date");
        require APPPATH . '/controllers/news/news.php';

        $this->data['newsCount'] = News::newsCount();
        $this->data['news'] = News::LastNews();

    }

    public function index(){
        $this->data["title"] = "UTM метки";
        $info['result'] = $this->utm_model->getUtms();
        $info['groups'] = $this->utm_model->getGroups();

        $this->data['content'] = $this->load->view("pages/user/admin/utm/list", $info, true );
        $this->load->view("layouts/main", $this->data );
    }


    public function groups(){

        $this->data["title"] = "Группы UTM меток";
        $info['result'] = $this->utm_model->getGroups();
        $this->data['content'] = $this->load->view("pages/user/admin/utm/groups", $info, true );
        $this->load->view("layouts/main", $this->data );
    }


    public function update_group(){
        $data = array('name' => checkStr($this->input->post('name')),'title' => checkStr($this->input->post('title')));
        if( $this->input->post('id') ){
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('utm_groups', $data);
        } else{
            $this->db->insert('utm_groups', $data);
            echo $this->db->insert_id();
        }
        exit();
    }

    public function add_utm( $action = "add", $id = 0 ){

        if( $this->user_model->info->type != 3 ) return false;

        if( $action == "edit" ) {
            $this->data['title'] = "Редактирование метки";
            $this->data['result'] = $this->db->from("utm")->where(array('id'=>$id))->get()->row();
        } else{
            $this->data['title'] = "Добавление метки";
            $this->data['result'] = array();
        }
        $this->data['groups'] = $this->utm_model->getGroups();
        $this->form_validation->set_rules('title', 'текст', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('keyValue', 'текст', 'trim|required|htmlspecialchars');

        if ($this->form_validation->run() != FALSE)
        {
            $data = [
                'keyValue' 	=> checkStr($this->input->post('keyValue')),
                'title'	   	=> checkStr($this->input->post('title')),
                'group_id'	   	=> intval($this->input->post('group_id')),
                'id'		=> (int)$id,
                'action'    =>  $action

            ];


            $this->utm_model->add_utm( $data );
            redirect(base_url()."admin/utm");
        }


        $this->data['content'] = $this->load->view("pages/user/admin/utm/edit", $this->data, true );
        $this->load->view("layouts/main", $this->data );

    }


    public function delete($id)
    {
        if(!$this->user_model->isAdmin()) {
            show_404();
            return;
        }
        $this->db->delete("utm", array("id" => $id));
        redirect(base_url() . "/admin/utm" );
    }

    public function delete_group($id){
        if(!$this->user_model->isAdmin()) {
            show_404();
            return;
        }
        $this->db->delete("utm_groups", array("id" => $id));
        $this->db->delete("utm", array("group_id" => $id));
        exit();
    }
}


