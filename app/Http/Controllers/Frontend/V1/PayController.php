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

	/**
	 * show pay page
	 * @return mixed
	 */
	public function index()
	{
		return $this->service->pay($this->request);

	}

	/**
	 * checkout success
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function success()
	{
		return $this->apiReturn($this->service->success($this->request->out_trade_no));
	}

	/**
	 * get notify data --alipay
	 * @return mixed
	 */
	public function aliNotify()
	{
		return $this->service->aliNotify();
	}

	/**
	 * get notify data --wechat
	 * @return mixed
	 */
	public function wechatNotify()
	{
		return $this->service->wechatNotify();
	}
}
