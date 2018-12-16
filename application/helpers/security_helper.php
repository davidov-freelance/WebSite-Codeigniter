<?php

if( !function_exists("checkStr") )
{
	
		function checkStr($data){
			$CI =& get_instance();
			return $CI->security_model->checkStr($data);
		}
	
}

if( !function_exists("checkInt") )
{
		function checkInt($data){
			$CI =& get_instance();
			return $CI->security_model->checkInt($data);
		}
	
}