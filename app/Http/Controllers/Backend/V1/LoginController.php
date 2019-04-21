<?php

namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Service\UserService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginController extends ApiController
{
    protected $userService;

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
	public function getInfoByToken(UserService $userService)
	{
		 $user = Auth::guard('api')->user();

		$rules = $user->is_admin ? Permission::get() :$user->getPermissionsViaRoles()->unique('id')->values()->all();
		$user->rules = $rules;
		$userService->setUserRule($user->id, $rules);

		return $this->apiReturn($user);
	}
}
