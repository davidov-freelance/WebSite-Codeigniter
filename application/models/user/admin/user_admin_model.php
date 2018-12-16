<?php

class User_admin_model extends CI_Controller
{

	public function getUsersList(){
		$this->db->select("users.*"
			. ", (SELECT SUM(money) FROM hold_money WHERE user_id=users.id) AS hold_money"
			. ", (SELECT SUM(sum) FROM payments WHERE paid='0' AND user_id=users.id) AS on_payment")
			//->where("type", "0")
			->from("users")
			->order_by("reg_date", "DESC");
		return $this->db->get();
	}


	public function getAdvertsUsers(){
		$this->db->select("o.name AS offer_name, o.id, "
			. "u.id AS user_id, u.name, u.surname, u.money, u.email")
			->from("offers AS o")
			->join("users AS u", "u.id=o.user_id", "left");
		$query = $this->db->get();
		$users = array();
		foreach($query->result() AS $row){
			$users[$row->user_id]["offers"][] = array(
				"offer_name"	=>	$row->offer_name,
				"offer_id"		=>	$row->id
			);
			if(!in_array("info", $users[$row->user_id]))
			{
				$users[$row->user_id]["info"] = array(
					"user_id"	=>	$row->user_id,
					"user_name"	=>	($row->name . " " . $row->surname == " " ? "-" : $row->name . " " . $row->surname),
					"email"	=>	$row->email
				);
			}
		}
		return $users;
	}


	public function getUserInfo($ar = array()){

		if(isset($ar["select"]))
			$this->db->select($ar["select"]);
		if(isset($ar["id"]))
			$this->db->where("id", $ar["id"]);
		if(isset($ar["type"]) && ($ar["type"] == '0' || $ar["type"] == '1' || $ar["type"] == '2' || $ar["type"] == '3'))
			$this->db->where("type", $ar["type"]);
		if(isset($ar["user_id"]))
			$this->db->where("user_id", $ar["user_id"]);

		$query = $this->db->get("users");

		if(isset($ar["count"]))
		{
			if($ar["count"])
				return $query->row();
			else
				return $query->result();
		}
		else
			return $query->result();
	}
}

?>