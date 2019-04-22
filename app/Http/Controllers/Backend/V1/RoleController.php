<?php

namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\ApiController;
use App\Service\RoleService;
use Illuminate\Http\Request;

class RoleController extends ApiController
{
    protected $service;

    public function __construct(RoleService $service)
    {
        $this->service = $service;

    }

	/**
	 * 获取角色列表
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getList(Request $request)
    {
    	return $this->apiReturn($this->service->getList($request));
    }

    public function getInfo($id)
    {
	    return $this->apiReturn($this->service->info($id));
    }

    public function save(Request $request)
    {
		return $this->apiReturn($this->service->save($request));
    }

	public function getRules(Request $request)
	{
		return $this->apiReturn($this->service->getRules($request->id));
	}


    public function saveRules(Request $request)
    {
	    return $this->apiReturn($this->service->saveRules($request));
    }

    public function delete($id)
    {
	    return $this->apiReturn($this->service->delete($id));
    }
}