<?php

class Block extends CI_Controller{

    public function index(){

       if( $this->user_model->info->status == 1 )
            redirect("/panel");
        $this->load->view("pages/account/block" );
    }


}