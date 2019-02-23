<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    protected $casts = [
        'duration' => 'integer',
    ];
    protected $fillable = ['id','title','course_id','source_id','duration','pid','havesection'];
    protected $appends = ['duration_int'];       // 表里没有的字段

    public function children()
    {
    	return $this->hasMany(self::class, 'pid');
    }

    public function parent()
    {
    	return $this->belongsTo(self::class, 'pid');
    }

    public function getDurationAttribute()
    {
		return numberToTime($this->attributes['duration']);
    }
    public function getDurationIntAttribute()
    {
        return $this->attributes['duration'];
    }

}
