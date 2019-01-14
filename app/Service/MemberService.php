<?php

namespace App\Service;


use App\Models\Member;
use App\Proxy\ProxyService;
use App\Repository\MemberRepository;
use App\Repository\OauthRepository;
use Illuminate\Support\Facades\Auth;

class MemberService extends Service
{
	protected $memberRepository;


	public function __construct(MemberRepository $memberRepository)
	{
		$this->memberRepository = $memberRepository;
	}

	public function login($request)
	{
		if (Auth::guard('member')->attempt(['phone' => $request->username, 'password' => $request->password])) {

			return $this->getToken($request->username, $request->password);
		} else {
			$this->response->errorUnauthorized('用户名或密码错误');
		}
	}

	public function register($request)
	{
		try {
			$user= $this->memberRepository->create([
				'phone' => $request->username,
				'password' => bcrypt($request->password)
			]);

			return ['success'=>true,'obj'=>$user];

		} catch (\Exception $e) {
			return ['success' => false, 'obj' => null];
		}
	}


	public function updateInfo($request)
	{
		//感兴趣疾病
		$interest = (array)$request->interest;
		$interest = array_map(function($v){ return [$v=>['type'=>Member::INTERESTED]];}, $interest);

		dd($interest);
		$data = $request->only('identify', 'gender','birth', 'diagnosis_at', 'province_id', 'city_id', 'company');


		$this->memberRepository->update($request->user()->id, $data);
	}


	protected function getToken($username, $password)
	{
		$oauth = (new OauthRepository())->getOne(config('config.frontend_client'));
		$params = [
			'client_id' => $oauth->id,
			'client_secret' => $oauth->secret,
			'username' => $username,
			'password' => $password,
			'scope' => '',
		];

		$tokenProxy = new ProxyService;
		$token = $tokenProxy->proxy('password', $params);
		if (isset($token->error)) {
			$this->response->errorForbidden($token->error);
		}

		return $this->response->array($token);
	}

}