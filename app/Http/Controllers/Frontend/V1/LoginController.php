<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Models\OauthClient;
use App\Proxy\TokenProxy;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends ApiController
{
	use AuthenticatesUsers;

	public function __construct()
	{
		//$this->middleware('guest')->except('logout');
	}

	public function login(TokenProxy $tokenProxy, Request $request)
	{
		if(Auth::attempt(['name'=>$request->username,'password'=>$request->password])){

			$oauth = OauthClient::find(1);
			$params = [
				'client_id' => $oauth->id,
				'client_secret' => $oauth->secret,
				'username' => $request->username,
				'password' => $request->password,
				'scope' => '',
			];

			$token = $tokenProxy->proxy('password', $params);
			return $this->response->item($token);
		}else{
			return $this->response->errorUnauthorized('用户名或密码错误');
		}
	}
}
