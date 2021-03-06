<?php

namespace App\Strategy\OrderSuccess;

use App\Repository\MemberVideoRepository;
use App\Repository\VideoRepository;
use Carbon\Carbon;

class OrderVideo implements IOrderSuccess
{
	public function addMemberOrder($member_id, $goods_id)
	{
		(new MemberVideoRepository())->create(['member_id'=>$member_id, 'video_id'=>$goods_id, 'expired_at'=>Carbon::now()->addYear()]);
		(new VideoRepository())->incrSold($goods_id);
	}

	public function orderRefund($goods_id)
	{
		(new MemberVideoRepository())->del($goods_id);
	}
}

