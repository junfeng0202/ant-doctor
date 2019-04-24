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

	public function contentInBuyedCollege($member_id, $content_id, $type)
	{
		return MemberCollege::from('member_colleges as a')->Join('college_section_contents as b', 'a.college_id', '=', 'b.college_id')->where(['a.member_id' => $member_id, 'b.contentable_id' => $content_id, 'b.contentable_type'=>$type])->exists();

	}

	public function create($data){
		return MemberCollege::create($data);
	}
}