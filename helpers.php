<?php
if(!function_exists('numberToTime')){
	function numberToTime($number)
	{
		$hour = intval($number/3600);
		$minute = intval(($number-$hour*3600)/60);
		$second = intval($number%60);
		return sprintf('%02d:%02d:%02d',$hour,$minute,$second);
	}
}

