<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image',200)->default('')->comment('广告图');
            $table->string('link',200)->default('')->comment('广告链接');
            $table->unsignedTinyInteger('position')->default(0)->comment('广告位置 0.首页');
            $table->float('sort',5,2)->default(0)->comment('排序');
            $table->unsignedTinyInteger('enable')->default(1)->comment('状态 0.禁用 1.启用');
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
        Schema::dropIfExists('banners');
    }
}
