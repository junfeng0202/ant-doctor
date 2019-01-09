<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Proxy\TokenProxy;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends ApiController
{
	use AuthenticatesUsers;

	public function __construct()
	{
		//$this->middleware('guest')->except('logout');
	}

	public function login(TokenProxy $tokenProxy, Request $request)
	{
		return $tokenProxy->proxy('password', 1,$request->all());
	}
}
