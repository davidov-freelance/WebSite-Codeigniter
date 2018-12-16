<?php

class Add_model extends CI_Model{

    public function add($info = array()){
        //Определяем следующий ID в offers
        $next_id = $this->db->last_id("offers");
        //Загрузка изображения
        if (!empty($_FILES['logo']['name'])) {
            $imageFileName = $this->uploadImage($next_id);
        } else {
            $imageFileName = '';
        }
        $info_to_db = array(
            'name'      =>  $info['name'],
            'user_id'   =>  $info['user_id'],
            'id_in_crm' =>  $info['id_in_crm'],
            'image'     =>  $imageFileName,
            'places'    =>  implode(", ", $info["traffics"]),
            'small_descr'   =>  $info["text"],
            'cat'       =>  $info["cat"],
            'postclick' =>  $info["postclick"],
            'sex'       =>  $info["sex"],
            'age'       =>  '[' .  $info['ageMin'].", ". $info['ageMax'] . ']',
            'added'     =>  time()
        );

        // добавляем цели
        $goals_list = $this->addGoals($info["goals"], $next_id);

        // добавляем связки
        if( isset( $info["bunches"] ) )
            $this->addBunches($info["bunches"], $goals_list, $next_id);
        if( isset( $info["pages"] ) )
            $this->addPages($info["pages"], $next_id);

        if( isset( $info["gaskets"] ) )
            $this->addGaskets($info["gaskets"], $next_id);

        if( !isset( $info["offers_private"] ) OR !is_array($info["offers_private"])){
            $info_to_db['private'] = '0';
        } elseif( count($info["offers_private"]) ){
            $info_to_db['private'] = '1';
            $offers_private = $info["offers_private"];
        }

        $this->db->insert("offers", $info_to_db);
        if( isset( $offers_private ) )
        $this->addOffer->private_offer( $this->db->insert_id(), $offers_private );





        //Перенаправляем на страницу просмотра оффера
        redirect(base_url() . "offer/view/id/" . $next_id);
    }




    public function uploadImage($offer_id){
        $uploadDir = "files/images/offers/" . $offer_id . "/";
        if( !is_dir( $uploadDir ) )
            mkdir($uploadDir, 0777);

        $config = array (
            'upload_path'   => $uploadDir,
            'allowed_types' => 'gif|jpg|png',
            'encrypt_name'  => TRUE
        );

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('logo')) {
            $error = array('error' => $this->upload->display_errors());
            return '';
        } else {
            $data = array('upload_data' => $this->upload->data());
            $name_img = $data['upload_data']['file_name'];
            return $name_img;
        }
    }



    public function uploadImage_for_edit($offer_id){
        $uploadDir = "files/images/offers/" . $offer_id . "/";
        if( !is_dir( $uploadDir ) )
            mkdir($uploadDir, 0777);
        // очистка папки
        $this->load->helper("file"); // load the helper
        delete_files($uploadDir, true); // delete all files/folders

        $config = array (
            'upload_path'   => $uploadDir,
            'allowed_types' => 'gif|jpg|png',
            'encrypt_name'  => TRUE
        );

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('logo')) {
            $error = array('error' => $this->upload->display_errors());
            return '';
        } else {
            $data = array('upload_data' => $this->upload->data());
            $name_img = $data['upload_data']['file_name'];
            return $name_img;
        }
    }


    public function private_offer($id, $offers_private){


        // $offers_private - пользователи из формы

        // пользователи, которые уже были приватными
        $private_users = array_column($this->db->select('user_id')->get_where('offers_private', array('offer_id' => $id))->result_array(), 'user_id' );

        //Пользователи, которые уже успели добавить оффер к себе до того, как он стал приватным
        $my_offers = array_column( $this->db->select('user_id')->get_where('my_offers', array('offer_id' => $id))->result_array(), 'user_id');

        /* Новые пользователи, для которых оффер стал доступен
         * добавляем их в базу приватных офферов
         */
        $new_users = array_diff( $offers_private, $private_users );

        $this->changeStatusForUsers( $new_users, $id, "add", "private_offer" );

        /* Пользователи, для которых оффер закрылся, но раньше был доступен */
        $remove_users = array_diff( $private_users, $offers_private );
        $this->changeStatusForUsers( $remove_users, $id, "delete", "forbidden_offer_after_access" );

        /* Пользователи, которые успели добавить, но сейчас их в списке разрешенных нет */
        //$remove_my_offers = array_diff( $my_offers, $offers_private );
        //$this->changeStatusForUsers( $remove_my_offers, $id, "delete", "forbidden_offer" );


    }


    public function changeStatusForUsers( $user_list, $offer_id, $action, $email_alias = false ){

        $offer_link = base_url("offer/view/id/".$offer_id);
        $ticket_link = base_url("ticket/add");
        if( $email_alias ) {
            $this->load->model("email/email_model", "email_model");
            $this->load->model("email/email_message_model", "email_message_model");
            $email = $this->db->get_where('emails', array('alias' => $email_alias))->row();
        }
        $offer = $this->db->get_where('offers', array('id' => $offer_id))->row();
        foreach( $user_list as $user_id ){
            $user = $this->db->get_where('users', array('id' => $user_id))->row();
            $data = [
                'offer_id' => $offer_id,
                'user_id' =>$user_id
            ];

            if( $action == "add" ){
                $this->db->insert('offers_private', $data);

                $this->db->where('offer_id', $offer_id);
                $this->db->where('user_id', $user_id);
                $this->db->update('flows', ['status'=>'active_private'] );
            }
            if( $action == "delete" ){
                $this->db->delete('offers_private', $data );

                $this->db->where('offer_id', $offer_id);
                $this->db->where('user_id', $user_id);
                $this->db->update('flows', ['status'=>'forbidden'] );
            }

            if( $email_alias ) {
                $search = ['{offer_name}', '{offer_id}', '{name}', '{offer_link}', '{ticket_link}'];
                $replace = [$offer->name, $offer_id, $user->login, $offer_link, $ticket_link];
                $email_text = str_replace($search, $replace, $email->message);

                $this->email_model->setSubject($email->subject);

                $message = $this->email_message_model->getMessage($email->subject, $email_text);
                $this->email_model->setMessage($message);

                $this->email_model->setEmails([$user->email]);
                $this->email_model->send();
            }
        }

    }




    public function addPages($pages, $offer_id){
        if(count($pages['names']) > 0){
            foreach($pages['links'] AS $key=>$page_link){
                $findPage = $this->db->get_where('pages', array('id' => $pages['id'][$key]))->result();
                $sql = "INSERT INTO pages (name, url, type, offer_id) VALUES ";
                if (strpos($page_link, 'http://') === false) {
                    $page_link = 'http://' .$page_link;
                }

                if( isset( $findPage['0']->id ) ){
                    $pages_array[] = $findPage['0']->id;
                    $this->db->where('id', $findPage['0']->id);
                    $this->db->update('pages', array('name'=>$pages['names'][$key], 'url'=>$page_link) );

                } else{
                    ;
                    $sql .= "(".$this->db->escape($pages['names'][$key]).", ".$this->db->escape($page_link).", ".$pages['pageType'][$key].", '".$offer_id."')";
                    $this->db->query($sql);
                    $pages_array[] = $this->db->insert_id();
                }

            }


            if( count( $pages_array ) )
                $this->db->query( "DELETE FROM pages WHERE offer_id ='".$offer_id."' AND id NOT IN (".implode(",",$pages_array).")" );


        }
    }

    public function addGaskets($gaskets, $offer_id){

        if(count($gaskets['links']) > 0){
            $gaskets_array = array();
            foreach($gaskets['links'] AS $key=>$gasket_link){
                $findGasket = $this->db->get_where('gaskets', array('id' => $key))->result();
                if( isset( $findGasket['0']->id ) ){
                    $gaskets_array[] = $findGasket['0']->id;
                    $this->db->where('id', $findGasket['0']->id);
                    $this->db->update('gaskets', array('name'=>$gaskets['names'][$key], 'url'=>$gaskets['names'][$key]) );
                } else{
                    $sql = "INSERT INTO gaskets (name, url, offer_id) VALUES ";
                    $sql .= "(".$this->db->escape($gaskets['names'][$key]).", ".$this->db->escape($gasket_link).", '".$offer_id."')";
                    $this->db->query($sql);
                    $gaskets_array = $this->db->insert_id();
                }

            }

            if( count( $gaskets_array ) )
                $this->db->query( "DELETE FROM gaskets WHERE offer_id ='".$offer_id."' AND id NOT IN (".implode(",",$gaskets_array).")" );


        }

    }

    public function goalsList($offer_id){

        $this->db->where('offer_id', $offer_id);
        $data = $this->db->get("goals")->result('array');
        return $data;
    }




    public function addGoals( $goals, $offer_id){


        if(count($goals) > 0){

            $goals_array = array();

            foreach($goals AS $key=>$goal){

                $findGoal = $this->db->get_where('goals', array('id' => $key))->result();

                if( count($findGoal) ){
                    $this->db->where('id', $findGoal['0']->id);
                    $this->db->update('goals', array('name'=>$goal) );
                    $goals_array[$key] = $findGoal['0']->id;

                } else{
                    $sql = "INSERT INTO goals (name, offer_id) VALUES ";
                    $this->db->query($sql."('".$goal."', '".$offer_id."')" );
                    $goals_array[$key] = $this->db->insert_id();
                }

            }
            if( count( $goals_array ) )
            $this->db->query( "DELETE FROM goals WHERE offer_id ='".$offer_id."' AND id NOT IN (".implode(",",$goals_array).")" );
            return $goals_array;
        }

    }

    public function addBunches( $bunches, $goalsIDs, $offer_id){
        if(count($bunches['goal']) > 0){

            foreach($bunches['goal'] AS  $key => $bunch_goal) {
                $findBunch = $this->db->get_where('geo_goals', array('id' => $bunches['id'][$key]))->result();
                if( count( $findBunch ) ) {
                    $bunch_data = array( "goal_id"      =>      $goalsIDs[$bunches['goal'][$key]],
                                    "country_id"    =>      $bunches['country'][$key],
                                    "city_id"       =>      $bunches['city'][$key],
                                    "price"         =>      $bunches['price'][$key],
                                    "real_price"    =>      $bunches['real_price'][$key],
                                    "lid_count"     =>      $bunches['lid_count'][$key]
                        );
                    $this->db->where('id', $findBunch['0']->id);
                    $this->db->update('geo_goals', $bunch_data );
                    $bunch_ids[] = $findBunch['0']->id;
                    $bunch_goals[] = $goalsIDs[$bunches['goal'][$key]];

                } else {
                    $sql = "INSERT INTO geo_goals (goal_id, country_id, city_id, price, real_price, lid_count) VALUES ";
                    $sql .=  "(" . $goalsIDs[$bunches['goal'][$key]] . ", " . $bunches['country'][$key] . ", " . $bunches['city'][$key] . ", " . $bunches['price'][$key] . ",  " . $bunches['real_price'][$key] . ", " . $bunches['lid_count'][$key] . ")";
                    $this->db->query($sql);

                    $bunch_ids[] = $this->db->insert_id();
                    $bunch_goals[] = $goalsIDs[$bunches['goal'][$key]];
                }

            }



        }
    }


}

