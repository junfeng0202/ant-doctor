<?php

namespace App\Repository;


use App\Models\Config;

class ConfigRepository
{

	public function updateOrCreate($key, $value)
	{
		return Config::updateOrcreate(['key'=>$key], ['value'=>$value]);
	}

	public function getValueByKey($key)
	{
		return Config::where(['key'=>$key])->value('value');
	}
}