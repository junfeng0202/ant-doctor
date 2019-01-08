<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Live extends Model
{
	//直播状态
	const BEGINING = 1;
	const WAITING = 2;
	const END = 3;

	protected $fillable = ['title', 'status', 'image', 'disease_id', 'start_at', 'end_at', 'link', 'playback', 'brief'];

	protected $dates = ['start_at', 'end_at'];

	public function doctor()
	{
		return $this->belongsToMany(Doctor::class);
	}

	public function disease()
	{
		return $this->belongsTo(Disease::class);
	}
}
