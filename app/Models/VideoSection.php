<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoSection extends Model
{
    public function children()
    {
    	return $this->hasMany(self::class, 'pid');
    }

	public function getDurationAttribute()
	{
		return numberToTime($this->attributes['duration']);
	}

	public function getClicksAttribute()
	{
		return \Redis::hget(config('redisKeys.videoSectionHits'), $this->attributes['id']) ?: $this->attributes['hits'];
	}
}
