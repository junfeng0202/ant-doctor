<?php

namespace App\Http\Controllers\Backend\V1;


use App\Http\Controllers\ApiController;
use App\Service\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

    }

    public function info()
    {
	    $user = Auth::guard('api')->user();
	    $user->roles = ['admin'];
	    return $this->apiReturn($user);
    }
}