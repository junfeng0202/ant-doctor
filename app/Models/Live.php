<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Live extends Model
{
	//直播状态
	const BEGINING = 1;
	const WAITING = 2;
	const END = 3;

    protected $table = 'lives';

    protected $fillable = ['title', 'status', 'image', 'disease_id', 'start_at', 'end_at', 'link', 'brief'];

	protected $dates = ['start_at', 'end_at'];


	public function doctor()
	{
		return $this->belongsToMany(Doctor::class);
	}

	public function disease()
	{
		return $this->belongsTo(Disease::class);
	}

	public function getHitsAttribute()
	{
		return \Redis::hget(config('redisKeys.liveHits'), $this->attributes['id']) ?? $this->attributes['hits'];
	}

	public function scopeIsIndex($query)
	{
		return $query->select(DB::raw('1 as isIndex'), 'id', 'title', 'status', 'image', 'disease_id', 'start_at', 'end_at', 'link', 'brief');
	}

}
