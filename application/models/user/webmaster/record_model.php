<?php

class Record_Model extends CI_Model{
	
	public function __construct() {
		parent::__construct();
		$this->load->helper('string');
	}
	
	public function add($data = array(), $flow_info = '', $only_hash = false){


		$data['flow_id'] = $flow_info->id;
		$data['page_id'] = $flow_info->page_id;
		$data['offer_id'] = $flow_info->offer_id;
		$data['user_id'] = $flow_info->user_id;
		$data['hash'] = random_string('unique');


	
		
		$mobile_url = '';
		$split_test_page_url = '';
		$split_test_page_id = 0;
		$split_test_pages = array();

		if (!empty($flow_info->split_test)) {
			$split_test_pages = unserialize($flow_info->split_test);
		}


		if (!empty($split_test_pages)) {

			/////////////////////////////////////////////////////////////////
			/* split test code                                             */
			/////////////////////////////////////////////////////////////////

			$last_transit = $this->db->query('SELECT page_id FROM transits WHERE offer_id = ' . $flow_info->offer_id . ' ORDER BY id DESC LIMIT 1')->row_array();
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
			
		} else {

			/////////////////////////////////////////////////////////////////
			/* check mobile visits and redirect to mobile landing (if set) */
			/////////////////////////////////////////////////////////////////

			
			if ($flow_info->m_page_id > 0) {
				$tmp = $this->db->query('SELECT url FROM pages WHERE id = ' . $flow_info->m_page_id)->row_array();
				if (isset($tmp['url'])) {

					// check if visit from mobile device
					$this->load->library('user_agent');
					if ($this->agent->is_mobile()) {
						$mobile_url = $tmp['url'];
						$data['page_id'] = $flow_info->m_page_id;
					}

					
				}
			}

		}


		// insert transit
		$this->db->insert('transits', $data);
		if( $only_hash ) return $data['hash'];

		/*
		 * TRAFFICBACK
		 */
		if(trim($flow_info->trafficback_url) != "")
		{
			$c_array = explode(", ", $flow_info->countries);
			$codes = config_item("countries_code");
			if(!in_array($data["country_code"], $codes) || !in_array($codes[$data["country_code"]], $c_array))
				return array("trafficback_url" => $flow_info->trafficback_url);
		}
		/*
		 * END TRAFFICBACL
		 */		
		
		//Если вдруг пользователь выбрал прокладку какую-то, прежде чем лить на лендинг
		if($flow_info->gasket_id > 0) {
			return $flow_info->gasket_url . '?hash=' . $data['hash'];
		}
			
		if ($flow_info->city_id > 0 && $flow_info->flow_type == "city" ) {

			if (!empty($split_test_page_url)) {
				$back_url = $split_test_page_url;
			} elseif (!empty($mobile_url)) {
				$back_url = $mobile_url;
			} else {
				$back_url = $flow_info->page_url;
			}

			return $back_url . '?hash=' . $data['hash'];
			
		} else {

			if (!empty($split_test_page_url)) {
				return $split_test_page_url . '?hash=' . $data['hash'];
			} elseif (!empty($mobile_url)) {
				return $mobile_url . '?hash=' . $data['hash'];
			} else {
				return $flow_info->page_url . '?hash=' . $data['hash'];
			}

		}


	}
	
}
