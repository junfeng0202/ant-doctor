<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->char('number',19)->default('')->comment('订单号');
            $table->unsignedInteger('member_id')->default(0)->comment('用户id');
            $table->decimal('amount',10,2)->default(0)->comment('订单价格');
            $table->unsignedTinyInteger('status')->default(0)->comment('订单状态 0.待支付 1.已支付 2.已取消');
            $table->timestamp('place_at')->default(null)->nullable()->comment('下单时间');
            $table->timestamp('pay_at')->default(null)->nullable()->comment('支付时间');
            $table->unsignedTinyInteger('pay_type')->default(0)->comment('支付方式 1.支付宝 2.微信');
            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id')->default(0)->comment('订单ID');
            $table->unsignedTinyInteger('type')->default(0)->comment('商品类型');
            $table->unsignedInteger('goods_id')->default(0)->comment('商品ID');
            $table->string('image','100')->default('')->comment('商品封面');
            $table->string('title','100')->default('')->comment('商品名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
