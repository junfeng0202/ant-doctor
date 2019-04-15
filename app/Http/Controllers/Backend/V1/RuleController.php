<?php

namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\ApiController;
use App\Service\RuleService;
use Illuminate\Http\Request;

class RuleController extends ApiController
{
    protected $service;

    public function __construct(RuleService $service)
    {
        $this->service = $service;

    }

    public function getList()
    {
    	return $this->apiReturn($this->service->getList());
    }

	public function save(Request $request)
	{
		return $this->apiReturn($this->service->save($request));
    }

}