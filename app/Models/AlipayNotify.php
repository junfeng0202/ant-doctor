<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlipayNotify extends Model
{
	protected $table = 'alipay_notify';

	public $timestamps = false;

	protected $fillable = ['gmt_payment','gmt_create','charset','notify_time','subject', 'buyer_id','passback_params','invoice_amount', 'notify_id','fund_bill_list','notify_type','total_amount','out_trade_no','trade_status','trade_no','receipt_amount','point_amount','app_id','buyer_pay_amount','sign_type','seller_id'];
}
