<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('video_id')->comment('音频id');
            $table->string('title',100)->default('')->comment('名称');
            $table->string('video_id',100)->default('')->comment('音频id');
            $table->unsignedSmallInteger('duration',100)->default('')->comment('时长(秒)');
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
