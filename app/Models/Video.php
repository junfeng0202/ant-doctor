<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Video extends Model
{

	protected $fillable = ['hits','title','disease_id','image','brief','sort','enable'];
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
		return $this->hasMany(VideoSection::class)->latest('sort');
	}

	public function scopeEnable($query)
	{
		return $query->where('enable',1);
	}

	public function scopeIsIndex($query)
	{
		return $query->select(DB::raw('1 as `index`'),'id','hits','title','disease_id','image','brief','sort','enable','created_at');
	}

	public function getClicksAttribute()
	{
		return \Redis::hget(config('redisKeys.videoHits'), $this->attributes['id']) ?: $this->attributes['hits'];
	}

	public function scopeSort($query)
	{
		return $query->orderByDesc('sort');
	}

}
