<?php
namespace App\Http\Controllers\Frontend\V1;

use App\Http\Controllers\ApiController;
use App\Service\PayService;
use Illuminate\Http\Request;

class PayController extends ApiController
{
	protected $service;
	protected $request;

	public function __construct(PayService $payService, Request $request)
	{
		$this->service = $payService;
		$this->request = $request;
	}

	public function index()
	{
		return $this->service->pay($this->request);

	}

	public function success()
	{
		return $this->apiReturn($this->service->success($this->request->out_trade_no));
	}

	public function aliNotify()
	{
		return $this->service->aliNotify();
	}

	public function wechatNotify()
	{
		return $this->service->wechatNotify();
	}
}
