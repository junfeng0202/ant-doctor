<?php

namespace App\Repository;


use App\Models\MemberVideo;
use Carbon\Carbon;

class MemberVideoRepository
{
	public function buyStatus($member_id, $id)
	{
		return MemberVideo::where(['member_id' => $member_id, 'video_id' => $id])
			->where('expired_at', '>', Carbon::now())
			->exists();
	}

	public function create($data)
	{
		return MemberVideo::create($data);
	}

	public function del($id)
	{
		return MemberVideo::destroy($id);
	}
}