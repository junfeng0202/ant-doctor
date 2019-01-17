<?php
if(!function_exists('numberToTime')){
	function numberToTime($number)
	{
		if(!$number) return '00:00:00';
		$hour = intval($number/3600);
		$minute = intval(($number-$hour*3600)/60);
		$second = intval($number%60);
		return sprintf('%02d:%02d:%02d',$hour,$minute,$second);
	}
}

