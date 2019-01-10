<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
	public function scopeSort($query)
	{
		return $query->orderByDesc('sort');
	}
}
