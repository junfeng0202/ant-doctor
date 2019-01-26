<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    protected $casts = [
        'duration' => 'integer',
    ];
    protected $fillable = ['id','title','course_id','source_id','duration','pid','havesection'];
    public function children()
    {
    	return $this->hasMany(self::class, 'pid');
    }

    public function getDurationAttribute()
    {
		return numberToTime($this->attributes['duration']);
    }
}
