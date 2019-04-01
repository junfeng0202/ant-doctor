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
		return \Redis::hget(config('redisKeys.collegeHits'), $this->attributes['id']) ?? $this->attributes['hits'];
	}

	public function scopeEnable($query)
	{
		return $query->where('enable', 1);
	}
}
