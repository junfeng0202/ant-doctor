<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Course extends Model
{

	protected $fillable = ['hits', 'title', 'disease_id', 'image', 'brief', 'sort', 'enable'];

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

	public function scopeIsIndex($query)
	{
		return $query->select(DB::raw('1 as `index`'),'id','hits', 'title', 'disease_id', 'image', 'brief', 'sort', 'enable', 'created_at');
	}

	public function getClicksAttribute()
	{
		return \Redis::hget(config('redisKeys.courseHits'), $this->attributes['id']) ?? $this->attributes['hits'];
	}
}
