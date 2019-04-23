<?php

namespace App\Repository;


use App\Models\Order;
use App\Models\OrderDetail;

class OrderRepository
{

	public function create($data)
	{
		return Order::create($data);
	}

	public function createOrderDetail($data)
	{
		return OrderDetail::create($data);
	}

	public function getOrderDetail($id)
	{
		return Order::with('detail')->find($id);
	}
}