<?php

function getConversion($leads, $transits, $isTrue = true){
	if(($transits < 100) && $isTrue)
		return "<span class='text-warning'>new</span>";
	if($leads == 0 || $transits == 0)
		return "0.00";
	$result = ($leads / $transits) * 100;
	return round($result, 2) . "%";
}

function getEPC($profit, $transits, $isTrue = true){
	if($transits < 100 && $isTrue)
		return "<span class='text-warning'>new</span>";
	if($profit == 0 || $transits == 0)
		return "0.00";
	return round( ($profit/$transits), 2 );
}

//Вовзращает строку денег в виде 8'000'000 (8 миллионов)
function getNormalMoney($money = 0, $with = true){
	if(!$money)
		return 0;
	if($with)
		return number_format($money, 2, '.', ", ");
	else
		return number_format($money);
}

//Процент подтверждения заявок
function getProcentRequests($trueRequests = 0, $falseRequests = 0){
	if(!$trueRequests)
		return 0;
	return round( ($trueRequests * 100) / ($falseRequests + $trueRequests), 2 );
	
}