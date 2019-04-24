<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotify extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('alipay_notify', function (Blueprint $table) {
		    $table->increments('id');
		    $table->decimal('total_amount',5,2)->default(null)->nullable()->comment('交易付款时间');
		    $table->string('out_trade_no', 30)->default('')->comment('商户订单号');
		    $table->string('trade_status', 30)->default('')->comment('交易状态');
		    $table->string('trade_no', 64)->default('')->comment('支付宝交易号');
		    $table->string('seller_id', 64)->default('')->comment('卖家支付宝用户号');
		    $table->decimal('receipt_amount', 5,2)->default('0.00')->comment('实收金额');
		    $table->decimal('point_amount', 5,2)->default('0.00')->comment('集分宝金额');
		    $table->string('app_id', 32)->default('')->comment('开发者的app_id');
		    $table->decimal('buyer_pay_amount', 5,2)->default('')->comment('付款金额');
		    $table->timestamp('gmt_payment')->default('0.00')->comment('订单金额');
		    $table->timestamp('gmt_create')->default(null)->nullable()->comment('交易创建时间');
		    $table->string('charset',20)->default('')->comment('编码格式');
		    $table->timestamp('notify_time')->default(null)->nullable()->comment('通知时间');
		    $table->string('subject','255')->default('')->comment('订单标题');
		    $table->string('buyer_id','255')->default('')->comment('买家支付宝用户号');
		    $table->string('passback_params','255')->default('')->comment('回传参数');
		    $table->decimal('invoice_amount',6,2)->default('0.00')->comment('开票金额');
		    $table->string('notify_id',150)->default('')->comment('通知校验ID');
		    $table->string('fund_bill_list',512)->default('')->comment('支付金额信息');
		    $table->string('notify_type',100)->default('')->comment('通知类型');
	    });

	    Schema::create('wechat_notify', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('out_trade_no',32)->default('')->comment('商户订单号');
		    $table->unsignedInteger('total_fee')->default(0)->comment('订单金额');
		    $table->string('transaction_id',32)->default('')->comment('微信支付订单号');
		    $table->string('trade_type')->default('')->comment('交易类型');
		    $table->string('result_code',32)->default('')->comment('业务结果');
		    $table->string('return_code',32)->default('')->comment('返回状态码');
		    $table->string('appid',32)->default('')->comment('公众账号ID');
		    $table->string('mch_id', 32)->default('')->comment('商户号');
		    $table->string('bank_type', 20)->default('')->comment('付款银行');
		    $table->unsignedInteger('cash_fee')->default(0)->comment('现金支付金额');
		    $table->string('fee_type', 10)->default('')->comment('货币种类');
		    $table->unsignedTinyInteger('is_subscribe')->default(0)->comment('是否关注公众账号');
		    $table->string('openid', 32)->default('');
		    $table->string('nonce_str', 32)->default('');
		    $table->string('time_end',20)->default('')->comment('支付完成时间');
		    $table->string('attach',255)->default('')->comment('商家数据包');

	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notify');
    }
}
