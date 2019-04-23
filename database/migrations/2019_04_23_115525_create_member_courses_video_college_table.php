<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberCoursesVideoCollegeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id')->default(0)->comment('课程id');
            $table->unsignedInteger('member_id')->default(0)->comment('用户id');
            $table->timestamp('expired_at')->default(null)->nullable()->comment('过期时间');
            $table->timestamps();
        });

        Schema::create('member_videos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('video_id')->default(0)->comment('音频id');
            $table->unsignedInteger('member_id')->default(0)->comment('用户id');
            $table->timestamp('expired_at')->default(null)->nullable()->comment('过期时间');
            $table->timestamps();
        });

        Schema::create('member_colleges', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('college_id')->default(0)->comment('讲堂id');
            $table->unsignedInteger('member_id')->default(0)->comment('用户id');
            $table->timestamp('expired_at')->default(null)->nullable()->comment('过期时间');
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
        Schema::dropIfExists('member_courses');
    }
}
