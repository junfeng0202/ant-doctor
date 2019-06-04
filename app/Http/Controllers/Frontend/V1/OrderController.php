<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\ArticleService;
use App\Service\OrderService;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
	protected $service;

	public function __construct(OrderService $orderService)
	{
		$this->service = $orderService;

	}

	/**
	 * 创建订单--学院卡
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function createCollegeOrder($id)
	{
		return $this->apiReturn($this->service->submitCollegeCardOrder($id));
	}

	/**
	 * 创建订单--课程
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function createCourseOrder($id)
	{
		return $this->apiReturn($this->service->submitCourseOrder($id));
	}

	/**
	 * 创建音频订单
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function createVideoOrder($id)
	{
		return $this->apiReturn($this->service->submitVideoOrder($id));
	}

	/**
	 * 订单详情
	 * @param $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function orderInfo($id)
	{
		return $this->apiReturn($this->service->orderDetail($id));
	}

	/**
	 * 取消订单
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function cancelOrder()
	{
		$index = $this->service->cancel() ? 1 : 0;
		return $this->setIndex($index)->apiReturn();
	}

}
