<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseDoctorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_doctor', function (Blueprint $table) {
            $table->unsignedInteger('course_id')->default(0)->comment('课程id');
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
