<?php

namespace App\Strategy\OrderSuccess;

use App\Repository\CourseRepository;
use App\Repository\MemberCourseRepository;
use Carbon\Carbon;

class OrderCourse implements IOrderSuccess
{
	public function addMemberOrder($member_id, $goods_id)
	{
		(new MemberCourseRepository())->create(['member_id' => $member_id, 'course_id' => $goods_id, 'expired_at' => Carbon::now()->addYear()]);
		(new CourseRepository())->incrSold($goods_id);
	}

	public function orderRefund($goods_id)
	{
		(new MemberCourseRepository())->del($goods_id);
	}
}

