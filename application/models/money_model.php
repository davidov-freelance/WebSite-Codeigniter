<?php

class Money_Model extends CI_Model{
	
	public function fromAdvertiserToWebmaster($advertiser_balance, $advertiser_id = 0, $webmaster_id = 0, $money = 0, $real_money = 0){
		//if($advertiser_balance >= $money)
		//{
			$sql1 = "UPDATE users SET money = money - ? WHERE id=?";
			$sql2 = "UPDATE users SET money = money + ? WHERE id=?";
			$this->db->query($sql1, array($real_money, $advertiser_id));
			$this->db->query($sql2, array($money, $webmaster_id));
			return true;
		//}
		//else
		//	return false;
	}
	
	public function fromAdvertiserToWebmasterWithHold(
		  $request_id
		, $advertiser_balance
		, $advertiser_id = 0
		, $webmaster_id = 0
		, $webmaster_hold = 14
		, $money = 0
		, $real_money = 0
	)
	{
		//Если у вебмастера холд > 0
		if(0 <= 0)
		{
			return $this->fromAdvertiserToWebmaster($advertiser_balance, $advertiser_id, $webmaster_id, $money, $real_money);
		}
		else
		{
			//if($advertiser_balance >= $money)
			//{
				$db["date"] = date( "Y-m-d", time() + ($webmaster_hold * 86400) );
				$db["user_id"] = $webmaster_id;
				$db["money"] = $money;
				$db["request_id"] = $request_id;
				$this->db->insert("hold_money", $db);
				$this->minusFromBalance($real_money, $advertiser_id);
				return true;
			//}
			//return false;
		}
	}
	
	public function minusFromBalance($sum, $user_id){
		$sql1 = "UPDATE users SET money = money - ? WHERE id=?";
		$this->db->query($sql1, array($sum, $user_id));
		return true;
	}
	
	public function minusHold($sum, $user_id){
		$sql = "UPDATE users SET hold = hold - ? WHERE id=?";
		$this->db->query($sql, array($sum, $user_id));
		return true;
	}
	
	public function addMoneyToUser($sum, $user_id){
		$sql = "UPDATE users SET money = money + ? WHERE id=?";
		$array = array(
		    "user_id"	=>	$user_id,
		    "sum"	=>	$sum
		);
		$this->db->insert("add_money_history", $array);
		$this->db->query($sql, array($sum, $user_id));
		return true;
	}
	
}