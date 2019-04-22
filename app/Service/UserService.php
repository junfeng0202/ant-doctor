<?php

namespace App\Service;

use App\Repository\UserRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class UserService
{
	protected $userRepository;


	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * 管理员列表
	 * @param $request
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function getList($request)
	{
		return $this->userRepository->getList($request->limit, $request->sort);
	}

	/**
	 * 获取用户详情
	 * @param $id
	 * @return mixed
	 */
	public function getUser($id)
	{
		$user = $this->userRepository->getUserById($id);
		$user->roles = $user->roles()->pluck('id');
		return $user;
	}

	public function save($id, $data)
	{
		if (isset($data['password']) && $data['password'] !== '') {
			$data['password'] = bcrypt($data['password']);
		} else {
			unset($data['password']);
		}

		$user = $this->userRepository->updateOrCreate($id, $data);
		$user->roles()->sync($data['roles']);
	}


	public function setUserRule($id, $rules)
	{
		$res = $rules->where('api_name', '!=', '')->pluck('api_name')->all();

		Cache::tags('rules')->add(config('config.rule_key').$id, $res, 60*24*7);

	}
}