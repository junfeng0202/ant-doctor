<?php

namespace App\Repository;

use App\Models\Member;

class MemberRepository
{
	public function create($data)
	{
		return Member::create($data);
	}

	public function getById($id)
	{
		return Member::find($id);
	}

	public function update($id, $data)
	{
		return Member::whereId($id)->update($data);
	}
}