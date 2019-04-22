<?php

namespace App\Service;

class Service
{
	protected function arrToTree(&$arr, $pid=0)
	{
		$result=[];
		foreach ($arr as $key=>$item) {
			if($item['pid'] == $pid){
				unset($arr[$key]);
				$item['children'] = $this->arrToTree($arr, $item['id']);
				$result[] = $item;
			}
		}
		return $result;
	}
}