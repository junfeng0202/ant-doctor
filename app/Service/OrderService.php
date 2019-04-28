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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yansongda\LaravelPay\Facades\Pay;

class OrderService
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
	 * @return mixed
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
	 * @return mixed
	 * @throws ApiException
	 */
	public function submitCourseOrder($id)
	{
		if ((new MemberCourseRepository())->buyStatus($this->user->id, $id)) {
			throw new ApiException('你已经拥有了该课程，请勿重复购买');
		}
		$this->goodsInfo = (new CourseRepository())->courseInfo($id);
		return $this->createOrder(Order::COURSE);
	}


	/**
	 * 提交音频订单
	 * @param $id
	 * @return mixed
	 * @throws ApiException
	 */
	public function submitVideoOrder($id)
	{
		if ((new MemberVideoRepository())->buyStatus($this->user->id, $id)) {
			throw new ApiException('你已经拥有了该音频，请勿重复购买');
		}
		$this->goodsInfo = (new VideoRepository())->BackById($id);
		return $this->createOrder(Order::VIDEO);
	}


	/**
	 * 订单详情
	 * @param $id
	 * @return OrderResource
	 * @throws ApiException
	 */
	public function orderDetail($id)
	{
		$orderDetail = $this->orderRepository->getOrderDetail($id);
		if (!$orderDetail || $orderDetail->status !== Order::WAIT_PAY) {
			throw new ApiException('订单不存在，或已支付');
		}
		return new OrderResource($orderDetail);

	}

	public function cancel()
	{
		$member = Auth::user();
		$id = request()->get('id');
		$order = $this->orderRepository->getOrderByID($id);
		if (!$order) throw new ApiException('订单不存在');
		if ($order->member_id != $member->id) throw new ApiException('无权限');
		if ($order->status != Order::WAIT_PAY) throw new ApiException('订单状态错误');
		return $this->orderRepository->updateById($id, ['status' => Order::CANCEL]);
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
				'goods_type' => $type,
				'amount' => $this->goodsInfo->sold_price,
				'status' => Order::WAIT_PAY,
			];
			$order = $this->orderRepository->create($data);

			//创建订单详情
			$detailData = [
				'order_id' => $order->id,
				'goods_type' => $type,
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


	/*======================  后台  ======================*/

	public function backList()
	{
		$query = $this->handleCondition();
		return $this->orderRepository->backList($query, request()->get('limit', 20));
	}

	public function statistics()
	{
		$query = $this->handleCondition();
		$total = $this->orderRepository->total($query);
		$payedTotal = $this->orderRepository->payedTotal($query);
		$payedAmount = $this->orderRepository->payedAmount($query);
		return ['total'=> $total, 'payedTotal'=> $payedTotal, 'payedAmount'=> $payedAmount];
	}

	public function refund($id)
	{
		$order = $this->orderRepository->getOrderByID($id);
		if(!$order) throw new ModelNotFoundException('订单不存在');
		if ($order->pay_type === Order::ALIPAY) {
			$order = [
				'out_trade_no' => $order->number,
				'refund_amount' => $order->amount,
			];
			$result = Pay::alipay()->refund($order);
			if($result->code == 10000) {
				return $this->orderRepository->updateById($id, ['refund_at'=> Carbon::now()]);
			}
		} else {
			$order = [
				'out_trade_no' => $order->number,
				'out_refund_no' => 'p-'.date('YmdHis'),
				'total_fee' => $order->amount * 100,
				'refund_fee' => $order->amount * 100,
				'refund_desc' => '蚂蚁医生科普版--退款',
			];
			$result = Pay::wechat()->refund($order);
			if($result->return_code == 'SUCCESS' && $result->return_msg == 'OK') {
				return $this->orderRepository->updateById($id, ['refund_at'=> Carbon::now()]);
			}
		}
		return false;
	}

	protected function handleCondition()
	{
		$condition = request()->all();
		$query = $this->orderRepository->query();
		// 商品类型
		if($goods_type = $condition['goods_type']){
			$query->where('goods_type', (int)$goods_type);
		}
		// 支付状态
		if($status = $condition['status']){
			$query->where('status', (int)$status);
		}
		// 属于用户
		if(isset($condition['phone']) && $phone = $condition['phone']){
			$query->whereHas('member', function ($member) use($phone) {
				return $member->where('phone','LIKE', $phone.'%');
			});
		}
		// 订单号
		if(isset($condition['number']) && $number = $condition['number']){
			$query->where('number', $number);
		}

		if(isset($condition['created_at']) && $condition['created_at']){
			$query->whereBetween('created_at', $condition['created_at']);
		}
		if(isset($condition['pay_at']) && $condition['pay_at']){
			$query->whereBetween('pay_at', $condition['pay_at']);
		}
		return $query;
	}
}