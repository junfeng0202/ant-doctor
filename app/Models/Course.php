<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Course extends Model
{

	protected $fillable = ['hits', 'title', 'disease_id', 'image', 'brief', 'sort', 'enable', 'audio_count', 'havesection', 'price', 'active_price', 'active_on', 'active_start_at', 'active_end_at'];

	public function doctor()
	{
		return $this->belongsToMany(Doctor::class);
	}

	public function disease()
	{
		return $this->hasOne(Disease::class, 'id', 'disease_id');
	}

	public function section()
	{
		return $this->hasMany(CourseSection::class)->orderBy('section_num');
	}

	public function collegeContents()
	{
		return $this->morphMany(CollegeSectionContent::class, 'contentable');
	}


	public function scopeIsIndex($query)
	{
		return $query->select(DB::raw('1 as `index`'), 'id', 'hits', 'title', 'disease_id', 'image', 'brief', 'havesection', 'sort', 'enable', 'audio_count', 'created_at', 'price', 'active_price', 'active_on', 'active_start_at', 'active_end_at');
	}

	public function scopeEnable($query)
	{
		return $query->where('enable', 1);
	}

	public function getClicksAttribute()
	{
		return \Redis::hget(config('redisKeys.courseHits'), $this->attributes['id']) ?? $this->attributes['hits'];
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

	public function getSoldPriceAttribute()
	{
		return $this->in_active ? $this->active_price : $this->price;
	}
}
