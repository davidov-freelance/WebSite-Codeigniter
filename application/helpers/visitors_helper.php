<?php

function getNormalReferer($referer = ''){
	if(strlen(trim($referer)) == 0 || $referer == '0')
	{
		return "Нет";
	}
	else
	{
		if(strlen($referer) > 25)
			$refererName = substr($referer, 0, 25) . "...";
		else
			$refererName = $referer;
		return "<a target='_blank' href='".$referer."'>".$refererName."</a>";
	}
}