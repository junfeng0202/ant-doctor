<?php
namespace App\Strategy\OrderSuccess;

use App\Repository\MemberCollegeRepository;
use Carbon\Carbon;

class OrderCollege implements IOrderSuccess
{
	public function addMemberOrder($member_id, $goods_id)
	{
		(new MemberCollegeRepository())->create(['member_id' => $member_id, 'college_id' => $goods_id, 'expired_at' => Carbon::now()->addYear()]);
	}
}

