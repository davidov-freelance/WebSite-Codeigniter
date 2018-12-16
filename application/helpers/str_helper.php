<?php
function mb_ucfirst($text) {
    return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
}

function cut_words($text, $start, $finish){
	if(strlen($text) > $finish)
		return mb_substr($text, $start, $finish) . "...";
	return $text;
}
