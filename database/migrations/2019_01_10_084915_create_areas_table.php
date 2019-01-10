<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('pid')->default(0)->comment('父id');
            $table->string('name',100)->default('')->comment('名称');
            $table->unsignedTinyInteger('type')->default(0)->comment('类型 国家|country|0,省份|province|1,城市|city|2,区县|area|3');
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
        Schema::dropIfExists('areas');
    }
}
