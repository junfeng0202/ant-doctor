<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberStudyLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_study_logs', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('member_id')->default(0)->comment('用户id');
	        $table->unsignedInteger('course_id')->default(0)->comment('课程id');
	        $table->unsignedInteger('course_section_id')->default(0)->comment('视频id');
	        $table->unsignedInteger('time')->default(0)->comment('视频时间点');
	        $table->unsignedTinyInteger('end')->default(0)->comment('是否结束');
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
        Schema::dropIfExists('member_study_logs');
    }
}
