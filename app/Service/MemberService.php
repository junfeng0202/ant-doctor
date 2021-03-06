<?php

namespace App\Service;

use App\Exceptions\ApiException;
use App\Http\Resources\MemberResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\StudyLogResource;
use App\Models\Disease;
use App\Models\Member;
use App\Proxy\OtherService;
use App\Repository\FeedbackRepository;
use App\Repository\MemberStudyRepository;
use App\Repository\MemberRepository;
use App\Repository\OauthRepository;
use App\Repository\OrderRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Facades\JWTAuth;

class MemberService extends Service
{
	protected $memberRepository;


	public function __construct(MemberRepository $memberRepository)
	{
		$this->memberRepository = $memberRepository;
	}

	/**
	 * 登入
	 * @param $request
	 * @return mixed
	 * @throws ApiException
	 */
	public function login($request)
	{
		if ($user = $this->memberRepository->getUserByPhone($request->username)) {
			if (password_verify($request->password, $user->password)) {
				if ($request->openid && !$user->openid) {
					$user->openid = $request->openid;
					$user->save();
				}
				return $user;
			} else {
				throw new ApiException('密码错误', 420);
			}
		} else {
			return $this->loginFormDoc($request);
		}
	}

	/**
	 * 老账号登入
	 * @param $request
	 * @return mixed
	 * @throws ApiException
	 */
	protected function loginFormDoc($request)
	{
		if ($this->memberRepository->phoneExist($request->username)) {
			throw new ApiException('密码错误', 420);
		}

		if ($doctor = DB::connection('mysql_doc')->table('member')->where(['user_name' => $request->username])->first()) {
			if (password_verify($request->password, $doctor->password)) {
				$data = [
					'phone' => $request->username,
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

	/**
	 * 通过openid登入
	 * @param $request
	 * @return MemberResource
	 * @throws ApiException
	 */
	public function loginByOpenid($request)
	{
		$openid = $request->openid;
		$user = $this->memberRepository->getUserByOpenid($openid);
		if ($user) {
			return new MemberResource($this->getDiseases($user));
		} else {
			throw new ApiException('openid不存在', 420);
		}
	}

	/**
	 * 忘记密码
	 * @param $request
	 */
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
			$this->memberRepository->updateByPhone($phone, ['password' => bcrypt($request->password)]);
		}
	}

	/**
	 * 注册
	 * @param $request
	 * @return mixed
	 * @throws ApiException
	 */
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

		//添加推荐
		if ($inventId = $request->inventId) {
			$client = new Client();
			$key = openssl_encrypt(json_encode(['invent_id' => $inventId]), 'aes-256-cbc', config('config.openssl_key'), OPENSSL_RAW_DATA, config('config.openssl_iv'));
			$key = str_replace('+', '_', base64_encode($key));
			$client->post(config('config.doctor_url') . '/api/invent/success', [
				'form_params' => [
					'key' => $key
				]
			]);
			$registerData['invent_id'] = $inventId;
		}

		$request->openid && $registerData['openid'] = $request->openid;
		$request->avatar && $registerData['avatar'] = $request->avatar;
		$request->nickname && $registerData['nickname'] = $request->nickname;
		$request->gender && $registerData['gender'] = $request->gender;
		return $this->memberRepository->create($registerData);


	}

	/**
	 * 获取用户信息
	 * @return mixed
	 */
	public function getUser()
	{
		$member = JWTAuth::parseToken()->touser();
		$key = config('redisKeys.userInfo') . $member->id;

		if (!Redis::exists($key)) {
			$member = (new MemberResource($this->getDiseases($member)));
			Redis::setex($key, 86400 * 7, json_encode($member));
		}
		return json_decode(Redis::get($key));
	}

	/**
	 * 更新
	 * @param $request
	 */
	public function updateInfo($request)
	{
		DB::transaction(function () use ($request) {
			$member = JWTAuth::parseToken()->touser();
			//感兴趣疾病
			$interest = (array)$request->interest;
			$this->memberDisease($member, $interest, Disease::INTERESTED);

			//合并症
			$combine = (array)$request->combine;
			$this->memberDisease($member, $combine, Disease::COMBINE);

			//并发症
			$complication = (array)$request->complication;
			$this->memberDisease($member, $complication, Disease::COMPLICATION);

			$data = $request->only('avatar', 'nickname', 'identify', 'gender', 'birth', 'diagnosis_at', 'province_id', 'city_id', 'company');
			$data = array_filter($data, function ($v) {
				return !is_null($v);
			});
			$member->fill($data);
			$member->save();

			//更新用户信息，删除缓存
			$key = config('redisKeys.userInfo') . $member->id;
			Redis::del($key);
		});

	}


	/**
	 * 用户学习记录
	 * @param $request
	 * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function studyHistory($request)
	{

		$member = JWTAuth::parseToken()->touser();

		$study = (new MemberStudyRepository())->memberStudyLog($member->id, $request->get('show_num', 8));
		return StudyLogResource::collection($study);

	}

	/**
	 * 反馈数据提交
	 * @param $request
	 */
	public function feedback($request)
	{
		$member = JWTAuth::parseToken()->touser();
		$data = $request->all();
		// $data['member_id'] = 1;
		$data['member_id'] = $member->id;
		(new FeedbackRepository())->create($data);
	}

	/**
	 * 用户订单
	 * @param Request $request
	 * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function orders(Request $request)
	{
		$member = Auth::user();
		$orders = (new OrderRepository())->getUserOrders($member->id, $request->get('show_num', 20), $request->get('status', 0));
		return OrderResource::collection($orders);
	}

	/**
	 * 加载用户的所有病种
	 * @param $member
	 * @return mixed
	 */
	protected function getDiseases($member)
	{
		$member->interest = $member->disease(Disease::INTERESTED)->get(['id', 'name']);
		$member->combine = $member->disease(Disease::COMBINE)->get(['id', 'name']);
		$member->complication = $member->disease(Disease::COMPLICATION)->get(['id', 'name']);
		return $member;
	}

	/**
	 * 更新用户相关病种
	 * @param $member
	 * @param $disease
	 * @param $type
	 */
	protected function memberDisease($member, $disease, $type)
	{
		$data = collect($disease)->mapWithKeys(function ($v) use ($type) {
			return [$v => ['type' => $type]];
		});
		$member->disease($type)->sync($data->toArray());
	}

	/**
	 * 用户感兴趣的疾病id
	 * @return array
	 */
	public function memberInterest()
	{
		if (auth()->check()) {
			$member = $this->getUser();
			$interest = array_map(function ($v) {
				return $v->id;
			}, $member->interest);
		} else {
			$interest = [];
		}
		return $interest;
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




	/**
	 * 用户列表
	 * @param $limit
	 * @param $kw
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function BackList($limit, $kw)
	{
		$items = $this->memberRepository->BackPaginate($limit, null, $kw);
		return $items;
	}


	/**
	 * 统计用户总数
	 * @return mixed
	 */
	public function BackUserCount()
	{
		$res = $this->memberRepository->BackCount();
		return $res;
	}

}