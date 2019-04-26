<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('hits')->default(0)->comment('点击量');
            $table->string('title', 200)->default('')->comment('课程标题');
	        $table->unsignedInteger('disease_id')->default(0)->comment('所属病种');
	        $table->string('image')->default('')->comment('音频封面');
	        $table->text('brief')->nullable()->comment('音频简介');
	        $table->float('sort',5,2)->default(0)->comment('排序');
	        $table->tinyInteger('enable')->default(1)->comment('状态 0.禁用 1.启用');
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
        Schema::dropIfExists('courses');
    }
}
