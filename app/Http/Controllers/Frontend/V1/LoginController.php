<?php

namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\MemberRequest;
use App\Service\MemberService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends ApiController
{
	protected $memberService;

	public function __construct(MemberService $memberService)
	{
		$this->memberService = $memberService;

	}

	/**
	 * Get a JWT via given credentials.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login(LoginRequest $request)
	{
		$user = $this->memberService->login($request);
		$token = JWTAuth::fromUser($user);
		return $this->setIndex(10)->apiReturn($this->respondWithToken($token));
	}

	public function forget(MemberRequest $request)
	{
		$this->memberService->forget($request);
		return $this->setIndex(105)->apiReturn();
	}

	public function register(MemberRequest $request)
	{
		$user = $this->memberService->register($request);

		$token = JWTAuth::fromUser($user);
		return $this->setIndex(11)->apiReturn($this->respondWithToken($token));

	}

	/**
	 * Get the authenticated User.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function me()
	{
		return $this->apiReturn(JWTAuth::parseToken()->touser());
	}

	/**
	 * Log the user out (Invalidate the token).
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout()
	{
		JWTAuth::parseToken()->invalidate();

		return $this->apiReturn(['message' => 'Successfully logged out']);
	}

	/**
	 * Refresh a token.
	 * 刷新token，如果开启黑名单，以前的token便会失效。
	 * 值得注意的是用上面的getToken再获取一次Token并不算做刷新，两次获得的Token是并行的，即两个都可用。
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refresh()
	{
		$token = JWTAuth::parseToken()->refresh();
		return $this->apiReturn($this->respondWithToken($token));
	}

	/**
	 * 微信登录
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function loginByOpenid(Request $request)
	{
		$user = $this->memberService->loginByOpenid($request);
		return $this->apiReturn([
			'access_token' => auth()->tokenById($user->id),
			'user' => $user
		]);
	}

	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithToken($token)
	{
		return [
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => JWTAuth::factory()->getTTL() * 60
		];
	}
}
