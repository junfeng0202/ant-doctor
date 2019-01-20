<?php
if(!function_exists('numberToTime')){
	function numberToTime($number)
	{
		if(!$number) return '00:00';
		$minute = intval($number/60);
		$second = intval($number%60);
		return sprintf('%02d:%02d',$minute,$second);
	}
}

