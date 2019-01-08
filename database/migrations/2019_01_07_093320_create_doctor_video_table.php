<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_video', function (Blueprint $table) {
            $table->unsignedInteger('video_id')->default(0)->comment('音频id');
            $table->unsignedInteger('doctor_id')->default(0)->comment('讲师id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_doctor');
    }
}
