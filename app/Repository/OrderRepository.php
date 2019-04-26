<?php

namespace App\Repository;


use App\Models\AlipayNotify;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\WechatNotify;

class OrderRepository
{
	public function query()
	{
		return Order::query();
	}

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

	public function backList($query, $limit)
	{
		return $query->with('detail', 'member:id,nickname,phone')->latest('id')->paginate($limit);
	}

	public function total($query)
	{
		return $query->count('id');
	}

	public function payedTotal($query)
	{
		return $query->where('status', Order::PAYED)->count('id');
	}

	public function payedAmount($query)
	{
		return $query->where('status', Order::PAYED)->sum('amount');
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