<?php

class helper_model extends CI_Model {


    function __construct() {
        parent::__construct();
    }




    public function getHelpers(){
        $result	= $this->db->order_by("helper.id", "DESC")->get('helper')->result();
        return $result;
    }



    function add_helper( $data )
    {

        if( $data['action'] == "edit" ){
            unset($data['action']);
            $this->db->where("id", $data['id'])->update("helper", $data);
        }else{
            unset($data['action']);

            $data['add_time'] = time();
            $this->db->insert('helper', $data);
        }




    }


}
