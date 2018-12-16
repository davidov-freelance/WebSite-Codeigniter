<?php

class Login_model extends CI_Model{
    
    public function goLogin($email, $password){
        $passhash = $this->user_model->getMD5($password);
        $res =  $this->user_model->getUserInfo(
                    array(
                        "email" => $email, 
                        "passhash" => $passhash
                    )
                );
        if($res->num_rows() > 0){
            $this->session->set_userdata("email", $email);
            $this->session->set_userdata("passhash", $passhash);
            return true;
        }
        return false;
    }   
    
	public function go($email, $passhash){
		$this->session->set_userdata("email", $email);
		$this->session->set_userdata("passhash", $passhash);
		return true;
	}
	
	public function logout(){
		$this->session->unset_userdata('passhash');
		return true;
	}
    
}
