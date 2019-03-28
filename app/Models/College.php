<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class College extends Model
{
	public $fillable = ['title', 'brief', 'image', 'enable', 'sort'];

	public function section()
	{
		return $this->hasMany(CollegeSection::class)->orderByDesc('sort');
	}

	/**
	 * 动态属性clicks
	 * @return mixed
	 */
	public function getClicksAttribute()
	{
		$key = config('redisKeys.collegeHits');
		if (Redis::exists($key)) {
			return Redis::get($key);

		} else {
			$hits = $this->hits;
			Redis::set($key, $hits);
			return $hits;
		}
	}
}
