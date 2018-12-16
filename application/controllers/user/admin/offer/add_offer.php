<?php

class Add_Offer extends CI_Controller{

    public function __construct(){

        parent::__construct();
        $this->load->model("offer/add_model", "addOffer");
        $this->load->model("offer/info_model", "offer_info");
        $this->load->model("country_model", "country_model");
        $this->load->model("utm_model", "utm_model");
        $this->load->library("form_validation");
        require APPPATH . '/controllers/news/news.php';
        $this->data = array(
            "newsCount" =>  News::newsCount(),
            "news"      =>  News::LastNews(),
            "lastGoal"  =>  $this->offer_info->getLastGoal(),
        );
        $this->data['countries'] = $this->country_model->getCountries();
        $this->data['utm_groups'] = $this->utm_model->getGroups(); 
    }


    public function index(){

        $this->data['title'] = 'Добавление';
        $this->data['users'] = $this->db->get_where('users', array('type' => '1')); // get advertisers

        $config = array(
            array('field'   => 'name', 'rules'   => 'required'),
        );

        $this->form_validation->set_rules($config);
        $this->data['users2'] = $this->db->get_where('users', array('type' => '0')); // get webmasters

        if ($this->form_validation->run() == FALSE)
        {
            $this->data['content'] = $this->load->view("pages/user/admin/offer/add", $this->data, true);
        }
        else
        {
            $this->addOffer->add($this->input->post());
        }


        $this->load->view("layouts/main", $this->data);
    }


    public function edit($id){
        // head
        $this->data['title'] = 'Редактирование рекламного предложения';

        $this->data['main'] = $this->db->get_where('offers', array('id' => $id))->row();
        $this->data['main']->age = explode( ",", str_replace( array('[', ']' ), '', $this->data['main']->age ) );
//        $this->data['pages'] = $this->db->get_where('pages', array('offer_id' => $id))->result();
        $this->data['pages'] = $this->db->select('pages.*,utm_groups.title')
                                        ->from('pages')
                                        ->where(array('pages.offer_id' => $id))
                                        ->join('utm_groups', 'pages.utm_group_id = utm_groups.id', 'left')
                                        ->get()->result();
        $this->data['offers_cities'] = $this->db->get_where('offers_cities', array('offer_id' => $id));
        $this->data['gaskets'] = $this->db->get_where('gaskets', array('offer_id' => $id))->result();


        $query = $this->db->get_where('goals', array('offer_id' => $id)); // get goals
        $goals = $query->result();
        $goals_ids = array();

        foreach( $goals as $goal ){
            $goals_ids[] = $goal->id;
        }
        $this->data['goals'] = $goals;

        if( count( $goals_ids ) ){
            $this->db->select('geo_goals.*, countries.country_name, cities.name as city_name, goals.name as goal_name')->from('geo_goals');
            $this->db->where_in("geo_goals.goal_id", $goals_ids );
            $this->db->join('goals', 'goals.id = geo_goals.goal_id', 'left');
        } else {
            $this->db->select('geo_goals.*, countries.country_name, cities.name')->from('geo_goals');
        }



        $this->db->join('countries', 'countries.country_id = geo_goals.country_id', 'left');
        $this->data['geo_goals'] = $this->db->join('cities', 'geo_goals.city_id = cities.id', 'left')->get()->result();



        $this->data['users'] = $this->db->get_where('users', array('type' => '1')); // get advertisers
        $this->data['users2'] = $this->db->get_where('users', array('type' => '0')); // get webmasters

        $this->data['offers_private'] = $private_users = array_column( $this->db->select('user_id')->get_where('offers_private', array('offer_id' => $id))->result_array(), 'user_id');

        $this->data['content'] = $this->load->view("pages/user/admin/offer/edit", $this->data, true);
        $this->load->view("layouts/main", $this->data);
    }


    public function edit_true(){

        $id = $this->input->post('id');
        $offer_info = $this->db->get_where('offers', array('id' => $id))->row();
        $this->load->model("offer/add_model", "addOffer");

        if( count( $this->input->post("traffics") ) ){
            $traffics = implode(", ", $this->input->post("traffics"));
        }
        $data = array(
            'name'      =>  $this->input->post("name"),
            'id_in_crm'     =>  intval($this->input->post("id_in_crm")),
            'user_id'   =>  intval($this->input->post("user_id")),
            'places'    =>  $traffics,
            'small_descr'   =>  $this->input->post("text"),
            'cat'       =>  $this->input->post("cat"),
            'postclick' =>  $this->input->post("postclick"),
            'sex'       =>  $this->input->post("sex"),
            'age'       =>  '[' .  $this->input->post('ageMin').", ". $this->input->post('ageMax') . ']',

        );

        if (!empty($_FILES['logo']['name'])) {
            $data['image'] = $this->addOffer->uploadImage_for_edit($id);
        } else {
            $imageFileName = $this->db->get_where('offers', array('id' => $id))->row('image');
            $imageFileName = '';
        }




        $offers_private = $this->input->post("offers_private");

        /* работа с приватностью оффера
        *
        * оффер был приватным
        * убрали всех пользователей, поэтому делаем оффер доступным
        */
        if( !is_array($offers_private)){
            $this->db->delete('offers_private', array('offer_id' => $id));
            $data['private'] = '0';

            $this->db->where('offer_id', $id);
            $this->db->update('flows', ['status'=>'active'] );
        } elseif( count($offers_private) ){
            $data['private'] = '1';
            $this->addOffer->private_offer( $id, $offers_private );

        }


        $this->db->where('id', $id);
        $this->db->update('offers', $data);


        $goals = $this->input->post('goals');
        $goals_ids = $this->addOffer->addGoals( $goals, $id );


        // связки
        $this->addOffer->addBunches($this->input->post('bunches'), $goals_ids, $id);


        // страницы
        $pages = $this->input->post('pages');
        $this->addOffer->addPages($pages, $id);

        // прокладки
        $gaskets = $this->input->post('gaskets');
        $this->addOffer->addGaskets($gaskets, $id);

        // обновление потока
        //$this->db->where('offer_id', $id);
        //$this->db->update('flows', array('active' => 0));

        redirect(base_url() . "admin/offer/edit/".$id.'?msg=success');

        //$this->output->enable_profiler(TRUE); // профайлер
    }

    public function delete($id) {
        $id = intval($id);
        $this->db->delete('offers', array('id' => $id));
        $this->db->delete('offers_cities', array('offer_id' => $id));
        $this->db->delete('pages', array('offer_id' => $id));
        $this->db->delete('goals', array('offer_id' => $id));
        $this->db->delete('gaskets', array('offer_id' => $id));

        // update flows
        $this->db->update('flows',['status'=>'stop'], 'offer_id = ' . $id);

        redirect(base_url() . 'admin/offer/list');
    }

    public function bunch_status($offer_id, $bunch_id, $status){
        $this->flow_status($offer_id, $bunch_id, $status);

        $this->db->update('geo_goals', array('status' => $status), 'id = ' . $bunch_id );
        return '';
    }
    
    public function flow_status($offer_id, $bunch_id, $status){
        $bunch = $this->db->select('country_id, city_id')
                          ->from('geo_goals')
                          ->where('id', $bunch_id)->get()->row();

        $this->db->where('offer_id', $offer_id)
                 ->where('country_id', $bunch->country_id)
                 ->where('city_id', $bunch->city_id)
                 ->update('flows', ['status'=> $status ? 'active' : 'stop'] );
    }   
    public function delete_geo_goal($id, $offer_id) {
        $id = intval($id);

        $this->flow_status($offer_id, $id, 0);

        $this->db->delete('geo_goals', array('id' => $id));
        redirect(base_url() . 'admin/offer/edit/' . $offer_id);
    }

    public function edit_geo_goal() {

        $out      = '';
        $id       = intval($this->input->post('id'));
        $offer_id = intval($this->input->post('offer_id'));

        $geo_data      = array();        
        $geo_data['goal_id']    = (int)$this->input->post('goal_id');
        $geo_data['country_id'] = (int)$this->input->post('country_id');
        $geo_data['city_id']    = (int)$this->input->post('city_id');
        $geo_data['price']      = (int)$this->input->post('price');
        $geo_data['real_price'] = (int)$this->input->post('real_price');
        $geo_data['lid_count']  = (int)$this->input->post('lid_count');
        $geo_data['status']     = (int)$this->input->post('status');
        $r = $this->db->get_where('geo_goals', array('country_id'=>$geo_data['country_id'],
                                                     'city_id'=>$geo_data['city_id'],
                                                     'goal_id'=>$geo_data['goal_id']))->row();
        if ($id == 0) {
            if ($r) {
                show_404();
            } else {
                $this->db->insert('geo_goals', $geo_data);
                $id = $this->db->insert_id();

                $this->db->where('offer_id', $offer_id)
                         ->where('country_id', $geo_data['country_id'])
                         ->where('city_id', $geo_data['city_id'])
                         ->update('flows', ['status'=>'active']);
            }
        } else {
            if (!$r || $r->id == $id) {
                $bunch = $this->db->get_where('geo_goals', array('id'=>$id))->row();
                if ($bunch->country_id != $geo_data['country_id'] || $bunch->city_id != $geo_data['city_id']) {
                    $this->db->where('offer_id', $offer_id)
                             ->where('country_id', $bunch->country_id)
                             ->where('city_id', $bunch->city_id)
                             ->update('flows', ['status'=>'stop']);
                             
                    $this->db->where('offer_id', $offer_id)
                             ->where('country_id', $geo_data['country_id'])
                             ->where('city_id', $geo_data['city_id'])
                             ->update('flows', ['status'=>'active']);
                }
                $this->db->update('geo_goals', $geo_data,'id = ' . $id);
            } else {
                show_404();
            }
        }

        echo $id;
    }

    public function edit_page() {

        $upd = array();
        $out = '';
        $id = intval($this->input->post('id'));
        if ($id > 0) {

            $name = trim($this->input->post('name'));
            if(!empty($name)) {
                $upd['name'] = $name;
                $out = $upd['name'];
            }

            $url = trim($this->input->post('url'));
            if(!empty($url)) {
                $upd['url'] = $url;
                $out = $upd['url'];
            }

            $this->db->update('pages', $upd,'id = ' . $id);
        }

        echo $out;
    }

    public function delete_page($id, $offer_id = 0) {
        $id = intval($id);
        $this->db->delete('pages', array('id' => $id));

        redirect(base_url() . 'admin/offer/edit/' . $offer_id);
    }


    public function edit_gasket() {

        $upd = array();
        $out = '';
        $id = intval($this->input->post('id'));
        if ($id > 0) {

            $name = trim($this->input->post('name'));
            if(!empty($name)) {
                $upd['name'] = $name;
                $out = $upd['name'];
            }

            $url = trim($this->input->post('url'));
            if(!empty($url)) {
                $upd['url'] = $url;
                $out = $upd['url'];
            }

            $this->db->update('gaskets', $upd,'id = ' . $id);
        }

        echo $out;
    }

    public function delete_gasket($id, $offer_id = 0) {
        $id = intval($id);
        $this->db->delete('gaskets', array('id' => $id));

        redirect(base_url() . 'admin/offer/edit/' . $offer_id);
    }



    public function goals_list( $id ){
        $this->load->model("offer/add_model", "addOffer");
        echo json_encode( $this->addOffer->goalsList( $id ) );

        exit();
    }

    public function edit_goal() {

        $upd = array();
        $out = '';
        $id = intval($this->input->post('id'));
        if ($id > 0) {

            $name = trim($this->input->post('name'));
            if(!empty($name)) {
                $upd['name'] = $name;
                $out = $upd['name'];
            }

            $price = trim($this->input->post('price'));
            if(!empty($price)) {
                $upd['price'] = $price;
                $out = $upd['price'];
            }

            $real_price = trim($this->input->post('real_price'));
            if(!empty($real_price)) {
                $upd['real_price'] = $real_price;
                $out = $upd['real_price'];
            }

            $this->db->update('goals', $upd,'id = ' . $id);
        }

        echo $out;
    }

    public function delete_goal($id, $offer_id = 0) {
        $id = intval($id);
        $this->db->delete('goals', array('id' => $id));
        $this->db->delete('ind_payments', array('goal_id' => $id));
        redirect(base_url() . 'admin/offer/edit/' . $offer_id);
    }




}
