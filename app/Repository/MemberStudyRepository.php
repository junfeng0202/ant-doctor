<?php

namespace App\Repository;


use App\Models\MemberStudy;
use App\Models\MemberStudyLog;

class MemberStudyRepository
{
	public function createStudy($data)
	{
		return MemberStudy::create($data);
	}

	public function createStudyLog($data)
	{
		return MemberStudyLog::create($data);
	}

	public function update($up,$create)
	{
		return MemberStudy::updateOrCreate($up,$create);
	}

	public function memberStudyLog($member_id,$page=8)
	{
		return MemberStudy::where('member_id',$member_id)
			->with(['studyCourse:id,title,image,audio_count','studyCourseSection:id,title,duration,pid'])
			->latest()->paginate($page);
	}

}