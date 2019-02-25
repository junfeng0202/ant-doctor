<?php
namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Service\UserService;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends ApiController
{
	use AuthenticatesUsers;
	protected $userService;

	public function __construct(UserService $userService)
	{
		//$this->middleware('guest')->except('logout');
		$this->userService = $userService;

	}

	public function login(UserRequest $request)
	{
		$http = new Client(['base_uri' => config('app.name')]);
		$response = $http->request('POST','/oauth/token', [
			'form_params' => [
				'grant_type' => 'password',
				'client_id' => config('config.backend_client_id'),
				'client_secret' => config('config.backend_client_secret'),
				'username' => $request->username,
				'password' => $request->password,
				'scope' => '',
			],
		]);
		$token = json_decode((string) $response->getBody(), true);
		$this->apiReturn($token);
	}

}
