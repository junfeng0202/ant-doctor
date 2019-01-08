<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('')->comment('标题');
            $table->unsignedTinyInteger('status')->default(0)->comment('直播状态 1.直播中 2.未开始 3.已结束');
            $table->string('image')->default('')->comment('封面');
            $table->unsignedInteger('disease_id')->default(0)->comment('病种');
            $table->timestamp('start_at')->default(null)->nullable()->comment('开始时间');
            $table->timestamp('end_at')->default(null)->nullable()->comment('结束时间');
            $table->string('link')->default('')->comment('直播地址');
            $table->string('playback')->default('')->comment('回放ID');
            $table->text('brief')->default(null)->comment('简介');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lives');
    }
}
