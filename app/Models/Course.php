<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

	public function doctor()
	{
		return $this->belongsToMany(Doctor::class);
	}

    public function disease(){
        return $this->hasOne(Disease::class,'id','disease_id');
    }

	public function section()
	{
		return $this->hasMany(CourseSection::class)->orderBy('sort');
	}

	public function getHitsAttribute()
	{
		return \Redis::hget(config('redisKeys.courseHits'), $this->attributes['id']) ?? $this->attributes['hits'];
	}
}
