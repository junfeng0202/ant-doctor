<?php

namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Service\UserService;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
            throw  new UnauthorizedHttpException('', '账号验证失败');
        }

        $token = json_decode((string)$response->getBody(), true);
        return $this->apiReturn($token);
    }

    public function userInfo()
    {
        $data = ['roles' => ['admin'],
            'token' => 'admin',
            'introduction' => '我是超级管理员',
            'avatar' => 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
            'name' => 'Super Admin'];
        return $this->apiReturn($data);
    }

}
