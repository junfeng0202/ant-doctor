<?php

namespace App\Models\back;

use Illuminate\Database\Eloquent\Model;

class VideoSection extends Model
{
    protected $fillable = ['id','title','video_id','url','duration','section_num'];


	public function getClicksAttribute()
	{
		return \Redis::hget(config('redisKeys.videoSectionHits'), $this->attributes['id']) ?: $this->attributes['hits'];
	}
}
