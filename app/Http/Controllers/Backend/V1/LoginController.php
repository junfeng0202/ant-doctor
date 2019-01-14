<?php
namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\ApiController;
use App\Http\Requests\UserRequest;
use App\Service\UserService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
		return  'success';
	}
	public function test(){
	    echo 123;
    }
}
