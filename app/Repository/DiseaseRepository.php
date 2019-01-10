<?php

namespace App\Repository;


use App\Models\Disease;

class DiseaseRepository
{

	public function getAll($onlyEnable=true)
	{
		$disease = Disease::query();
		$onlyEnable && $disease->where('enable',1);
		return $disease->sort()->get();
	}
}