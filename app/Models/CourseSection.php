<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
	protected $casts = [
		'duration' => 'integer',
	];
	protected $fillable = ['id', 'title', 'course_id', 'source_id', 'duration', 'pid', 'section_num', 'is_free'];

	public function children()
	{
		return $this->hasMany(self::class, 'pid');
	}

	public function parent()
	{
		return $this->belongsTo(self::class, 'pid');
	}

	public function getDurationTimeAttribute()
	{
		return numberToTime($this->attributes['duration']);
	}

}
