<?php

namespace App\Http\Controllers\Backend\V1;

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
	 * 获取后台列表
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getList(Request $request)
	{
		$res = $items = $this->service->backList($request);
		return $this->apiReturn($res);
	}

	/**
	 * 讲堂详情
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function info($id)
	{
		$item = $this->service->backInfo($id);
		return $this->apiReturn($item);
	}

	/**
	 * 修改讲堂信息
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function save(Request $request)
	{
		$this->service->updateOreCreate($request);
		return $this->apiReturn();
	}

	/**
	 * 讲堂频道列表
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function sections($id)
	{
		return $this->apiReturn($this->service->sections($id));
	}

	/**
	 * 频道信息
	 * @param $sectionId
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function sectionInfo($sectionId)
	{
		$item = $this->service->sectionInfo($sectionId);
		return $this->apiReturn($item);
	}

	/**
	 * 修改频道信息
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function sectionSave(Request $request, $id)
	{
		$this->service->sectionSave($request, $id);
		return $this->apiReturn();
	}

	/**
	 * 频道内容列表
	 * @param $sectionId
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function contents($sectionId)
	{
		$items = $this->service->sectionContentList($sectionId);
		return $this->apiReturn($items);
	}

	/**
	 * 频道内容的id数组
	 * @param $sectionId
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function contentIds($sectionId)
	{
		$items = $this->service->sectionContentIds($sectionId);
		return $this->apiReturn($items);
	}

	/**
	 * 保存内容
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function contentSave(Request $request)
	{
		$data = $this->service->contentSave($request);
		return $this->apiReturn($data);
	}

	/**
	 * 删除内容
	 * @param $conentId
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function contentDelete($conentId)
	{
		$this->service->contentDelete($conentId);
		return $this->apiReturn();
	}

}