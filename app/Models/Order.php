<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	// 订单类型
    const COURSE = 1;
    const VIDEO = 2;
    const COLLEGE = 3;

    // 订单状态
    const WAIT_PAY = 1;
    const PAYED = 2;
    const CANCEL = 3;

    // 支付方式
    const ALIPAY = 1;
    const WECHAT = 2;

    protected $fillable = ['number', 'member_id', 'amount', 'status', 'goods_type', 'pay_at', 'pay_type'];

    protected $dates = ['pay_at'];

    public function detail()
    {
    	return $this->hasOne(OrderDetail::class);
    }

    public function member()
    {
    	return $this->belongsTo(Member::class);
    }
}
