<?php

namespace App\Repository;


use App\Models\Disease;

class DiseaseRepository
{

	public function getAll($onlyEnable=true,$type=1)
	{
		$disease = Disease::query();
		$onlyEnable && $disease->where('enable',1);
        $disease = $disease->where('type',1);
		return $disease->sort()->get();
	}
}