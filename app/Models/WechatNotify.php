<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WechatNotify extends Model
{
	protected $table = 'wechat_notify';

	public $timestamps = false;

	protected $fillable = ['appid', 'mch_id', 'bank_type', 'cash_fee', 'fee_type', 'is_subscribe', 'nonce_str', 'openid', 'out_trade_no', 'result_code', 'return_code', 'time_end', 'total_fee', 'trade_type', 'transaction_id', 'attach'];
}
