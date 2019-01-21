<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberStudy extends Model
{
    protected $fillable = ['member_id', 'course_id', 'course_section_id', 'time', 'end'];


    public function studyCourse()
    {
    	return $this->belongsTo(Course::class,'course_id');
    }

    public function studyCourseSection()
    {
    	return $this->belongsTo(CourseSection::class,'course_section_id');
    }
}
