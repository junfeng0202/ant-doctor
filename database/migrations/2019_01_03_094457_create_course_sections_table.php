<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id')->comment('课程id');
            $table->string('title',100)->default('')->comment('名称');
            $table->string('source_id',100)->default('')->comment('视频id');
            $table->unsignedSmallInteger('duration')->default(0)->comment('时长(秒)');
	        $table->float('sort',5,2)->default(0)->comment('排序');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_sections');
    }
}
