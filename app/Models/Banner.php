<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    const INDEX = 0;

	/**
	 * 动态条件--广告位置
	 * @param $query
	 * @param int $position
	 * @return mixed
	 */
	public function scopePosition($query, $position=self::INDEX)
    {
		return $query->where('position', $position);
    }
}
