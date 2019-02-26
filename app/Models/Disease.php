<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
	//疾病类型
	const INTERESTED = 0;
	const COMBINE = 1;
	const COMPLICATION = 2;

	public function scopeSort($query)
	{
		return $query->orderByDesc('sort');
	}
}
