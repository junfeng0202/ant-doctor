<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Video extends Model
{

	protected $fillable = ['hits', 'title', 'disease_id', 'image', 'brief', 'sort', 'enable', 'audio_count', 'price', 'active_price', 'active_on', 'active_start_at', 'active_end_at'];

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
		return $this->hasMany(VideoSection::class)->orderBy('section_num');
	}

	public function collegeContents()
	{
		return $this->morphMany(CollegeSectionContent::class, 'contentable');
	}

	public function scopeEnable($query)
	{
		return $query->where('enable', 1);
	}

	public function scopeIsIndex($query)
	{
		return $query->select(DB::raw('1 as `index`'), 'id', 'hits', 'title', 'disease_id', 'image', 'brief', 'sort', 'enable', 'audio_count', 'created_at', 'price', 'active_price', 'active_on', 'active_start_at', 'active_end_at');
	}

	public function getClicksAttribute()
	{
		return \Redis::hget(config('redisKeys.videoHits'), $this->attributes['id']) ?: $this->attributes['hits'];
	}

	public function scopeSort($query)
	{
		return $query->orderByDesc('sort');
	}


	/**
	 * 活动是否生效
	 * @return bool
	 */
	public function getInActiveAttribute()
	{
		if ($this->active_on && $this->active_start_at && $this->active_end_at) {
			$start = Carbon::parse($this->active_start_at);
			$end = Carbon::parse($this->active_end_at);
			return Carbon::now()->between($start, $end);
		} else {
			return false;
		}
	}
}
