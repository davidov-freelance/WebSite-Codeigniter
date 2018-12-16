<?php

function normal_time($time){
	
	$month_name = 
	    array( 1 => 'января',
		   2 => 'февраля',
		   3 => 'марта',
		   4 => 'апреля',
		   5 => 'мая',
		   6 => 'июня',
		   7 => 'июля',
		   8 => 'августа',
		   9 => 'сентября',
		   10 => 'октября',
		   11 => 'ноября',
		   12 => 'декабря'
	);

	$month = $month_name[ date( 'n',$time ) ];

	$day   = date( 'j',$time );
	$year  = date( 'Y',$time );
	$hour  = date( 'G',$time );
	$min   = date( 'i',$time );

	$date = $day . ' ' . $month . ' ' . $year . ' г. в ' . $hour . ':' . $min;

	$dif = time()- $time;

	if($dif<59){
	    return $dif." сек. назад";
	}elseif($dif/60>1 and $dif/60<59){
	    return round($dif/60)." мин. назад";
	}elseif($dif/3600>1 and $dif/3600<23){
	    return round($dif/3600)." час. назад";
	}else{
	    return $date;
	}
}

function date_helper($date, $type = 1) {
	
	if($date != null) {
		if($type == 1) {
			return date('d.m.Y H:i', strtotime($date));
		}
		elseif($type == 2) {
			switch(date('m', strtotime($date))) {
				case "01": $m = "января"; break;
				case "02": $m = "февраля"; break;
				case "03": $m = "марта"; break;
				case "04": $m = "апреля"; break;
				case "05": $m = "мая"; break;
				case "06": $m = "июня"; break;
				case "07": $m = "июля"; break;
				case "08": $m = "августа"; break;
				case "09": $m = "сентября"; break;
				case "10": $m = "октября"; break;
				case "11": $m = "ноября"; break;
				case "12": $m = "декабря"; break;
				default: $m = "";
			}
			
			if(date('Y', strtotime($date)) == date('Y')) {
				if(date('d', strtotime($date)) == date('d')) {
					return date('сегодня в H:i', strtotime($date));
				}				
				else {
					return date('d '.$m.' в H:i', strtotime($date));
				}
			}
			else {
				return date('d '.$m.' y года', strtotime($date));
			}
		}
		elseif($type == 3) {
			return date('d.m.Y', strtotime($date));
		}
	}
	else {
		return "неизвестно";
	}
}
?>
