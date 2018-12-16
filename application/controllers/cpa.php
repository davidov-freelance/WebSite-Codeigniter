<?php

class Cpa extends CI_Controller{

	public function index(){
		mail("79372920862@yandex.ru", "Test", "TEST");
		echo "Yes";
	}



}