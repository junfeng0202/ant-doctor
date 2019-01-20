<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberStudyLog extends Model
{
	protected $fillable = ['member_id', 'course_id', 'course_section_id', 'time', 'end'];
}
