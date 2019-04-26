<?php
namespace App\Http\Controllers\Backend\V1;

use App\Http\Controllers\ApiController;
use App\Service\OrderService;

class OrderController extends ApiController
{
	protected $service;

	public function __construct(OrderService $orderService)
	{
		$this->service = $orderService;

	}


	public function index()
	{
		return $this->apiReturn($this->service->backList());
	}

	public function statistics()
	{
		return $this->apiReturn($this->service->statistics());
	}

}
