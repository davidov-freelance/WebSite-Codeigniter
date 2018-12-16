<?php

class Promo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
     //   $this->load->model("user/webmaster/promo_model", "promo_model");

        $this->load->helper("date");
        $this->load->library("form_validation");
        require APPPATH . '/controllers/news/news.php';

        $this->data = array(
            "newsCount" => News::newsCount(),
            "news" => News::LastNews(),
        );
    }


    public function index(){
        $info = [];
        $this->data['title'] = 'Промо материалы';
        $this->data['content'] = $this->load->view("pages/user/webmaster/promo/index", $info, true);
        $this->load->view("layouts/main", $this->data);
    }

    public function landing(){
        $where = "user_id='{$this->user_model->info->id}' AND (status='active' OR status='active_private')";
        $info = [];
        $this->data['title'] = 'Генерация лэндинга';
        $info['landings'] = $this->db->get("promo_landing")->result();
        $info['my_promos'] = $this->db->get_where("my_promo", ['user_id'=>$this->user_model->info->id])->result();
        $info['terms'] = $this->db->get("utm_groups")->result();
        $info['flows'] = $this->db->where($where, NULL, FALSE)->get("flows")->result();
        $this->data['content'] = $this->load->view("pages/user/webmaster/promo/landing", $info, true);
        $this->load->view("layouts/main", $this->data);
    }


    public function download($id){

        $this->load->model("promo_model", "promo_model");

        $landing = $this->db->get_where("my_promo", ['id'=>(int)$id, 'user_id'=>$this->user_model->info->id])->row();
        if( !isset( $landing->id ) ){
            show_404();
        } else{

            $file_name = $landing->file_name.".zip";
            if( $landing->time > (time()-1800 )  AND file_exists( $this->promo_model->download_dir.$file_name )){
                header("Content-Type: application/zip");
                header("Content-Disposition: attachment; filename=$file_name");
                header("Content-Length: " . filesize($this->promo_model->download_dir.$file_name));

                @readfile($this->promo_model->download_dir.$file_name);




            } else{
                show_404();
            }
        }

    }

    public function save_promo(){

        $this->load->model("promo_model", "promo_model");
        $this->load->model("user/webmaster/flow_model", "flow_model");
        $this->form_validation->set_rules('landing_variant', 'landing_variant', 'trim|required|integer');
        $this->form_validation->set_rules('flow_id', 'flow_id', 'trim|required|integer');
        $this->form_validation->set_rules('promo_name', 'promo_name', 'trim|required');
        $file_name = md5( time() );


        if ($this->form_validation->run() != FALSE){
            $flow = $this->db->select("url")->from("flows")->where("id", (int)$this->input->post("flow_id"))->get()->row();
            $promo_landing = $this->db->get_where("promo_landing", ['id'=>$this->input->post("landing_variant")])->row();
            if( count( $promo_landing ) AND $promo_landing->alias ) {

                $data = array(
                    'flow_id' => (int)$this->input->post("flow_id"),
                    'promo_name' => checkStr($this->input->post("promo_name")),
                    'user_id' => $this->user_model->info->id,
                    'promo_id' => (int)$this->input->post("landing_variant"),
                    'promo_type' => 'landing',
                    'time'      => time(),
                    'file_name' => $file_name
                );


                $landing_data = [
                    'flow_id'       => $data['flow_id'],
                    'flow_key'       => $flow->url,
                    'file_name'     => $file_name,
                    'term_group'    => (int)$this->input->post("term_group"),
                    'api_key'       => $this->user_model->info->api_key,
                    'goal_id'       => $this->flow_model->get_flow_goal( $this->input->post("flow_id") ),
                    'alias'         => $promo_landing->alias,
                ];

                $this->db->insert('my_promo', $data);
                $this->promo_model->archive_landing($landing_data);

                echo $this->db->insert_id();
            }
        }
        exit();
    }



}