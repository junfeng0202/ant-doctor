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

	public function getList($request)
	{
		return $this->userRepository->getList($request->limit, $request->sort);
	}

	public function getUser($id)
	{
		return $this->userRepository->getUserById($id);
	}

	public function save($id, $data)
	{
		if (isset($data['password']) && $data['password'] !== '') {
			$data['password'] = bcrypt($data['password']);
		}

		if ($id) {
			$data = array_filter($data, function ($v) {
				return $v;
			});
			return $this->userRepository->update($id, $data);
		} else
			return $this->userRepository->create($data);
	}

}