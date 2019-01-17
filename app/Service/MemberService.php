<?php

namespace App\Service;


use App\Exceptions\ApiException;
use App\Models\Member;
use App\Proxy\OtherService;
use App\Repository\MemberRepository;
use App\Repository\OauthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
		$phone = $request->username;
		if($code = Cache::get('reg-'.$phone)){

			if(!$code){
				throw new ApiException('验证码已过期，请重新获取',420);
			}

			if($code != $request->code){
				throw new ApiException('验证码错误',420);
			}
		}

		if($this->memberRepository->phoneExist($phone)){
			throw new ApiException('手机号已被注册',419);
		}

		return $this->memberRepository->create([
			'phone' => $phone,
			'password' => bcrypt($request->password)
		]);


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

		$tokenProxy = new OtherService;
		$token = $tokenProxy->proxy('password', $params);
		if (isset($token->error)) {
			$this->response->errorForbidden($token->error);
		}

		return $this->response->array($token);
	}

}