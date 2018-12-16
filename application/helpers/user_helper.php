<?php

function getUserType($type) {
	switch ($type) {
		case '0':
			return 'вебмастер';
			break;
		
		case '1':
			return 'рекламодатель';
			break;

		case '2':
			return 'модератор';
			break;

		case '3':
			return 'администратор';
			break;

		default:
			return 'unknown';
			break;
	}
}

?>