<?php

namespace App\Repository;


use App\Models\MemberCollege;
use Carbon\Carbon;

class MemberCollegeRepository
{
	public function buyStatus($member_id, $id)
	{
		return MemberCollege::where(['member_id' => $member_id, 'college_id' => $id])
			->where('expired_at', '>', Carbon::now())
			->exists();
	}
}