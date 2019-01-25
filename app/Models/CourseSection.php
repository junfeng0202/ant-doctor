<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
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
}
