<?php

namespace App\Service;

use App\Proxy\OtherService;
use App\Repository\OauthRepository;
use App\Repository\UserRepository;
use Dingo\Api\Exception\StoreResourceFailedException;

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

}