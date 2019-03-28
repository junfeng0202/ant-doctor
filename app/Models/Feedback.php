<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
	const BUG = 1;
	const PRODUCT = 2;
	const COMPLAIN = 3;
	const OTHER = 4;

	public function member()
	{
		return $this->belongsTo(Member::class);
	}

	public function images()
	{
		return $this->hasMany(FeedbackImage::class);
	}
}
