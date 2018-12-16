<?php

class utm_model extends CI_Model {


    function __construct() {
        parent::__construct();
    }


    public function getTitle( $title, $group_id ){
        $title = $this->db->select("*")
            ->from("utm")
            ->where("keyValue", $title)
            ->where("group_id", $group_id)->get()->row();
        return (isset( $title->title ) )?$title->title:'';
    }

    public function getTitleByPageId( $page_id ){
        $title = $this->db->select("title")
                          ->from("utm_groups")
                          ->join('pages', 'pages.utm_group_id = utm_groups.id', 'left')
                          ->where("pages.id", (int)$page_id)->get()->row();
        return (isset( $title->title ) )?$title->title:'';
    }

    public function getDefaultTitle( $id ){
        $title = $this->db->select("title")
            ->from("utm_groups")
            ->where("id", (int)$id)->get()->row();
        return (isset( $title->title ) )?$title->title:'';
    }



    public function getUtms(){


        $result	= $this->db->order_by("utm.id", "DESC")->get('utm')->result();
        return $result;
    }

    public function getGroups(){


        $result	= $this->db->order_by("id", "DESC")->get('utm_groups')->result();
        return $result;
    }



    function add_utm( $data )
    {

        if( $data['action'] == "edit" ){
            unset($data['action']);
            $this->db->where("id", $data['id'])->update("utm", $data);
        }else{
            unset($data['action']);
            $this->db->insert('utm', $data);
        }




    }


}
