<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('hits')->comment('点击量');
            $table->string('title', 200)->default('')->comment('课程标题');
	        $table->unsignedInteger('disease_id')->comment('所属病种');
	        $table->string('image')->comment('视频封面');
	        $table->text('brief')->comment('视频简介');
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
