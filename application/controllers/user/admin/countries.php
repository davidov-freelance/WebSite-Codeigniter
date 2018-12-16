<?php

class Countries extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        require APPPATH . '/controllers/news/news.php';
        $this->load->model('country_model');
        $this->data = array(
            "newsCount"	=>	News::newsCount(),
            "news"		=>	News::LastNews(),
            "countries" => $this->country_model->getCountries(),
        );
        $this->load->library("form_validation");

    }

	
    public function index(){

        $this->form_validation->set_rules("country_id", "country", "trim");
        $this->form_validation->set_rules("name", "name", "required|trim");
        $this->form_validation->set_rules("eng_name", "eng_name", "required|trim");
        if ($this->form_validation->run() == FALSE)
	{
            $this->data['title'] = 'Страны и города';


            $info["result"] = $this->db->select('cities.*, countries.country_name')->from('cities')->join('countries', 'countries.country_id = cities.country_id')->get()->result();
            $info["countries"] = $this->db->get("countries")->result();

            $this->data['content'] = $this->load->view("pages/user/admin/countries", $info, true);
            $this->load->view("layouts/main", $this->data);
        }else{
            $data = array(
                "name"          =>  $this->input->post("name"),
                "name2"          =>  $this->input->post("name2"),
                "name3"          =>  $this->input->post("name3"),
                "eng_name"      =>  $this->input->post("eng_name"),
                "country_id"    =>  $this->input->post("country_id")
            );
            $this->db->insert("cities", $data);
            redirect(base_url() . "admin/countries");
        }
    }


    // редактирование города
    public function edit($id ){
        echo $this->country_model->edit_city( $id, $this->input->post() );
    }

    public function delete_city($id = 0){
        $this->db->where("id", $id)->delete("cities");
    }

    // возвращаем список городов для страны
    public function getCities(  ){
        echo json_encode($this->country_model->getCities($_POST['c_id']));
    }


    // синхронизация данных
    public function updateData(){
        $this->country_model->updateData();
    }



}
