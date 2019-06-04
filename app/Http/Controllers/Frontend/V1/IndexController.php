<?php

namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\IndexService;
use Illuminate\Http\Request;

class IndexController extends ApiController
{
	protected $indexService;

	public function __construct(IndexService $indexService)
	{
		$this->indexService = $indexService;

	}

	/**
	 * 首页内容内部
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		$data = $this->indexService->index();
		return $this->apiReturn($data);
	}

	/**
	 * 首页搜索
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function search(Request $request)
	{
		$data = $this->indexService->search($request);
		return $this->apiReturn($data);
	}

}
