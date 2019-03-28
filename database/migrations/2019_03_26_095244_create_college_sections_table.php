<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegeSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_sections', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('college_id')->default(0)->comment('讲堂id');
	        $table->string('title', 100)->default('')->comment('名称');
	        $table->string('type',20)->comment('频道类型 course.课程 video.音频 artice.资讯');
	        $table->unsignedTinyInteger('enable')->default(1)->comment('状态');
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
        Schema::dropIfExists('college_sections');
    }
}
