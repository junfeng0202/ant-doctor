<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegeSectionContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_section_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('college_section_id')->default(0)->comment('频道id');
            $table->unsignedInteger('college_id')->default(0)->comment('讲堂id');
            $table->unsignedInteger('contentable_id')->default(0)->comment('关联模型id');
            $table->string('contentable_type')->default('')->comment('关联模型类型 course.课程 video.音频 artice.资讯');
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
        Schema::dropIfExists('college_section_contents');
    }
}
