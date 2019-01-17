<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\MemberRequest;
use App\Service\MemberService;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends ApiController
{
	protected $memberService;

	public function __construct(MemberService $memberService)
	{
		$this->middleware('auth:member', ['except' => ['login','register']]);
		$this->memberService = $memberService;

	}

	/*public function login(MemberRequest $request)
	{
		return $this->memberService->login($request);
	}


	public function register(MemberRequest $request)
	{
		return $this->memberService->register($request);
	}

	*/

	/**
	 * Get a JWT via given credentials.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function login()
	{
		$credentials = [
			'phone' =>request('username'),
			'password' =>request( 'password')
		];

		if (! $token = auth('member')->attempt($credentials)) {
			return $this->setIndex(100)->apiReturn();
		}

		return $this->apiReturn(['token'=>$token]);
	}

	public function register(MemberRequest $request)
	{
		$user = $this->memberService->register($request);
		if($user){
			return $this->apiReturn(['token'=>JWTAuth::fromUser($user)]);
		}else{
			return $this->setIndex(101)->apiReturn();
		}
	}

	/**
	 * Get the authenticated User.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function me()
	{
		return response()->json(auth('member')->user());
	}

	/**
	 * Log the user out (Invalidate the token).
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout()
	{
		auth('api')->logout();

		return response()->json(['message' => 'Successfully logged out']);
	}

	/**
	 * Refresh a token.
	 * 刷新token，如果开启黑名单，以前的token便会失效。
	 * 值得注意的是用上面的getToken再获取一次Token并不算做刷新，两次获得的Token是并行的，即两个都可用。
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refresh()
	{
		return $this->respondWithToken(auth('member')->refresh());
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
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth('member')->factory()->getTTL() * 60
		]);
	}
}
