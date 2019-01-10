<?php
namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Service\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
		return $this->userService->login($request);
	}
}
