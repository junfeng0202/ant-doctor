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

	public function login($request)
	{

	}

	public function info()
	{

	}


}