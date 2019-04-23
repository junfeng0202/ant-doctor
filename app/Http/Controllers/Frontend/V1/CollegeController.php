<?php

namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\CollegeService;
use Illuminate\Http\Request;

class CollegeController extends ApiController
{
	protected $service;

	public function __construct(CollegeService $service)
	{
		$this->service = $service;

	}

	/**
	 * 获取列表
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getList(Request $request)
	{
		$res = $items = $this->service->getList($request);
		return $this->apiReturn($res);
	}

	/**
	 * 讲堂详情
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function info($id)
	{
		$item = $this->service->getInfo($id);
		return $this->apiReturn($item);
	}

	/**
	 * 频道内容列表
	 * @param $sectionId
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function sectionContents(Request $request, $sectionId)
	{
		$items = $this->service->sectionContents($sectionId, $request);
		return $this->apiReturn($items);
	}

	public function collegeCard($id)
	{

		return $this->apiReturn();
	}


}