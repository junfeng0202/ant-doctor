<?php

namespace App\Repository;


use App\Models\Disease;

class DiseaseRepository
{

	public function getAll($onlyEnable=true,$type=null)
	{
		$disease = Disease::query();
		$onlyEnable && $disease->where('enable',1);
        is_null($type) || $disease = $disease->where('type', $type);
		return $disease->sort()->get();
	}
}