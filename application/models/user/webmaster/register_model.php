<?php

class Register_model extends CI_Model {
	
	public function add($array){
				
		$num_rows = 1;
		if(isset($array["email"]) && isset($array["login"]) && isset($array["passhash"]))
			$num_rows = $this->db->get_where("users", array("email" => $array["email"]))->num_rows();
	
		if($num_rows > 0)
			return false;
		
		$this->db->insert("users", $array);		
		return true;
	}



	function email_check($str){
		$query = $this->db->get_where("users", array("email" => $str));
		if($query->num_rows() > 0)
		{
			$this->form_validation->set_message('email_check', 'Данный email уже зарегистрирован');
			return false;
		}
		else
			return true;
	}
}
