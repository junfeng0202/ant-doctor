<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name','100')->default('')->comment('姓名');
            $table->unsignedTinyInteger('identify')->default(0)->comment('性别 1.男 2.女');
            $table->string('hospital',200)->default('')->comment('医院');
            $table->string('depart',200)->default('')->comment('科室');
            $table->string('job',200)->default('')->comment('职称');
            $table->unsignedInteger('mime_id')->default('')->comment('医生端id');
            $table->text('brief')->comment('简介');
	        $table->float('sort',5,2)->default(0)->comment('排序');
	        $table->boolean('enable')->default(true)->comment('状态');
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
        Schema::dropIfExists('doctors');
    }
}
