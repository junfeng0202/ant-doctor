<?php
namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\ApiController;
use App\Service\FeedbackService;
use Illuminate\Http\Request;

class FeedbackController extends ApiController
{
    protected $service;

    public function __construct(FeedbackService $service)
    {
        $this->service = $service;
    }

	/**
	 * 后台列表
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getList(Request $request)
    {
    	return $this->apiReturn($this->service->backList($request));
    }

}