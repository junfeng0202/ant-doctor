<?php

namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Service\UserService;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class LoginController extends ApiController
{
    use AuthenticatesUsers;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(UserRequest $request)
    {
        $http = new Client(['base_uri' => config('app.url')]);
        try {
            $response = $http->request('POST', '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('config.backend_client_id'),
                    'client_secret' => config('config.backend_client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                    'scope' => '',
                ],
            ]);
        } catch (\Exception $e) {
            throw  new UnauthorizedHttpException('', '账号验证失败', null, 400);
        }

        $token = json_decode((string)$response->getBody(), true);
        return $this->apiReturn($token);
    }


	/**
	 * 登入用户信息获取
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getInfoByToken()
	{
		$user = Auth::guard('api')->user();
		$user->roles = ['admin'];
		return $this->apiReturn($user);
	}
}
