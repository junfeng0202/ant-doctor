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

if (!function_exists('orderNumber')) {
	function orderNumber()
	{
		/* 选择一个随机的方案 */
		mt_srand((double) microtime() * 1000000);

		return date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
	}
}

