<?php

namespace App\Http\Controllers\Backend\V1;


use App\Http\Controllers\ApiController;
use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

    }

    public function getList(Request $request)
    {
        $users = $this->userService->getList($request);
        return $this->apiReturn($users);
    }

    public function getInfoById($id)
    {
	    $user = $this->userService->getUser($id);
	    return $this->apiReturn($user);
    }

    public function save(Request $request)
    {
    	$this->userService->save($request->id, $request->except('id'));
		return $this->apiReturn();
    }
}