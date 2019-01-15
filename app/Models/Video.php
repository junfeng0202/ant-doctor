<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

	public function doctor()
	{
		return $this->belongsToMany(Doctor::class);
	}

	public function disease()
	{
		return $this->belongsTo(Disease::class);
	}

	public function section()
	{
		return $this->hasMany(VideoSection::class)->where('parent_id',0);
	}

	public function scopeEnable($query)
	{
		return $query->where('enable',1);
	}

	public function getHitsAttribute()
	{
		return \Redis::hget(config('redisKeys.videoHits'), $this->attributes['id']) ?? $this->attributes['hits'];
	}

	public function scopeSort($query)
	{
		return $query->orderByDesc('sort');
	}

}
