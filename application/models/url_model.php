<?php

class Url_Model extends CI_Model{
	
	public function generateNew(){
		$this->load->helper('string');		
		$urlTrue = false;
		while($urlTrue === false)
		{
			$url = random_string('alnum', 5);
			$query = $this->db->get_where("flows", array("url" => $url));
			if($query->num_rows() == 0)
				$urlTrue = true;
		}
		return $url;
	}
	
}