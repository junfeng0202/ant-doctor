<?php
/**
 * 将时间（秒）转换为00：00格式
 */
if (!function_exists('numberToTime')) {
	function numberToTime($number)
	{
		if (!$number) return '00:00';
		$minute = intval($number / 60);
		$second = intval($number % 60);
		return sprintf('%02d:%02d', $minute, $second);
	}
}

if (!function_exists('sortHandler')) {
	function sortHandler($sort)
	{
		if (!$sort) {
			return null;
		}

		$sort = str_replace(['+', '-'], [' asc', ' desc'], $sort);
		return explode(' ', $sort);
	}
}

