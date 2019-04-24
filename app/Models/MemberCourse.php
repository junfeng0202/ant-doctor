<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberCourse extends Model
{
	protected $fillable = ['course_id', 'member_id', 'expired_at'];

	protected $dates = ['expired_at'];
}
