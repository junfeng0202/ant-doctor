<?php

namespace App\Repository;


use App\Models\Area;

class AreaRepository
{

	public function province()
	{
		return Area::with('children:id,pid,name')->where('type',1)->get();
	}
}