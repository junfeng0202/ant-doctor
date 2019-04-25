<?php

namespace App\Repository;


use App\Models\AlipayNotify;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\WechatNotify;

class OrderRepository
{

	/**
	 * 创建订单
	 * @param $data
	 * @return mixed
	 */
	public function create($data)
	{
		return Order::create($data);
	}

	/**
	 * 创建订单详情
	 * @param $data
	 * @return mixed
	 */
	public function createOrderDetail($data)
	{
		return OrderDetail::create($data);
	}

	/**
	 * 通过订单id获取订单信息
	 * @param $id
	 * @return mixed
	 */
	public function getOrderByID($id)
	{
		return Order::find($id);
	}

	/**
	 * 通过订单id获取订单详情
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
	 */
	public function getOrderDetail($id)
	{
		return Order::with('detail')->find($id);
	}

	/**
	 * 用户订单列表
	 * @param $member_id
	 * @param $limit
	 * @param $status
	 * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
	 */
	public function getUserOrders($member_id, $limit, $status)
	{
		$order = Order::query();
		if($status) $order->where('status', $status);
		return $order->with('detail')->where('member_id', $member_id)->latest('id')->paginate($limit);
	}

	/**
	 * 通过订单号获取订单详情
	 * @param $number
	 * @return mixed
	 */
	public function getOrderByNumber($number)
	{
		return Order::where('number', $number)->with('detail')->first();
	}

	/**
	 * 通过id更新订单信息
	 * @param $id
	 * @param $data
	 * @return mixed
	 */
	public function updateById($id, $data)
	{
		return Order::whereId($id)->update($data);
	}

	public function backList($condition)
	{
		$limit = $condition['limit'];
		$order = Order::query();
		// 商品类型
		if($goods_type = $condition['goods_type']){
			$order->where('goods_type', (int)$goods_type);
		}
		// 支付状态
		if($status = $condition['status']){
			$order->where('status', (int)$status);
		}
		// 属于用户
		if(isset($condition['phone']) && $phone = $condition['phone']){
			$order->whereHas('member', function ($member) use($phone) {
				return $member->where('phone','LIKE', $phone.'%');
			});
		}
		// 订单号
		if(isset($condition['number']) && $number = $condition['number']){
			$order->where('number', $number);
		}

		if(isset($condition['created_at']) && $condition['created_at']){
			$order->whereBetween('created_at', $condition['created_at']);
		}
		if(isset($condition['pay_at']) && $condition['pay_at']){
			$order->whereBetween('pay_at', $condition['pay_at']);
		}
		return $order->with('detail', 'member:id,nickname,phone')->latest('id')->paginate($limit);
	}


	/**
	 * 存储回调的详细数据
	 * @param $type
	 * @param $data
	 */
	public function notifyDateStore($type, $data)
	{
		if($type == Order::ALIPAY){
			AlipayNotify::create($data);
		} else{
			WechatNotify::create($data);
		}
	}
}