<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoSection extends Model
{
	public $fillable = ['video_id', 'title', 'url', 'duration', 'sort', 'section_num'];

    public function children()
    {
    	return $this->hasMany(self::class, 'pid');
    }

	public function getDurationTimeAttribute()
	{
		return numberToTime($this->attributes['duration']);
	}

	public function getClicksAttribute()
	{
		return \Redis::hget(config('redisKeys.videoSectionHits'), $this->attributes['id']) ?: $this->attributes['hits'];
	}
}
