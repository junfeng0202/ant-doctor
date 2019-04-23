<?php

namespace App\Service;


use App\Exceptions\ApiException;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Repository\CollegeRepository;
use App\Repository\CourseRepository;
use App\Repository\MemberCollegeRepository;
use App\Repository\MemberCourseRepository;
use App\Repository\MemberVideoRepository;
use App\Repository\OrderRepository;
use App\Repository\VideoRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService extends Service
{
	protected $orderRepository;
	protected $user;
	protected $goodsInfo;

	public function __construct(OrderRepository $orderRepository)
	{
		$this->orderRepository = $orderRepository;
		$this->user = Auth::user();
	}

	/**
	 * 提交讲堂学习卡订单
	 * @param $id
	 * @throws ApiException
	 */
	public function submitCollegeCardOrder($id)
	{
		if ((new MemberCollegeRepository())->buyStatus($this->user->id, $id)) {
			throw new ApiException('你已经拥有了该权益卡，请勿重复购买');
		}
		$this->goodsInfo = (new CollegeRepository())->getById($id);
		return $this->createOrder(Order::COLLEGE);
	}

	/**
	 * 提交课程订单
	 * @param $id
	 * @throws ApiException
	 */
	public function submitCourseOrder($id)
	{
		if ((new MemberCourseRepository())->buyStatus($this->user->id, $id)) {
			throw new ApiException('你已经拥有了该课程，请勿重复购买');
		}
		$this->goodsInfo = (new CourseRepository())->getById($id);
		return $this->createOrder(Order::COURSE);
	}

	/**
	 * 提交音频订单
	 * @param $id
	 * @throws ApiException
	 */
	public function submitVideoOrder($id)
	{
		if ((new MemberVideoRepository())->buyStatus($this->user->id, $id)) {
			throw new ApiException('你已经拥有了该音频，请勿重复购买');
		}
		$this->goodsInfo = (new VideoRepository())->getById($id);
		return $this->createOrder(Order::VIDEO);
	}


	public function orderDetail($id)
	{
		$orderDetail = $this->orderRepository->getOrderDetail($id);
		if(!$orderDetail || $orderDetail->status !== Order::WAIT_PAY) {
			throw new ApiException('订单不存在，或已支付');
		}
		return new OrderResource($orderDetail);

	}

	/**
	 * 创建订单
	 * @param $type
	 * @return mixed
	 * @throws \Exception
	 */
	protected function createOrder($type)
	{
		DB::beginTransaction();
		try {
			// 创建订单
			$data = [
				'number' => orderNumber(),
				'member_id' => $this->user->id,
				'amount' => $this->goodsInfo->in_active ? $this->goodsInfo->active_price : $this->goodsInfo->price,
				'status' => Order::WAIT_PAY,
				'place_at' => Carbon::now(),
			];
			$order = $this->orderRepository->create($data);

			//创建订单详情
			$detailData = [
				'order_id' => $order->id,
				'type' => $type,
				'goods_id' => $this->goodsInfo->id,
				'image' => $this->goodsInfo->image,
				'title' => $this->goodsInfo->title,
			];
			$this->orderRepository->createOrderDetail($detailData);
			DB::commit();
			return ['order_id' => $order->id];
		} catch (\Exception $exception) {
			DB::rollBack();
			throw $exception;
		}


	}

}