<?php

namespace App\Service;


use App\Exceptions\ApiException;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Repository\OrderRepository;
use App\Strategy\OrderSuccess\IOrderSuccess;
use App\Strategy\OrderSuccess\OrderCollege;
use App\Strategy\OrderSuccess\OrderCourse;
use App\Strategy\OrderSuccess\OrderVideo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yansongda\LaravelPay\Facades\Pay;

class PayService
{
	protected $repository;

	public function __construct(OrderRepository $orderRepository)
	{
		$this->repository = $orderRepository;
	}

	/**
	 * 支付跳转
	 * @param Request $request
	 * @return mixed
	 * @throws ApiException
	 */
	public function pay(Request $request)
	{
		$order = $this->repository->getOrderByID($request->id);
		$type = $request->pay_type;

		if (!$order || in_array($type, [Order::ALIPAY, Order::WECHAT])) throw new ApiException('参数错误');

		if ($type == Order::ALIPAY) {
			$data = [
				'out_trade_no' => $order->number,
				'total_amount' => $order->amount,
				'subject' => '蚂蚁医生科普版',
			];
			return Pay::alipay()->wap($data);
		} else {
			$data = [
				'out_trade_no' => $order->number,
				'body' => '蚂蚁医生科普版',
				'total_fee' => $order->amount * 100,
				'openid' => $order->member->openid,
			];
			return Pay::wechat()->mp($data);
		}
	}


	/**
	 * 支付成功
	 * @param $number
	 * @return OrderResource
	 * @throws ApiException
	 */
	public function success($number)
	{
		$order = $this->repository->getOrderByNumber($number);
		if (!$order) throw new ApiException('订单不存在');
		return new OrderResource($order);
	}

	/**
	 * 支付宝支付回调
	 * @return mixed
	 */
	public function aliNotify()
	{
		$ali = Pay::alipay();
		try {
			$data = $ali->verify();
			if ($data->trade_status == 'TRADE_SUCCESS' && $this->charge_succeeded($data, Order::ALIPAY)) {
				return $ali->success();
			}
		} catch (\Exception $err) {
			Log::error('Ali-notify error', ['msg' => $err->getMessage()]);
		}
	}

	/**
	 * 微信支付回调
	 * @return mixed
	 */
	public function wechatNotify()
	{
		$wechat = Pay::wechat();
		try {
			$data = $wechat->verify();
			if ($data->result_code == 'SUCCESS' && $data->return_code == 'SUCCESS' && $this->charge_succeeded($data, Order::WECHAT))
				return $wechat->success();
		} catch (\Exception $err) {
			Log::error('Wechat-notify error', ['msg' => $err->getMessage()]);
		}
	}

	protected function charge_succeeded($data, $type)
	{

		//订单是否存在
		$order = $this->repository->getOrderByNumber($data->out_trade_no);

		if (!$order) {
			Log::error('订单号不存在', $data->toArray());
			return false;
		}

		if ($order->process_status != Order::WAIT_PAY) {
			return true;
		}

		$total = $type == Order::ALIPAY ? $data->total_amount * 100 : $data->total_fee;
		if (bccomp($total, $order->amount * 100) != 0) {
			Log::error('金额支付错误', $data->toArray());
			return false;
		}

		//保存支付信息
		DB::transaction(function () use ($order, $type) {
			// 更新订单状态
			$this->repository->updateById($order->id, ['status' => Order::PAYED, 'pay_at' => Carbon::now(), 'pay_type' => $type]);
			// 添加用户购买状态
			$this->getOrderSuccessStrategy($order->goods_type)->addMemberOrder($order->member_id, $order->detail->goods_id);
		});
		return true;
	}

	protected function getOrderSuccessStrategy($type): IOrderSuccess
	{
		switch ($type) {
			case Order::COURSE:
				return new OrderCourse();
			case Order::VIDEO:
				return new OrderVideo();
			default:
				return new OrderCollege();
		}
	}
}