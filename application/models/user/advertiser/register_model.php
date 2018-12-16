<?php

class Register_model extends CI_Model {
	
	public function add($array){
		$this->db->insert("advertiser_requests", $array);
	}
	
}
