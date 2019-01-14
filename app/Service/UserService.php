<?php

namespace App\Service;


use App\Proxy\ProxyService;
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

		$rules = [
			'username' => ['required', 'alpha'],
			'password' => ['required', 'min:6']
		];

		$payload = $request->only('username', 'password');
		dd($payload);
		$validator = app('validator')->make($payload, $rules);

		if ($validator->fails()) {
			throw new StoreResourceFailedException('username and password required.', $validator->errors());
		}

		if(Auth::attempt(['phone'=>$request->username,'password'=>$request->password])){

			$oauth = (new OauthRepository())->getOne(config('config.frontend_client'));
			$params = [
				'client_id' => $oauth->id,
				'client_secret' => $oauth->secret,
				'username' => $request->username,
				'password' => $request->password,
				'scope' => '',
			];

			$tokenProxy = new ProxyService();
			$token = $tokenProxy->proxy('password', $params);

			if(isset($token->error)){
				return $this->response->errorForbidden($token->error);
			}

			return $this->response->array($token)->setStatusCode(201);
		}else{
			return $this->response->errorUnauthorized('用户名或密码错误');
		}
	}


}