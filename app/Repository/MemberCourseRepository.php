<?php

namespace App\Repository;


use App\Models\MemberCourse;
use Carbon\Carbon;

class MemberCourseRepository
{
	public function buyStatus($member_id, $id)
	{
		return MemberCourse::where(['member_id' => $member_id, 'course_id' => $id])
			->where('expired_at', '>', Carbon::now())
			->exists();
	}

	public function create($data)
	{
		return MemberCourse::create($data);
	}
}