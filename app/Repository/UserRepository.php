<?php

namespace App\Repository;


use App\Models\User;

class UserRepository
{
	public function getList($size = 20, $sort = null)
	{
		$user = User::query();
		if ($sort && $sortArr = sortHandler($sort))
			$user->orderBy(...$sortArr);
		return $user->with('roles')->paginate($size, ['id', 'name', 'created_at']);
	}

	public function getUserById($id)
	{
		return User::find($id, ['id', 'name','is_admin']);
	}

	public function updateOrCreate($id, $data)
	{
		return User::updateOrCreate(['id' => $id], $data);
	}

}