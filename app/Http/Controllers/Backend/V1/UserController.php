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

	/**
	 * 管理员列表
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getList(Request $request)
    {
        $users = $this->userService->getList($request);
        return $this->apiReturn($users);
    }

	/**
	 * 管理员详情
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getInfoById($id)
    {
	    $user = $this->userService->getUser($id);
	    return $this->apiReturn($user);
    }

	/**
	 * 保存用户信息
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function save(Request $request)
    {
    	$this->userService->save($request->id, $request->except('id'));
		return $this->apiReturn();
    }
}