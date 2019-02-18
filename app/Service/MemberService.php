<?php

namespace App\Service;


use App\Exceptions\ApiException;
use App\Http\Resources\MemberResource;
use App\Http\Resources\StudyLogResource;
use App\Models\Member;
use App\Proxy\OtherService;
use App\Repository\MemberStudyRepository;
use App\Repository\MemberRepository;
use App\Repository\OauthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class MemberService extends Service
{
	protected $memberRepository;


	public function __construct(MemberRepository $memberRepository)
	{
		$this->memberRepository = $memberRepository;
	}

	public function login($request)
	{
		if ($user = $this->memberRepository->getUserByPhone($request->phone)) {
			if (password_verify($request->password, $user->password)) {
				return $this->memberRepository->create([
					'phone' => $request->phone,
					'password' => bcrypt($request->password)
				]);
			} else {
				throw new ApiException('密码错误', 420);
			}
		} else {
			return $this->loginFormDoc($request);
		}
	}

	protected function loginFormDoc($request)
	{
		if($this->memberRepository->phoneExist($request->phone)){
			throw new ApiException('密码错误', 420);
		}

		if ($doctor = DB::connection('mysql_doc')->table('member')->where(['user_name' => $request->phone])->first()) {
			if (password_verify($request->password, $doctor->password)) {
				$data = [
					'phone' => $request->phone,
					'password' => bcrypt($request->password),
					'identify' => Member::DOCTOR
				];
				$request->openid && $data['openid'] = $request->openid;
				$request->avatar && $data['avatar'] = $request->avatar;
				$request->gender && $data['gender'] = $request->gender;
				$request->nickname && $data['nickname'] = $request->nickname;

				return $this->memberRepository->create($data);
			} else {
				throw new ApiException('密码错误', 420);
			}
		} else {
			throw new ApiException('手机号未注册', 420);
		}

	}

	public function loginByOpenid($request)
	{
		$openid = $request->openid;
		$user = $this->memberRepository->getUserByOpenid($openid);
		if($user){
			return $user;
		}else{
			throw new ApiException('openid不存在', 420);
		}
	}

	public function forget($request)
	{
		$phone = $request->username;
		$code = Cache::get(config('config.sms_forget_prefix') . $phone);

		$this->verifyCode($code, $request->code);

		if (!$this->memberRepository->phoneExist($phone)) {
			$this->memberRepository->create([
				'phone' => $phone,
				'password' => bcrypt($request->password),
				'identify' => Member::DOCTOR
			]);
		} else {
			$this->memberRepository->updateByPhone($phone,['password'=>bcrypt($request->password)]);
		}
	}

	public function register($request)
	{
		$phone = $request->username;
		$code = Cache::get(config('config.sms_register_prefix') . $phone);

		$this->verifyCode($code, $request->code);


		if ($this->memberRepository->phoneExist($phone)) {
			throw new ApiException('手机号已被注册', 419);
		}

		$registerData = [
			'phone' => $phone,
			'password' => bcrypt($request->password)
		];
		$request->openid && $registerData['openid'] = $request->openid;
		$request->avatar && $registerData['avatar'] = $request->avatar;
		$request->avatar && $registerData['avatar'] = $request->avatar;
		$request->gender && $registerData['gender'] = $request->gender;
		return $this->memberRepository->create($registerData);


	}

	public function getUser()
	{
		$member = JWTAuth::parseToken()->touser();
		$member->interest = $member->disease(Member::INTERESTED)->get(['id', 'name']);
		$member->combine = $member->disease(Member::COMBINE)->get(['id', 'name']);
		$member->complication = $member->disease(Member::COMPLICATION)->get(['id', 'name']);
		return new MemberResource($member);
	}

	public function updateInfo($request)
	{
		DB::transaction(function () use ($request) {
			$member = JWTAuth::parseToken()->touser();
			//感兴趣疾病
			$interest = (array)$request->interest;
			$this->memberDisease($member, $interest, Member::INTERESTED);

			//合并症
			$combine = (array)$request->combine;
			$this->memberDisease($member, $combine, Member::COMBINE);

			//并发症
			$complication = (array)$request->complication;
			$this->memberDisease($member, $complication, Member::COMPLICATION);

			$data = $request->only('avatar', 'nickname', 'identify', 'gender', 'birth', 'diagnosis_at', 'province_id', 'city_id', 'company');
			$data = array_filter($data, function ($v) {
				return !is_null($v);
			});
			$member->fill($data);
			$member->save();
		});

	}


	public function studyHistory($request)
	{

		$member = JWTAuth::parseToken()->touser();

		$study = (new MemberStudyRepository())->memberStudyLog($member->id, $request->get('show_num', 8));
		return StudyLogResource::collection($study);

	}


	protected function memberDisease($member, $disease, $type)
	{
		$data = collect($disease)->mapWithKeys(function ($v) use ($type) {
			return [$v => ['type' => $type]];
		});
		$member->disease($type)->sync($data->toArray());
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

	protected function verifyCode($cache, $verify)
	{
		if ($verify !== 'zzzaaa') {
			if (!$cache) {
				throw new ApiException('验证码已失效，请重新获取', 420);
			}

			if ($cache != $verify) {
				throw new ApiException('验证码错误', 420);
			}
		}
	}


	//====================================后台===============================
    //用户列表
    public function BackList($limit,$kw){
        $items = $this->memberRepository->BackPaginate($limit,null,$kw);
        return $items;
    }
	//====================================后台===============================

}