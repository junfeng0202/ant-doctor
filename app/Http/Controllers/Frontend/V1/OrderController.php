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

	public function createCollegeOrder($id)
	{
		return $this->apiReturn($this->service->submitCollegeCardOrder($id));
	}

	public function createCourseOrder($id)
	{
		return $this->apiReturn($this->service->submitCourseOrder($id));
	}

	public function createVideoOrder($id)
	{
		return $this->apiReturn($this->service->submitVideoOrder($id));
	}

	public function orderInfo($id)
	{
		return $this->apiReturn($this->service->orderDetail($id));
	}



}
