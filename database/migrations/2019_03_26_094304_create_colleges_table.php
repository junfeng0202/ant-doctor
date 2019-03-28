<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100)->default('')->comment('名称');
            $table->string('brief',512)->default('')->comment('简介');
            $table->string('image',100)->default('')->comment('封面图');
            $table->unsignedInteger('content_count')->default(0)->comment('内容数');
            $table->unsignedInteger('hits')->default(0)->comment('点击数');
            $table->unsignedTinyInteger('enable')->default(1)->comment('状态 0.禁用 1.启用');
            $table->float('sort', 4, 2)->default(0.00)->comment('排序');
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
        Schema::dropIfExists('colleges');
    }
}
