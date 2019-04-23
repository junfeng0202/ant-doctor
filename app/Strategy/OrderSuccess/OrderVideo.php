<?php

namespace App\Strategy\OrderSuccess;

use App\Repository\MemberVideoRepository;
use Carbon\Carbon;

class OrderVideo implements IOrderSuccess
{
	public function addMemberOrder($member_id, $goods_id)
	{
		(new MemberVideoRepository())->create(['member_id'=>$member_id, 'video_id'=>$goods_id, 'expired_at'=>Carbon::now()->addYear()]);
	}
}

