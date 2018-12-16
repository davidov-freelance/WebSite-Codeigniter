<?php

class Helper extends CI_Controller {

    public $icons = ['bullhorn', 'bolt', 'book', 'bell', 'life-ring'];
    public $icons_label = ['default', 'info', 'success', 'danger'];

    public function __construct() {
        parent::__construct();
        $this->load->model("helper_model");
        $this->load->library('form_validation');
        $this->load->helper("date");
        require APPPATH . '/controllers/news/news.php';

        $this->data['newsCount'] = News::newsCount();
        $this->data['news'] = News::LastNews();

    }

    public function index(){
        $this->data["title"] = "Информация и инструменты";
        $info['result'] = $this->helper_model->getHelpers();

        $this->data['content'] = $this->load->view("pages/user/admin/helper/list", $info, true );
        $this->load->view("layouts/main", $this->data );
    }

    public function add_helper( $action = "add", $id = 0 ){
        if( $this->user_model->info->type != 3 ) return false;

        if( $action == "edit" ) {
            $this->data['title'] = "Редактирование";
            $this->data['result'] = $this->db->from("helper")->where(array('id'=>$id))->get()->row();
        } else{
            $this->data['title'] = "Добавление";
            $this->data['result'] = array();
        }
        $this->form_validation->set_rules('title', 'Заголовок', 'trim|required|htmlspecialchars');
        $this->form_validation->set_rules('link', 'Ссылка', 'trim|required|htmlspecialchars');

        if ($this->form_validation->run() != FALSE)
        {
            $data = [
                'id'        =>  $id,
                'link' 	    => checkStr($this->input->post('link')),
                'title'	   	=> checkStr($this->input->post('title')),
                'icon'	   	=> checkStr($this->input->post('icon')),
                'label'=>  checkStr($this->input->post('label')),
                'action'    => $action

            ];


            $this->helper_model->add_helper( $data );
            redirect(base_url()."admin/helper");
        }

        $this->data['icons'] = $this->icons;
        $this->data['icons_label'] = $this->icons_label;
        $this->data['content'] = $this->load->view("pages/user/admin/helper/edit", $this->data, true );
        $this->load->view("layouts/main", $this->data );

    }


    public function delete($id)
    {
        if(!$this->user_model->isAdmin()) {
            show_404();
            return;
        }
        $this->db->delete("helper", array("id" => $id));
        redirect(base_url() . "/admin/helper" );
    }

}


