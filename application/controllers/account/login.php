<?php

class Login extends CI_Controller{
    
    public function index(){
        $this->load->model("login_model", "login");
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Пароль', 'trim|required');        

        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view("pages/account/login" );
        }
        else
        {
            if( $this->login->goLogin( checkStr($this->input->post("email")), checkStr($this->input->post("password")) ) )
			    redirect("/panel");
            else
			    $this->load->view("pages/account/login" );
        }
    }


}