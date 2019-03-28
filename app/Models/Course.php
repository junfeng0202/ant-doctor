<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Course extends Model
{

	protected $fillable = ['audio_count','hits', 'title', 'disease_id', 'image', 'brief', 'sort', 'enable','havesection'];

	public function doctor()
	{
		return $this->belongsToMany(Doctor::class);
	}

    public function disease(){
        return $this->hasOne(Disease::class,'id','disease_id');
    }

	public function section()
	{
		return $this->hasMany(CourseSection::class)->orderBy('section_num');
	}

	public function collegeContents()
	{
		return $this->morphMany(CollegeSectionContent::class,'contentable');
	}


	public function scopeIsIndex($query)
	{
		return $query->select(DB::raw('1 as `index`'),'id','hits', 'title', 'disease_id', 'image', 'brief', 'sort', 'enable', 'audio_count', 'created_at');
	}

	public function scopeEnable($query)
	{
		return $query->where('enable', 1);
	}

	public function getClicksAttribute()
	{
		return \Redis::hget(config('redisKeys.courseHits'), $this->attributes['id']) ?? $this->attributes['hits'];
	}
}
