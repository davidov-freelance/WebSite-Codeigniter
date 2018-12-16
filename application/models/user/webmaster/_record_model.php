<?php

class Record_Model extends CI_Model{
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('string');
	}
	
	public function add($data = array(), $url = ''){
		$query = $this->db->select('flows.*, cities.eng_name, pages.url AS page_url, gaskets.url AS gasket_url, offers.countries')
				->where('flows.url', $url)
				->where('flows.active', 1)
				->from('flows')
				->join('pages', 'pages.id=flows.page_id', 'left')
				->join('gaskets', 'gaskets.id=flows.gasket_id', 'left')
				->join('offers', 'offers.id=flows.offer_id', 'left')
                ->join('cities', 'cities.id=flows.city_id', 'left')
				->get();
		if($query->num_rows() == 0) {
			return false;
		}


		$data['flow_id'] = $query->row()->id;
		$data['page_id'] = $query->row()->page_id;
		$data['offer_id'] = $query->row()->offer_id;
		$data['user_id'] = $query->row()->user_id;
		$data['hash'] = random_string('unique');


		// split test code
		$split_test_page_url = '';
		$split_test_page_id = 0;
		$split_test_pages = array();

		if (!empty($query->row()->split_test)) {
			$split_test_pages = unserialize($query->row()->split_test);
		}

		if (!empty($split_test_pages)) {
			$last_transit = $this->db->query('SELECT page_id FROM transits WHERE offer_id = ' . $query->row()->offer_id . ' ORDER BY id DESC LIMIT 1')->row_array();
			if (!empty($last_transit)) {

				$split_test_page_id = $split_test_pages[0];

				$key = array_search($last_transit['page_id'], $split_test_pages);
				
				if ($key !== false) {
					if (isset($split_test_pages[$key + 1])) {
						$split_test_page_id = $split_test_pages[$key + 1];
					}
				}
				

				$tmp = $this->db->query('SELECT url FROM pages WHERE id = ' . $split_test_page_id)->row_array();
				if (!empty($tmp)) {
					$data['page_id'] = $split_test_page_id;
					$split_test_page_url = $tmp['url'];
				}

			}
			
		}


		// insert transit
		$this->db->insert('transits', $data);


		/*
		 * TRAFFICBACL
		 */
		if(trim($query->row()->trafficback_url) != "")
		{
			$c_array = explode(", ", $query->row()->countries);
			$codes = config_item("countries_code");
			if(!in_array($data["country_code"], $codes) || !in_array($codes[$data["country_code"]], $c_array))
				return array("trafficback_url" => $query->row()->trafficback_url);
		}
		/*
		 * END TRAFFICBACL
		 */		
		
		//Если вдруг пользователь выбрал прокладку какую-то, прежде чем лить на лендинг
		if($query->row()->gasket_id > 0) {
			return $query->row()->gasket_url . "?hash=" . $data["hash"];
		}
			
		if ($query->row()->city_id > 0) {

			if (!empty($split_test_page_url)) {
				return $split_test_page_url . "?hash=" . $data["hash"] . "&geotrg=".$query->row()->eng_name;
			} else {
				return $query->row()->page_url . "?hash=" . $data["hash"] . "&geotrg=".$query->row()->eng_name;
			}
			
		} else {

			if (!empty($split_test_page_url)) {
				return $split_test_page_url . "?hash=" . $data["hash"];
			} else {
				return $query->row()->page_url . "?hash=" . $data["hash"];
			}

		}


	}
	
}
