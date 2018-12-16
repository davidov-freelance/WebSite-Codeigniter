<?php

class Add_model extends CI_Model{
	
	public function add($info = array()){
		//Определяем следующий ID в offers
		$next_id = $this->db->last_id("offers");
		//Загрузка изображения
		if (!empty($_FILES['logotip']['name'])) { 
			$imageFileName = $this->uploadImage($next_id);
		} else {
			$imageFileName = '';
		}		
		$info_to_db = array(
		    'name'		=>	$info['name'],
		    'user_id'	=>	$info['user_id'],
		    'image'		=>	"files/images/offers/" . $next_id . "/" . $imageFileName,
		    'places'	=>	implode(", ", $info["traffics"]),
		    'small_descr'	=>	$info["small_descr"],
		    //'descr'	=>	$info["descr_dop"],
		    'cat'		=>	$info["cat"],
		    'countries'	=>	$info["countries"],
		    'max_leads'	=>	$info["max_leads"],
		    'postclick'	=>	$info["postclick"],
		    'sex'		=>	$info["sex"],
		    'age'		=>	'[' . str_replace(array('[',']'), '', $info['age']) . ']',
            'send_to'	=>	$info["send_to"],
		    'added'		=>	time()
		);

		if (empty($imageFileName)) {
			$info_to_db['image'] = 'files/images/no-img-90x90.gif';
		}


		$this->addGoals($info["goals"], $next_id);
		$this->addPages($info["pages"], $next_id);
		$this->addGaskets($info["gaskets"], $next_id);
        $this->addCities($info["cities"], $next_id);
		$this->db->insert("offers", $info_to_db);
		
		//Перенаправляем на страницу просмотра оффера
		redirect(base_url() . "offer/view/id/" . $next_id);
	}
	
	public function uploadImage($offer_id){
		$uploadDir = "files/images/offers/" . $offer_id . "/";
		mkdir($uploadDir, 0777);

		$config = array (
			'upload_path' 	=> $uploadDir,
			'allowed_types' => 'gif|jpg|png',
			//'max_size'	=> '100',
			//'max_width' 	=> '250',
			//'max_height' 	=> '250',
			'encrypt_name' 	=> TRUE
			);

		$this->load->library('upload', $config);
		//$this->upload->do_upload('logotip');
		//$data = $this->upload->data();
		//return $data["file_name"];
/////		
		if ( ! $this->upload->do_upload('logotip')) {
			$error = array('error' => $this->upload->display_errors());
			//print_r($error);
			//exit();
			return '';
		} else {
			$data = array('upload_data' => $this->upload->data());
			$name_img = $data['upload_data']['file_name'];
			return $name_img;
		}		
/////		
	}



	public function uploadImage_for_edit($offer_id){
		$uploadDir = "files/images/offers/" . $offer_id . "/";
		mkdir($uploadDir, 0777);
		// очистка папки
		$this->load->helper("file"); // load the helper
		delete_files($uploadDir, true); // delete all files/folders

		$config = array (
			'upload_path' 	=> $uploadDir,
			'allowed_types' => 'gif|jpg|png',
			//'max_size'	=> '100',
			//'max_width' 	=> '250',
			//'max_height' 	=> '250',
			'encrypt_name' 	=> TRUE
			);

		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('logotip')) {
			$error = array('error' => $this->upload->display_errors());
			return '';
		} else {
			$data = array('upload_data' => $this->upload->data());
			$name_img = $data['upload_data']['file_name'];
			return $name_img;
		}		
	}






	
	public function addCities($arr, $offer_id){
		if(count($arr) > 0){
			$sql = "INSERT INTO offers_cities (city_id, offer_id) VALUES ";
			$insertArray = array();
			foreach($arr AS $c){
				array_push($insertArray, "(".$this->db->escape($c).", '".$offer_id."')");
			}
			$sql .= implode(", ", $insertArray);
			$this->db->query($sql);
		}            
        }
	
	public function addPages($jsonStr, $offer_id){
		$pages = json_decode($jsonStr);
		if(count($pages) > 0){
			$sql = "INSERT INTO pages (name, url, offer_id) VALUES ";
			$insertArray = array();
			foreach($pages AS $page){

				// check 'hhtp://' in url
				if (strpos($page[1], 'http://') === false) {
                	$page[1] = 'http://' . $page[1];
				}

				array_push($insertArray, "(".$this->db->escape($page[0]).", ".$this->db->escape($page[1]).", '".$offer_id."')");
			}
			$sql .= implode(", ", $insertArray);
			$this->db->query($sql);
		}
	}
	
	public function addGaskets($jsonStr, $offer_id){
		$gaskets = json_decode($jsonStr);
		if(count($gaskets) > 0){
			$sql = "INSERT INTO gaskets (name, url, offer_id) VALUES ";
			$insertArray = array();
			foreach($gaskets AS $page){
				array_push($insertArray, "(".$this->db->escape($page[0]).", ".$this->db->escape($page[1]).", '".$offer_id."')");
			}
			$sql .= implode(", ", $insertArray);
			$this->db->query($sql);
		}
	}
	
	public function addGoals($jsonStr, $offer_id){
		$goals = json_decode($jsonStr);
		if(count($goals) > 0){
			$sql = "INSERT INTO goals (name, price, real_price, offer_id, city_id) VALUES ";
			$insertArray = array();
			foreach($goals AS $goal){
				//array_push($insertArray, "(".$this->db->escape($goal[0]).", ".$this->db->escape($goal[2]).", ".$this->db->escape($goal[1]).", '".$offer_id."')");
				array_push($insertArray, "(".$this->db->escape($goal[0]).", ".$this->db->escape($goal[2]).", ".$this->db->escape($goal[1]).", '".$offer_id."', ".$this->db->escape($goal[3]).")");
			}
			$sql .= implode(", ", $insertArray);
			$this->db->query($sql);
		}
	}
	
}

