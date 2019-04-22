<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class College extends Model
{
	public $fillable = ['title', 'brief', 'image', 'enable', 'sort', 'sold_on', 'price', 'active_price', 'active_on', 'active_start_at', 'active_end_at'];

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

	/**
	 * 活动是否生效
	 * @return bool
	 */
	public function getInActiveAttribute()
	{
		if($this->active_on && $this->active_start_at && $this->active_end_at){
			$start = Carbon::parse($this->active_start_at);
			$end = Carbon::parse($this->active_end_at);
			return Carbon::now()->between($start, $end);
		} else {
			return false;
		}
	}
}
